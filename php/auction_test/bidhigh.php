<?php
session_start();
//Function
require_once "func.php";
//DB接続
include_once "DBconnect.php";

//ログアウト
if (isset($_POST["logout"])) {
	unset($_SESSION["userId"]);
}
//ログイン認証
if (!isset($_SESSION["userId"])) {
	if(isset($_POST["mail"])){
		$mail = sqlite_escape_string($_POST["mail"]);
		$pass = sqlite_escape_string($_POST["pass"]);
//		$loginfl = 0;
		$sql = "SELECT * FROM users WHERE mail = '".$mail."'";					//mailに一致した行のみ取得
		$result = sqlite_query($link, $sql, SQLITE_BOTH, $sqliteerror);
		if (!$result) {
			$error = "ログインできませんでした。".$sqliteerror;
		}else{
			$sql = "SELECT id , name FROM users WHERE mail = '".$mail."' AND  pass = '".$pass."'";					//passに一致した行のみ取得
			$result = sqlite_query($link, $sql, SQLITE_BOTH, $sqliteerror);
			if (!$result) {
				$error = "パスワードが違います。".$sqliteerror;
			}else{
				$rows = sqlite_fetch_array($result, SQLITE_ASSOC);
				$_SESSION["userId"] = $rows["id"];
				$userName = $rows["name"];
			}
		}
	}
}else{
	$sql = "SELECT name FROM users WHERE id = ".$_SESSION["userId"];
	$result = sqlite_query($link, $sql, SQLITE_BOTH, $sqliteerror);
	if (!$result) {
		$error = "ログインできませんでした。".$sqliteerror;
	}else{
		$rows = sqlite_fetch_array($result, SQLITE_ASSOC);
		$userName = $rows["name"];
	}

}
//テスト用
//unset($_SESSION["userId"]);


//商品ID取得
if (isset($_GET["id"])) {
	$goodId = $_GET["id"];

	//商品情報取得
	$sql = "SELECT name , img1 , img2 , img3 , description , blandTitle , blandMessage , endDate , flBid , user_id FROM goods WHERE id = ".$goodId;
	$result = sqlite_query($link, $sql, SQLITE_BOTH, $sqliteerror);
	if (!$result) {
	    die("SELECTクエリーが失敗しました。".$sqliteerror);
	}
	$rows = sqlite_fetch_array($result, SQLITE_ASSOC);
	$goodName = $rows["name"];
	$img[0] = $rows["img1"];
	$img[1] = $rows["img2"];
	$img[2] = $rows["img3"];
	$description = $rows["description"];
	$blandTitle = $rows["blandTitle"];
	$blandMessage = $rows["blandMessage"];
	$endDate = $rows["endDate"];
	$flBid = $rows["flBid"];
	$goodUser_id = $rows["user_id"];


//入札情報取得
	if ( $flBid == 0) {
		//未落札
		$sql = "SELECT user_id , amount FROM bids WHERE good_id = ".$goodId." ORDER BY amount DESC LIMIT 1";//$goodIdの商品の中から最高額を一つ
		$result = sqlite_query($link, $sql, SQLITE_BOTH, $sqliteerror);
		if (!$result) {
			die("SELECTクエリーが失敗しました。".$sqliteerror);
		}
		$rows = sqlite_fetch_array($result, SQLITE_ASSOC);
		$bidUser_id = $rows["user_id"];
		$amount = $rows["amount"];
		
		if (isset($_SESSION["userId"])) {
			if ($bidUser_id == $_SESSION["userId"]) {
				$youBid = "<p>あなたが最高額を入札しています。</p>";
			}else{
				$youBid = "";
			}
		}
	}
}


//更新情報取得
$sql = "SELECT date , good_id , title , content FROM infos ORDER BY date DESC LIMIT 6";					//日付が新しい順に6件
$result = sqlite_query($link, $sql, SQLITE_BOTH, $sqliteerror);
if (!$result) {
    die("SELECTクエリーが失敗しました。".$sqliteerror);
}

for ($i = 0 ; $i < sqlite_num_rows($result) ; $i++){
	$rows = sqlite_fetch_array($result, SQLITE_ASSOC);
	$date[$i] = $rows["date"];
	$infoGood_id[$i] = $rows["good_id"];
	$title[$i] = stlimit($rows["title"],15);															//文字制限15文字(func.php参照)
	$content[$i] = stlimit($rows["content"],30);														//文字制限30文字(func.php参照)
}

sqlite_close($link);

echo "<?xml version=\"1.0\" encoding=\"Shift-JIS\"?>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang	="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift-JIS" />

<!-- //////////// Site Name //////////// -->
<title><? echo $g_name[$g_id]; ?> | car auctin_test </title>

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

<body>

<!-- //////////// Container *Holds Left and Right Colums Together* //////////// -->
<div class="container">
    
    <!-- //////////// SideNavbar *Everything in Left-Hand Column* //////////// -->
    <div id="sidenav">
    	<img src="images/logo.gif" alt="" class="logo" />
        
        <!-- //////////// MAIN NAVIGATION //////////// -->
        <ul>
            <li><a class="home" href="#home">ホーム</a></li>
            <li><a class="services" href="#services">入札状況</a></li>
            <li><a class="portfolio" href="#information">更新情報</a></li>
            <li><a class="contact" style="border-bottom: 0;" href="#contact">お問合せ</a></li>
        </ul>

        <!-- //////////// SOCIAL NETWORKING BLOCK //////////// -->
        <div id="social">
			<? if(!isset($_SESSION["userId"])){
				//未ログイン
				echo "
				<div id=\"login-form\" title=\"ログインフォーム\">
					<p>ログインフォーム</p>
					<form ";
				echo "action=\"index.php?id=". $goodId. "\"";
				echo " method=\"POST\">
					<fieldset>";
				if (isset($error)) {
					echo "
					<p>".$error."</p>
					<label for=\"email\">Email</label>
					<input type=\"text\" name=\"mail\" id=\"email\" value=\"".$mail."\" />
					<label for=\"password\">Password</label>
					<input type=\"password\" name=\"pass\" id=\"password\" value=\"\" />";
				}else{
					echo "
					<label for=\"email\">Email</label>
					<input type=\"text\" name=\"mail\" id=\"email\" value=\"\" />
					<label for=\"password\">Password</label>
					<input type=\"password\" name=\"pass\" id=\"password\" value=\"\" />";
				}
				echo "
					</fieldset>
					<button type=\"submit\" id=\"loginb\">ログイン</button>
					</form>
				</div>";
			}else{
				//ログイン済み
				echo "
				<div id=\"login-form\" title=\"ログインフォーム\">
					<p>ユーザ認証できました。<br />
					お客様名：<br />
					&nbsp;".$userName."様</p>
					<form ";
				echo "action=\"index.php?id=". $goodId. "\"";
				echo " method=\"POST\">
					<input type=\"hidden\" name=\"logout\" value=\"logout\" />
					<button type=\"submit\" id=\"loginb\">ログアウト</button>
					</form>
				</div>";
			} ?>
            <div class="social_facebook"><a href="http://www.facebook.com/" title="">&nbsp;</a></div><!-- //social_facebook -->
            <div class="social_twitter"><a href="http://www.twitter.com/" title="">&nbsp;</a></div><!-- //social_twitter -->
            <!--div class="social_flickr"><a href="http://www.flickr.com/" title="">&nbsp;</a></div--><!-- //social_flickr -->
        </div><!-- //social -->
        
        <!-- //////////// Sidenav Footer //////////// -->
        <div id="footer">
            &copy; wacsystem.co.jp 2014
        </div><!-- //footer -->
    </div><!-- //sidenav -->

    <!-- //////////// Anchor used to scroll to HOME //////////// -->
    <a name="home"></a>
    
    <!-- //////////// Content *Everything in Right-Hand Column* //////////// -->
    <div id="content">
            
            <!-- //////////// NIVO SLIDER //////////// -->
			<?
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
                </tr>";
				if(!isset($_SESSION["userId"])){
				echo "
                <tr>
                    <td class=\"textright\" colspan=\"2\">入札するにはログインしてください。</td>
                </tr>";
				}else{
				echo "
                <tr>
                    <td class=\"textright\" colspan=\"2\">
					<form action=\"bidhigh.php\" method=\"post\" id=\"bidform\">
						<div class=\"bidtext\">
							<label for=\"bid\">入札金額</label>
							<input type=\"text\" id=\"bid\" name=\"amount\" />
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
?>
            </table>
            
    
    <!-- //////////// Anchor used to scroll to 更新情報 //////////// -->
    <a name="information"></a>
            
			<? if (!empty($infoGood_id)) {
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
			} ?>
    
    <!-- //////////// Anchor used to scroll to CONTACT //////////// -->        
    <a name="contact"></a>
            
            <h2>お問合せ</h2>
            
            <form action="" method="post" id="contactform">
                <div id="name-wrap" class="slider"> 
                    <label for="name">Name</label> 
                    <input type="text" id="name" name="name" /> 
                </div><!--//name-wrap--> 
                
                <div id="email-wrap"  class="slider"> 
                    <label for="email">E&ndash;mail</label> 
                    <input type="text" id="email" name="email" /> 
                </div><!--//email-wrap-->
                
                <div id="phone-wrap"  class="slider"> 
                    <label for="phone">Phone</label> 
                    <input type="text" id="phone" name="phone" /> 
                </div><!--//phone-wrap--> 
                
                <div id="url-wrap"  class="slider"> 
                    <label for="url">URL</label> 
                    <input type="text" id="url" name="url" /> 
                </div><!--//email-wrap--> 
                
                <div id="comment-wrap"  class="slider"> 
                    <label for="comment">Comment</label> 
                    <textarea cols="53" rows="10" id="comment"></textarea> 
                </div><!--//comment-wrap--> 
                
                <div><button type="submit" id="btn" name="btn">Submit</button></div>
                
            </form>
            
            <div id="contactdetails">
                
                <!-- //////////// GoogleMapを入れるならiframe 張りぼてはimg //////////// -->
                <!--<img src="images/map.gif" alt="Map" />-->
                <iframe width="420" height="268" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?q=wacsystem&amp;iwloc=J&amp;ll=34.760265,135.496659&amp;z=15&amp;la=ja&amp;output=embed"></iframe>

                <p>
                <strong>運営会社</strong><br />
                社名：（株）ワックシステム<br />
                事業所：〒564-0051<br />大阪府吹田市豊津町1-21<br />エサカ中央ビル8F
                </p>
                
                <p>
                <strong>問合せ</strong><br />
                Tel :06-6190-3539<br />
                Fax : 06-6190-3039<br />
                E-mail : <a href="mailto:mail@wacsystem.co.jp" title="Email Us">mail@wacsystem.co.jp</a>
                </p>
                
            </div><!-- //contactdetails -->
            
            <div class="clearall"></div><!-- //clearall -->
            
            <div id="footfiller">
			footer(height200px)
            </div><!-- //footfiller -->
            
    </div><!-- //content -->
    
</div><!-- //container -->
</body>
</html>