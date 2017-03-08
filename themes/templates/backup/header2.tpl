<!DOCTYPE html>
<html lang="en">
<head>
<!-- You can use Open Graph tags to customize link previews.
			Learn more: https://developers.facebook.com/docs/sharing/webmasters -->
<title>{$SITETITLE} | {block name="page_title"}{/block}</title>
<!---->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="author" content="">
<link rel="icon" href="{$ASSET}img/site_logo.ico">
<link href="{$ASSET}dist/css/reset.css" rel="stylesheet">
<!-- Bootstrap 3.3.5 -->
<link href="{$ASSET}dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="{$ASSET}dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="{$ASSET}dist/css/skins/_all-skins.min.css">
<!-- User Theme Customize css -->
<link href="{$ASSET}dist/css/user_customize/my.css" rel="stylesheet">
<!-- plugin css -->
<link href="{$ASSET}dist/css/perfect-scrollbar.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/css/swiper.min.css">
<!-- fancy box -->
<link rel="stylesheet" type="text/css" href="{$ASSET}js_plugins/fancyBox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
<link rel="stylesheet" type="text/css" href="{$ASSET}js_plugins/fancyBox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
<link rel="stylesheet" type="text/css" href="{$ASSET}js_plugins/fancyBox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
<!-- my css -->
<link href="{$ASSET}dist/css/animate.min.css" rel="stylesheet" type="text/css">
<link href="{$ASSET}js_plugins/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css">
<style>
section.content-header.draft:before{
	background-image: none;	
}
.slide_frame:after {
	background: url({$ASSET}img/slide_bg.jpg);	
}
</style>
{foreach $css as $key=>$c}
<!--////////////{$key}////////////////////-->
	{foreach $c as $cc}
		<link href="{$cc}" rel="stylesheet">
	{/foreach}
{/foreach}
</head>
<body class="hold-transition layout-top-nav skin-black-light sidebar-mini">
<div class="wrapper">
<header class="main-header"> 
	

	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top">
		{block name="sidebar-toggle"}
		{/block}
		<div class="container">
			<div class="navbar-header"> <a href="{$FCPATH}" class="navbar-brand"><span>Trimagic Coffee</span></a>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse"> <i class="fa fa-bars"></i> </button>
			</div>
			
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="navbar-collapse">
				<ul class="nav navbar-nav">
				</ul>
				<ul class="nav navbar-nav navbar-right vmedium">
					<li><a href="{$FCPATH}">หน้าแรก</a></li>
					<li><a href="{$FCPATH}shop.html">สินค้าของเรา</a></li>
					<li><a href="{$FCPATH}album.html">แกลอรี่</a></li>
					<li><a href="{$FCPATH}review.html">รีวิว</a></li>
					<li><a href="{$FCPATH}contact.html">ตัวแทนจำหน่าย</a></li>
					<li><a href="{$FCPATH}contact.html">เกี่ยวกับเรา</a></li>
					<li><a href="{$FCPATH}contact.html">ติดต่อทางร้าน</a></li>										
				</ul>
			</div>
			<!-- /.navbar-collapse --> 
		</div>
		<!-- /.container-fluid --> 
	</nav>
</header>
<!-- Left side column. contains the logo and sidebar --> 

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<div class="row">
<section class="content slide_frame" style="padding-bottom:0;min-height:0;">
<div class="row">
<div class="container">
{block name="slide"} 
{if $slide|@count gt 0} 
<!-- Slider main container -->
<div class="swiper-container" style="margin:auto;max-height: 500px;max-width:2048px;"> 
	<!-- Additional required wrapper -->
	<div class="swiper-wrapper"> 
		<!-- Slides --> 
		{foreach $slide as $s}
		<div class="swiper-slide"><img class="img-responsive" src="{$FCPATH}admin/gallery_dir/headslide/{$s}" style="margin:auto;"></div>
		{/foreach} </div>
	<!-- If we need pagination -->
	<div class="swiper-pagination"></div>
</div>
<!-- /.carousel --> 
{/if}
{/block}
</div>
</div>
</div>
</content>

<!-- Placed at the end of the document so the pages load faster --> 
<!-- jQuery 2.1.4 --> 
<script src="{$ASSET}plugins/jQuery/jQuery-2.1.4.min.js"></script> 
<!-- Bootstrap 3.3.5 --> 
<script src="{$ASSET}dist/js/bootstrap.min.js"></script> 
<!-- FastClick --> 
<script src="{$ASSET}plugins/fastclick/fastclick.js"></script> 
<!-- AdminLTE App --> 
<script src="{$ASSET}dist/js/app.js"></script> 
<script src="{$ASSET}dist/js_class/global.js"></script> 
<script src="{$ASSET}dist/js/startup.js"></script> 
<!-- SlimScroll 1.3.0 --> 
<script src="{$BASEURL}/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script> 
{block name="js"}
{/block} 
<!-- AdminLTE dashboard demo (This is only for demo purposes) --> 
<!--<script src="{$ASSET}dist/js/pages/dashboard2.js"></script> --> 
<!-- AdminLTE for demo purposes --> 
<!--<script src="{$ASSET}dist/js/demo.js"></script> --> 

<script type="text/javascript">
$(function(){
	var lazyOption = {
		effect : "fadeIn"
	};
	$(".lazy").lazyload(lazyOption);
});
</script> 
<!-- my js include -->

</body>
</html>