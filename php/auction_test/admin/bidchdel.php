<?php
/*ニュートラル	→	変更入力画面	→	変更確認	→	変更完了
	↓				↓	└	エラー→┘	↓
	↓	└	←	←	戻る	←		←	┘
	削除確認画面	→	削除完了
*/
//http://affiliate.aki-f.com/prog/page/42.html
//Function
require_once "../func.php";
//DB接続
include_once "../DBcon.php";

//まとめて変数初期化
list($id,$name,$img[0],$img[1],$img[2],$description,$blandTitle,$blandMessage,$endDate,$error[0],$error[1],$error[2]) = null;


//処理部分
//時刻を取得
date_default_timezone_set('Asia/Tokyo');
$nowTime = strtotime("now");
$now = getdate();
$nextYear = $now["year"];
if($now["mon"]>6){
	$nextYear = $now["year"]+1;
	$nextMonth = $now["mon"]+6-12;
}
//ニュートラル（リスト）
if(empty($_POST) || isset($_POST["reset"])){
	try {
		$sql = "SELECT bids.id, goods.name AS good_name, date,  users.name AS user_name, amount FROM bids LEFT JOIN goods ON bids.good_id = goods.id LEFT JOIN users ON bids.user_id = users.id ORDER BY id ASC;";
	    foreach ($dbh->query($sql)  as $key => $row) {
		$id[$key] = $row["id"];
		if(!empty($row["good_name"])){
			$good_name[$key] = $row["good_name"];
		}else{
			$good_name[$key] = "削除されています";
		}
		$date[$key] = $row["date"];
		if(!empty($row["user_name"])){
			$user_name[$key] = $row["user_name"];
		}else{
			$user_name[$key] = "削除されています";
		}
		$amount[$key] = $row["amount"];
		}
	}catch (PDOException $e){
    	echo"SELECTクエリーが失敗しました。".$e->getMessage();
    	die();
	}
	$disp ="";
}
//変更入力
if(isset($_POST["change"])){
	$id = $_POST["change"];
	try {
		//spritfで代入する	
		$sql = sprintf("SELECT name , img1 , img2 , img3 , description , blandTitle , blandMessage , endDate , flBid FROM goods WHERE id = '%d'"
				, $id);
		$stmt = $dbh->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$name = $row["name"];
		$img[0] = $row["img1"];
		$img[1] = $row["img2"];
		$img[2] = $row["img3"];
		$description = $row["description"];
		$blandTitle = $row["blandTitle"];
		$blandMessage = $row["blandMessage"];
		$endDateSplit[0] = date("Y",strtotime($row["endDate"]));
		$endDateSplit[1] = date("m",strtotime($row["endDate"]));
		$endDateSplit[2] = date("d",strtotime($row["endDate"]));
		$endDateSplit[3] = date("H",strtotime($row["endDate"]));
		$flBid = $row["flBid"];
	}catch (PDOException $e){
		$error = "SELECTクエリーが失敗しました。".$e->getMessage();
		die();
	}

	$disp = "change";
}
//変更確認
if(isset($_POST["confirm"])){
	//現在の値を取得
	try {
		//spritfで代入する	
		$sql = sprintf("SELECT name , img1 , img2 , img3 , description , blandTitle , blandMessage , endDate FROM goods WHERE id = '%d'"
				, $_POST["id"]);
		$stmt = $dbh->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$beforeName = $row["name"];
		$beforeImg[0] = $row["img1"];
		$beforeImg[1] = $row["img2"];
		$beforeImg[2] = $row["img3"];
		$beforeDescription = $row["description"];
		$beforeBlandTitle = $row["blandTitle"];
		$beforeBlandMessage = $row["blandMessage"];
		$beforeEndDate = strtotime($row["endDate"]);
	}catch (PDOException $e){
		$error = "SELECTクエリーが失敗しました。".$e->getMessage();
		die();
	}
	//日本語処理（文字コード指定）
	FormEncode($_POST);

	//エラー処理
	//必須項目name
	if (!$_POST["name"] || $beforeName == ShapeStr($_POST["name"],0)) {
		$name = $beforeName;
	}else{
		$name = ShapeStr($_POST["name"],0);
		//かぶり防止
		try {
			$sql = sprintf("SELECT id FROM goods WHERE name = '%s'"
					, $name);
			$stmt = $dbh->query($sql);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if (!empty($row) && $row["id"] != $beforeName) {
				$error[0] = "<p class=\"error\">「".$_POST["name"]."」は既に登録されています。</p>";
			}
		}catch (PDOException $e){
			$error = "SELECTクエリーが失敗しました。".$e->getMessage();
			die();
		}
	}
	//必須項目img																		3/7
	for($i=0; $i<3; $i++){
		if (empty($_FILES["img".($i+1)]["name"])) {
			if(isset($_POST["beforeimg".($i+1)])){
				$img[$i] = $_POST["beforeimg".($i+1)];
			}
		}elseif ($_FILES["img".($i+1)]["size"] >= 300000) {
			$error[1] = "<p class=\"error\">画像が300KBを超えています</p>";
		}else{
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
	if (!($_POST["enddate1"]) || !($_POST["enddate2"]) || !($_POST["enddate3"]) || !($_POST["enddate4"])){
		$error[2] = "<p class=\"error\">終了日時が選択されていません</p>";
	}elseif (!($_POST["enddate1"] && $_POST["enddate2"] && $_POST["enddate3"] && $_POST["enddate4"])) {
		$endDate = date("Y-m-d H:i:s",$beforeEndDate);
	}else{
		//結合
		$endDate = date("Y-m-d H:i:s", strtotime(ShapeStr($_POST["enddate1"],0)."-".ShapeStr($_POST["enddate2"],0)."-".ShapeStr($_POST["enddate3"],0)." ".ShapeStr($_POST["enddate4"],0).":00:00"));
		//endDateは最長6ヶ月													3/2
		if($endDate > date("Y-m-d H:i:s", strtotime('+6 month'))){
			$error[2] = "<p class=\"error\">終了日時は最長6ヶ月です。</p>";
		}
	}
	$endDateSplit[0] = date("Y",strtotime($endDate));
	$endDateSplit[1] = date("m",strtotime($endDate));
	$endDateSplit[2] = date("d",strtotime($endDate));
	$endDateSplit[3] = date("H",strtotime($endDate));

	//格納
	$id = $_POST["id"];
	if(!$_POST["description"]){
		$description = $beforeDescription;
	}else{
		$description = ShapeStr($_POST["description"],1);
	}
	if(!$_POST["blandtitle"]){
		$blandTitle = $beforeBlandTitle;
	}else{
		$blandTitle = ShapeStr($_POST["blandtitle"],1);
	}
	if(!$_POST["blandmessage"]){
		$blandMessage = $beforeBlandMessage;
	}else{
		$blandMessage = ShapeStr($_POST["blandmessage"],1);
	}

	if(empty($error[0] . $error[1] . $error[2])){
		//確認画面
		$disp = "confirm";
	}else{
		//エラー
		try {
			//spritfで代入する	
			$sql = sprintf("SELECT name , img1 , img2 , img3 , description , blandTitle , blandMessage , endDate , flBid FROM goods WHERE id = '%d'"
					, $id);
			$stmt = $dbh->query($sql);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$name = $row["name"];
			$img[0] = $row["img1"];
			$img[1] = $row["img2"];
			$img[2] = $row["img3"];
			$description = $row["description"];
			$blandTitle = $row["blandTitle"];
			$blandMessage = $row["blandMessage"];
			$endDateSplit[0] = date("Y",strtotime($row["endDate"]));
			$endDateSplit[1] = date("m",strtotime($row["endDate"]));
			$endDateSplit[2] = date("d",strtotime($row["endDate"]));
			$endDateSplit[3] = date("H",strtotime($row["endDate"]));
			$flBid = $row["flBid"];
		}catch (PDOException $e){
			$error = "SELECTクエリーが失敗しました。".$e->getMessage();
			die();
		}
		$disp = "error";
	}
}

//変更完了
if(isset($_POST["update"])){
	$id = $_POST["id"];
	$name = $_POST["name"];
	for ($i=0; $i<3; $i++) {
		if (!empty($_POST["img" . ($i+1)])) {
			$img[$i] =  $id . sprintf("%03d",($i+1)) . "." . GetExt($_POST["img" . ($i+1)]);
			if (!empty($_POST["imgtmp" . ($i+1)])) {
			$imgUp[$i] = 1;
			}
		}
	}
	$description = $_POST["description"];
	$blandTitle = $_POST["blandtitle"];
	$blandMessage = $_POST["blandmessage"];
	$endDate = date("Y-m-d H:i:s",strtotime($_POST["enddate"]));
	
	//DB追加
	$sql = sprintf("UPDATE goods SET name='%s', img1='%s', img2='%s', img3='%s', description='%s', blandTitle='%s', blandMessage='%s', endDate='%s' WHERE id = %d"
         , $name, $img[0], $img[1], $img[2], $description, $blandTitle, $blandMessage, $endDate, $id);
	$row = $dbh->query($sql);
	if (!$row) {
		die('UPDATEクエリーが失敗しました。'.mysql_error());
	}
	
	//画像フォルダに格納
	$area= "../images/slider/" . $id;
	if (!is_dir($area)) {
		mkdir($area);
		chmod($area,0777);
	}
	for ($i=0; $i<3; $i++) {
		$imgPath[$i] =  $area . "/" . $img[$i];
		if (!empty($_POST["imgtmp" . ($i+1)])) {
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
	
	try {
		//spritfで代入する	
		$sql = sprintf("SELECT name , img1 , img2 , img3 , description , blandTitle , blandMessage , endDate FROM goods WHERE id = '%d'"
				, $id);
		$stmt = $dbh->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$name = $row["name"];
		$img[0] = $row["img1"];
		$img[1] = $row["img2"];
		$img[2] = $row["img3"];
		$description = $row["description"];
		$blandTitle = $row["blandTitle"];
		$blandMessage = $row["blandMessage"];
		$endDate = date("Y年m月d日 H時",strtotime($row["endDate"]));
	}catch (PDOException $e){
		$error = "SELECTクエリーが失敗しました。".$e->getMessage();
		die();
	}
	
	$disp = "update";
}
//削除確認
if(isset($_POST["delete"])){
	$id = $_POST["delete"];
	try {
		//spritfで代入する	
		$sql = sprintf("SELECT name , img1 , img2 , img3 , description , blandTitle , blandMessage , endDate , flBid FROM goods WHERE id = '%d'"
				, $id);
		$stmt = $dbh->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$name = $row["name"];
		$img[0] = $row["img1"];
		$img[1] = $row["img2"];
		$img[2] = $row["img3"];
		$description = $row["description"];
		$blandTitle = $row["blandTitle"];
		$blandMessage = $row["blandMessage"];
		$endDate = date("Y年m月d日 H時",strtotime($row["endDate"]));
		$flBid = $row["flBid"];
	}catch (PDOException $e){
		$error = "SELECTクエリーが失敗しました。".$e->getMessage();
		die();
	}

	$disp ="delete";
//削除完了
}elseif(isset($_POST["deletecomp"])){
	$id = $_POST["deletecomp"];
	try {
		//spritfで代入する	
		$sql = sprintf("SELECT name FROM goods WHERE id = '%d'"
				, $id);
		$stmt = $dbh->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$name = $row["name"];
	}catch (PDOException $e){
		$error = "SELECTクエリーが失敗しました。".$e->getMessage();
		die();
	}
	$sql = sprintf("DELETE FROM goods WHERE id = '%d'", $id);
	$row = $dbh->query($sql);
	if (!$row) {
		die('DELETEクエリーが失敗しました。'.mysql_error());
	}
	
	//DB閉じる
	$dbh = null;

	$disp ="deletecomp";
//戻る
}elseif(isset($_POST["reset"])){
	$disp ="";
}

//画面表示
if(empty($disp)){
	include_once "disp/bidchdellist.html";
}
if($disp == "change"){
	include_once "disp/gchdelch.html";
}elseif($disp == "confirm"){
	include_once "disp/gchdelco.html";
}elseif($disp == "error"){
	include_once "disp/gchdeler.html";
}elseif($disp == "update"){
	include_once "disp/gchdelup.html";
}elseif($disp == "delete"){
	include_once "disp/gchdeldel.html";
}elseif($disp == "deletecomp"){
	include_once "disp/gchdeldeco.html";
}

?>

