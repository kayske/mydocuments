<?php
//Function
require_once "../func.php";
//DB�ڑ�
include_once "../DBcon.php";


//�폜�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@--2/25
//�ύX�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@--2/25
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang	="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift-JIS" />

<link href="admin.css" type="text/css" rel="stylesheet" />

</head>

<body>
<h2>���D�ҏ��ύX�폜</h2>
<div>
	<form>
	<table>
		<tr>
			<th>ID</th><th>�����O</th><th>���[���A�h���X</th><th>�p�X���[�h</th><th>VIP�o�^</th><th>�ύX</th><th>�폜�{�^��</th>
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
		echo "<td><a href=\"\">�ύX</a></td><td><input type=\"submit\" /></td>
		</tr>";
		}
		?>
	</table>
	</form>
</div>
</body>
</html>