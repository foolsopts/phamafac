var vertical_name = ".vertical"
var pre_top
var flash_url
$(function(){
  menuActive()
  is_mobile()
  set_footer()
  parallax_init()

  $(window).on('resize',function(){
    setTimeout(function(){
      is_mobile()
    },500)
    set_footer()
    parallax2()
    try{
      resizeIframe($('.iframe-responsive'))
    }catch(e){

    }
  })
  $(window).on('scroll',function(){
    parallax2()
  })

  $('#top-menu .collapse').on('show.bs.collapse',function(){
    flash_url = $('.flash').attr('src')
    $('.flash').attr('src','')
    var dom = document.querySelectorAll('#top-menu .navbar-toggle')[0]
    var pos = dom.getBoundingClientRect();
    var top = pre_top = pos.top
    $('.navbar-toggle').css('top',top+"px")
    $('#top-menu .navbar-collapse').prepend($('.navbar-toggle'));
    $("body").addClass('menu-open')
    setTimeout(function(){
        $(".navbar-toggle").addClass('active')
        $('.navbar-toggle').css('top','')
    },70)
  })
  $('#top-menu .collapse').on('hide.bs.collapse',function(){
    $('.navbar-toggle').css({
      'top': pre_top+"px"
    })
    $(".navbar-toggle").removeClass('active')
    //$('#top-menu .navbar-header').prepend($('.navbar-toggle'));
    //$("body").removeClass('menu-open')
    setTimeout(function(){
      $('#top-menu .navbar-header').prepend($('.navbar-toggle'));
      $('.navbar-toggle').css('top','')
      $("body").removeClass('menu-open')
    },500)
  })
  $('#top-menu .collapse').on('shown.bs.collapse',function(){
    $('.com_credit').fadeIn()
  })
  $('#top-menu .collapse').on('hidden.bs.collapse',function(){
    $('.flash').attr('src',flash_url)
  })
  $(document).on('click','body:not(.mobile) ._btn_search:not(.ready)',function(){
    $(this).closest('.navbar-form').addClass('active')
    $(this).closest('.navbar-form').find('input').focus()
    $(this).addClass('ready').attr('type','submit').off()
    return false
  })
  $(document).on('click','body:not(.mobile) ._btn_search.ready',function(e){
    e.stopPropagation()
    //$('.navbar-form').submit()
  })
  $('.navbar-form input').on('focus click',function(e){
    e.stopPropagation()
  })
  $(document).on('click','body:not(.mobile)',function(){
    $('.navbar-form input').val('')
    $('.navbar-form').removeClass('active')
    $('.navbar-form button').attr('type','button').removeClass('ready')
  })
  function set_vertical()
  {
    var parent_height = $(vertical_name).parent().height()
    var vertical_height = $(vertical_name).height()
    console.log(parent_height)
    console.log(vertical_height)
    if(vertical_height < parent_height){
      var diff = parent_height - vertical_height
      $(vertical_name).css({
        "padding-top":diff/2,
        "padding-bottom":diff/2
      })
    }
  }

  function is_mobile()
  {
    var window = $(document).width()+17
    //console.log(window)
    if(window >= 1200){
      //console.log("lg")
      $('body').removeClass('md sm xs mobile').addClass('lg')
      $('.navbar-collapse .navbar-nav').removeClass('nav-justified')
    }else if(window >= 992){
      //console.log("md")
      $('body').removeClass('lg sm xs mobile').addClass('md')
      $('.navbar-collapse .navbar-nav').removeClass('nav-justified')
    }else if(window >= 768){
      //console.log("sm")
      $('body').removeClass('lg md xs mobile').addClass('sm')
      $('.navbar-collapse .navbar-nav').addClass('nav-justified')
    }else if(window < 768){
      //console.log("xs")
      $('body').removeClass('lg md sm').addClass('mobile xs')
      $('.navbar-collapse .navbar-nav').removeClass('nav-justified')
    }

    if(window < 768){
      $('body #top-menu .navbar-form button').attr('type','submit')
    }else{
      $('body #top-menu .navbar-form button').removeClass('ready')
      $('body #top-menu .navbar-form button').attr('type','button')
    }
  }

  function set_footer()
  {
    var footer_height = $('.footer').height()
    $('.push').height(footer_height)
    $('.wrapper').css('margin-bottom','-'+footer_height+'px')
  }
  function parallax()
  {
      var duration = 50
      $('.my_parallax').each(function(i,d){
        var top = $(window).scrollTop()
        var dom = $(d).offset().top

        if(top >= dom && top <= dom+$(d).outerHeight()){
          var m_top = top-dom
          var pos = m_top-(m_top*duration/100)
          $(d).find('.mp-c').css('top',pos)
          if($(d).hasClass('blur')){
            $(d).find('.mp-c').css({
              '-webkit-filter':'blur('+pos+'px)',
              '-moz-filter':'blur('+pos+'px)',
              '-o-filter':'blur('+pos+'px)',
              '-ms-filter':'blur('+pos+'px)',
              'filter':'blur('+pos+'px)'
            })
          }
        }else{
          $(d).find('.mp-c').css('top','')
          if($(d).hasClass('blur')){
            $(d).find('.mp-c').css({
              '-webkit-filter':'blur(0px)',
              '-moz-filter':'blur(0px)',
              '-o-filter':'blur(0px)',
              '-ms-filter':'blur(0px)',
              'filter':'blur(0px)'
            })
          }
        }
      })
  }
  function parallax2()
  {
    var duration = 75
    $('.a_parallax').each(function(i,d){
      var top = $(window).scrollTop()
      var dom = $(d).offset().top
      var f_dom = $(d).find('.f_parallax')
      var b_dom = $(d).find('.b_parallax')
      if($(d).height() != $(b_dom).outerHeight()){
        $(d).css('height',$(b_dom).outerHeight())
      }
      if(top >= dom && top <= dom+$(d).outerHeight()){
        var m_top = top-dom
        var pos = m_top-(m_top*duration/100)
        $(f_dom).css({
          'height':$(b_dom).outerHeight(),
          'position': 'absolute'
        })
        $(b_dom).css({
          'position':'fixed',
          'top': '-'+pos+'px'
        })
      }else{
        $(f_dom).css({
          'height':'',
          'position':''
        })
        $(b_dom).css({
          'position':'',
          'top': ''
        })
      }
    })
  }
  function parallax_init()
  {
      $('.my_parallax').wrap("<div class='a_parallax'><div class='f_parallax'><div class='b_parallax'></div></div></div>")
      $('.a_parallax').each(function(i,d){
        var p_height = $(d).find('.b_parallax').outerHeight()
        $(d).css('height',p_height)
      })
  }

  function menuActive()
  {
    var current = $('body').attr('data-page')
    $('#top-menu li[data-active='+current+']').addClass('active')
  }
})
function resizeIframe(obj) {
  if(obj.length){
    obj[0].style.height = obj[0].contentDocument.querySelectorAll('svg')[0].scrollHeight + 'px'
    $(obj[0]).parents('.a_parallax').height($(obj[0]).parents('.b_parallax').outerHeight());
  }else{
    obj.style.height = obj.contentDocument.querySelectorAll('svg')[0].scrollHeight + 'px'
    $(obj).parents('.a_parallax').height($(obj).parents('.b_parallax').outerHeight());
  }
}
