<?php
$Data=file("test.csv"); //‰ðà(1)
?>
<table>
<? for($i=0;$i<sizeof($Data);$i++){
$line=explode(", ", $Data[$i]); //‰ðà(2)
?>
<tr>
<td><? echo $line[1];?></td>
<td><? echo $line[2];?></td>
<td><? echo $line[3];?></td>
<td><? echo $line[4];?></td>
</tr><? } ?>
</table>
<p><? print_r($Data); ?></p>