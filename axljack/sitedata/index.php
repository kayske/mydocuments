<?php get_header(); ?>
<div id="contents">
<div id="top"><img src="<?php echo bloginfo('template_url'); ?>/images/car1.png" width="900" height="300" /></div>
  <div id="main">

<h2>テンプレートご利用の前に必ずお読み下さい</h2>
<p><span class="color1">■<strong>下の著作表示は外さないで下さい。</strong></span><br />
お守りいただけない場合、テンプレートの利用を中止し、違反金を請求いたします。 逆に、490円のライセンス料を支払う事により、外す事も可能です。<br />
<a href="http://nikukyu-punch.com/license/index.html" target="_blank">&gt;&gt;ライセンスコードお申し込みフォームはこちら</a></p>
<p><span class="color1">■<strong>WEB制作業者様、もしくは外部業者にWEB制作依頼を予定されている方へ</strong></span><br /> 

WEB制作代行用に当テンプレートを使う<strong>WEB制作業者</strong>様などの場合、必ず<strong>事業者登録</strong>(及びテンプレートコード取得)を行って下さい。<a href="http://nikukyu-punch.com/member.html" target="_blank">詳しくはこちら</a>。<br />
また、<strong>外部のWEB制作業者に制作を依頼予定</strong>の方の場合は、その制作業者側にこの事業者登録を行って頂く必要があります。<br />
違反された場合、罰則がございますので該当者様は<a href="http://nikukyu-punch.com/member.html" target="_blank">必ずご一読</a>下さい。</p>
<h2>Wordpressテーマcar1_blueについて</h2>
<p><span class="color1">■<strong>サイドバーの最新情報の項目について</strong></span><br /> 
What's Newは記事を更新をすると自動でタイトルが出力されるので便利です。</p>
<p><span class="color1">■<strong>トップの画像</strong></span><br /> 
Featured Content Galleryというプラグインを使用すると簡単にFlash画像に変更することが出来ます。設定に関しましては<a href="http://wp-site.biz/882" target="_blank">Featured Content Gallery 固定ページの画像を反映させる</a>をご参考ください。</p>
<h2>What's New</h2>
<dl class="new">
<?php query_posts('showposts=5'); ?>
<?php if (have_posts()):while(have_posts()):the_post(); ?>
<dt><?php the_time('Y.n.j'); ?></dt>
<dd><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title_attribute(); ?></a></dd>
 <?php endwhile; endif; ?></dl>
<p>上の「What's New」内の記事タイトルをクリックすると記事にリンクします。</p>
</div>
<!--/main-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
