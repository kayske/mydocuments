<?php
echo $dsn;

try{
	$sql = "SELECT id FROM bids ORDER BY id DESC LIMIT 1";
	$stmt = $dbh->query($sql);
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	echo $nextId = $row["id"] + 1;
}catch (PDOException $e){
	$error = "SELECTクエリーが失敗しました。".$e->getMessage();
	die();
}

$sql = sprintf("INSERT INTO bids (id, good_id, date, user_id, amount) VALUES ('%d', '%d', '%s', '%d', '%d')"
         , $nextId, $goodId, date("Y/m/d H:i:s",$now), $_SESSION["userId"], $bidAmount);
$row = $dbh->query($sql);

if (!$row) {
    die('INSERTクエリーが失敗しました。'.mysql_error());
}

?>