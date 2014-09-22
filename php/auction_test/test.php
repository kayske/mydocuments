<?php
$dt = new DateTime();
$dt->setTimeZone(new DateTimeZone("Asia/Tokyo"));
echo $today = $dt->format("Y-m-d H:i:s");


// 比較する日付を設定
$target_day = "2014/3/1 10:00:00";
 
// 日付を比較
if (strtotime($target_day) > strtotime($today)) {
    echo "指定した日付は未来です。";
}
elseif(strtotime($target_day) < strtotime($today)) {
    echo "指定した日付は過去です。";
}
else {
    echo "指定した日付は今日です。";
}

echo "\n-----------------------------------------\n";

$expiration_date = '2014/3/2 14:45:00';
$unix_expiration = strtotime($expiration_date);
$now = strtotime('now');
 
$date_interval = round(($unix_expiration - $now) / 60);
 
if ($date_interval >= (60*24)) {
    $date_counter = '（残り '.ceil($date_interval/(60*24)).' 日）';
} elseif ($date_interval < (60*24) && $date_interval > 60) {
    $date_counter = '（残り '.floor($date_interval/60).' 時間）';
} elseif ($date_interval <= 60) {
    $date_counter = '（残り '.$date_interval.' 分!）';
} else {
    $date_counter = '(エラー：日数計算に失敗)';
}
 
echo $expiration_date.$date_counter;

include_once "admin/disp/gaddn.html";

echo "\n-----------------------------------------\n<br>";

$a="b";
$$a="C";

echo "C=".$b;

?>