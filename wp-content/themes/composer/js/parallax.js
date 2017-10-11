jQuery(function( $ ){

  // Enable parallax and fade effects on homepage sections
  $(window).scroll(function(){

    scrolltop = $(window).scrollTop()
    scrollwindow = scrolltop + $(window).height();

    $(".banner").css("backgroundPosition", "50% " + -(scrolltop/6) + "px");

  });

});