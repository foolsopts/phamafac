var $inputImage;
var $image;
var submit_btn;
$(function() {
    // Set idle time
    //clear_form();
    try{
       var demo1 = $('select[name="voucher[]"]').bootstrapDualListbox({
         nonSelectedListLabel: 'รายการสวัสดิการ',
         selectedListLabel: 'สวัสดิการที่อนุมัติ',
         preserveSelectionOnMove: 'moved',
         helperSelectNamePostfix: '',
         moveOnSelect: false
       });
    }catch(e){
      console.log(e);
    }
    //alert($('._quit:checked').val());
    if(typeof $('._quit:checked').val() === "undefined"){
      $('._quit_note').hide();
    }else{
      $('._quit_note').show();
    }
    if(typeof $('._blacklist:checked').val() === "undefined"){
      $('._blacklist_note').hide();
    }else{
      $('._blacklist_note').show();
    }
    $( document ).idleTimer( 500000 );
    $( document ).on( "idle.idleTimer", function(event, elem, obj){
       // function you want to fire when the user goes idle
       console.log("timeup");
   });

   $( document ).on( "active.idleTimer", function(event, elem, obj, triggerevent){
       // function you want to fire when the user becomes active again
       console.log("continue");
   });

    $('.tagsinput').tagsinput({
        tagClass: 'label label-primary',
        width: '100%'
    });

    $("._warehouse").select2({
        theme: "bootstrap"
    });
    $("._work-group").select2({
        theme: "bootstrap"
    });
    $("._level").select2({
        theme: "bootstrap"
    });
    ///////////////////NEW EMPLOYEE METHOD////////////////////
    submit_btn = $('.ladda-button._save-profile').ladda();
    //<!--/// Intialize Jquery-form ///-->
    var options = {
        //target:        '#output1',   // target element(s) to be updated with server response
        beforeSubmit: function(formData, jqForm, options) {
            // console.log($.param(formData));
            // return false;
            if(!filter()){
              return false;
            }
            submit_btn.ladda('start');
            return true;
        }, // pre-submit callback
        success: function(responseText, statusText, xhr, $form) {
                console.log(responseText);
                if(responseText.stat === "fail"){
                  var msg = "";
                  $.each(responseText.data.code,function(index, val){
                    msg += index+" : "+val+" ";
                    swal("ข้อมูลไม่ถูกต้อง!", msg, "error");
                    console.log(msg);
                  });
                  swal("ข้อมูลไม่ถูกต้อง!", msg, "error");
                  if(typeof responseText.data.attr !== "undefined"){
                    clear_form(responseText.data.attr);
                  }
                  submit_btn.ladda('stop');
                }else{
                  location.reload();
                }
            }, // post-submit callback
        dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type)
    };

    // bind form using 'ajaxForm'
    $('#_employee-form').ajaxForm(options);
    //<!--/////////////////////////////-->


    $("._province").select2({
        placeholder: "จังหวัด",
        allowClear: false,
        theme: "bootstrap"
    });
    $('.input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });
    /*$('._save-profile').click(function(){
        swal({
            title: "บันทึกข้อมูลแล้ว",
            type: "success"
        });
    });*/
    /////// image cropper ////////////////////////////////
    $inputImage = $("#inputImage");
    $image = $(".image-crop > img");
    $('._set-preview').on('click', function() {
        $pointer = $(this).attr('data-pointer');
        $('#img-upload #download').attr('preview-data', $pointer)
    });
    $l = $('.ladda-button._set-image').ladda();
    $ll = $('.ladda-button._select-image').ladda();


    //<!-- ////////////////////////// ->
    $("#img-upload").on('show.bs.modal', function(e) {
        $($image).cropper({
            preview: ".img-preview",
            viewMode: 1,
            done: function(data) {
                // Output the result data for cropping image.
            }
        });

        if (window.FileReader) {
            $inputImage.change(function() {
                var fileReader = new FileReader(),
                    files = this.files,
                    file;

                if (!files.length) {
                    return;
                }
                file = files[0];
                console.log(file);
                if (/^image\/\w+$/.test(file.type)) {
                    fileReader.readAsDataURL(file);
                    fileReader.onload = function() {
                        //$inputImage.val("");
                        $image.cropper("reset", true).cropper("replace", this.result);
                        $('._set-image').show();
                    };
                    $("#img-upload").addClass('ready');
                } else {
                    sweet_alert("กรุณาเลือกรูปที่ต้องการอัพโหลด");
                }
            });
        } else {
            $inputImage.addClass("hide");
        }
        $l.click(function() {
            $inputImage.prop('disabled', true);
            $l.ladda('start');
            $target = $(this).attr('preview-data');
            setTimeout(function() {
                $data = $image.cropper("getCroppedCanvas").toDataURL();
                $('input[name=' + $target + ']').val($data);
                var set = setInterval(function() {
                    if ($('input[name=' + $target + ']').trim !== "") {
                        clearInterval(set)
                        $l.ladda('stop');
                        $('[data-pointer=' + $target + ']').css({
                            "background": "url(" + $data + ")no-repeat center",
                            "background-size": "cover!important"
                        });
                        $('#img-upload').modal('hide');
                    }
                    console.log("xxx");
                }, 1000);
            }, 1000);
        });
    });

    $("#img-upload").on('hidden.bs.modal', function(e) {
        $inputImage.val("");
        $image.cropper("destroy");
        $('._set-image').hide();
        $inputImage.prop('disabled', false);
        $("#img-upload").removeClass('ready');
    });


    ///////////////END image cropper ///////////////////////

    $('._auto_code').on('ifChecked', function() {
  		//alert(22);
      $('input[name="ref_id"]').val("สร้างอัตโนมัติ").prop("disabled",true);
  	});
    $('._auto_code').on('ifUnchecked', function() {
  		//alert(22);
      $('input[name="ref_id"]').val("").prop("disabled",false).attr("required","true");
  	});
    $('._quit').on('ifChecked', function(){
      $('._quit_note').show();
    });
    $('._quit').on('ifUnchecked', function(){
      $('._quit_note').hide();
    });
    $('._blacklist').on('ifChecked', function(){
      $('._blacklist_note').show();
    });
    $('._blacklist').on('ifUnchecked', function(){
      $('._blacklist_note').hide();
    });

    /////////////////////////////////////////////////////////
});

function sweet_alert($title) {
    swal({
        title: $title,
        type: "warning",
        text: "อนุญาติให้ใช้ได้เฉพาะไฟล์รูปเท่านั้น"
    });
}

function filter(){
  var i = 0;
  $('.required .control-input input, .required .control-input select').not("input[type='checkbox']").each(function(index,obj){
    if($(this).val().trim() == ""){
      $(this).closest('.control-input').addClass('has-error');
      i++;
    }else{
      if($(this).is("select")&&$(this).val() === "0"){
        $(this).closest('.control-input').addClass('has-error');
        i++;
      }else{
        $(this).closest('.control-input').removeClass('has-error');
      }
    }
  });
  if(i > 0){
    swal("ข้อมูลไม่ถูกต้อง!", "โปรดกรอกข้อมูลให้ครบถ้วน", "error");
    return false;
  }
  try{
    if($('input[name="user"]').val().length < 6){
      $('input[name="user"]').closest('.control-input').addClass('has-error');
      //swal("ชื่อผู้ใช้ ต้องมี 6 ตัวอักษรขึ้นไป");
      swal("ข้อมูลไม่ถูกต้อง!", "ชื่อผู้ใช้ ต้องมี 6 ตัวอักษรขึ้นไป!", "error");
      i++;
    }else{
      $('input[name="user"]').closest('.control-input').removeClass('has-error');
    }
  }catch(e){
    console.log(e);
  }

  if($('input[name="pass"]').val() !== "" && $('input[name="repass"]').val() !== ""){
    if($('input[name="pass"]').val() !== $('input[name="repass"]').val()){
      $('input[name="pass"]').closest('.control-input').addClass('has-error');
      $('input[name="repass"]').closest('.control-input').addClass('has-error');
      swal("ข้อมูลไม่ถูกต้อง!", "รหัสผ่านทั้งสองช่องไม่ตรงกัน!", "error");
      i++;
    }else{
      if($('input[name="pass"]').val().length < 6 || $('input[name="pass"]').val().length < 6){
        $('input[name="pass"]').closest('.control-input').addClass('has-error');
        $('input[name="repass"]').closest('.control-input').addClass('has-error');
        swal("ข้อมูลไม่ถูกต้อง!", "รหัสผ่านต้องมี 6 ตัวขึ้นไป!", "error");
        i++;
      }else{
        $('input[name="pass"]').closest('.control-input').removeClass('has-error');
        $('input[name="repass"]').closest('.control-input').removeClass('has-error');
      }
    }
  }
  /////////////////////////////////////////
  // if($('input[name="current_post"]').val() !== ""){
  //   var zip =$('input[name="current_post"]').val();
  //   var zipRegex =  /\d{5}-\d{4}$|^\d{5}$/;
  //   if (!zipRegex.test(zip))
  //   {
  //     swal("ข้อมูลไม่ถูกต้อง!", "รหัสไปรษณีย์ไม่ถูกต้อง!", "error");
  //     $('input[name="current_post"]').closest('.control-input').addClass('has-error');
  //     i++;
  //   }else {
  //     $('input[name="current_post"]').closest('.control-input').removeClass('has-error');
  //   }
  // }else{
  //   $('input[name="current_post"]').closest('.control-input').removeClass('has-error');
  // }
  // if($('input[name="birth_post"]').val() !== ""){
  //   var zip =$('input[name="birth_post"]').val();
  //   var zipRegex =  /\d{5}-\d{4}$|^\d{5}$/;
  //   if (!zipRegex.test(zip))
  //   {
  //     swal("ข้อมูลไม่ถูกต้อง!", "รหัสไปรษณีย์ไม่ถูกต้อง!", "error");
  //     $('input[name="birth_post"]').closest('.control-input').addClass('has-error');
  //     i++;
  //   }else {
  //     $('input[name="birth_post"]').closest('.control-input').removeClass('has-error');
  //   }
  // }else{
  //   $('input[name="birth_post"]').closest('.control-input').removeClass('has-error');
  // }
  /////////////////////////////////////////
  if(i > 0){
    return false;
  }
  return true;
}
function clear_form($name)
{
  if($('[name="'+$name+'"]').is("select")){
    $('[name='+$name+']').val(0).trigger('change');
  }else{
    $('[name="'+$name+'"]').val('');
  }
  $('[name="'+$name+'"]').closest('.control-input').addClass('has-error');
  // $('form#_employee-form .required input[type="text"]:not(._start_work)').val('');
  // $('.required select').val(0).trigger('change');
}
