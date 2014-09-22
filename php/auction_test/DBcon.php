<?php
$root = "C:/Users/cl3/xampp/htdocs/auction_test";

$dsn = 'mysql:dbname=auction;host=localhost';
$user = 'root';
$password = 'Xmpp2014';

try{
    $dbh = new PDO($dsn, $user, $password);
    //print('接続に成功しました。<br>');
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}

?>
	