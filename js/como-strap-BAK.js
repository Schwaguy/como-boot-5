/* Como */
// Check Screen size and adjust nav menus accordingly
function hoverdrop() {
	'use strict';
	var windowwidth = jQuery(window).width();
	if(windowwidth>991) {
		jQuery('.hoverable .navbar-nav').addClass('hover-menu');
		jQuery('.hoverable .navbar-nav .dropdown').addClass('hover-menu');
		jQuery('.hoverable .navbar-nav .dropdown').removeClass('mobile-menu');
	} else {
		jQuery('.hoverable .navbar-nav').removeClass('hover-menu');
		jQuery('.hoverable .navbar-nav .dropdown').removeClass('hover-menu');
		jQuery('.hoverable .navbar-nav .dropdown').addClass('mobile-menu');
	}
}
function removeHash() { 
    var scrollV, scrollH, loc = window.location;
    if ('pushState' in history)
        history.pushState('', document.title, loc.pathname + loc.search);
    else {
        // Prevent scrolling by storing the page's current scroll offset
        scrollV = document.body.scrollTop;
        scrollH = document.body.scrollLeft;
        loc.hash = '';
        // Restore the scroll offset, should be flicker free
        document.body.scrollTop = scrollV; 
        document.body.scrollLeft = scrollH;
    }
}
function scrollToAnchor($anchor, scrollto, scrollDelay) {
	var $linkInfo, $anchorLink, $updateURL, $updateNav;
	
	$updateURL = (($anchor.parent('.scroll-link').hasClass('updateURL')) ? true : false);
	$updateNav = (($anchor.parent('.scroll-link').hasClass('updateNav')) ? true : false);
	
	if ($anchor.parent('.scroll-link').attr('class').indexOf('scrollto') >= 0) {
		var classes = ($anchor.parent('.scroll-link').attr('class')).split(' ');
		var $scrollClass = classes.filter(function(item){
			return typeof item == 'string' && item.indexOf('scrollto') > -1;            
		}) + '';
		if ($scrollClass) {
			var scrollArr; 
			scrollArr = $scrollClass.split('-');
			scrollto = scrollArr[1];
		} else {
			scrollto = 50;
		}
	}
	if ($anchor.attr('href').indexOf('#') > -1) {
		$linkInfo = $anchor.attr('href').split('#');
		$anchorLink = $linkInfo[1];
	} else {
		if ($anchor.attr('href').indexOf('/') > -1) {
			$linkInfo = $anchor.attr('href').split('/');
			$linkInfo = $linkInfo.filter(function(v){return v!==''});
			$anchorLink = $linkInfo[$linkInfo.length-1];
		} else {
			$anchorLink = $anchor.attr('href');	
		}
	}
	
	if ($anchorLink) {
		if ($anchorLink.indexOf('/dev/') >= 0) {
			$anchorLink = $anchorLink.replace('/dev/','');
		} else if ($anchorLink.charAt(0) === '/') {
			$anchorLink = $anchorLink.substring(1, $anchorLink.length);
		} 
		if ($anchorLink.charAt(0) === '#') {
			$anchorLink = $anchorLink.substring(1, $anchorLink.length);
		}
			
		// Check to anchor on page
		if (jQuery('[id='+ $anchorLink.replace('dev/','') +']').length > 0) {
			//console.log('on-page')
			scrollDelay = 1000;
			
			// Get Anchor Information
			if ($anchor.parent('.scroll-link').hasClass('custom-offset')) {
				var scrollClass = jQuery.grep(($anchor.closest('.scroll-link').attr('class').split(/\s+/)), function(v, i){
					return v.indexOf('scrollto') === 0;
				}).join();
				scrollto = (scrollClass.split("-"))[1];
			}
			
			// Update Menu Items if they exist on page if Specified
			if ($updateNav) {
				jQuery('body').find('.menu-item').removeClass('active-menu-item');
				jQuery('body').find('.menu-item.'+ $anchorLink ).addClass('active-menu-item');
			}
			
			// Update page URL if Specified
			if ($updateURL) {  
				var newURL = '/'+ $linkInfo.join('/') + '/';
				window.history.pushState(null,null,newURL);
			}
			
			// Add Class to Anchor link
			jQuery('#'+ $anchorLink).addClass('active-anchor');
			
			// Scroll to Element
			jQuery('html,body').stop().animate({
				scrollTop: (jQuery('#'+ $anchorLink).offset().top - scrollto)
			}, scrollDelay, 'easeInOutExpo');
			removeHash(); 
		} else {
			window.location.href = $anchor.attr('href');
		}
	}
}
function isAnchorOnPage($scrollLink) {
	var $linkInfo, $anchorLink;
	$scrollLink = $scrollLink.attr('href');
	if ($scrollLink.indexOf('#') > -1) {
		$linkInfo = $scrollLink.split('#');
		$anchorLink = $linkInfo[1];
	} else if ($scrollLink.charAt(0) === '/') {
		$anchorLink = $scrollLink.substring(1, $scrollLink.length);
		$linkInfo = $anchorLink.split('/');
		$linkInfo = $linkInfo.filter(function(v){return v!==''});
		$anchorLink = $linkInfo[$linkInfo.length-1];
		var newURL = $scrollLink;
		//console.log('newURL'+ newURL);
		window.history.pushState(null,null,newURL);
	}
	if (jQuery('[id='+ $anchorLink.replace('dev/','') +']').length > 0) {
		return true;
	} else {
		return false;
	}
}
// Browser Detection
var browser = (function (agent) {
	switch (true) {
		case agent.indexOf("edge") > -1: return "ms-edge-edge-html";
		case agent.indexOf("edg") > -1: return "ms-edge-chromium";
		case agent.indexOf("opr") > -1 && !!window.opr: return "opera";
		case agent.indexOf("chrome") > -1 && !!window.chrome: return "chrome";
		case agent.indexOf("trident") > -1: return "internet-explorer";
		case agent.indexOf("firefox") > -1: return "firefox";
		case agent.indexOf("safari") > -1: return "safari";
		default: return "other";
	}
})(window.navigator.userAgent.toLowerCase());
jQuery('body').addClass(browser);
//detects if user uses Internet Explorer 
//returns version of IE or false, if browser is not IE 
//Function to detect IE or not 
function IEdetection() {
	var ua = window.navigator.userAgent;
	var msie = ua.indexOf('MSIE ');
	if (msie > 0) {
		// IE 10 or older
		return ('IE-OLD');
	}
	var trident = ua.indexOf('Trident/');
	if (trident > 0) {
		// IE 11, return version number
		return ('IE');
	}
	var edge = ua.indexOf('Edge/');
	if (edge > 0) {
		//Edge (IE 12+)
		return ('EDGE');
	}
	// User uses other browser
	return ('NOT-IE');
} 
// Misc Mobile Adjutsments
function comoMobileBehavior() {
	'use strict';
	var windowwidth = jQuery(window).width();
	if(windowwidth>991) {
		jQuery('.hoverable .navbar-nav').addClass('hover-menu');
		jQuery('.hoverable .navbar-nav .dropdown').addClass('hover-menu');
		jQuery('.hoverable .navbar-nav .dropdown').removeClass('mobile-menu');
		jQuery('.mobile-toggle-link').each(function() { jQuery(this).addClass('scroll-link'); });
	} else {
		jQuery('.hoverable .navbar-nav').removeClass('hover-menu');
		jQuery('.hoverable .navbar-nav .dropdown').removeClass('hover-menu');
		jQuery('.hoverable .navbar-nav .dropdown').addClass('mobile-menu');
		jQuery('.mobile-toggle-link').each(function() { jQuery(this).removeClass('scroll-link'); });
	}
}
function isInView(elem) {
	// if the element doesn't exist, abort
	if( elem.length == 0 ) {
		return;
	}
	var $window = jQuery(window)
	var viewport_top = $window.scrollTop()
	var viewport_height = $window.height()
	var viewport_bottom = viewport_top + viewport_height
	var $elem = jQuery(elem)
	var top = $elem.offset().top
	var height = $elem.height()
	var bottom = top + height
	return (top >= viewport_top && top < viewport_bottom) ||
	(bottom > viewport_top && bottom <= viewport_bottom) ||
	(height > viewport_height && top <= viewport_top && bottom >= viewport_bottom)
}
jQuery.noConflict(); 
(function($) { 	
    "use strict"; // Start of use strict
	
	comoMobileBehavior();
		
	var iOS = !!navigator.platform && /iPad|iPhone|iPod/.test(navigator.platform);
	if (iOS === true) {
		jQuery('body').addClass('ios');
	}
	
	var ie = IEdetection();
	if ((ie === 'IE') || (ie === 'IE-OLD')) {
		jQuery('body').addClass('ie');
		if (ie === 'IE-OLD') {
			jQuery('body').addClass('ie-old');
		} else {
			jQuery('body').addClass('ie-11');
		}
	} else if (ie === 'EDGE') {
		jQuery('body').addClass('ie-edge');
	} else {
		jQuery('body').addClass('not-ie');
	}
	
	// Add skip links
	$('section').each(function() {
		var $this = $(this);
		//var $thisID = $this.attr('id');
		if (($this).next('section').length>0) {
			var $next = $this.next('section');
			var $nextID = $next.attr('id');
			$('<a class="skip-link skip-section screenreader-text sr-only" href="#'+ $nextID +'" aria-label="Skip to Next Section">Skip to Next Section</a>').prependTo($this);
		}
	});
	
	// Add External Link Notifications
	$('a').each(function() {
		var $this = $(this);
		//var $thisID = $this.attr('id');
		if ($this.attr('target') === '_blank') {
			var $linkHref = $this.attr('href');
			var ext = $linkHref.split('.').pop();
			if (ext === 'pdf') {
				$('<span class="screenreader-text sr-only">(opens pdf document in a new tab)</span>').appendTo($this);
			} else {
				$('<span class="screenreader-text sr-only">(opens in a new tab)</span>').appendTo($this);
			}
		}
	});
	
	//$('#nav-icon').click(function(){
	$('#nav-icon').on('click', function(){
		$(this).toggleClass('open');
	});
	
	//$('.scroll-top').click(function(){
	$('.scroll-top').on('click', function(){
		$('html,body').animate({scrollTop : 0},800);
		return false;
	});
	
	//$('.home .scroll-top-home').click(function(){
	$('.home .scroll-top-home').on('click', function(){
		$('html,body').animate({scrollTop : 0},800);
		return false;
	});
	
	// Used to Override "Prevent Default" on dropdown toggles
	//$('.hover-menu .follow-link > .dropdown-toggle').click(function(e) {
	$('.hover-menu .follow-link > .dropdown-toggle').on('click', function(e) {
		if ($(this).hasClass('disable-click-link')) {
			//console.log('CLICK DISABLE');
			e.preventDefault();
			return false;
		} else {
			//console.log('CLICK FOLLOW');
			var $link = $(this);
			window.location.href = $link.attr('href');
		}
	});
	
	// Fix for non-working top level links without dropdown
	//$('.hoverable .navbar-nav > .menu-item a').click(function(e) {
	$('.hoverable .navbar-nav > .menu-item a').on('click', function(e) {
		e.preventDefault();
		//console.log('HERE 3');
		
		if (!$(this).parent('li').hasClass('scroll-link')) {
			//console.log('HERE 3.1');
			var $link, $linkTarget
			if (!$(this).hasClass('dropdown-toggle')) {	
				//console.log('HERE 3.2');
				$link = $(this);
				$linkTarget = $(this).attr('target');
				if ($linkTarget === '_blank') {
					window.open($link.attr('href'), '_blank');	
				} else {
					window.location.href = $link.attr('href');
				}
			} else {
				//console.log('HERE 3.3');
				var windowwidth = jQuery(window).width();
				if(windowwidth>991) {
					//console.log('HERE 3.4');
					$link = $(this);
					$linkTarget = $(this).attr('target');
					if ($linkTarget === '_blank') {
						window.open($link.attr('href'), '_blank');	
					} else {
						window.location.href = $link.attr('href');
					}
				}
			}
		}
	});
	
	$(function() {
		var $anchorLink, $anchor, pageURL, urlsplit, lastpart;
		var scrollDelay = 1000;
		var scrollto = 50;
		if(window.location.hash) {
			pageURL = window.location.href;
			$anchorLink = window.location.hash;
			$anchor = $($anchorLink);
			scrollDelay = 0;
		} else {
			pageURL = window.location.href;
			urlsplit = pageURL.split("/");
			lastpart = urlsplit[urlsplit.length-1];
			if (!lastpart.trim()) {
				lastpart = urlsplit[urlsplit.length-2];
			}
			$anchorLink = '#'+ lastpart;
			$anchor = $anchorLink;
			scrollDelay = 0;
		}
		
		if ($anchorLink) {
			if ($($anchorLink).length > 0) {
				if ($($anchorLink).hasClass('custom-offset')) {
					var scrollClass = $.grep(($anchor.attr('class').split(/\s+/)), function(v, i){
						return v.indexOf('scrollto') === 0;
					}).join();
					scrollto = (scrollClass.split("-"))[1];
				}
				// Add delay if Chrome to overcome Chrome anchor bug 
				var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
				if (isChrome) {
					setTimeout(function () {
						$('html, body').animate({
							scrollTop: $($anchorLink).offset().top - scrollto
						}, scrollDelay, 'easeInOutExpo');
					}, 300);
				} else {
					$('html, body').animate({
						scrollTop: $($anchorLink).offset().top - scrollto
					}, scrollDelay, 'easeInOutExpo');
				}
			}
			check_if_in_view();
		}
		
		$('body').on('click','a.scroll-link, .scroll-link > a',function(event){
			event.preventDefault();
			var $anchor = $(this);
			scrollToAnchor($anchor, scrollto, scrollDelay);
		});
	});
	
	// Add Slide Down effect to Dropdowns
	/*$('.dropdown-menu').on('show.bs.dropdown', function(){
		console.log('DROPDOWN');
		//$('.menu-item.sub-expand').removeClass('sub-expand').children('.dropdown-menu').removeClass('expand');
		$(this).find('.dropdown-menu').first().stop(true, true).slideDown(300);
	});
	$('.dropdown-menu').on('hide.bs.dropdown', function(){
		console.log('DROPDOWN CLOSE');
		$(this).find('.dropdown-menu').first().stop(true, true).slideUp(200);
	});*/
	
	
	// Dropdown Menus updated for Bootstrap 5 - 20210505
	document.querySelectorAll('.hover-menu .dropdown').forEach(function(everyitem){
		everyitem.addEventListener('mouseover', function(e){
			let el_link = this.querySelector('a[data-bs-toggle]');
			if(el_link != null){
				let nextEl = el_link.nextElementSibling;
				el_link.classList.add('show');
				nextEl.classList.add('show');
			}
		});
		everyitem.addEventListener('mouseleave', function(e){
			let el_link = this.querySelector('a[data-bs-toggle]');
			if(el_link != null){
				let nextEl = el_link.nextElementSibling;
				el_link.classList.remove('show');
				nextEl.classList.remove('show');
			}
		})
	});
	
	// Check dropdown items to see if they are scroll links
	//$('.dropdown-menu .dropdown-item').click(function(event) {
	$('.dropdown-menu .dropdown-item').on('click', function(event) {
		event.preventDefault();
		var $link = $(this);
		//console.log('$link: '. $link);
		
		if ($link.parent('li').hasClass('scroll-link')) {
			//console.log('scroll-link');
			if (isAnchorOnPage($link) === true) {
				//console.log('anchor on page');
				scrollToAnchor($link,50,1000);
			} else {
				//console.log('not on page');
				window.location.href = $link.attr('href');
			}
		} else {
			var linkAction;
			var parentMenu = $(this).closest('.dropdown-menu').closest('.dropdown'); 
			if (parentMenu.hasClass('hover-menu')) {
				linkAction = ($(this).hasClass('follow-link')) ? 'follow' : 'toggle';
			} else {
				linkAction = 'toggle';
			}
			//console.log(linkAction);
			if (linkAction == 'toggle') {
				var $subDrop = $(this).parent('.dropdown').children('.dropdown-menu');
				if ($(this).parent('.menu-item').hasClass('sub-expand')) {
					$.when($subDrop.removeClass('expand')).done(function() {
						$(this).parent('.menu-item').removeClass('sub-expand');
					});
				} else {
					$.when($subDrop.addClass('expand')).done(function() {
						$(this).parent('.menu-item').addClass('sub-expand');
						$(this).parent('.menu-item').parent('.menu-item').addClass('show');
					});
				}
				return false;
			} else {
				window.location.href = $link.attr('href');
			}
		}
	});
	
	// 2nd Level Dropdowns
	$('body').on('hover focus mouseenter blur focusout mouseleave','.hover-menu .dropdown-menu .dropdown',function(e){
		var $this = $(this);
		var $subToggle = $this.children('.dropdown-toggle');
		var $subDrop = $this.children('.dropdown-menu');
		if ((e.type === 'hover') || (e.type === 'focus') || (e.type === 'mouseenter')) {
			$.when($subDrop.addClass('expand')).done(function() {
				if ($('#mainNav.hoverable').hasClass('hide-sub-onBlur')) {
					$('.hover-menu .dropdown-menu .dropdown').not($this).removeClass('sub-expand');
					$('.hover-menu .dropdown-menu .dropdown').not($this).children('.dropdown-menu').removeClass('expand');
				}
				$this.addClass('sub-expand');
				$subToggle.addClass('show');
				e.stopPropagation();
			});
		} else {
			//console.log('LEAVE');
			$this.removeClass('sub-expand');
			$subToggle.removeClass('show');
			$subDrop.removeClass('expand');
		}
	});
	
	$('body').on('click','.hover-menu .dropdown-menu .dropdown .dropdown-toggle',function(e){
		if (!$(this).hasClass('follow-link')) {
			e.preventDefault();
			var $subDrop = $(this).parent('.dropdown').children('.dropdown-menu');
			if ($(this).parent('.menu-item').hasClass('sub-expand')) {
				$.when($subDrop.removeClass('expand')).done(function() {
					$(this).parent('.menu-item').removeClass('sub-expand');
				});
			} else {
				$.when($subDrop.addClass('expand')).done(function() {
					$(this).parent('.menu-item').addClass('sub-expand');
					$(this).parent('.menu-item').parent('.menu-item').addClass('show');
					e.stopPropagation();
				});
			}
			return false;
		} 
	});
	
	// Second Level Dropdown Mobile Toggle
	$('body').on('click','.mobile-menu .dropdown-menu .dropdown .dropdown-toggle',function(e){
		var $this = $(this);
		var $subDrop = $this.parent('.dropdown').children('.dropdown-menu');
		if ($this.hasClass('show') != false) {
			$.when($subDrop.addClass('expand')).done(function() {
				$this.parent('.menu-item').addClass('sub-expand');
				$this.parent('.menu-item').parent('.menu-item').addClass('show');
				//e.stopPropagation();
			});
		} else {
			$.when($subDrop.removeClass('expand')).done(function() {
				$this.parent('.menu-item').removeClass('sub-expand');
				$this.parent('.menu-item').parent('.menu-item').removeClass('show');
				//e.stopPropagation();
			});
		}
		return false;
	});
	
	$('body').on('blur focusout mouseleave','.hover-menu .dropdown-menu .dropdown', function(){
		var $subDrop = $(this);
		//console.log('LEAVE');
		if ($('#mainNav.hoverable').hasClass('hide-sub-onBlur')) {
			//console.log('has class');
			$subDrop.removeClass('expand');
			$(this).parent('.menu-item').removeClass('sub-expand');
			$(this).parent('.menu-item').parent('.menu-item').removeClass('show');
			//e.stopPropagation();
		}
	});
	
	// Accessible Dropdowns
	// Layer 1
	$('body').on('focus focusin','.hoverable .navbar-nav > .menu-item > a', function(e) {
		var $this = $(this);
		var $subParent = $this.closest('.dropdown');
		var $subDrop = $subParent.find('.dropdown-menu').first();
		var $navBar = $subParent.closest('.navbar-nav');
		$navBar.addClass('active-nav');
		
		$('.active-nav .hover-menu').removeClass('sub-expand');
		$('.active-nav .hover-menu .dropdown-toggle').removeClass('show').attr('aria-expanded','false');
		$('.active-nav .hover-menu .dropdown-menu').removeClass('expand show');
		
		if ($subParent.hasClass('hover-menu')) {
			$this.addClass('show').attr('aria-expanded','true');
			$subParent.addClass('sub-expand');
			$subDrop.first().addClass('expand show');
		} 
	});
	
	// Layer 2
	$('body').on('focus focusin','.hover-menu > .dropdown-menu > .dropdown', function(e) {
		//console.log('FOCUS!!!');
		var $this = $(this);
		var $subToggle = $this.children('.dropdown-toggle');
		//var $subParent = $this.closest('.dropdown');
		var $subDrop = $this.find('.dropdown-menu').first();
		$subToggle.addClass('show').attr('aria-expanded','true');
		$this.addClass('sub-expand');
		$subDrop.first().addClass('expand show');
		
		var $grandParent = $this.parent('.menu-item');
		if ($grandParent) {
			$grandParent.addClass('sub-expanded');
		}
	});
	
	// Layer 3
	$('body').on('focus focusin','.hover-menu > .dropdown-menu > li > a > .dropdown-menu > li > a', function(e) {
		var $this = $(this);
		var $subParent = $this.closest('.dropdown');
		var $subDrop = $subParent.find('.dropdown-menu').first();
		$this.addClass('show').attr('aria-expanded','true');
		$subParent.addClass('sub-expand');
		$subDrop.first().addClass('expand show');
		
		var $grandParent = $subParent.parent('.menu-item');
		if ($grandParent) {
			$grandParent.addClass('sun-expanded');
			var $greatGrandParent = $grandParent.parent('.menu-item');
			$greatGrandParent.addClass('sun-expanded');
		}
	});
	
	// Closes the Responsive Menu on Menu Item Click
    //$('.navbar-collapse ul li.scroll-link a').click(function() {
	$('.navbar-collapse ul li.scroll-link a').on('click', function() {
        $('.navbar-toggle:visible').click();
    });
	
	// Add sticky class to header on scroll
	$(function () {
		var scrollPos = $(document).scrollTop();
		if (scrollPos > 100) {
			$('#masthead').addClass('sticky');
			$('body').addClass('scrolled');
		} else {
			$('#masthead').removeClass('sticky');
			$('body').removeClass('scrolled');
		}
		//$(window).scroll(function () {
		$(window).on('scroll', function () {
            if ($(this).scrollTop() > 100) {
				$('#masthead').addClass('sticky');
				$('body').addClass('scrolled');
            } else {
				$('#masthead').removeClass('sticky');
				$('body').removeClass('scrolled');
			}
        });
    });
	
	// Add Scrolled Deep class to header on scroll
	$(function () {
		var scrollPos = $(document).scrollTop();
		var contentStart = $('#content-wrap').offset().top;
		if (scrollPos > contentStart) {
			$('body').addClass('scrolled-content');
		} else {
			$('body').removeClass('scrolled-content');
		}
		//$(window).scroll(function () {
		$(window).on('scroll', function () {
            if ($(this).scrollTop() > contentStart) {
				$('body').addClass('scrolled-content');
            } else {
				$('body').removeClass('scrolled-content');
			}
        });
    });
	
	// Add Animations to on scroll
	//var $animation_elements = $('.show-on-scroll');
	var $window = $(window);
	$window.on('scroll resize', check_if_in_view);
	$window.trigger('scroll');
	function check_if_in_view() {
		var $animation_elements = $('.show-on-scroll');
		//var window_height = $window.height();
		//var window_top_position = $window.scrollTop();
		//var window_bottom_position = (window_top_position + window_height);
		//console.log('window_top_position: '. window_top_position);
		//console.log('window_bottom_position: '. window_bottom_position);
		$.each($animation_elements, function() {
			var $element = $(this);
			//var element_height = $element.outerHeight();
			//var element_top_position = $element.offset().top;
			//var element_bottom_position = (element_top_position + element_height);
	
			//check to see if this current container is within viewport
			//if ((element_bottom_position >= window_top_position) && (element_top_position <= window_bottom_position)) {
			//if (element_top_position <= window_bottom_position) {
				
			if (isInView($element)) { 	
				//console.log($element);
				if ($element.hasClass('bounceIn-on-scroll')) { $element.addClass('animated bounceIn'); }
				else if ($element.hasClass('fadeInUp-on-scroll')) { $element.addClass('animated fadeInUp'); }
				else if ($element.hasClass('fadeInDown-on-scroll')) { $element.addClass('animated fadeInDown'); }
				else if ($element.hasClass('fadeInLeft-on-scroll')) { $element.addClass('animated fadeInLeft'); }
				else if ($element.hasClass('fadeInRight-on-scroll')) { $element.addClass('animated fadeInRight'); }
				else if ($element.hasClass('rotateIn-on-scroll')) { $element.addClass('animated rotateIn'); }
				else if ($element.hasClass('rotateInDownLeft-on-scroll')) { $element.addClass('animated rotateInDownLeft'); }
				else if ($element.hasClass('rotateInDownRight-on-scroll')) { $element.addClass('animated rotateInDownRight'); }
				else if ($element.hasClass('rotateInUpLeft-on-scroll')) { $element.addClass('animated rotateInUpLeft'); }
				else if ($element.hasClass('rotateInUpRight-on-scroll')) { $element.addClass('animated rotateInUpRight'); }
				else if ($element.hasClass('zoomIn-on-scroll')) { $element.addClass('animated zoomIn'); }
				else if ($element.hasClass('bounce-on-scroll')) { $element.addClass('animated bounce'); }
				else if ($element.hasClass('shake-on-scroll')) { $element.addClass('animated shake'); }
				else if ($element.hasClass('pulse-on-scroll')) { $element.addClass('animated pulse'); }
				else if ($element.hasClass('flash-on-scroll')) { $element.addClass('animated flash'); }
				else if ($element.hasClass('slideInDown-on-scroll')) { $element.addClass('animated slideInDown'); }
				else if ($element.hasClass('slideInLeft-on-scroll')) { $element.addClass('animated slideInLeft'); }
				else if ($element.hasClass('slideInRight-on-scroll')) { $element.addClass('animated slideInRight'); }
				else if ($element.hasClass('slideInUp-on-scroll')) { $element.addClass('animated slideInUp'); }
				else if ($element.hasClass('bounceIn-on-scroll')) { $element.addClass('animated bounceIn'); }
				else if ($element.hasClass('bounceInDown-on-scroll')) { $element.addClass('animated bounceInDown'); }
				else if ($element.hasClass('bounceInDown-on-scroll')) { $element.addClass('animated bounceInDown'); }
				else if ($element.hasClass('bounceInLeft-on-scroll')) { $element.addClass('animated bounceInLeft'); }
				else if ($element.hasClass('bounceInRight-on-scroll')) { $element.addClass('animated bounceInRight'); }
				else if ($element.hasClass('bounceInUp-on-scroll')) { $element.addClass('animated bounceInUp'); }
				else if ($element.hasClass('rollIn-on-scroll')) { $element.addClass('animated rollIn'); }
				else if ($element.hasClass('animateCustom-on-scroll')) { $element.addClass('animate-custom'); }
				else { $element.addClass('animated fadeIn'); }
				if ($element.hasClass('no-repeat')) { 
					$element.removeClass('show-on-scroll');
				}
			}  
		});
	}
	//$('.search-toggle').click(function(e) { 
	$('.search-toggle').on('click', function(e) { 
		e.preventDefault();
		$(this).toggleClass('clicked');
		$(this).closest('.menu-search').toggleClass('active');
		$(this).parents('.widget').toggleClass('search-active');
		return false;
	});
	//$('#masthead .nav-link').not('.search-toggle').hover(function() { 
	$('#masthead .nav-link').not('.search-toggle').on('hover', function() { 
		$('#masthead').find('.menu-search').removeClass('active');
		$('#masthead').find('.search-active').removeClass('search-active');
	});
	
	// Modal Class added/removed from body
	$(document.body).on('show.bs.modal', function () {
		$(window.document).find('html').addClass('no-scrollbar');
	});
	$(document.body).on('hide.bs.modal', function () {
		$(window.document).find('html').removeClass('no-scrollbar');
	});
	
	check_if_in_view();
	
})(jQuery);
//jQuery(window).resize(function() {
jQuery(window).on('resize', function() {
    "use strict"; // Start of use strict
	comoMobileBehavior();
});