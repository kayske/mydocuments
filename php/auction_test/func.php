<?php

function stlimit($cont,$int){
	if(mb_strlen($cont, 'UTF8') > $int) {
		$cont = mb_substr($cont,0,$int-1, 'UTF8') . "...";
	}
	return $cont;
}

function ShapeStr($Str, $Br){
$Str=str_replace(", ", "", $Str);//解説(1)
if($Br==1){
$Str=nl2br($Str); //解説(2)
}
$Str=str_replace("\n", "", $Str);
$Str=str_replace("\r", "", $Str);
return $Str;//解説(3)
}

function FormEncode(&$post){
	if ( !isset($post['enc']) ){
		return;
	}
	//どのエンコーディングか判定
	$enc = mb_detect_encoding($post['enc']);
	$default_enc = "UTF-8";
	foreach ($post as &$value) {
		EncodeCore($value,$default_enc,$enc);
	}
	unset($value);
}
function EncodeCore( &$value , $default_enc , $enc){
	if( is_array($value)){
		//配列の場合は再帰処理
		foreach ($value as &$value2) {
			EncodeCore($value2 , $default_enc , $enc);
		}
	}else if( $enc != $default_enc){
		//文字コード変換
		$value = mb_convert_encoding( $value , $default_enc , $enc ) ;
	}
}

// GetExt
// ファイルの拡張子を取得します。
function GetExt($FilePath){
$f=strrev($FilePath);
$ext=substr($f,0,strpos($f,"."));
return strrev($ext);
}

// dstの値から最適なサイズにリサイズ（縦横比を）
function getImageSizeForSmartResize($dstWidth, $dstHeight, $srcWidth, $srcHeight){
   $factor = min(($dstWidth / $srcWidth), ($dstHeight / $srcHeight));

   return array($factor * $srcWidth, $factor * $srcHeight);
}

// サムネイル画像作成
function createThumnail($filename, $type){
   // 必要ないと思いますが、もしうまくいかない場合書いてみてください
   // header('Content-type: image/jpeg');
   // イメージサイズ取得
   list($width, $height) = getimagesize($filename.".".$type);
   
   // サムネイル画像のサイズを指定
   list($new_width, $new_height) = getImageSizeForSmartResize(100, 100, $width, $height);
   
   // 新しい画像を生成
   if ($type === "jpg" || $type === "jpeg")
      $src = imagecreatefromjpeg($filename.".".$type);
   else
      $src = imagecreatefrompng($filename.".".$type);
      
   // 画像領域の作成
   $image = imagecreatetruecolor($new_width, $new_height);
   // exifデータ生成
   $exif = exif_read_data($filename.".".$type);
   
   // サムネイル画像の生成
   imagecopyresampled($image, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

   if(!empty($exif['Orientation'])){
      switch ($exif['Orientation']) {
         case 8:
            $image = imagerotate($image, 90, 0);
            break;
         case 3:
            $image = imagerotate($image, 180, 0);
            break;
         case 6:
            $image = imagerotate($image, -90, 0);
            break;
         }
      }
      
   if ($type === "jpg" || $type === "jpeg")
      imagejpeg($image, $filename."_thumb.".$type);
   else
      imagepng($image, $filename."_thumb.".$type);

   imagedestroy($image);
   imagedestroy($src);

   return $filename."_thumb.".$type;
}

?>