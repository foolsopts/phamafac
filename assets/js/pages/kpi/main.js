$(function(){
  //var go = $('.ladda-button._save-kpi').ladda();
  //<!--/// Intialize Jquery-form ///-->
  var empty = 0;
  var options = {
      //target:        '#output1',   // target element(s) to be updated with server response
      beforeSubmit: function(formData, jqForm, options) {
        $.each(formData,function(index, object){
          if(this.value === ""){
            empty = 1;
            alert("ห้ามเว้นว่าง");
            return false;
          }
        });
        if(empty === 1){
          empty = 0;
          return false;
        }
          var queryString = $.param(formData);
          return true;

      }, // pre-submit callback
      success: function(responseText, statusText, xhr, $form) {
              console.log(responseText);
              location.reload();
          }, // post-submit callback
      dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type)
  };
  // bind form using 'ajaxForm'
  $('._kpi-form').ajaxForm(options);

  $('._kpi-del').on('click',function(){
    var kpi_id = $(this).attr('data-id');
    $.ajax({
      //type: "POST",
      //dataType: 'json',
      url: base_url+"pcgadmin/kpi/delete_data/"+kpi_id,
      //data: data,
      success: function(data){
        location.replace(base_url+"pcgadmin/kpi.html");
      }
    });
  });
  $("._workgroup").select2({
      theme: "bootstrap"
  });
});
