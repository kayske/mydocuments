<?php
$root = "/var/www/html/CC/auction_test";
$link = sqlite_open($root . '/db/auction.db', 0666, $sqliteerror);
if (!$link) {
    die('�ڑ����s�ł��B'.$sqliteerror);
}

//���L�R�}���h�ŕ���
//sqlite_close($link);

?>
