(function($){
  $(window).scroll(function($) {
    if (jQuery(window).scrollTop() >= 10) {
      jQuery('#site-header').addClass('fixed',10000);
      jQuery('#site-content').css('margin-top', '60px');
    }
    else {
      jQuery('#site-header').removeClass('fixed',10000);
      jQuery('#site-content').css('margin-top', '0px');
    }
 })
})(jQuery)
