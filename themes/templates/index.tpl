<!DOCTYPE html>
<!--
#   /$$$$$$$$                  /$$                                 /$$
#  | $$_____/                 | $$                                | $$
#  | $$     /$$$$$$   /$$$$$$ | $$  /$$$$$$$  /$$$$$$   /$$$$$$  /$$$$$$   /$$$$$$$
#  | $$$$$ /$$__  $$ /$$__  $$| $$ /$$_____/ /$$__  $$ /$$__  $$|_  $$_/  /$$_____/
#  | $$__/| $$  \ $$| $$  \ $$| $$|  $$$$$$ | $$  \ $$| $$  \ $$  | $$   |  $$$$$$
#  | $$   | $$  | $$| $$  | $$| $$ \____  $$| $$  | $$| $$  | $$  | $$ /$$\____  $$
#  | $$   |  $$$$$$/|  $$$$$$/| $$ /$$$$$$$/|  $$$$$$/| $$$$$$$/  |  $$$$//$$$$$$$/
#  |__/    \______/  \______/ |__/|_______/  \______/ | $$____/    \___/ |_______/
#  Developer: Foolsopts(Foolsopts@hotmail.com)        | $$
#  Company : Thevirus Infomation and Technology.co.,ltd $$
#                                                     |__/
-->

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="site_url" content="{$smarty.const.ROOTURL}" />
	<title>{$site_title} | Main view</title>
	<link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
	<link href="{$smarty.const.ROOTURL}_glob_res/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="{$smarty.const.ROOTURL}_glob_res/font-awesome/css/font-awesome.css" rel="stylesheet">
	<link href="{$smarty.const.ROOTURL}_glob_res/assets/css/animate.css" rel="stylesheet">
	<link href="{$smarty.const.ROOTURL}_glob_res/assets/css/style.css" rel="stylesheet">
	<!-- Themes -->
	<link href="{$smarty.const.ROOTURL}assets/css/main.css" rel="stylesheet">
	<!-- Product -->
	<link href="{$smarty.const.ROOTURL}assets/css/product.css" rel="stylesheet">
	<!-- waitMe -->
	<link href="{$smarty.const.ROOTURL}_glob_res/css/plugins/waitMe/waitMe.min.css" rel="stylesheet">
	<style>
		.container-fluid {
			max-width: 1420px!important;
		}
	</style>
	{$css}
	<script src="{$smarty.const.ROOTURL}_glob_res/jquery/jquery-2.1.1.js"></script>
</head>

<body data-page="{$current_controller}">
<div class="my_parallax">
	<nav class="navbar" style="min-height:25px;border-radius:0;margin-bottom:0;">
		<div class="container-fluid">
			<div class="logo">
				<img class="img-responsive" src="{$BASEURL}assets/img/logo-a.png">
			</div>
		</div>
	</nav>
</div>
	<nav id="top-menu" class="navbar navbar-default m-b-xs-0 m-b-sm-5">
		<div class="navbar-inner">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
				<a class="navbar-brand hide" href="#" style="border-right:2px solid gainsboro;">Sangaroonbike</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li data-active="welcome"><a href="{$smarty.const.ROOTURL}">HOME</a></li>
					<li data-active="info"><a href="info.html">INFORMATION</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							DOWNLOAD<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
              <li><a href="#">Action</a></li>
              <li><a href="#">Another action</a></li>
              <li><a href="#">Something else here</a></li>
              <li role="separator" class="divider"></li>
              <li class="dropdown-header">Nav header</li>
              <li><a href="#">Separated link</a></li>
              <li><a href="#">One more separated link</a></li>
            </ul>
					</li>
					<li class="drodown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							GALLERY<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
              <li><a href="#">Portfolio</a></li>
              <li><a href="#">Activity</a></li>
              <li><a href="#">Showroom</a></li>
            </ul>
					</li>
					<li data-active="contact"><a href="contact.html">CONTACT<span class="hidden-sm"> US</span></a></li>
					<li><a href="servince.html">SERVICE</a></li>
					<li><a href="#train">TRAINING</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<form class="navbar-form">
						<div class="form-group">
							<div class="input-group">
								<input type="text" name="key" class="form-control" placeholder="Search">
								<div class="input-group-addon">
									<button type="button" class="btn btn-default btn-search _btn_search"><i class="fa fa-search"></i></button>
								</div>
							</div>
						</div>
					</form>
				</ul>
				<!--/.nav-collapse -->
			</div>
		</div>
	</nav>
	<div class="wrapper">
		<section class="content">
			{include file = "$include"}
		</section>
		<!--/.section.content -->
		<div class="push"></div>
	</div>
	<!--/.wrapper -->
	<div class="footer" style="background: gainsboro;padding:0 0 0 0;background:#0d2934;display:inline-block;width:100%;">
		<div class="topper_footer gap-xs-15" style="height:220px;background:url({$smarty.const.ROOTURL}assets/img/footer.jpg)no-repeat center;padding:85px 0;">
			<form class="navbar-form" style="max-width:450px;margin:auto;box-shadow: 0 0 25px -10px;">
				<div class="form-group">
					<div class="input-group">
						<input type="text" name="key" class="form-control" placeholder="Search">
						<div class="input-group-addon" style="width:1%;">
							<button type="submit" class="btn btn-default btn-search _btn_search"><i class="fa fa-search"></i></button>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="container">
			<div class="col-sm-4 text-center" style="color: white;">
				<h2>CONTACT US</h2>
				<ul class="item-list">
					<li><a href="#"><i class="fa fa-phone"></i>02-1574511 FAX : 02-1574510</a></li>
					<li><a href="#"><i class="fa fa-envelope"></i>admin@pharmafacgroup.com</a></li>
					<li class="social">
						<i class="fa"></i>
						<img src="{$smarty.const.ROOTURL}assets/img/social/fb.png" alt="">
						<img src="{$smarty.const.ROOTURL}assets/img/social/ig.png" alt="">
						<img src="{$smarty.const.ROOTURL}assets/img/social/tw.png" alt="">
					</li>
				</ul>
			</div>
			<div class="col-sm-4 col-sm-offset-4 text-center" style="color: white;">
				<h2>OFFICE HOURS</h2>
				<ul class="item-list">
					<li><i class="fa fa-clock-o"></i>จันทร์ - ศุกร์ เวลา 08.00 - 17.00</li>
				</ul>
			</div>
			<div class="col-xs-12 text-center" style="border-top:1px solid">
				<div style="padding:5px;color: white;">2016 - 2017 All Right Reserved Developed by TheVirus Information and Technology Co., Ltd.</div>
			</div>
		</div>
	</div>
	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<!-- Mainly scripts -->
	<script src="{$smarty.const.ROOTURL}_glob_res/bootstrap/js/bootstrap.min.js"></script>
	<script src="{$smarty.const.ROOTURL}_glob_res/assets/js/core.js"></script>
	<!-- waitMe -->
	<script src="{$smarty.const.ROOTURL}_glob_res/js/plugins/waitMe/waitMe.js"></script>
	{$js}
</body>

</html>
