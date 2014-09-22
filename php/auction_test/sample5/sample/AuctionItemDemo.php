<?php


require_once('../sdk/AuctionItem.php');

/**
 * このプログラムのパスを取得
 */
$self_path = $_SERVER['SCRIPT_NAME'];

/**
 * いくつかの記号をHTMLの表現形式に変換する関数の定義
 */
function convert($str) {
    return htmlspecialchars($str, ENT_QUOTES);
}

/**
 * フォームに入力されたオークションIDを取得
 */
$auctionID = '';
if (array_key_exists('auctionID', $_GET) && !empty($_GET['auctionID'])) {
    $auctionID = $_GET['auctionID'];
}

/**
 * 商品詳細APIのクラスオブジェクトを生成します。
 * 第１引数にアプリケーションID(appid)
 * 第２引数にAPIのバージョン(例：Version 2 ⇒　V2)
 * を指定してください。
 */
$obj = new AuctionItem('<あなたのアプリケーションID>', 'V2');

$result = null;
if ($auctionID) {

    /**
     * オークションIDをセットします。
     */
    $obj->setOption(AuctionItem::API_OPTION_AUCTIONID, $auctionID);

    /**
     * Yahoo!オークションWeb APIにリクエストを投げ、
     * 商品詳細情報を取得します。
     */
    $result = $obj->action();
}
?>

<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="content-style-type" content="text/css" />
<title>オークションデモサイト - オークション商品詳細</title>
<style type="text/css">
<!--
* {
    margin:0;
    padding:0;
}
body {
    font-family:verdona, Arial, Helvetica, sans-serif;
    line-height:1.5em;
    font-size:0.8em;
    letter-spacing:1px;
}
img {
    border-width:0px;
}
img.image{
    width:200px;
}
#wrapper {
    text-align:center;
}
#container:after{
	content: ".";
	display: block;
	height:0;
	font-size:0;
	clear:both;
	visibility:hidden;
}
#container{
	min-height:1px;
	margin:auto;
	text-align:left;
	padding: 15px 0px;
	width:800px;
}
* html #container{
	height:1px;
	overflow:visible;
}
#head {
}
#head {
    text-align:center;
    clear:both;
}
#center {
    clear:both;
}
.row {
    clear:both;
    margin-bottom:1px;
    padding-top:10px;
}
.leftcolumn {
    float:left;
    width:150px;
    font-weight:bold;
    text-align:left;
    border-bottom:1px solid #f0f0f0;
}
.rightcolumn {
    float:left;
    letter-spacing:0px;
}
.error{
    text-align:center;
    color:#f00;
}
-->
</style>
</head>
<body>
<div id="wrapper">
<div id="container">
<div id="head">
オークションデモサイト - オークション商品詳細
<br />
<br />
<form action"<?php echo convert($self_path); ?>" method="GET">
オークションID:<input type="text" name="auctionID" value="<?php echo convert($auctionID) ?>"/>
<input type="submit" value="表示" />
</form>
<br />
</div><!-- head -->

<?php
if (!($result instanceof SimpleXMLElement) || !empty($result->Message)) {
?>
<div class="error">
<?php
if ($result instanceof SimpleXMLElement) {
    echo convert($result->Message);
}
?>
</div><!-- error -->

<?php
} else {
    $optionHTML = "";
    foreach( $result->Result->Option->children() as $option ) {
        $optionHTML .= '<img src="' . convert($option) . '" />';
    }

    $imageHTML = "";
    foreach( $result->Result->Img->children() as $image ) {
        $imageHTML .= '<a href="' . convert($image) . '"><img class="image" src="' . convert($image) . '" /></a>';
    }
?>
<div id="center">

<div class="row">
<div class="leftcolumn">
オークションID
</div>
<div class="rightcolumn">
<?php echo convert($result->Result->AuctionID); ?>
</div>
</div>

<div class="row">
<div class="leftcolumn">
カテゴリのID
</div>
<div class="rightcolumn">
<?php echo convert($result->Result->CategoryID); ?>
</div>
</div>

<div class="row">
<div class="leftcolumn">
カテゴリパス
</div>
<div class="rightcolumn">
<?php echo convert($result->Result->CategoryPath); ?>
</div>
</div>

<div class="row">
<div class="leftcolumn">
タイトル
</div>
<div class="rightcolumn">
<?php echo convert($result->Result->Title); ?>
</div>
</div>

<div class="row">
<div class="leftcolumn">
商品URL
</div>
<div class="rightcolumn">
<a href="<?php echo convert($result->Result->AuctionItemUrl); ?>">商品詳細</a>
</div>
</div>


<div class="row">
<div class="leftcolumn">
出品者
</div>
<div class="rightcolumn">
    <div class="row">
    <div class="leftcolumn">
    Yahoo! JAPAN ID
    </div>
    <div class="rightcolumn">
    <?php echo convert($result->Result->Seller->Id); ?>
    </div>
    </div>

    <div class="row">
    <div class="leftcolumn">
    出品地域
    </div>
    <div class="rightcolumn">
    <?php echo convert($result->Result->Location); ?>
    </div>
    </div>

    <div class="row">
    <div class="leftcolumn">
    出品リストURL
    </div>
    <div class="rightcolumn">
    <?php echo convert($result->Result->Seller->ItemListURL); ?>
    </div>
    </div>
</div>
</div>

<div class="row">
<div class="leftcolumn">
画像
</div>
<div class="rightcolumn">
<?php echo $imageHTML; ?>
</div>
</div>

<div class="row">
<div class="leftcolumn">
開始価格
</div>
<div class="rightcolumn">
<?php echo convert(number_format($result->Result->Initprice)) . ' 円'; ?>
</div>
</div>

<div class="row">
<div class="leftcolumn">
現在価格
</div>
<div class="rightcolumn">
<?php echo convert(number_format($result->Result->Price)) . ' 円'; ?>
</div>
</div>

<div class="row">
<div class="leftcolumn">
商品の数
</div>
<div class="rightcolumn">
<?php echo convert($result->Result->Quantity); ?>
</div>
</div>

<div class="row">
<div class="leftcolumn">
現在の入札数
</div>
<div class="rightcolumn">
<?php echo convert($result->Result->Bids); ?>
</div>
</div>

<div class="row">
<div class="leftcolumn">
開始日時
</div>
<div class="rightcolumn">
<?php echo convert(date('n月 j日 H時 i分', strtotime($result->Result->StartTime))); ?>
</div>
</div>

<div class="row">
<div class="leftcolumn">
終了日時
</div>
<div class="rightcolumn">
<?php echo convert(date('n月 j日 H時 i分', strtotime($result->Result->EndTime))); ?>
</div>
</div>

<div class="row">
<div class="leftcolumn">
希望落札価格
</div>
<div class="rightcolumn">
<?php
if (!empty($result->Result->Bidorbuy)) {
    echo convert(number_format($result->Result->Bidorbuy)) . ' 円';
}
?>
</div>
</div>

<div class="row">
<div class="leftcolumn">
最低落札価格の有無
</div>
<div class="rightcolumn">
<?php
if (isset($result->Result->Reserved)) {
    echo '有り';
} else {
    echo '無し';
}
?>
</div>
</div>

<div class="row">
<div class="leftcolumn">
オプションアイコン
</div>
<div class="rightcolumn">
<?php echo $optionHTML; ?>
</div>
</div>

<div class="row">
<div class="leftcolumn">
商品説明
</div>
<div class="rightcolumn">
<?php echo $result->Result->Description; ?>
</div>
</div>

</div><!-- center -->
<?php } ?>

</div><!-- container -->
</div><!-- wrapper -->

<!-- Begin Yahoo! JAPAN Web Services Attribution Snippet -->
<a href="http://developer.yahoo.co.jp/about">
<img src="http://i.yimg.jp/images/yjdn/yjdn_attbtn2_105_17.gif" width="105" height="17" title="Webサービス by Yahoo! JAPAN" alt="Webサービス by Yahoo! JAPAN" border="0" style="margin:15px 15px 15px 15px" /></a>
<!-- End Yahoo! JAPAN Web Services Attribution Snippet -->

</body>
</html>
