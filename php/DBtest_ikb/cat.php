<?php
$Data=file("test.csv"); //���(1)
?>
<table>
<? for($i=0;$i<sizeof($Data);$i++){
$line=explode(", ", $Data[$i]); //���(2)
?>
<tr>
<td><? echo $line[1];?></td>
<td><? echo $line[2];?></td>
<td><? echo $line[3];?></td>
<td><? echo $line[4];?></td>
</tr><? } ?>
</table>
<p><? print_r($Data); ?></p>