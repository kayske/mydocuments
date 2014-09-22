<?php
include_once "DBcon.php";


//goodsテーブル
try {
	$sql = "SELECT id , name , img1 , img2 , img3 FROM goods WHERE flBid = 0 ORDER BY id DESC";
    foreach ($dbh->query($sql)  as $key => $row) {
		$id[$key] = $row["id"];
		$name[$key] = $row["name"];
		$img[$key][0] = $row["img1"];
		$img[$key][1] = $row["img2"];
		$img[$key][2] = $row["img3"];
    }
}catch (PDOException $e){
    print("SELECTクエリーが失敗しました。".$e->getMessage());
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
<title>商品一覧 | car auctin_test </title>

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

<script type="text/javascript">
$(document).ready(function() {
	$().piroBox({
			my_speed: 400, //animation speed
			bg_alpha: 0.6, //background opacity
			slideShow : true, // true == slideshow on, false == slideshow off
			slideSpeed : 4, //slideshow duration in seconds(3 to 6 Recommended)
			close_all : '.piro_close,.piro_overlay'// add class .piro_overlay(with comma)if you want overlay click close piroBox

	});
});
</script>

<!-- //////////// Settings for fixed sidebar layout //////////// -->
<script type="text/javascript">
$(document).ready(function() {

	function staticNav() { 
		var sidenavHeight = $("#sidenav").height();
		var winHeight = $(window).height();
		var browserIE6 = (navigator.userAgent.indexOf("MSIE 6")>=0) ? true : false;

		if (browserIE6) {
			$("#sidenav").css({'position' : 'absolute'});
		} else {
			$("#sidenav").css({'position' : 'fixed'});
		}
	
		if (sidenavHeight > winHeight) {
			$("#sidenav").css({'position' : 'static'});
		}
	}
	
	staticNav();
	
	$(window).resize(function () { //Each time the viewport is adjusted/resized, execute the function
		staticNav();
	});

});
</script>

<script type="text/javascript" src="js/smoothscroll.js"></script>

<!-- //////////// Settings for Nivo Slider //////////// -->

<script type="text/javascript">
    $(document).ready(function () {

            // transition effect
            style = 'easeOutBounce';

            // if the mouse hover the image
            $('.photo').hover(
                    function() {
                            //display heading and caption
                            $(this).children('div:first').stop(false,true).animate({top:0},{duration:600, easing: style});
                            $(this).children('div:last').stop(false,true).animate({bottom:0},{duration:600, easing: style});
                    },

                    function() {
                            //hide heading and caption
                            $(this).children('div:first').stop(false,true).animate({top:-50},{duration:600, easing: style});
                            $(this).children('div:last').stop(false,true).animate({bottom:-50},{duration:600, easing: style});
                    }
            );

    }); 
</script>

</head>

<body>

<!-- //////////// Container *Holds Left and Right Colums Together* //////////// -->
<div class="container">
    
    <!-- //////////// SideNavbar *Everything in Left-Hand Column* //////////// -->
    <div id="sidenav">
    	<img src="images/logo.png" alt="" class="logo" />
        
        
    </div><!-- //sidenav -->

    <!-- //////////// Content *Everything in Right-Hand Column* //////////// -->
    <div id="content">

    <!-- //////////// Anchor used to scroll to PORTFOLIO //////////// -->
    <a name="portfolio"></a>
            
            <h2>商品一覧</h2>
            
            <div id="portfolio">
			<?
			for($j=0;$j<sizeof($id);$j++){
				echo "
				<div class=\"photowrapper\">";
				if ($j == 0){
				echo "
				<div class=\"latest\"></div><!-- //latest -->";
//				<div class=\"featured\"></div><!-- //latest -->";
				} else {
				}
				echo "
				<div class=\"photo\">
				<div class=\"heading\"><a href=\"index.php?id=", $id[$j], "\"><span>", $name[$j], "</span></a></div>
				<a href=\"index.php?id=", $id[$j], "\"><img src=\"images/slider/", $id[$j], "/", $img[$j][0], "\" alt=\"\" /></a>
				<div class=\"imagecaption\">
				<span>Screenshots:</span>";
				for($i=0;$i<3;$i++){
					if (!empty($img[$j][$i])) {
						echo "
						<div class=\"mini\">
						<a href=\"images/slider/", $id[$j], "/", $img[$j][$i], "\" class=\"pirobox_work01\" title=\"", $name[$j], "\">0", ($i+1), "</a>
						</div>";
					}
				}
				echo "
				</div><!-- //imagecaption -->
				</div><!-- //photo -->
				<div class=\"photocaption\">
				<a href=\"index.php?id=", $id[$j], "\">", $name[$j], "</a>
				</div><!-- //photocaption -->
				</div><!-- //photowrapper -->\n";
			}
			?>
                
            </div><!-- //portfolio -->
            
    </div><!-- //content -->
    
</div><!-- //container -->
</body>
</html>