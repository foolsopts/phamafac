$(function(){
  var gtop;
  var gthumb;
  var single_image;
  $("body").on("click", "._product_block", function(e) {
		$.fancybox.showLoading();
		id = $(this).attr('product-id');
		if(isNaN(id)){
			showProduct(page);
		}
		$.ajax({
			type: "POST",
			url: base_url+"product_block/getSelectList",
			data: 'id='+id,
			dataType: 'json',
			success: function(data) {
				if($.isArray(data)){
					$('#quickView .box3').empty();
					var sel = $('<select class="product_option fit-input form-control">').appendTo('#quickView .box3');
					$.each(data, function(key, value) {
						sel.append($("<option>").attr('value', value.product_no).text(value.product_size + ' | ' + value.product_color + ' | ' + value.price_default));
					});
					$('#quickView .product_option').val(id);
					$('#quickView .product_option').trigger('change');
				}
				return true;
			},
			error: function(data){
				console.log(data);
			}
		});
	});
  ////////////ON SELECT PRODUCT OPTION///////////////////////////////////////////////////////////
  $('body').on('change','.product_option',function(){
    $.fancybox.showLoading();
    var cart_control = $(this).closest('._cart_control');
    $('.btn.add_product',cart_control).addClass('disabled').text('wait..');
    $('.btn.add_product',cart_control).unbind("click");
    var img_block = $('#div-img .reload',cart_control);
    $(img_block).empty();
    $('<div class="signal"></div>').appendTo(img_block);
    id = $(this).val();
    $('.numberPieces',cart_control).val(1);
    var price;
    $.ajax({
      type: "POST",
      url: base_url+"product_block/detail",
      data: 'id='+id,
      dataType: 'json',
      success: function(data) {
        if($.isArray(data)){
          $('#div-img .reload',cart_control).load(base_url+"product_block/preview",{id:id},function(){
            gtop = $('.swiper-container._previewTop',cart_control);
            gthumb = $('.swiper-container._previewThumb',cart_control);
            $('.signal',cart_control).remove();
            single_image = parseInt(data[0].single_image);
            if($(cart_control).hasClass('full')||$('#quickView').hasClass('in')){
              if(single_image !== 1){
                galleryTop = new Swiper(gtop, {
                    nextButton: '.swiper-button-next',
                    prevButton: '.swiper-button-prev',
                    spaceBetween: 10
                });
                galleryThumb = new Swiper(gthumb, {
                    spaceBetween: 5,
                    centeredSlides: true,
                    slidesPerView: 5,
                    touchRatio: 0.2,
                    autoplay: 3000,
                    slideToClickedSlide: true
                });
                galleryTop.params.control = galleryThumb;
                galleryThumb.params.control = galleryTop;
              }
              intialize();
              $(".product_preview").css("visibility","visible");
            }
            if(data[0].catalog !== 1){
              if(data[0].out_of_stock_bypass !== 1){
                if(data[0].product_balance === "0"){
                  $('.option-box',cart_control).hide();
                  $('.pre-box',cart_control).show();
                }else{
                  $('.option-box',cart_control).show();
                  $('.pre-box',cart_control).hide();
                }
              }
            }else{
              $('.option-box',cart_control).hide();
              $('.catalog-box',cart_control).show();
              $('.pre-box',cart_control).hide();
            }
            $('.quick_view_info a').attr('href',base_url+"product/detail/"+data[0].product_no+"/"+data[0].friendly+".html");
            if($(cart_control).hasClass('compact')){
              $('.modal-title').text(data[0].product_name);
            }
            $('.idPro',cart_control).text(data[0].product_code);
            price = addCommas(parseFloat(data[0].price_default).toFixed(2));
            $('.qt',cart_control).text(price);
            $('.qt',cart_control).attr('price-data',	parseInt(data[0].price_default));

            $('._productname',cart_control).text(data[0].product_name);
            var model = "-";
            if(data[0].product_model.trim() !== ""){
              model = data[0].product_model;
            }
            $('._model',cart_control).text(model);
            var brand = "-";
            if(data[0].product_brand.trim() !== ""){
              brand = data[0].product_brand;
            }
            $('._brand',cart_control).text(brand);


            $('.warranty',cart_control).text("-");
            if(data[0].product_warranty !== "0"){
              switch(data[0].product_warranty){
                case "4":
                  $('.warranty',cart_control).text("LIFE TIME");
                break;

                default:
                  $('.warranty',cart_control).text(data[0].product_warranty_no+" "+data[0].product_warranty_name);
                break;
              }
            }
            if(data[0].product_description.trim() !== ""){
              $('._pdetail',cart_control).text(data[0].product_description).show();
              $('.text-nodetail',cart_control).hide();
            }else{
              $('._pdetail',cart_control).empty().hide();
              $('.text-nodetail',cart_control).show();
            }
            $('.btn.add_product',cart_control).removeClass('disabled').text('Add To Cart');
            $('.btn.add_product',cart_control).bind("click");
            if($(cart_control).hasClass('compact')){
              $('#quickView').modal('show');
            }
            $.fancybox.hideLoading();
          });
        }
        return true;
      },
      error: function(data){
        console.log(data);
      }
    });
  });
  $('#quickView').on('shown.bs.modal',function(){
    if(single_image !== 1){
      galleryTop = new Swiper(gtop, {
          nextButton: '.swiper-button-next',
          prevButton: '.swiper-button-prev',
          spaceBetween: 10
      });
      galleryThumb = new Swiper(gthumb, {
          spaceBetween: 5,
          centeredSlides: true,
          slidesPerView: 5,
          touchRatio: 0.2,
          autoplay: 3000,
          slideToClickedSlide: true
      });
      galleryTop.params.control = galleryThumb;
      galleryThumb.params.control = galleryTop;
    }
    intialize();
    $(".product_preview").css("visibility","visible");
  });
  ////////////////////////////////ON + OR - PRODUCT QUANTITY//////////////////////////////////////
  $('body').on('change','.numberPieces',function(){
    var cart_control = $(this).closest('._cart_control');
    qt = $(this).val();
    if(parseInt(qt) <= 0 || !$.isNumeric(qt)){
      $(this).val(1);
      qt = 1;
    }
    $('.qt',cart_control).text(addCommas(parseFloat($('.qt',cart_control).attr('price-data')*qt).toFixed(2))).highlight();
  });
  $('body').on('keyup','.numberPieces',function(){
    var cart_control = $(this).closest('._cart_control');
    qt = $(this).val();
    if(parseInt(qt) <= 0 || !$.isNumeric(qt)){
      $(this).val(1);
      qt = 1;
    }
    $('.qt',cart_control).text(addCommas(parseFloat($('.qt',cart_control).attr('price-data')*qt).toFixed(2))).highlight();
  });
  //////////////////////////////////////ON Push Add To Cart //////////////////////////////////////
  $('body').on('click','.add_product',function(){
    $.fancybox.showLoading();
    var cart_control = $(this).closest('._cart_control');
    qt = $('.numberPieces',cart_control).val();
    $(this).addClass('disabled').text('wait..');
    $('.add_product',cart_control).unbind("click");
    $.ajax({
      type: "POST",
      url: base_url+"product_block/addToCart/"+id+"/"+qt,
      //dataType: 'json',
      success: function(data) {
        //console.log(data);
        if(!$.isNumeric(data)){
          alert(data);
          $.fancybox.hideLoading();
        }else{
          $('.cart_count').text(data);
        }
        $('.add_product',cart_control).removeClass('disabled').text('Add To Cart');
        $('.add_product',cart_control).bind("click");
        $.fancybox.hideLoading();
        if($(cart_control).hasClass('compact')){
          $('#quickView').modal('hide');
        }
        var notify = {
          position: "left"
        };
        if($('body').scrollTop() > $('.cart_count').scrollTop()){
          $.notify("เพิ่มสินค้า "+qt+" ชิ้น","success");
        }else{
          $('.cart_count').notify(
            "เพิ่มสินค้า "+qt+" ชิ้น",{
              className: "success",
              position:"left bottom"
            }
          );
        }
        return true;
      },
      error: function(data){
        console.log(data);
        //alert(data);
      }
    });
  });
});
