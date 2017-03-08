$(function() {
    $('select[name=by_quarter]').on('change', function() {
        $('select[name=by_month]').val(0);
    });
    $('select[name=by_month]').on('change', function() {
        $('select[name=by_quarter]').val(0);
    });
    $('._search').on('click',function(){
      $('input[name=export]').val(0);
    });
    $('._export').on('click',function(){
      $('input[name=export]').val(1);
      //$('form').submit();
    });

});
