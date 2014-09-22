<?php
//http://php1st.com/598/
//http://affiliate.aki-f.com/prog/page/40.html

/*�j���[�g����	��	�m�F	��	����
	��	�G���[����	��
	��	�����Z�b�g	��
*/
//Function
require_once "../func.php";
//DB�ڑ�
include_once "../DBcon.php";


//�܂Ƃ߂ĕϐ�������
list($id,$name,$img[0],$img[1],$img[2],$description,$blandTitle,$blandMessage,$endDate,$error[0],$error[1],$error[2]) = null;


//endDate���̓t�H�[���̓f�t�H���g1��

//��������
//�������擾
date_default_timezone_set('Asia/Tokyo');
$now = getdate();

//�j���[�g����
if(!isset($_POST["confirm"], $_POST["add"])){
	$disp ="";
	$nextYear = $now["year"];
	if($now["mon"]>6){
		$nextYear = $now["year"]+1;
		$nextMonth = $now["mon"]+6-12;
	}
}
//�m�F
if(isset($_POST["confirm"])){
	//���{�ꏈ���i�����R�[�h�w��j
	FormEncode($_POST);
	//�K�{����name
	if (!$_POST["name"]) {
		$error[0] = "<p class=\"error\">���i�������͂���Ă��܂���</p>";
	}else{
		$name = ShapeStr($_POST["name"],0);
		//���Ԃ�h�~
		try {
			$sql = sprintf("SELECT id FROM goods WHERE name = '%s'"
					, $name);
			$stmt = $dbh->query($sql);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if (!empty($row)) {
				$error[0] = "<p class=\"error\">���̏��i�͊��ɓo�^����Ă��܂��B</p>";
			}
		}catch (PDOException $e){
			$error = "SELECT�N�G���[�����s���܂����B".$e->getMessage();
			die();
		}
	}
	//�K�{����img
	if (!($_FILES["img1"]["name"]) && !($_FILES["img2"]["name"]) && !($_FILES["img3"]["name"])) {
		$error[1] = "<p class=\"error\">�摜���I������Ă��܂���</p>";
	}elseif ($_FILES["img1"]["size"] >= 300000 || $_FILES["img2"]["size"] >= 300000 || $_FILES["img3"]["size"] >= 300000) {
		$error[1] = "<p class=\"error\">�摜��300KB�𒴂��Ă��܂�</p>";
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
	//�K�{����enddate
	if (!($_POST["enddate1"] || $_POST["enddate2"] || $_POST["enddate3"] || $_POST["enddate4"])) {
		$error[2] = "<p class=\"error\">�I���������I������Ă��܂���</p>";
	}else{
		//����
		$endDate = date("Y-m-d H:i:s", strtotime(ShapeStr($_POST["enddate1"],0)."-".ShapeStr($_POST["enddate2"],0)."-".ShapeStr($_POST["enddate3"],0)." ".ShapeStr($_POST["enddate4"],0).":00:00"));
		//endDate�͍Œ�6����													3/2
		if($endDate > date("Y-m-d H:i:s", strtotime('+6 month'))){
			$error[2] = "<p class=\"error\">�I�������͍Œ�6�����ł��B</p>";
		}
	}
	//�i�[
	$description = ShapeStr($_POST["description"],1);
	$blandTitle = ShapeStr($_POST["blandtitle"],1);
	$blandMessage = ShapeStr($_POST["blandmessage"],1);

	//�G���[�L��
	if(empty($error[0] . $error[1] . $error[2])){
		//�m�F���
		$disp = "confirm";
	}else{
		$disp = "error";
	}

//����
}elseif(isset($_POST["add"])){
	//id�擾
	try {
		//spritf�ő������	
		$sql = "SELECT id FROM goods ORDER BY id DESC LIMIT 1";
		$stmt = $dbh->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$id = $row["id"]+1;
	}catch (PDOException $e){
		$error = "SELECT�N�G���[�����s���܂����B".$e->getMessage();
		$id = 0;
		die();
	}
	//�i�[
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
	//DB�ǉ�
	$sql = sprintf("INSERT INTO goods (id, name, img1, img2, img3, description, blandTitle, blandMessage, endDate, flBid, user_id) VALUES ('%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', 0, null)"
         , $id, $name, $img[0], $img[1], $img[2], $description, $blandTitle, $blandMessage, $endDate);
	$row = $dbh->query($sql);
	if (!$row) {
		die('INSERT�N�G���[�����s���܂����B'.mysql_error());
	}
	$endDate = date("Y�Nm��d�� H��",strtotime($endDate));
	
	$dbh = null;


	//�摜�t�H���_�Ɋi�[
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
		//tmp�t�@�C���A�T���l�C�����폜����
		$thumb = "../tmp/tmp" . ($i+1) . "_thumb." . GetExt($_POST["img" . ($i+1)]);
		unlink($tmparea[$i]);
		unlink($thumb);
		}
	}
	
	

	
	//�������
	$disp = "add";
//���Z�b�g
}elseif(isset($_POST["reset"])){
	$disp ="";
}

//��ʕ\��
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
