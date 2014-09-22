<?php
session_start();
//時刻を取得
$now = strtotime("now");

//Function
require_once "func.php";
//DB接続
include_once "DBcon.php";

$disp = "";

//ログアウト
if (isset($_POST["logout"])) {
	unset($_SESSION["userId"]);
}
//ログイン認証
if (!isset($_SESSION["userId"])) {
	if(isset($_POST["mail"])){
		$mail = mysql_real_escape_string($_POST["mail"]);
		$pass = mysql_real_escape_string($_POST["pass"]);
//		$loginfl = 0;
		try {
			$sql = "SELECT * FROM users WHERE mail = '".$mail."'";					//mailに一致した行のみ取得
			foreach ($dbh->query($sql)  as $row) {
    		}
		}catch (PDOException $e){
			echo("SELECTクエリーが失敗しました。".$e->getMessage());
			die();
		}
		if (empty($e)) {
			try {
				//spritfで代入する																																			3/5
				$sql = "SELECT id , name FROM users WHERE mail = '".$mail."' AND  pass = '".$pass."'";					//passに一致した行のみ取得
				foreach ($dbh->query($sql)  as $key => $row) {									//行は1つなので回さないでいい												3/4
					$_SESSION["userId"] = $row["id"];
					$userName = $row["name"];
    			}
			}catch (PDOException $e){
				echo("SELECTクエリーが失敗しました。".$e->getMessage());
				die();
			}
		}
	}
}else{
	try {
		//spritfで代入する																																			3/5
		$sql = "SELECT name FROM users WHERE id = ".$_SESSION["userId"];
		foreach ($dbh->query($sql)  as $key => $row) {
			$userName = $row["name"];
    	}
	}catch (PDOException $e){
		$error = "ログインできませんでした。".$e->getMessage();
		die();
	}
}
//テスト用
//unset($_SESSION["userId"]);


//商品ID取得
if (isset($_GET["id"])) {
	$goodId = $_GET["id"];

	//商品情報取得
	try {
		//spritfで代入する	
		$sql = sprintf("SELECT name , img1 , img2 , img3 , description , blandTitle , blandMessage , endDate , flBid , user_id FROM goods WHERE id = '%d'"
				, $goodId);
		$stmt = $dbh->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$goodName = $row["name"];
		$img[0] = $row["img1"];
		$img[1] = $row["img2"];
		$img[2] = $row["img3"];
		$description = $row["description"];
		$blandTitle = $row["blandTitle"];
		$blandMessage = $row["blandMessage"];
		$endDate = strtotime($row["endDate"]);
		$flBid = $row["flBid"];
		$goodUser_id = $row["user_id"];
	}catch (PDOException $e){
		$error = "SELECTクエリーが失敗しました。".$e->getMessage();
		die();
	}

	//終了していたら落札フラグON
	if ($endDate <= $now) {
		$flBid = 1;
    }

//入札情報取得
	if ( $flBid == 0) {
		//初期化
		$amount = 0;$bidUser_id=0;
		//未落札
		try {
			//spritfで代入する																																			3/5
			$sql = "SELECT user_id , amount FROM bids WHERE good_id = ".$goodId." ORDER BY amount DESC LIMIT 1";//$goodIdの商品の中から最高額を一つ
			foreach ($dbh->query($sql)  as $row) {									//行は1つなので回さないでいい												3/4
				$bidUser_id = $row["user_id"];
				$amount = $row["amount"];
    		}
		}catch (PDOException $e){
			$error = "SELECTクエリーが失敗しました。".$e->getMessage();
			die();
		}
		
		//残り時間計算
		$endDateafter = ceil(($endDate - $now) / 60);
		
		if ($endDateafter >= (60*24)) {
			$endDateafter = ceil($endDateafter / (60 * 24))." 日";
		}elseif ($endDateafter < (60*24) && $endDateafter > 60) {
			$endDateafter = floor($endDateafter/60)." 時間";
		}elseif ($endDateafter <= 60) {
			$endDateafter = $endDateafter." 分!";
		}else {
			$endDateafter = "(エラー：日数計算に失敗)";
		}
 
		if (isset($_SESSION["userId"])) {
			if ($bidUser_id == $_SESSION["userId"]) {
				$youBid = "<p>あなたが最高額を入札しています。</p>";
			}else{
				$youBid = "";
			}
			//入札
			if (isset($_POST["bidhigh"])) {
				//確認
				if (empty($_POST["bidamount"])) {
					$bidError = "入札額が指定されていません。";
				}else{
					if (!is_numeric($_POST["bidamount"])) {
						$bidError = "数値を入力してください。";
					}else{
						$bidAmount = $_POST["bidamount"];
						if ($bidAmount <= $amount) {
							$bidError = "現在の最高額より高い金額を入力してください。";
						}else{
						}
					}
				}
				$disp = "bidconfirm";
			}
			if (isset($_POST["bidadd"])) {
			//入札処理
				$bidAmount = $_POST["bidadd"];
				include_once "bidsDBadd.php";
				$disp = "bidadd";
			}
		}
	}
}
//GET,POSTエラー処理


//更新情報取得
try {
	$sql = "SELECT date , good_id , title , content FROM infos ORDER BY date DESC LIMIT 6";					//日付が新しい順に6件
	foreach ($dbh->query($sql)  as $key => $row) {
		$date[$key] = date("m月d日", strtotime($row["date"]));
		$infoGood_id[$key] = $row["good_id"];
		$title[$key] = stlimit($row["title"],15);															//文字制限15文字(func.php参照)
		$content[$key] = stlimit($row["content"],30);														//文字制限30文字(func.php参照)
    }
}catch (PDOException $e){
	$error = "SELECTクエリーが失敗しました。".$e->getMessage();
	die();
}
	
$dbh = null;

echo "<?xml version=\"1.0\" encoding=\"Shift-JIS\"?>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang	="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<!-- //////////// Site Name //////////// -->
<title><? echo $goodName; ?> | car auctin_test </title>

<!-- //////////// Website Icon //////////// -->
<link rel="shortcut icon" href="favicon.ico" />

<!-- //////////// STYLESSHEETS //////////// -->
<link href="css/style.css" type="text/css" rel="stylesheet" />
<link href="css/pirobox_lightbox.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />

<!-- //////////// SCRIPTS //////////// -->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="js/jquery.nivo.slider.pack.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/pirobox.min.js"></script>
<script src="js/jquery.slidinglabels.js" type="text/javascript"></script>
<script src="js/other.js" type="text/javascript"></script>


</head>

<?
include_once "disp/left.php";

if ($disp == "bidconfirm") {
	//入札確認画面
	if (!isset($bidError)) {
		echo "
	<div id=\"content\">
	<h2>入札確認</h2>
	<p>下記内容で入札いたします。よろしいですか？</p>
	<table class=\"confirmtable\">
		<tr>
			<td>商品名</td><td>".$goodName."</td>
		</tr>
		<tr>
			<td>現在の最高額</td><td>&yen;".number_format($amount)."</td>
		</tr>
		<tr>
			<td>入札額</td><td>&yen;".number_format($bidAmount)."</td>
		</tr>
		<tr>
		<form action=\"index.php?id=".$goodId."\" method=\"post\" id=\"bidform\">
			<td><button type=\"submit\" id=\"bidbtn\" name=\"bidadd\" value=\"".$bidAmount."\">入札する</button></td>
		</form>
			<td><input type=\"button\" value=\"戻る\" onClick=\"history.back()\"></td>
		</tr>
	</table>";
	}else{
		echo "
	<div id=\"content\">
	<h2>入札確認</h2>
	<p class=\"error\">エラーです。".$bidError."</p>
	<table class=\"confirmtable\">
		<tr>
			<td>商品名</td><td>".$goodName."</td>
		</tr>
		<tr>
			<td>現在の最高額</td><td>&yen;".number_format($amount)."</td>
		</tr>
		<tr>
			<form action=\"index.php?id=".$goodId."\" method=\"post\" id=\"bidform\">
				<td><label for=\"bid\">入札額</label></td>
				<td><input type=\"text\" id=\"bid\" name=\"bidamount\"";
		if (isset($bidAmount)) {
			echo " value=\"".$bidAmount."\"";
		}
		echo " />
		</tr>
		<tr>
			<td><button type=\"submit\" id=\"bidbtn\" name=\"bidhigh\">入札する</button></td>
			<td><input type=\"button\" value=\"戻る\" onClick=\"history.back()\"></td>
			</form>
		</tr>
	</table>";
	}
}elseif ($disp == "bidadd") {
		//入札完了画面
		echo "
	<div id=\"content\">
	<h2>入札完了</h2>
	<p>入札が完了いたしました。</p>
	<table class=\"confirmtable\">
		<tr>
			<td>商品名</td><td>".$goodName."</td>
		</tr>
		<tr>
			<td>現在の最高額</td><td><strong>&yen;".number_format($bidAmount)."</strong></td>
		</tr>
		<tr>
			<td colspan=\"2\"><input type=\"button\" value=\"戻る\" onClick=\"location.href='index.php?id=".$goodId."'\"></td>
		</tr>
	</table>";

}else{
	echo "
    <!-- //////////// Anchor used to scroll to HOME //////////// -->
    <a name=\"home\"></a>
    
    <!-- //////////// Content *Everything in Right-Hand Column* //////////// -->
    <div id=\"content\">
            
            <!-- //////////// NIVO SLIDER //////////// -->";
	if (!empty($img)) {
		echo "
            <div id=\"slider\">";
		for($i=0;$i<3;$i++){
			echo "<img src=\"images/slider/", $goodId, "/", $img[$i], "\" alt=\"\" />\n";
		}
		echo "
            </div>
            <br />";
	}
	echo "
            <h2>".$goodName."</h2>
            <p>".$description."</p>
            <h2>".$blandTitle."</h2>
            <p>".$blandMessage."</p>

    <!-- //////////// Anchor used to scroll to 入札状況 //////////// -->
    <a name=\"services\"></a>
            <h2>入札状況</h2>
            <p>".$goodName."の入札状況を表示しています。</p>
            <table cellpadding=\"0\" cellspacing=\"0\" class=\"bidtable\">";
	if ($flBid == 0) {
		//未落札
		echo "
                <tr>
                    <th>現在の入札状況：</th>
                    <th>最高額<br /><strong>&yen;" . number_format($amount) . "</strong><br />";
		if (isset($youBid)) {
			echo $youBid;
		}
		echo "
					</th>
                    <th>&nbsp;<br />残り<strong>&nbsp;".$endDateafter."</strong></th>";
		if(!isset($_SESSION["userId"])){
			echo "
                <tr>
                    <td class=\"textright\" colspan=\"3\">入札するにはログインしてください。</td>
                </tr>";
		}else{
			echo "
                <tr>
                    <td class=\"textright\" colspan=\"3\">
					<form action=\"index.php?id=".$goodId."\" method=\"post\" id=\"bidform\">
						<div class=\"bidtext\">
							<label for=\"bid\">入札金額</label>
							<input type=\"text\" id=\"bid\" name=\"bidamount\" />
						</div><!--//bid-wrap-->
						<div class=\"bidbtndiv\"><button type=\"submit\" id=\"bidbtn\" name=\"bidhigh\">入札する</button></div>
					</form>
					</td>
                </tr>";
		}
	}else{
		//落札済み
		echo "
                <tr>
                    <th>現在の入札状況：</th>
                    <th><strong>この商品は既に落札済みです</strong></th>
                </tr>
                <tr>
                    <td class=\"textright\" colspan=\"2\">&nbsp;</td>
                </tr>";
	}
	echo "
            </table>
    
    <!-- //////////// Anchor used to scroll to 更新情報 //////////// -->
    <a name=\"information\"></a>";
	if (!empty($infoGood_id)) {
		echo "
            	<h2>更新情報</h2>
            	<table cellpadding=\"0\" cellspacing=\"0\" class=\"infotable\">";
		for ($i=0; $i<sizeof($date); $i++) {
			echo "
                	<tr> <td>" . $date[$i] . "</td>
						<td><a href=\"index.php?id=" . $infoGood_id[$i] . "\"><span>" . $title[$i] . "</span></a></td>
						<td><p><a href=\"index.php?id=" . $infoGood_id[$i] . "\">" . $content[$i] . "</a></p></td>
					</tr>";
		}
		echo "
            	</table>";
	}
	include_once "disp/contact.html";
}
?>
</div><!-- //container -->
</body>
</html>
