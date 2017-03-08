// JavaScript Document
var count = 0;
var price = 0;
var q = 0;
$(function() {
	$('.quantity').on('blur', function() {
		if ($(this).val() < 1 && $(this).val() === "") {
			$(this).val('1');
			$(this).trigger('change');
		}
	});
	$('.quantity').on('change', function() {
		$this = $(this);
		$.fancybox.showLoading();
		var $price = $this.closest('tr').find('.q');
		//console.log($price.text());
		var $total = $this.closest('tr').find('.price');
		var code = $this.closest('tr').attr('id');
		var qt = $this.val();
		if (qt === "") {
			qt = 1;
		}
		$.ajax({
			type: "POST",
			url: base_url + "product_block/addToCart/" + code + "/" + qt + "/edit",
			//data : "mode=edit&code="+code+"&quantity="+qt,
			success: function(data) {
				//console.log($price.attr('price-data')*qt);
				$total.text(addCommas(parseFloat($price.attr('price-data') * qt).toFixed(2)));
				re_price();
				re_count();
			}
		});
		//alert($price.text());
		//$('.price').text(addCommas(parseFloat($('.quantity').val()*$('.price').text()).toFixed(2)));

	});
	$('.cart_del').on('click', function() {
		$this = $(this);
		if (!window.confirm('คุณต้องการลบสินค้าชิ้นนี้ออกจากตะกร้าสินค้าใช่หรือไม่?')) {
			return false;
		}
		$.fancybox.showLoading();
		var parent = $this.closest('tr');
		var code = $this.closest('tr').attr('id');
		$.ajax({
			type: "POST",
			url: base_url + "product_block/addToCart/" + code + "/NULL/del",
			//data : "mode=del&code="+code ,
			success: function(data) {
				$(parent).remove();
				$('.total_cat').text($('.total_cat').text() - 1);
				if ($('.total_cat').text() === '0') {
					$('#no_product').show();
					$(".have-pro").hide();
				}

				re_price();
				re_count();

			}
		});
	});

	function re_price() {
		$('.price').each(function() {
			price = $(this).text().replace(/,/g, '').split('.')[0];
			// alert(price);
			price = parseInt(price);
			count = count + price;
			//alert(count);
			//count = count.parseInt();
			// console.log(price);

		});
		$('.sum_total').text(addCommas(parseFloat(count).toFixed(2)));
		count = 0;
		price = 0;
	}

	function re_count() {
		$('.quantity').each(function() {
			q = q + parseFloat($(this).val());
		});
		$('.total_sum').text(q);
		q = 0;
		$('.cart_count').load(base_url + "product_block/addToCart");
		$.fancybox.hideLoading();
	}
	var numQuantity;
	$('.quantity ').on('change', function(e) {
		var str = $(this).val();
		if (str == '') {
			$(this).val(1);
			return;
		}
		numQuantity = parseInt(str);
		// alert(numQuantity );
		if (numQuantity <= 0) {
			alert('จำนวนสินค้าต้องเริ่มต้นที่ 1 ชิ้น');
			$(this).val(1);
		}
		if (numQuantity > 1000) {
			alert('จำนวนสินค้าต้องไม่เกิน 1,000 ชิ้น ต่อครั้ง');
			$(this).val(1000);
		}

	});

});
