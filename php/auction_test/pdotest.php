<?php
$dsn = 'mysql:dbname=test;host=localhost';
$user = 'root';
$password = 'Xmpp2014';

try{
    $dbh = new PDO($dsn, $user, $password);

    print('Ú‘±‚É¬Œ÷‚µ‚Ü‚µ‚½B<br>');

//    $dbh->query('SET NAMES sjis');

    $sql = 'select * from test';
    foreach ($dbh->query($sql) as $row) {
        print($row['id']);
        print($row['name'].'<br>');
    }
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}

$dbh = null;

?>