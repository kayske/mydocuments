<?php
//Function
require_once "../func.php";
//DB接続
include_once "../DBcon.php";

//追加　　　　　　　　　　　　　　　　　　　　　　　　　--2/25
//
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang	="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift-JIS" />

<link href="admin.css" type="text/css" rel="stylesheet" />

</head>

<body>
<h2>入札者追加</h2>
<div>
	<form>
	<table>
		<tr>
			<td>お名前</td><td><input type="text" /></td>
		</tr>
		<tr>
			<td>メールアドレス</td><td><input type="text" /></td>
		</tr>
		<tr>
			<td>パスワード</td><td><input type="text" /></td>
		</tr>
		<tr>
			<td>VIP登録</td><td><input type="text" /></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" /></td>
		</tr>
	</table>
	</form>
</div>
</body>
</html>