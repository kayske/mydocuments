<?php
$root = "/var/www/html/CC/auction_test";
$link = sqlite_open($root . '/db/auction.db', 0666, $sqliteerror);
if (!$link) {
    die('接続失敗です。'.$sqliteerror);
}

//下記コマンドで閉じる
//sqlite_close($link);

?>
