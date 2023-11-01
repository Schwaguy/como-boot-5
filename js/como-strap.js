/* Como */
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
function browserDetect($) {
	// General Browser Decestion
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
	$('body').addClass(browser);
	
	// iOS Detection
	var iOS = !!navigator.platform && /iPad|iPhone|iPod/.test(navigator.platform);
	if (iOS === true) {
		$('body').addClass('ios');
	}
	
	// Internet Explorer Detection
	var ie = IEdetection();
	if ((ie === 'IE') || (ie === 'IE-OLD')) {
		$('body').addClass('ie');
		if (ie === 'IE-OLD') {
			$('body').addClass('ie-old');
		} else {
			$('body').addClass('ie-11');
		}
	} else if (ie === 'EDGE') {
		$('body').addClass('ie-edge');
	} else {
		$('body').addClass('not-ie');
	}
	
}
function accessibilityLinks($) {
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
				$('<span class="screenreader-text sr-only">(opens/downloads pdf file)</span>').appendTo($this);
			} else if ((ext === 'doc') || (ext === 'docx')) {
				$('<span class="screenreader-text sr-only">(opens/downloads Word document)</span>').appendTo($this);
			} else if ((ext === 'ppt') || (ext === 'pptx')) {
				$('<span class="screenreader-text sr-only">(opens/downloads PowerPoint file)</span>').appendTo($this);
			} else {
				$('<span class="screenreader-text sr-only">(opens in a new tab)</span>').appendTo($this);
			}
		}
	});
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
// Accessible Menubar widget 
// Source: Open AJAX Alliance
// http://oaa-accessibility.org/example/25/
// Modified by Josh Comolli, https://comocreative.com
//$(document).ready(function() {
//	var menu1 = new menubar('menu-main-nav', false);
//}); // end ready()
/////////////// begin menu widget definition /////////////////////
// Function menubar() is the constructor of a menu widget
// The widget will bind to the ul passed to it.
// @param(id string) id is the HTML id of the ul to bind to
// @param(vmenu boolean) vmenu is true if menu is vertical; false if horizontal
// @return N/A
function menubar(id, vmenu) {
	// define widget properties
	//this.$id = jQuery('#' + id);
	this.$id = jQuery(id);
	this.$rootItems = this.$id.children('.menu-item'); // jQuerry array of all root-level menu items
	this.$items = this.$id.find('.menu-item'); // jQuery array of menu items
	this.$parents = this.$id.find('.menu-parent'); // jQuery array of menu items
	this.$allItems = this.$parents.add(this.$items); // jQuery array of all menu items
	this.$activeItem = null; // jQuery object of the menu item with focus
	this.vmenu = vmenu;
	this.bChildOpen = false; // true if child menu is open
	this.keys = {
		tab:    9,
		enter:  13,
		esc:    27,
		space:  32,
		left:   37,
		up:     38,
		right:  39,
		down:   40
	};
	// bind event handlers
	this.bindHandlers();
	// associate the menu with the textArea it controls this.textarea = new textArea(this.$id.attr('aria-controls'));
}
// Function bindHandlers() is a member function to bind event handlers for the widget.
// @return N/A
menubar.prototype.bindHandlers = function() {
	var thisObj = this;
	///////// bind mouse event handlers //////////
	// bind a handler for the menu items
	this.$items.on('mouseenter', function(e) {
		jQuery(this).addClass('menu-hover').attr('aria-expanded', 'true');
		jQuery(this).find('.dropdown-menu').first().addClass('show');
		return true;
	});
	// bind a mouseout handler for the menu items
	this.$items.on('mouseout', function(e) {
		jQuery(this).removeClass('menu-hover').attr('aria-expanded', 'false');
		//$(this).find('.dropdown-menu').first().removeClass('show');
		return true;
	});
	// bind a mouseenter handler for the menu parents
	this.$parents.on('mouseenter', function(e) {
		return thisObj.handleMouseEnter(jQuery(this), e);
	});
	// bind a mouseleave handler
	this.$parents.on('mouseleave', function(e) {
		return thisObj.handleMouseLeave(jQuery(this), e);
	});
	
	// bind a click handler
	this.$allItems.on('click', function(e) {
		return thisObj.handleClick(jQuery(this), e);
	});
	//////////// bind key event handlers //////////////////
	// bind a keydown handler
	this.$allItems.on('keydown', function(e) {
		return thisObj.handleKeyDown(jQuery(this), e);
	});
	// bind a keypress handler
	this.$allItems.on('keypress', function(e) {
		return thisObj.handleKeyPress(jQuery(this), e);
	});
	// bind a focus handler
	this.$allItems.on('focus', function(e) {
		return thisObj.handleFocus(jQuery(this), e);
	});
	// bind a blur handler
	this.$allItems.on('blur', function(e) {
		return thisObj.handleBlur(jQuery(this), e);
	});
	// bind a document click handler
	jQuery(document).on('click', function(e) {				  
		return thisObj.handleDocumentClick(e);
	});
} // end bindHandlers()
// Function handleMouseEnter() is a member function to process mouseover events for the top menus.
// @param($item object) $item is the jquery object of the item firing the event
// @param(e object) e is the associated event object
// @return(boolean) Returns false;
menubar.prototype.handleMouseEnter = function($item, e) {
	// add hover style
	$item.addClass('menu-hover');
	// expand the first level submenu
	if ($item.attr('aria-haspopup') == 'true') {
		if (!($item.closest('ul').hasClass('root-level'))) {
			// Close other Sub-menu Dropdowns
			var $menu = $item.closest('ul');
			$menu.children('.dropdown').not($item).children('.dropdown-menu').removeClass('show').attr('aria-hidden', 'true');
		}
		$item.children('.dropdown-menu').addClass('show').attr('aria-hidden', 'false');
		this.bChildOpen = true;
	}
	//e.stopPropagation();
	return true;
} // end handleMouseEnter()
// Function handleMouseOut() is a member function to process mouseout events for the top menus.
// @param($item object) $item is the jquery object of the item firing the event
// @param(e object) e is the associated event object
// @return(boolean) Returns false;
menubar.prototype.handleMouseOut = function($item, e) {
	// Remover hover styles
	$item.removeClass('menu-hover');
	//e.stopPropagation();
	return true;
} // end handleMouseOut()
// Function handleMouseLeave() is a member function to process mouseout events for the top menus.
// @param($menu object) $menu is the jquery object of the item firing the event
// @param(e object) e is the associated event object
// @return(boolean) Returns false;
menubar.prototype.handleMouseLeave = function($menu, e) {
	var $active = $menu.find('.menu-focus'); //???
	$active = $active.add($menu.find('.menu-focus'));
	
	if ($menu.parent().hasClass('root-level')) {
		// Remove hover style
		$menu.removeClass('menu-hover');
		// if any item in the child menu has focus, move focus to the root item
		if ($active.length > 0) {
			this.bChildOpen = false;
			// remove the focus style from the active item
			$active.removeClass('menu-focus');
			// store the active item
			this.$activeItem = $menu;
			// cannot hide items with focus -- move focus to root item
			$menu.focus();
		}
		// hide the child menu
		setTimeout(function(){
			$menu.find('.dropdown-menu').removeClass('show').attr('aria-hidden', 'true');
		}, 10);
		//e.stopPropagation();
		return true;
	} else {
		if ($menu.hasClass('dropdown')) {
			$menu.find('.dropdown-menu').removeClass('show').attr('aria-hidden', 'true')
		} 
	}
} // end handleMouseLeave()
// Function handleClick() is a member function to process click events for the top menus.
// @param($item object) $item is the jquery object of the item firing the event
// @param(e object) e is the associated event object
// @return(boolean) Returns false;
menubar.prototype.handleClick = function($item, e) {
	var $parentUL = $item.parent();
	if ($parentUL.is('.root-level')) {
		if ((($item.hasClass('follow-link'))) || ((!$item.hasClass('menu-parent')))) {
			if ($item.hasClass('hover-menu')) {
				// user pressed enter or space on a dropdown menu item, not an item on the menu bar get the target href and go there	
				var target = $item.find('a').attr('target');
				if (target === '_blank') {
					window.open($item.find('a').attr('href'), '_blank');
				} else {
					window.location = $item.find('a').attr('href');
				}
				return false;
			} else {
				$item.children('.dropdown-menu').first().addClass('show').attr('aria-hidden', 'false');
				this.bChildOpen = true;
				return false;
			}
		} else {
			// open the child menu if it is closed
			$item.children('.dropdown-menu').first().addClass('show').attr('aria-hidden', 'false');
			this.bChildOpen = true;
		}
	} else {
		var $mainNav = $parentUL.closest('.navbar-nav');
		
		if (!$mainNav.hasClass('hover-menu')) {
			//e.preventDefault();
			//console.log('not at hover-menu');
			//return false;
			if ($item.hasClass('dropdown')) {
				$item.children('.dropdown-menu').first().addClass('show').attr('aria-hidden', 'false');
				this.bChildOpen = true;
				return false;
			} 
		}
		// remove hover and focus styling
		this.$allItems.removeClass('menu-hover menu-focus');
		// close the menu
		this.$id.find('.dropdown-menu').not('.root-level').removeClass('show').attr('aria-hidden','true');
	}
	// If this is a scroll link
	if (($item.hasClass('scroll-link')) || ($item.find('a').hasClass('scroll-link'))) {
		event.preventDefault();

		var $anchorLink = $item.find('a');
		scrollToAnchor($anchorLink, 50, 1000);
		return false;
	} else {
		//console.log('THIS URL: '+ $item.find('a').attr('href'));
		target = $item.find('a').attr('target');
		if (target === '_blank') {
			window.open($item.find('a').attr('href'), '_blank');
		} else {
			window.location = $item.find('a').attr('href');
		}
		return false;	
	}
		
	// if menu item triggers some behavior other than going to a link, would stop propagation and return false 
	// e.stopPropagation();
	// return false;
} // end handleClick()
// Function handleFocus() is a member function to process focus events  for the menu.
// @param($item object) $item is the jquery object of the item firing the event
// @param(e object) e is the associated event object
// @return(boolean) Returns true;
menubar.prototype.handleFocus = function($item, e) {
	// if activeItem is null, we are getting focus from outside the menu. Store the item that triggered the event
	if (this.$activeItem == null) {
		this.$activeItem = $item;
	} else if ($item[0] != this.$activeItem[0]) {
		return true;
	}
	// get the set of jquery objects for all the parent items of the active item
	var $parentItems = this.$activeItem.parentsUntil('div').filter('.menu-item');
	// remove focus styling from all other menu items
	this.$allItems.removeClass('menu-focus');
	// add styling to the active item 
	this.$activeItem.addClass('menu-focus');
	/*	
	if (this.$activeItem.hasClass('menu-parent')) { 
		// for parent items, add .menu-focus directly to the list item
		this.$activeItem.addClass('menu-focus');
	}
	else { 
		// for sub-menu items, add .menu-focus to the anchor
		this.$activeItem.find('a').addClass('menu-focus');
	}
	*/
	// add styling to all parent items.
	$parentItems.addClass('menu-focus');
	if (this.vmenu == true) {
		// if the bChildOpen is true, open the active item's child menu (if applicable)
		if (this.bChildOpen == true) {
			var $itemUL = $item.parent();
			// if the itemUL is a root-level menu and item is a parent item, show the child menu.
			if ($itemUL.is('.root-level') && ($item.attr('aria-haspopup') == 'true')) {
				$item.children('.dropdown-menu').addClass('show').attr('aria-hidden', 'false');
			}
		} else {
			this.vmenu = false;
		}
	}
	return true;
} // end handleFocus()
// Function handleBlur() is a member function to process blur events  for the menu.
// @param($item object) $item is the jquery object of the item firing the event
// @param(e object) e is the associated event object
// @return(boolean) Returns true;
menubar.prototype.handleBlur = function($item, e) {
	// $item.find('a').removeClass('menu-focus');
	$item.removeClass('menu-focus');
	return true;
} // end handleBlur()
// Function handleKeyDown() is a member function to process keydown events  for the menus.
// @param($item object) $item is the jquery object of the item firing the event
// @param(e object) e is the associated event object
// @return(boolean) Returns false if consuming; true if propagating
menubar.prototype.handleKeyDown = function($item, e) {
	if (e.altKey || e.ctrlKey) {
		// Modifier key pressed: Do not process
		return true;
	}
	switch(e.keyCode) {
		case this.keys.tab: {
			// hide all menu items and update their aria attributes
			this.$id.find('.dropdown-menu').removeClass('show').attr('aria-hidden', 'true');
			// remove focus styling from all menu items
			this.$allItems.removeClass('menu-focus');
			this.$activeItem = null;
			this.bChildOpen == false;
			break;
		}
		case this.keys.esc: {
			var $itemUL = $item.parent();
			if ($itemUL.is('.root-level')) {
				// hide the child menu and update the aria attributes
				$item.children('.dropdown-menu').first().removeClass('show').attr('aria-hidden', 'true');
			} else {
				// move up one level
				this.$activeItem = $itemUL.parent();
				// reset the childOpen flag
				this.bChildOpen = false;
				// set focus on the new item
				this.$activeItem.focus();
				// hide the active menu and update the aria attributes
				$itemUL.removeClass('show').attr('aria-hidden', 'true');
			}
			e.stopPropagation();
			return false;
		}
		case this.keys.enter:
		case this.keys.space: {
			if (($item.hasClass('scroll-link')) || ($item.find('a').hasClass('scroll-link'))) {
				event.preventDefault();
				var $anchorLink = $item.find('a');
				scrollToAnchor($anchorLink, 50, 1000);
				return false;
			} else if ((($item.hasClass('follow-link'))) || ((!$item.hasClass('menu-parent')))) {
				// user pressed enter or space on a dropdown menu item, not an item on the menu bar get the target href and go there	
				var target = $item.find('a').attr('target');
				if (target === '_blank') {
					$item.find('a').trigger('click');
					//window.open($item.find('a').attr('href'), '_blank');
				} else {
					window.location = $item.find('a').attr('href');
				}
				return false;
			} else {	
				var $parentUL = $item.parent();
				if ($parentUL.is('.root-level')) {
					// open the child menu if it is closed
					$item.children('.dropdown-menu').first().addClass('show').attr('aria-hidden', 'false');
					this.bChildOpen = true;
				} else {
					// remove hover styling
					this.$allItems.removeClass('menu-hover');
					this.$allItems.removeClass('menu-focus');
					// close the menu
					this.$id.find('.dropdown-menu').not('.root-level').removeClass('show').attr('aria-hidden','true');
					// clear the active item
					this.$activeItem = null;
				}
				e.stopPropagation();
				return false;
			}
		}
		case this.keys.left: {
			if (this.vmenu == true && $itemUL.is('.root-level')) {
				// If this is a vertical menu and the root-level is active, move to the previous item in the menu
				this.$activeItem = this.moveUp($item);
				
			/*} else if (this.$activeItem.parent().hasClass('sub-menu')) {
				console.log('has sub menu');*/
				
			} else {
				var $parentMenu = this.$activeItem.parent(); 
				if ($parentMenu.hasClass('sub-menu')) {
					//console.log('SUB MENU');
				} else {
					//console.log('not sub menu');
				}
				this.$activeItem = this.moveToPrevious($item);
			}
			this.$activeItem.focus();
			e.stopPropagation();
			return false;
		}
		case this.keys.right: {
			if (this.vmenu == true && $itemUL.is('.root-level')) {
				// If this is a vertical menu and the root-level is active, move to the next item in the menu
				this.$activeItem = this.moveDown($item);
			} else {
				jQuery.when(this.$activeItem = this.moveToNext($item)).then(function() {
					//jQuery('.navbar-nav > .menu-item').not('.menu-focus').find('.dropdown-menu').removeClass('show');
					//jQuery('.navbar-nav .menu-focus > .dropdown-menu').addClass('show');	
					var $thisParent = this.parents('.dropdown-menu');
					var thisGrandParent = $thisParent.parents('.dropdown-menu').parent('.dropdown');
					
					//console.log('GrandParent: ');
					//console.log(thisGrandParent);
					
					//jQuery('.navbar-nav > .menu-item').not('.menu-focus').find('.dropdown-menu').removeClass('show');
					jQuery('.navbar-nav > .menu-item').not(thisGrandParent).find('.dropdown-menu').removeClass('show');
					//jQuery('.navbar-nav .menu-focus > .dropdown-menu').addClass('show');
					jQuery('.menu-focus > .dropdown-menu').addClass('show');
				}); 
			}
			this.$activeItem.focus();
			e.stopPropagation();
			return false;
		}
		case this.keys.up: {
			if (this.vmenu == true && $itemUL.is('.root-level')) {
				// If this is a vertical menu and the root-level is active, move to the previous root-level menu
				this.$activeItem = this.moveToPrevious($item);
			} else {
				this.$activeItem = this.moveUp($item);
			}
			this.$activeItem.focus();
			e.stopPropagation();
			return false;
		}
		case this.keys.down: {
			if (this.vmenu == true && $itemUL.is('.root-level')) {
				// If this is a vertical menu and the root-level is active, move to the next root-level menu
				this.$activeItem = this.moveToNext($item);
			} else {
				this.$activeItem = this.moveDown($item);
			}
			this.$activeItem.focus();
			e.stopPropagation();
			return false;
		}
	} // end switch
	return true;
} // end handleKeyDown()
// Function moveToNext() is a member function to move to the next menu level.
// This will be either the next root-level menu or the child of a menu parent. If at the root level and the active item is the last in the menu, this function will loop  to the first menu item.
// If the menu is a horizontal menu, the first child element of the newly selected menu will  be selected
// @param($item object) $item is the active menu item
// @return (object) Returns the item to move to. Returns $item is no move is possible
menubar.prototype.moveToNext = function($item) {
	var $itemUL = $item.parent(); // $item's containing menu
	var $menuItems = $itemUL.children('.menu-item').not('.seperator'); // the items in the currently active menu
	var menuNum = $menuItems.length; // the number of items in the active menu
	var menuIndex = $menuItems.index($item); // the items index in its menu
	var $newItem = null;
	var $newItemUL = null;
	if ($itemUL.is('.root-level')) {
		// this is the root level move to next sibling. This will require closing  the current child menu and opening the new one.
		if (menuIndex < menuNum-1) { // not the last root menu
			$newItem = $item.next();
		} else { // wrap to first item
			$newItem = $menuItems.first();
		}
		// close the current child menu (if applicable)
		if ($item.attr('aria-haspopup') == 'true') {
			var $childMenu = $item.children('.dropdown-menu').first();
			if ($childMenu.attr('aria-hidden') == 'false') {
				// hide the child and update aria attributes accordingly
				$childMenu.removeClass('show').attr('aria-hidden', 'true');
				this.bChildOpen = true;
			}
		}
		// remove the focus styling from the current menu
		$item.removeClass('menu-focus');
		// open the new child menu (if applicable)
		if (($newItem.attr('aria-haspopup') == 'true') && (this.bChildOpen == true)) {
			$childMenu = $newItem.children('.dropdown-menu').first();
			// open the child and update aria attributes accordingly
			$childMenu.show().attr('aria-hidden', 'false');
			if (!this.vmenu) {
				// select the first item in the child menu
				//$newItem = $childMenu.children('.menu-item').first().not('.seperator');
				$newItem = $childMenu.find('.menu-item').not('.seperator').first();
			}
		}
	} else {
		// this is not the root level. If there is a child menu to be moved into, do that;  otherwise, move to the next root-level menu if there is one
		if ($item.attr('aria-haspopup') == 'true') {
			$childMenu = $item.children('.dropdown-menu').first();
			//$newItem = $childMenu.children('.menu-item').first().not('.seperator');
			$newItem = $childMenu.find('.menu-item').not('.seperator').first();
			// show the child menu and update its aria attributes
			$childMenu.addClass('show').attr('aria-hidden', 'false');
			this.bChildOpen = true;
		} else {
			// at deepest level, move to the next root-level menu
			if (this.vmenu == true) {
				// do nothing
				return $item;
			}
			var $parentMenus = null;
			var $rootItem = null;
			// get list of all parent menus for item, up to the root level
			$parentMenus = $item.parentsUntil('div').filter('.dropdown-menu').not('.root-level');
			// hide the current menu and update its aria attributes accordingly
			$parentMenus.hide().attr('aria-hidden', 'true');
			// remove the focus styling from the active menu
			$parentMenus.find('.menu-item').removeClass('menu-focus');
			$parentMenus.last().parent().removeClass('menu-focus');
			$rootItem = $parentMenus.last().parent(); // the containing root for the menu
			menuIndex = this.$rootItems.index($rootItem);
			// if this is not the last root menu item, move to the next one
			if (menuIndex < this.$rootItems.length-1) {
				$newItem = $rootItem.next();
			} else { // loop
				$newItem = this.$rootItems.first();
			}
			if ($newItem.attr('aria-haspopup') == 'true') {
				$childMenu = $newItem.children('.dropdown-menu').first();

				//$newItem = $childMenu.children('.menu-item').first().not('.seperator');
				$newItem = $childMenu.find('.menu-item').not('.seperator').first();
				// show the child menu and update it's aria attributes
				$childMenu.addClass('show').attr('aria-hidden', 'false');
				this.bChildOpen = true;
			}
		}
	}
	return $newItem;
}
// Function moveToPrevious() is a member function to move to the previous menu level.
// This will be either the previous root-level menu or the child of a menu parent. If  at the root level and the active item is the first in the menu, this function will loop to the last menu item.
// If the menu is a horizontal menu, the first child element of the newly selected menu will  be selected
// @param($item object) $item is the active menu item
// @return (object) Returns the item to move to. Returns $item is no move is possible
menubar.prototype.moveToPrevious = function($item) {
	var $itemUL = $item.parent(); // $item's containing menu
	var $menuItems = $itemUL.children('.menu-item').not('.seperator'); // the items in the currently active menu
	var menuNum = $menuItems.length; // the number of items in the active menu
	var menuIndex = $menuItems.index($item); // the items index in its menu
	var $newItem = null;
	var $newItemUL = null;
	if ($itemUL.is('.root-level')) {
		// this is the root level move to previous sibling. This will require closing  the current child menu and opening the new one.
		if (menuIndex > 0) { // not the first root menu
			$newItem = $item.prev();
		} else { // wrap to last item
			$newItem = $menuItems.last();
		}
		// close the current child menu (if applicable)
		if ($item.attr('aria-haspopup') == 'true') {
			var $childMenu = $item.children('.dropdown-menu').first();
			if ($childMenu.attr('aria-hidden') == 'false') {
				// hide the child and update aria attributes accordingly
				$childMenu.removeClass('show').attr('aria-hidden', 'true');
				this.bChildOpen = true;
			}
		}
		// remove the focus styling from the current menu
		$item.removeClass('menu-focus');
		// open the new child menu (if applicable)
		if (($newItem.attr('aria-haspopup') == 'true') && this.bChildOpen == true) {
			$childMenu = $newItem.children('.dropdown-menu').first();
			// open the child and update aria attributes accordingly
			$childMenu.addClass('show').attr('aria-hidden', 'false');
			if (!this.vmenu) {
				// select the first item in the child menu
				//$newItem = $childMenu.children('li').first().not('.seperator');
				$newItem = $childMenu.find('.menu-item').not('.seperator').first();
			}
		}
	} else {
		// this is not the root level. If there is a parent menu that is not the root menu, move up one level; otherwise, move to first item of the previous root menu.
		var $parentLI = $itemUL.parent();
		var $parentUL = $parentLI.parent();
		var $parentMenus = null;
		var $rootItem = null;
		// if this is a vertical menu or is not the first child menu  of the root-level menu, move up one level.
		if (this.vmenu == true || !$parentUL.is('.root-level')) {
			$newItem = $itemUL.parent();
			// hide the active menu and update aria-hidden
			$itemUL.removeClass('show').attr('aria-hidden', 'true');
			// remove the focus highlight from the $item
			$item.removeClass('menu-focus');
			if (this.vmenu == true) {
				// set a flag so the focus handler does't reopen the menu
				this.bChildOpen = false;
			}
		} else { // move to previous root-level menu
			// hide the current menu and update the aria attributes accordingly
			$itemUL.removeClass('show').attr('aria-hidden', 'true');
			// remove the focus styling from the active menu
			$item.removeClass('menu-focus');
			$parentLI.removeClass('menu-focus');
			menuIndex = this.$rootItems.index($parentLI);
			if (menuIndex > 0) {
				// move to the previous root-level menu
				$newItem = $parentLI.prev();
			} else { // loop to last root-level menu
				$newItem = this.$rootItems.last();
			}
			// add the focus styling to the new menu
			$newItem.addClass('menu-focus');
			if ($newItem.attr('aria-haspopup') == 'true') {
				$childMenu = $newItem.children('.dropdown-menu').first();
				// show the child menu and update it's aria attributes
				$childMenu.addClass('show').attr('aria-hidden', 'false');
				this.bChildOpen = true;
				$newItem = $childMenu.children('.menu-item').first().not('.seperator');
			}
		}
	}
	return $newItem;
}
// Function moveDown() is a member function to select the next item in a menu.
// If the active item is the last in the menu, this function will loop to the  first menu item.
// @param($item object) $item is the active menu item
// @param(startChr char) [optional] startChr is the character to attempt to match against the beginning of the
// menu item titles. If found, focus moves to the next menu item beginning with that character.
// @return (object) Returns the item to move to. Returns $item is no move is possible
menubar.prototype.moveDown = function($item, startChr) {
	var $itemUL = $item.parent(); // $item's containing menu
	var $menuItems = $itemUL.children('.menu-item').not('.seperator'); // the items in the currently active menu
	var menuNum = $menuItems.length; // the number of items in the active menu
	var menuIndex = $menuItems.index($item); // the items index in its menu
	var $newItem = null;
	var $newItemUL = null;
	
	//console.log('DOWN');
	
	if ($itemUL.is('.root-level')) { // this is the root level menu
		if ($item.attr('aria-haspopup') != 'true') {
			// No child menu to move to
			return $item;
		}
		// Move to the first item in the child menu
		$newItemUL = $item.children('.dropdown-menu').first();
		$newItem = $newItemUL.find('.menu-item').not('.seperator').first();
		// make sure the child menu is visible
		$newItemUL.addClass('show').attr('aria-hidden', 'false');
		this.bChildOpen = true;
		return $newItem;
	}
	// if $item is not the last item in its menu, move to the next item. If startChr is specified, move to the next item with a title that begins with that character.
	if (startChr) {
		var bMatch = false;
		var curNdx = menuIndex+1;
		
		//console.log('LAST');
		// check if the active item was the last one on the list
		if (curNdx == menuNum) {
			curNdx = 0;
		}
		// Iterate through the menu items (starting from the current item and wrapping) until a match is found or the loop returns to the current menu item
		while (curNdx != menuIndex)  {
			// Use the first of the two following lines if menu does not contain anchor tags. Otherwise use the second var titleChr = $menuItems.eq(curNdx).html().charAt(0);
			var titleChr = $menuItems.eq(curNdx).find('a').html().charAt(0);
			if (titleChr.toLowerCase() == startChr) {
				bMatch = true;
				break;
			}
			curNdx = curNdx+1;
			if (curNdx == menuNum) {
				// reached the end of the list, start again at the beginning
				curNdx = 0;
			}
		}
		if (bMatch == true) {
			$newItem = $menuItems.eq(curNdx);
			// remove the focus styling from the current item
			$item.removeClass('menu-focus');
			return $newItem
		} else {
			return $item;
		}
	} else {
		
		//console.log('NOT LAST');
		
		//console.log(menuIndex);
		//console.log(menuNum);
		
		if (menuIndex < menuNum-1) {
			$newItem = $menuItems.eq(menuIndex+1);
		} else {
			$newItem = $menuItems.not('.seperator').first();
		}
	}
	// remove the focus styling from the current item
	$item.removeClass('menu-focus');
	return $newItem;
}
// Function moveUp() is a member function to select the previous item in a menu.
// If the active item is the first in the menu, this function will loop to the  last menu item.
// @param($item object) $item is the active menu item
// @return (object) Returns the item to move to. Returns $item is no move is possible
menubar.prototype.moveUp = function($item) {
	var $itemUL = $item.parent(); // $item's containing menu
	var $menuItems = $itemUL.find('.menu-item').not('.seperator'); // the items in the currently active menu
	var menuNum = $menuItems.length; // the number of items in the active menu
	var menuIndex = $menuItems.index($item); // the items index in its menu
	var $newItem = null;
	var $newItemUL = null;
	if ($itemUL.is('.root-level')) { // this is the root level menu
		// nothing to do
		return $item;
	}
	// if $item is not the first item in its menu, move to the previous item
	if (menuIndex > 0) {
		$newItem = $menuItems.eq(menuIndex-1);
	} else {
		// loop to top of menu
		$newItem = $menuItems.last();
	}
	// remove the focus styling from the current item
	$item.removeClass('menu-focus');
	return $newItem;
}
// Function handleKeyPress() is a member function to process keydown events  for the menus.
// @param($item object) $menu is the jquery object of the item firing the event
// @param(e object) e is the associated event object
// @return(boolean) Returns false if consuming; true if propagating
menubar.prototype.handleKeyPress = function($item, e) {
	if (e.altKey || e.ctrlKey || e.shiftKey) {
		// Modifier key pressed: Do not process
		return true;
	}
	switch(e.keyCode) {
		case this.keys.tab: {
			return true;
		}
		case this.keys.esc:
		case this.keys.enter: 
		case this.keys.space:
		case this.keys.up:
		case this.keys.down:
		case this.keys.left:
		case this.keys.right: {
			e.stopPropagation();
			return false;
		}
		default : {
			var chr = String.fromCharCode(e.which);
			this.$activeItem = this.moveDown($item, chr);
			this.$activeItem.focus();
			e.stopPropagation();
			return false;
		}
	} // end switch
	return true;
} // end handleKeyPress()
// Function handleDocumentClick() is a member function to process click events on the document. Needed to close an open menu if a user clicks outside the menu
// @param(e object) e is the associated event object
// @return(boolean) Returns true;
menubar.prototype.handleDocumentClick = function(e) {
	// get a list of all child menus
	var $childMenus = this.$id.find('.dropdown-menu').not('.root-level');
	// hide the child menus
	$childMenus.removeClass('show').attr('aria-hidden', 'true');
	this.$allItems.removeClass('menu-focus');
	this.$activeItem = null;
	// allow the event to propagate
	return true;
} // end handleDocumentClick()
/////////////// end menu widget definition /////////////////////
function enableTabbedAccessibleMenu($) {
	// Fix for non-working top level links without dropdown
	//$('.hoverable .navbar-nav > .menu-item a').click(function(e) {
	/*$('.hoverable .navbar-nav > .menu-item a').on('click', function(e) {
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
}

// Fix for non-working top level links without dropdown
function enableClickDropdowns($) {
	$('.dropdown-menu').on('click', '.dropdown-toggle', function (e) {
		$(this).is('.show') && e.stopPropagation();
		var parentLi = $(this).parent('.menu-item');
		var parentMenu = $(parentLi).parents('.dropdown-menu');
		$(parentMenu).children('.dropdown').not(parentLi).each(function () {
			$(this).children('.dropdown-toggle').removeClass('show').attr('aria-expanded','false');
			$(this).children('.dropdown-menu').removeClass('show');
		});
	});
	
	$('.navbar-nav > .menu-item a').on('click', function(e) {
		if (!$(this).hasClass('dropdown-toggle')) {
			e.preventDefault();
			if (!$(this).parent('li').hasClass('scroll-link')) {
				var $link, $linkTarget
				if (!$(this).hasClass('dropdown-toggle')) {	
					$link = $(this);
					$linkTarget = $(this).attr('target');
					if ($linkTarget === '_blank') {
						window.open($link.attr('href'), '_blank');	
					} else {
						window.location.href = $link.attr('href');
					}
				} else {
					var windowwidth = jQuery(window).width();
					if(windowwidth>991) {
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
		}
	});
}

// Make Main Nav Hoverable
function enableHoverMenu($) {
	document.querySelectorAll('.navbar .nav-item.hover-menu').forEach(function(everyitem){
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
}

// Fix for non-working top level links without dropdown
function enableTopLevelMenuLinks($) {
	$('.hoverable .navbar-nav > .menu-item a').on('click', function(e) {
		e.preventDefault();
		if (!$(this).parent('li').hasClass('scroll-link')) {
			var $link, $linkTarget
			if (!$(this).hasClass('dropdown-toggle')) {	
				$link = $(this);
				$linkTarget = $(this).attr('target');
				if ($linkTarget === '_blank') {
					window.open($link.attr('href'), '_blank');	
				} else {
					window.location.href = $link.attr('href');
				}
			} else {
				var windowwidth = jQuery(window).width();
				if(windowwidth>991) {
					$link = $(this);
					$linkTarget = $(this).attr('target');
					if ($linkTarget === '_blank') {
						window.open($link.attr('href'), '_blank');	
					} else {
						window.location.href = $link.attr('href');
					}
				} else {
					return false;
				}
			}
		}
	});
}

// Modal Adjustments
function modalAdjustments($) {
	// Modal Class added/removed from body
	$(document.body).on('show.bs.modal', function () {
		$(window.document).find('html').addClass('no-scrollbar');
	});
	$(document.body).on('hide.bs.modal', function () {
		$(window.document).find('html').removeClass('no-scrollbar');
	});
	
	// Pause Video PLayback on Modal Close
	jQuery('body').on('hidden.bs.modal', '.video-modal', function () { 
		jQuery('.video-modal').find('video').trigger('pause'); 
	});
}

// Check Accessibility Designation
function checkNavMenu($) {
	if ($('#mainNav').find('.navbar-nav').hasClass('accessible')) {
		var menu1 = new menubar('#mainNav .navbar-nav', false);
		enableTopLevelMenuLinks($);
	} else if ($('#mainNav').find('.navbar-nav').hasClass('tab-accessible')) {
		enableTabbedAccessibleMenu($);
		enableHoverMenu($);
		enableTopLevelMenuLinks($);
	} else {
		enableClickDropdowns($);
	}
}

// Update URL on Scroll for Scroll Anchor Links 
function registerScrollLinks($) {
	var navlist = [];
	$('#mainNav .update-url-on-scroll .scroll-link').each(function(i) {
		var thisLink = $(this).children('a');
		var thisId = thisLink.attr('href');
		var l = thisId.length - 1;
		if (thisId.lastIndexOf('/') === l) {
			thisId = thisId.substring(0, l);
		}
		var urlsplit = thisId.split("/");
		var lastpart = urlsplit[urlsplit.length-1];
		var thisId = '#'+ lastpart;
		var thisTarget = $(thisId);
		navlist.push({
			'anchor': thisLink,
			'id': thisId,
			'target': thisTarget
		});
	});
	if (typeof navlist !== 'undefined') {
		var permalink = $('body').data('page-permalink');
		var pageURL = window.location.href;
		
		
		
		var position = $(window).scrollTop();
		var scrollDirection;
		
		
		
		$(window).on('scroll', function(e) {
			var currentScrollOffset = $(this).scrollTop();
			/*
			var scroll = $(window).scrollTop();
			if (scroll > position) {
				//console.log('scrollDown');
				scrollDirection = 'scrollDown';
			} else {
				//console.log('scrollUp');
				scrollDirection = 'scrollUp';
			}
			position = scroll;
			//console.log('currentScrollOffset: '+ currentScrollOffset);
			*/
			if (currentScrollOffset > 100) {
				updateURLonScroll($,navlist);
			} else {
				//console.log('scrollDirection: '+ scrollDirection);
				//console.log('currentScrollOffset: '+ currentScrollOffset);
				/*
				// SOOOO CLOSE!!!!!!!!
				$.each(navlist, function(index, value) {
					section = value.id;
					section = section.replace('#','');
					console.log(section);
					pageURL = pageURL.replace(section + '/','');
				});
				*/
				window.history.pushState(null,null,pageURL);
			}
		});
	}
}
function updateURLonScroll($,navlist) {
	var pageURL = window.location.href;
	var permalink = $('body').data('page-permalink');
	var pageSlug = $('body').data('page-slug');
	
	var currentScrollOffset = $(window).scrollTop();
	//console.log('Scroll Offset: '+ currentScrollOffset);
	$.each(navlist, function(e, elem) {
		var elemID = elem.id;
		var urlUpdate = elemID.replace('#','');
		//var sectionHeader = $(elemID).find('.section-header');	
		//var sectionContent = $(elemID).find('.content');	
		if ($(elemID)[0]) {
			if (isInView(elemID)) { 
				if (window.location.href.indexOf(urlUpdate) > -1) {
					// Dont Update - Already in URL
				} else {
					var elementOffset = $(elemID).offset();
					if (($(elemID).offset().top)-75 <= currentScrollOffset) {
						//console.log(elemID);
						//console.log('Element Offset: '+ elementOffset.top);
						//console.log('Scroll Offset: '+ $(window). scrollTop());
						
						/*$.each(navlist, function(index, value) {
							console.log(value);
							pageURL = pageURL.replace(value,'');
						});
						console.log('pageURL: '+ pageURL);
						*/
						
						permalink = ((permalink.substr(-1) !== '/') ? permalink +'/' : permalink);
						
						urlUpdate = permalink + urlUpdate + '/'; 
						
						if (window.history.pushState) {
							window.history.pushState(null,null,urlUpdate);
							return false; // Exit $.each loop 
						}
					} 
				}
			} else if (currentScrollOffset < 100) {
				window.history.pushState(null,null,permalink);
			}
		}
	});
}
function detectScrollDirection($, scrollDirection) {
	var position = $(window).scrollTop();
	var scrollDirection;
	$(window).scroll(function() {
		var scroll = $(window).scrollTop();
		if (scroll > position) {
			console.log('scrollDown');
			scrollDirection = 'scrollDown';
		} else {
			console.log('scrollUp');
			scrollDirection = 'scrollUp';
		}
		position = scroll;
			
	});
	return scrollDirection;
}

jQuery.noConflict(); 
(function($) { 	
    "use strict"; // Start of use strict
	
	browserDetect($);
	accessibilityLinks($);
	comoMobileBehavior();
	checkNavMenu($);
	if ($('#mainNav .update-url-on-scroll')[0]) { 
		registerScrollLinks($);
		//detectScrollDirection($);
	}
	
	$('#nav-icon').on('click', function(){
		$(this).toggleClass('open');
	});
	
	$('.scroll-top').on('click', function(){
		$('html,body').animate({scrollTop : 0},800);
		return false;
	});
	
	$('.home .scroll-top-home').on('click', function(){
		$('html,body').animate({scrollTop : 0},800);
		return false;
	});
	
	// Leaving site warning
	$('body').on('click','.confirm-link',function(){
		var confirmMessage = (($(this).data('msg')) ? $(this).data('msg') : "You are about to leave this website.  Please confirm to continue.");
		if (confirm(confirmMessage)) {
			// proceed
		} else {
			return false;
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
				if ($($anchorLink).hasClass('override-scroll')) {
					// Do Not Scroll
				} else {
					if ($($anchorLink).hasClass('custom-offset')) {
						var scrollClass = $.grep(($($anchorLink).attr('class').split(/\s+/)), function(v, i){
							return v.indexOf('scrollto') === 0;
						}).join();
						scrollto = (scrollClass.split("-"))[1];
						//console.log(scrollto);
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
			}
			check_if_in_view();
		}
		
		$('body').on('click','a.scroll-link, .scroll-link > a',function(event){
			event.preventDefault();
			var $anchor = $(this);
			scrollToAnchor($anchor, scrollto, scrollDelay);
		});
	});
	
	/*
	// Add Slide Down effect to Dropdowns
	$('.dropdown').on('show.bs.dropdown', function(){
		console.log('DROPDOWN');
		$(this).find('.dropdown-menu').first().stop(true, true).slideDown(300);
	});
	$('.dropdown').on('hide.bs.dropdown', function(){
		console.log('DROPDOWN CLOSE');
		$(this).find('.dropdown-menu').first().stop(true, true).slideUp(200);
	});
	*/
	
	// Closes the Responsive Menu on Menu Item Click
	$('.navbar-collapse ul li.scroll-link a').on('click', function() {
        $('.navbar-toggle:visible').click();
    });
	
	// Add sticky class to header on scroll
	$(function () {
		var scrollPos = $(document).scrollTop();
		if (scrollPos > 100) {
			$('body').addClass('scrolled');
			$('#masthead').addClass('sticky');
			if (scrollPos > 300) {
				$('body').addClass('scrolled-deeper');
				$('#masthead').addClass('deep-scroll');
			} else {
				$('body').removeClass('scrolled-deeper');
				$('#masthead').removeClass('deep-scroll');
			}
		} else {
			$('body').removeClass('scrolled');
			$('body').removeClass('scrolled-deeper');
			$('#masthead').removeClass('sticky');
			$('#masthead').removeClass('deep-scroll');
		}
		$(window).on('scroll', function () {
            if ($(this).scrollTop() > 100) {
				$('#masthead').addClass('sticky');
				$('body').addClass('scrolled');
				if ($(this).scrollTop() > 300) {
					$('body').addClass('scrolled-deeper');
					$('#masthead').addClass('deep-scroll');
				} else {
					$('body').removeClass('scrolled-deeper');
					$('#masthead').removeClass('deep-scroll');
				}
			} else {
				$('body').removeClass('scrolled');
				$('body').removeClass('scrolled-deeper');
				$('#masthead').removeClass('sticky');
				$('#masthead').removeClass('deep-scroll');
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
		$(window).on('scroll', function () {
            if ($(this).scrollTop() > contentStart) {
				$('body').addClass('scrolled-content');
            } else {
				$('body').removeClass('scrolled-content');
			}
        });
    });
	
	// Add Animations to on scroll
	var $window = $(window);
	$window.on('scroll resize', check_if_in_view);
	$window.trigger('scroll');
	function check_if_in_view() {
		var $animation_elements = $('.show-on-scroll');
		$.each($animation_elements, function() {
			var $element = $(this);
			if (isInView($element)) { 	
				if ($element.hasClass('bounceIn-on-scroll')) { $element.addClass('animated bounceIn'); }
				else if ($element.hasClass('fadeInUp-on-scroll')) { $element.addClass('animated fadeInUp'); }
				else if ($element.hasClass('fadeInDown-on-scroll')) { $element.addClass('animated fadeInDown'); }
				else if ($element.hasClass('fadeInLeft-on-scroll')) { $element.addClass('animated fadeInLeft'); }
				else if ($element.hasClass('fadeInRight-on-scroll')) { $element.addClass('animated fadeInRight'); }
				else if ($element.hasClass('fadeInTopLeft-on-scroll')) { $element.addClass('animated fadeInTopLeft'); }
				else if ($element.hasClass('fadeInTopRight-on-scroll')) { $element.addClass('animated fadeInTopRight'); }
				else if ($element.hasClass('fadeInBottomLeft-on-scroll')) { $element.addClass('animated fadeInBottomLeft'); }
				else if ($element.hasClass('fadeInBottomRight-on-scroll')) { $element.addClass('animated fadeInBottomRight'); }
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
	
	$('.search-toggle').on('click', function(e) { 
		e.preventDefault();
		$(this).toggleClass('clicked');
		$(this).closest('.menu-search').toggleClass('active');
		$(this).parents('.widget').toggleClass('search-active');
		return false;
	});
	
	$('#masthead .nav-link').not('.search-toggle').on('hover', function() { 
		$('#masthead').find('.menu-search').removeClass('active');
		$('#masthead').find('.search-active').removeClass('search-active');
	});
	
	modalAdjustments($);
	check_if_in_view();
})(jQuery);
jQuery(window).on('resize', function() {
    "use strict"; // Start of use strict
	comoMobileBehavior();
	checkNavMenu(jQuery);
});