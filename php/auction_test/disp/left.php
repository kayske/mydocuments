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
