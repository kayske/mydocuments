<?php
//Function
require_once "../func.php";
//DB接続
include_once "../DBcon.php";


//削除　　　　　　　　　　　　　　　　　　　　　　　　　--2/25
//変更　　　　　　　　　　　　　　　　　　　　　　　　　--2/25
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang	="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift-JIS" />

<link href="admin.css" type="text/css" rel="stylesheet" />

</head>

<body>
<h2>入札者情報変更削除</h2>
<div>
	<form>
	<table>
		<tr>
			<th>ID</th><th>お名前</th><th>メールアドレス</th><th>パスワード</th><th>VIP登録</th><th>変更</th><th>削除ボタン</th>
		</tr>
		<? for ($i=1; $i<sizeof($b_id); $i++) {
		echo "
		<tr>
			<td>" . $b_id[$i] . "</td><td>" . $b_name[$i] . "</td><td>" . $b_mail[$i] . "</td><td>" . $b_pass[$i] . "</td>
			<td>";
		if ($b_vip[$i] == 1){
			echo "VIP</td>";
		}else{
			echo "&nbsp;</td>";
		};
		echo "<td><a href=\"\">変更</a></td><td><input type=\"submit\" /></td>
		</tr>";
		}
		?>
	</table>
	</form>
</div>
</body>
</html>