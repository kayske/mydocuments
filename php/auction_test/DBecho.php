<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang	="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<style type="text/css">  
table {
border-collapse: collapse;
border: 1px #1C79C6 solid;
}
td, th {
padding: 5px;
border: 1px #1C79C6 solid;
}
</style>  


</head>
<body>
<?php
include_once "DBcon.php";

//goodsテーブル
try {
	$sql = 'SELECT * FROM goods';
	echo "
<h2>goodsテーブル</h2>
<table>
	<tr>
		<th>id</th><th>name</th><th>img1</th><th>img2</th><th>img3</th><th>description</th><th>blandTitle</th><th>blandMessage</th><th>flBid</th><th>user_id</th><th>endDate</th>
	</tr>";
    foreach ($dbh->query($sql) as $row) {
	echo "
	<tr>
		<td>".$row['id']."</td>
		<td>".$row['name']."</td>
		<td>".$row['img1']."</td>
		<td>".$row['img2']."</td>
		<td>".$row['img3']."</td>
		<td>".$row['description']."</td>
		<td>".$row['blandTitle']."</td>
		<td>".$row['blandMessage']."</td>
		<td>".$row['flBid']."</td>
		<td>".$row['user_id']."</td>
		<td>".$row['endDate']."</td>
	</tr>";
    }
	echo "</table>";
	echo "<br />--------------------------------<br />";

}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}


//usersテーブル
try {
	$sql = "SELECT * FROM users";
	echo "
<h2>usersテーブル</h2>
<table>
	<tr>
		<th>id</th><th>name</th><th>mail</th><th>pass</th>
	</tr>";
    foreach ($dbh->query($sql) as $row) {
	echo "
	<tr>
		<td>".$row['id']."</td>
		<td>".$row['name']."</td>
		<td>".$row['mail']."</td>
		<td>".$row['pass']."</td>
	</tr>";
    }
	echo "</table>";
	echo "<br />--------------------------------<br />";

}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}


//bidsテーブル
try {
	$sql = 'SELECT * FROM bids';
	echo "
<h2>bidsテーブル</h2>
<table>
	<tr>
		<th>id</th><th>good_id</th><th>date</th><th>user_id</th><th>amount</th>
	</tr>";
    foreach ($dbh->query($sql) as $row) {
	echo "
	<tr>
		<td>".$row['id']."</td>
		<td>".$row['good_id']."</td>
		<td>".$row['date']."</td>
		<td>".$row['user_id']."</td>
		<td>".$row['amount']."</td>
	</tr>";
    }
	echo "</table>";
	echo "<br />--------------------------------<br />";

}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}


//infosテーブル
try {
	$sql = 'SELECT * FROM infos';
	echo "
<h2>infosテーブル</h2>
<table>
	<tr>
		<th>id</th><th>date</th><th>good_id</th><th>title</th><th>content</th>
	</tr>";
    foreach ($dbh->query($sql) as $row) {
	echo "
	<tr>
		<td>".$row['id']."</td>
		<td>".$row['date']."</td>
		<td>".$row['good_id']."</td>
		<td>".$row['title']."</td>
		<td>".$row['content']."</td>
	</tr>";
    }
	echo "</table>";
	echo "<br />--------------------------------<br />";

}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}

//joinテスト
try {
	$sql = 'SELECT infos.id, goods.name AS good_name, title, content FROM infos LEFT JOIN goods ON infos.good_id = goods.id';
	echo "
<h2>infosテーブル</h2>
<table>
	<tr>
		<th>id</th><th>good_id</th><th>title</th>
	</tr>";
    foreach ($dbh->query($sql) as $row) {
	echo "
	<tr>
		<td>".$row['id']."</td>
		<td>".$row['good_name']."</td>
		<td>".$row['title']."</td>
	</tr>";
    }
	echo "</table>";
	echo "<br />--------------------------------<br />";

}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}

//auto_increment取得
try {
	$sql = "SHOW TABLE STATUS LIKE 'goods'";
	$stmt = $dbh->query($sql);
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	echo $row["Auto_increment"];
}catch (PDOException $e){
	$error = "SELECTクエリーが失敗しました。".$e->getMessage();
	$id = 0;
	die();
}


$dbh = null;

?>
</body>
</html>