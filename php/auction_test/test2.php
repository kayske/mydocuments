<?php
$root = "/var/www/html/CC/auction_test";
$link = sqlite_open($root . '/db/test.db', 0666, $sqliteerror);
if (!$link) {
    die('�ڑ����s�ł��B'.$sqliteerror);
}

print('�ڑ��ɐ������܂����B<br>');

//sqlite_escape_string
/*�p�����[�^�̃G�X�P�[�v*/
//string sprintf ( string $format [, mixed $args [, mixed $... ]] )�@�w��̌`���Ƀt�H�[�}�b�g
//sqlite_query ( dbhandle, query [,result_type [, &error_msg]] );
//sqlite_fetch_array(result [, result_type [, decode_binary]]);


//INSERT INTO �e�[�u����(�J����, �J����) VALUES ('�l', '�l')
//CREATE TABLE �e�[�u���� (�J������1 �f�[�^�^, �J������2 �f�[�^�^, ...)

$sql = "SELECT id, name FROM shouhin";
$result = sqlite_query($link, $sql, SQLITE_BOTH, $sqliteerror);
if (!$result) {
    die('�N�G���[�����s���܂����B'.$sqliteerror);
}

for ($i = 0 ; $i < sqlite_num_rows($result) ; $i++){
    $rows = sqlite_fetch_array($result, SQLITE_ASSOC);
    print('id='.$rows['id']);
    print(',name='.$rows['name'].'<br>');
}


$id = 2;
$name = '�f�W�^���J����';
$sql = sprintf("UPDATE shouhin SET name = '%s' WHERE id = %s"
         , sqlite_escape_string($name), $id);
$result_flag = sqlite_exec($link, $sql, $sqliteerror);

if (!$result_flag) {
    die('�N�G���[�����s���܂����B'.$sqliteerror);
}else{
    print(sqlite_changes($link).'���̃��R�[�h���X�V���܂����B<br>');
}


$sql = "SELECT id, name FROM shouhin";
$result = sqlite_query($link, $sql, SQLITE_BOTH, $sqliteerror);
if (!$result) {
    die('�N�G���[�����s���܂����B'.$sqliteerror);
}

for ($i = 0 ; $i < sqlite_num_rows($result) ; $i++){
    $rows = sqlite_fetch_array($result, SQLITE_ASSOC);
    print('id='.$rows['id']);
    print(',name='.$rows['name'].'<br>');
}


sqlite_close($link);

print('�ؒf���܂����B<br>');



?>

<!doctype html>
<html lang="jp">
<head>
	<meta charset="SHIFT-JIS">
</head>
<body>


</body>
</html>
