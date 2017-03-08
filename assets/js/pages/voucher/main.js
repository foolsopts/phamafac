Dropzone.autoDiscover = false;
var myDropzone;
$(function() {
	//--- Set Page Defaults Plugins Setting --//
	$.fn.datepicker.defaults.startDate = '+';
  $.fn.datepicker.defaults.language = 'th';


	//---- DROPZONE initialize ---////
	var drop_limit = $('#dropzoneForm').attr('data-drop-limit');
	var drop_size_limit = $('#dropzoneForm').attr('data-size-limit');
	var drop_type_limit = $('#dropzoneForm').attr('data-type-limit');
	var drop_count = 0;
	try{
	  myDropzone = new Dropzone("div#dropzoneForm", {
	    paramName: "my_file",
	    url: base_url+"pcgadmin/voucher/upload.html",
			maxFilesize: drop_size_limit, // MB
	    dictDefaultMessage: "<strong>โยนรูปลงที่นี่ หรือคลิกเพื่ออัพโหลด. </strong></br> (รองรับเฉพาะไฟล์ "+drop_type_limit+" ที่ขนาดไม่เกิน "+drop_size_limit+" mb และจำกัดไม่เกิน "+drop_limit+" รูปต่อรายการ.)",
			dictFileTooBig: "ขนาดไฟล์ {{filesize}}mb. ใหญ่เกินไป ขนาดต้องไม่เกิน {{maxFilesize}}mb.",
			dictInvalidFileType: "อัพโหลดได้เฉพาะไฟล์ภาพเท่านั้น",
			dictRemoveFile: "ลบ",
			dictRemoveFileConfirmation: 'คุณต้องการลบรูปนี้?',
	    autoProcessQueue: false,
			acceptedFiles: "image/*",
			thumbnailWidth: 150,
	    uploadMultiple: false,
	    parallelUploads: 100,
			addRemoveLinks: true,
	    maxFiles: drop_limit,

	    // Dropzone settings
	    init: function() {
	        //var myDropzone = this;
	        this.on("sendingmultiple", function() {
						alert(22);
	        });
	        this.on("successmultiple", function(files, response) {
	          alert(response);
	        });
	        this.on("errormultiple", function(files, response) {
						alert(response);
	        });
					this.on('success',function(files, response){
						$('.dz-preview').addClass('mocked');
						console.log(response);
					});
					this.on("complete", function (file) {
			      if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
			      	location.reload();
			      }
			    });
	    }
	  });

		//-------- When Add file Event ---------//
		myDropzone.on('addedfile',function(files){
			//console.log(drop_limit);
			if(drop_count < drop_limit){
				drop_count++;
			}else{
				this.removeFile(files);
			}
			$('._drop_count_text').text(drop_count);
		});
		//-------- When Remove File event -------//
		myDropzone.on('removedfile', function(file, serverFileName) {
			console.log(file.status);
			if($(file.previewElement).hasClass('mocked')||file.status !== "added"){
				drop_count--;
			}
			if($(file.previewElement).hasClass('mocked')){
				$.ajax({
					url: base_url+"pcgadmin/voucher/delete_voucher_img.html",
					data:"name="+file.name,
					type:"GET",
					dataType:"json",
					success: function(data) {
						console.log(data);
						if(data.stat !== "success"){
							var mockFile = {
								name: file.name,
								size: file.size
							};
							myDropzone.emit("addedfile", mockFile);
							myDropzone.createThumbnailFromUrl(mockFile, base_url+"sandboxs/voucher/"+data.data.attr+"/img/"+file.name);
							$('.dz-progress').hide();
							$('.dz-preview').addClass('mocked');
						}
						if(data.stat === "fail"){
							drop_count++;
						}
					}
				});
			}
			$('._drop_count_text').text(drop_count);
		});

		//--- Load Voucher Image if Exist---///
		$.ajax({
			url: base_url+"pcgadmin/voucher/get_voucher_imgList",
			dataType:"json",
			success: function(data) {
				console.log(data.data);
				if (data.stat === "success") {
					$.each(data.data.list, function(key, value) {
						var mockFile = {
							name: value.name,
							size: value.size
						};
						myDropzone.emit("addedfile", mockFile);
						myDropzone.createThumbnailFromUrl(mockFile, base_url+"sandboxs/voucher/"+data.data.id+"/img/"+value.name);
						$('.dz-progress').hide();
						$('.dz-preview').addClass('mocked');
					});
				}
			}
		});
	}catch(e){

	}
	//--- initializing Plugins --//
	$('.i-checks').iCheck({
		checkboxClass: 'icheckbox_square-green',
		radioClass: 'iradio_square-green',
	});
	$('input[name="price"]').TouchSpin({
		min: 0,
    max: 1000000000,
    buttondown_class: 'btn btn-white',
    buttonup_class: 'btn btn-white'
	});
	$('input[name="quantity"]').TouchSpin({
		min: 1,
    max: 1000000000,
    buttondown_class: 'btn btn-white',
    buttonup_class: 'btn btn-white'
  });

	$('.summernote').summernote({
		lang: 'th-TH', // default: 'en-US'
		height: null, // set editor height
		minHeight: 250, // set minimum height of editor
		maxHeight: null, // set maximum height of editor
		focus: true // set focus to editable area after initializing summernote
	});
	$(".select2._category").select2({
		placeholder: "เลือก / เพิ่ม",
		allowClear: false,
		maximumSelectionLength: 1,
		tags: true,
		theme: "bootstrap"
	});
	$(".select2._heading").select2({
		placeholder: "เลือก",
		minimumResultsForSearch: Infinity,
		allowClear: false,
		theme: "bootstrap"
	});
	$(".select2._quantity_unit").select2({
		placeholder: "เลือก",
		minimumResultsForSearch: Infinity,
		allowClear: false,
		theme: "bootstrap"
	});
  $(".select2._status").select2({
		placeholder: "เลือก",
		minimumResultsForSearch: Infinity,
		allowClear: false,
		theme: "bootstrap"
	});
	$('.ladda-button').ladda();
	var limit_date = $('.input-group.date').datepicker({
		startDate: "+"
	});

	//--- Initialize Ajax Form --//
	var options = {
		//target:        '#output1',   // target element(s) to be updated with server response
		beforeSubmit: function(formData, jqForm, options) {

			var queryString = $.param(formData);
			//console.log(queryString);
			return true;
		}, // pre-submit callback
		success: function(responseText, statusText, xhr, $form) {
			console.log(responseText);

			if(responseText.stat === "success"){
				if($('.dz-preview:not(.mocked)').length > 0){
					$('[href="#tab-4"]').tab('show');
					myDropzone.processQueue();
				}else{
					location.reload();
				}
			}else{
				//console.log(responseText.data);
				alert("มีบางอย่างผิดพลาด")
			}
			//location.reload();
		}, // post-submit callback
		dataType: 'json' // 'xml', 'script', or 'json' (expected server response type)
	};

	// bind form using 'ajaxForm'
	$('form#_product_edit').ajaxForm(options);

	$('._product_delete').on('click',function(){
		$.ajax({
			url: base_url+"pcgadmin/voucher/product_delete",
			dataType:"json",
			success: function(data) {
				console.log(data);
			}
		});
	});
	//--- Checkbox Startup Event ---///
	if($('._auto_code').length <= 0||$('._auto_code:checked').val()==="on"){
		$('input[name=code]').prop('disabled', true);
	}else{
		$('input[name=code]').prop('disabled', false);
	}
	if(typeof($('._set_expire:checked').val()) === "undefined"){
		limit_date.datepicker('remove');
		$('input[name=expire]').prop('disabled', true);
	}
	if(typeof($('._unlimit_quantity:checked').val()) === "undefined"){
		$('input[name=quantity]').prop('disabled', false);
		$('select[name=quantity_unit]').prop('disabled', false).val(1);
	}else{
		$('input[name=quantity]').prop('disabled', true).val('0');
		$('select[name=quantity_unit]').prop('disabled', true).select2("val", "");
	}
	//-- ON Checked / unCheck Unlimit Quantity --//
	$('._unlimit_quantity').on('ifChecked', function() {
		$('input[name=quantity]').prop('disabled', true).val('0');
		$('select[name=quantity_unit]').prop('disabled', true).select2("val", "");
	});
	$('._unlimit_quantity').on('ifUnchecked', function() {
		$('input[name=quantity]').prop('disabled', false).val('1');
		$('select[name=quantity_unit]').prop('disabled', false).val("วัน").trigger('change');
	});
	//-- ON Checked /unCheck set expire --//
	$('._set_expire').on('ifChecked', function() {
		limit_date.datepicker('update');
		$('input[name=expire]').prop('disabled', false);
	});
	$('._set_expire').on('ifUnchecked', function() {
		limit_date.datepicker('remove');
		$('input[name=expire]').prop('disabled', true);
	});
	//--- ON Checked / unCheck auto Voucher Code --//
	$('._auto_code').on('ifChecked', function() {
		$('input[name=code]').prop('disabled', true).val("สร้างรหัสอัตโนมัติ");
	});
	$('._auto_code').on('ifUnchecked', function() {
		$('input[name=code]').prop('disabled', false).val("");
	});
});

function check_form(){
	$('.required input, .required select').each(function(index, dom){
		if(this.val() === ""){
			alert(22);
		}
	});
}
