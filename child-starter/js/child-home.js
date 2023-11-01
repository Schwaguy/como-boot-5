jQuery(document).ready(function($) {
    "use strict"; 
	// Add parallax to slider class on scroll
	$(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 1) {
				$('#home-hero .hero-title-circle').css({'top': 0+($(this).scrollTop() / 3) + "px"});
				//$('#platform-right-top').css({'top': 0+($(this).scrollTop() / 4) + "px"});
				//$('#platform-right-bottom').css({'top': 0+($(this).scrollTop() / 2) + "px"});
            } else {
				$('#home-hero .hero-title-circle').css({'top': "0"});
			} 
        });
    });
});