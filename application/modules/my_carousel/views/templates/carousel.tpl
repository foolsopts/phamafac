<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
<link rel="stylesheet" type="text/css" href="http://kenwheeler.github.io/slick/slick/slick-theme.css"/>
<style>
.slick .img-responsive {
	margin:auto!important;
}
</style>
<div class="slick slick-1 mp-c">
  <div><img class="img-responsive" src="{$smarty.const.ROOTURL}_sandboxs/my_box/brandslide/6.png" alt=""></div>
  <div><img class="img-responsive" src="{$smarty.const.ROOTURL}_sandboxs/my_box/brandslide/7.png" alt=""></div>
  <div><img class="img-responsive" src="{$smarty.const.ROOTURL}_sandboxs/my_box/brandslide/8.jpg" alt=""></div>
	<div><img class="img-responsive" src="{$smarty.const.ROOTURL}_sandboxs/my_box/brandslide/9.jpg" alt=""></div>
	<div><img class="img-responsive" src="{$smarty.const.ROOTURL}_sandboxs/my_box/brandslide/12.png" alt=""></div>
</div>
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
<script>
$(document).ready(function(){
  $('.slick-1').slick({
	  centerMode: true,
	  centerPadding: '60px',
		dots: true,
		autoplay: true,
 		autoplaySpeed: 2000,
	  slidesToShow: 3,
	  responsive: [
	    {
	      breakpoint: 768,
	      settings: {
	        arrows: false,
	        centerMode: true,
	        centerPadding: '40px',
	        slidesToShow: 3
	      }
	    },
	    {
	      breakpoint: 480,
	      settings: {
	        arrows: false,
	        centerMode: true,
	        centerPadding: '40px',
	        slidesToShow: 1
	      }
	    }
	  ]
	});
	$(window).on('resize orientationchange',function(){
		$('.slick-1').slick('resize');
	})
});
</script>
