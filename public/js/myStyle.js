$(document).ready(function(){
    $(window).scroll(function(){
        var scroll = $(window).scrollTop();
        if (scroll < 300) {
          $(".navbar").removeClass("navscrolled");
          $(".navbar").addClass("navtop");
        }
  
        else{
            $(".navbar").removeClass("navtop");
          $(".navbar").addClass("navscrolled");
        }
    })
  })