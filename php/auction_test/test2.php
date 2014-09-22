<?php
$root = "/var/www/html/CC/auction_test";
$link = sqlite_open($root . '/db/test.db', 0666, $sqliteerror);
if (!$link) {
    die('接続失敗です。'.$sqliteerror);
}

print('接続に成功しました。<br>');

//sqlite_escape_string
/*パラメータのエスケープ*/
//string sprintf ( string $format [, mixed $args [, mixed $... ]] )　指定の形式にフォーマット
//sqlite_query ( dbhandle, query [,result_type [, &error_msg]] );
//sqlite_fetch_array(result [, result_type [, decode_binary]]);


//INSERT INTO テーブル名(カラム, カラム) VALUES ('値', '値')
//CREATE TABLE テーブル名 (カラム名1 データ型, カラム名2 データ型, ...)

$sql = "SELECT id, name FROM shouhin";
$result = sqlite_query($link, $sql, SQLITE_BOTH, $sqliteerror);
if (!$result) {
    die('クエリーが失敗しました。'.$sqliteerror);
}

for ($i = 0 ; $i < sqlite_num_rows($result) ; $i++){
    $rows = sqlite_fetch_array($result, SQLITE_ASSOC);
    print('id='.$rows['id']);
    print(',name='.$rows['name'].'<br>');
}


$id = 2;
$name = 'デジタルカメラ';
$sql = sprintf("UPDATE shouhin SET name = '%s' WHERE id = %s"
         , sqlite_escape_string($name), $id);
$result_flag = sqlite_exec($link, $sql, $sqliteerror);

if (!$result_flag) {
    die('クエリーが失敗しました。'.$sqliteerror);
}else{
    print(sqlite_changes($link).'件のレコードを更新しました。<br>');
}


$sql = "SELECT id, name FROM shouhin";
$result = sqlite_query($link, $sql, SQLITE_BOTH, $sqliteerror);
if (!$result) {
    die('クエリーが失敗しました。'.$sqliteerror);
}

for ($i = 0 ; $i < sqlite_num_rows($result) ; $i++){
    $rows = sqlite_fetch_array($result, SQLITE_ASSOC);
    print('id='.$rows['id']);
    print(',name='.$rows['name'].'<br>');
}


sqlite_close($link);

print('切断しました。<br>');



?>

<!doctype html>
<html lang="jp">
<head>
	<meta charset="SHIFT-JIS">
</head>
<body>


</body>
</html>
