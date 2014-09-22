<?php
//http://php1st.com/598/
//http://affiliate.aki-f.com/prog/page/40.html

/*ニュートラル	→	確認	→	完了
	└	エラー→┘	↓
	└	←リセット	┘
*/
//Function
require_once "../func.php";
//DB接続
include_once "../DBcon.php";


//まとめて変数初期化
list($id,$name,$img[0],$img[1],$img[2],$description,$blandTitle,$blandMessage,$endDate,$error[0],$error[1],$error[2]) = null;


//endDate入力フォームはデフォルト1日

//処理部分
//時刻を取得
date_default_timezone_set('Asia/Tokyo');
$now = getdate();

//ニュートラル
if(!isset($_POST["confirm"], $_POST["add"])){
	$disp ="";
	$nextYear = $now["year"];
	if($now["mon"]>6){
		$nextYear = $now["year"]+1;
		$nextMonth = $now["mon"]+6-12;
	}
}
//確認
if(isset($_POST["confirm"])){
	//日本語処理（文字コード指定）
	FormEncode($_POST);
	//必須項目name
	if (!$_POST["name"]) {
		$error[0] = "<p class=\"error\">商品名が入力されていません</p>";
	}else{
		$name = ShapeStr($_POST["name"],0);
		//かぶり防止
		try {
			$sql = sprintf("SELECT id FROM goods WHERE name = '%s'"
					, $name);
			$stmt = $dbh->query($sql);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if (!empty($row)) {
				$error[0] = "<p class=\"error\">その商品は既に登録されています。</p>";
			}
		}catch (PDOException $e){
			$error = "SELECTクエリーが失敗しました。".$e->getMessage();
			die();
		}
	}
	//必須項目img
	if (!($_FILES["img1"]["name"]) && !($_FILES["img2"]["name"]) && !($_FILES["img3"]["name"])) {
		$error[1] = "<p class=\"error\">画像が選択されていません</p>";
	}elseif ($_FILES["img1"]["size"] >= 300000 || $_FILES["img2"]["size"] >= 300000 || $_FILES["img3"]["size"] >= 300000) {
		$error[1] = "<p class=\"error\">画像が300KBを超えています</p>";
	}else{
		for ($i=0; $i<3; $i++) {
			if (!empty($_FILES["img" . ($i+1)]["name"])) {
				$img[$i] = "tmp" . ($i+1) . "." . GetExt(ShapeStr($_FILES["img" . ($i+1)]["name"],0));
				$imgtmp[$i] = $_FILES["img" . ($i+1)]["tmp_name"];
				$tmparea[$i] = "../tmp/" . $img[$i];
				move_uploaded_file($imgtmp[$i],$tmparea[$i]);
				$tmpthumb[$i] = createThumnail("../tmp/tmp" . ($i+1), GetExt($img[$i]));
			}
		}
	}
	//必須項目enddate
	if (!($_POST["enddate1"] || $_POST["enddate2"] || $_POST["enddate3"] || $_POST["enddate4"])) {
		$error[2] = "<p class=\"error\">終了日時が選択されていません</p>";
	}else{
		//結合
		$endDate = date("Y-m-d H:i:s", strtotime(ShapeStr($_POST["enddate1"],0)."-".ShapeStr($_POST["enddate2"],0)."-".ShapeStr($_POST["enddate3"],0)." ".ShapeStr($_POST["enddate4"],0).":00:00"));
		//endDateは最長6ヶ月													3/2
		if($endDate > date("Y-m-d H:i:s", strtotime('+6 month'))){
			$error[2] = "<p class=\"error\">終了日時は最長6ヶ月です。</p>";
		}
	}
	//格納
	$description = ShapeStr($_POST["description"],1);
	$blandTitle = ShapeStr($_POST["blandtitle"],1);
	$blandMessage = ShapeStr($_POST["blandmessage"],1);

	//エラー有り
	if(empty($error[0] . $error[1] . $error[2])){
		//確認画面
		$disp = "confirm";
	}else{
		$disp = "error";
	}

//完了
}elseif(isset($_POST["add"])){
	//id取得
	//http://blog.kamabokonet.com/2013/06/22/%E3%80%90mysqlphp%E3%80%91auto_increment%E3%81%AE%E6%AC%A1%E5%9B%9E%E5%80%A4%E3%82%92%E5%8F%96%E5%BE%97%E3%81%99%E3%82%8B%E6%96%B9%E6%B3%95/
	try {
	$sql = "SHOW TABLE STATUS LIKE 'goods'";
	$stmt = $dbh->query($sql);
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$id = $row["Auto_increment"];
}catch (PDOException $e){
	$error = "SELECTクエリーが失敗しました。".$e->getMessage();
	$id = 0;
	die();
}
	//格納
	$name = $_POST["name"];
	for ($i=0; $i<3; $i++) {
		if (!empty($_POST["img" . ($i+1)])) {
			$img[$i] =  $id . sprintf("%03d",($i+1)) . "." . GetExt($_POST["img" . ($i+1)]);
		}
	}
	$description = $_POST["description"];
	$blandTitle = $_POST["blandtitle"];
	$blandMessage = $_POST["blandmessage"];
	$endDate = date("Y-m-d H:i:s",strtotime($_POST["enddate"]));
	//DB追加
	$sql = sprintf("INSERT INTO goods (name, img1, img2, img3, description, blandTitle, blandMessage, endDate, flBid, user_id) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', 0, null)"
         , $name, $img[0], $img[1], $img[2], $description, $blandTitle, $blandMessage, $endDate);
	$row = $dbh->query($sql);
	if (!$row) {
		die('INSERTクエリーが失敗しました。'.mysql_error());
	}
	$endDate = date("Y年m月d日 H時",strtotime($endDate));
	
	$dbh = null;


	//画像フォルダに格納
	$area= "../images/slider/" . $id;
	if (!is_dir($area)) {
		mkdir($area);
		chmod($area,0777);
	}
	for ($i=0; $i<3; $i++) {
		if (!empty($_POST["img" . ($i+1)])) {
			$imgPath[$i] =  $area . "/" . $img[$i];
			 $tmparea[$i] = $_POST["imgtmp" . ($i+1)];
			if ( copy( $tmparea[$i] ,$imgPath[$i] )) {
				$copyComp[$i] = 1;
			}else{
			}
		//tmpファイル、サムネイルを削除する
		$thumb = "../tmp/tmp" . ($i+1) . "_thumb." . GetExt($_POST["img" . ($i+1)]);
		unlink($tmparea[$i]);
		unlink($thumb);
		}
	}
	
	

	
	//完了画面
	$disp = "add";
//リセット
}elseif(isset($_POST["reset"])){
	$disp ="";
}

//画面表示
if(empty($disp)){
	include_once "disp/gaddn.html";
}
if($disp == "confirm"){
	include_once "disp/gaddc.html";
}elseif($disp == "error"){
	include_once "disp/gadde.html";
}elseif($disp == "add"){
	include_once "disp/gadda.html";
}
?>
