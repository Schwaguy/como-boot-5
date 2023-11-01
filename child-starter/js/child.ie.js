(function() {
	// Sliding Navigation Hover
	const target = document.querySelector(".target");
	const links = document.querySelectorAll(".slider-nav > .menu-item");
	//const colors = ["deepskyblue", "orange", "firebrick", "gold", "magenta", "black", "darkblue"];
	const colors = ['#015cd5', '#015cd5', '#015cd5', '#015cd5', '#015cd5', '#015cd5', '#015cd5'];
	function mouseenterFunc() {
		var windowwidth = jQuery(window).width();
		if(windowwidth>991) {
			if (!this.parentNode.classList.contains("active")) {
				for (let i = 0; i < links.length; i++) {
					if (links[i].parentNode.classList.contains("active")) {
						links[i].parentNode.classList.remove("active");
					}
					//links[i].style.opacity = "0.25";
				}
				this.parentNode.classList.add("active");
				this.style.opacity = "1";
				const width = this.getBoundingClientRect().width;
				const height = this.getBoundingClientRect().height;
				const left = this.getBoundingClientRect().left + window.pageXOffset;
				//const top = this.getBoundingClientRect().top + window.pageYOffset;
				const top = this.getBoundingClientRect().top;
				const color = colors[Math.floor(Math.random() * colors.length)];
				target.style.width = `${width}px`;
				target.style.height = `${height}px`;
				target.style.left = `${left}px`;
				target.style.top = `${top}px`;
				target.style.borderColor = color;
				target.style.transform = "none";
			}
		}
	}
	function mouseleaveFunc() {
		var windowwidth = jQuery(window).width();
		if(windowwidth>991) {
			for (let i = 0; i < links.length; i++) {
				if (links[i].parentNode.classList.contains("active")) {
					links[i].parentNode.classList.remove("active");
				}
			}
			this.parentNode.classList.remove("active");
			target.style.width = `0px`;
			target.style.height = `0px`;
			//target.style.left = `0px`;
			target.style.top = `100%`;
			target.style.borderColor = 'transparent';
			target.style.transform = 'none';
		}
	}
	for (let i = 0; i < links.length; i++) {
		links[i].addEventListener("click", (e) => e.preventDefault());
		links[i].addEventListener("mouseenter", mouseenterFunc);
		links[i].addEventListener("mouseleave", mouseleaveFunc);
	}
	function resizeFunc() {
		var windowwidth = jQuery(window).width();
		if(windowwidth>991) {
			const active = document.querySelector(".slider-nav li.active");
			if (active) {
				const left = active.getBoundingClientRect().left + window.pageXOffset;
				const top = active.getBoundingClientRect().top + window.pageYOffset;
				//const top = active.getBoundingClientRect().top;
				target.style.left = `${left}px`;
				target.style.top = `${top}px`;
			}
		}
	}
	window.addEventListener("resize", resizeFunc);
	
	function scrollFunc() {
		var windowwidth = jQuery(window).width();
		if(windowwidth>991) {
			const active = document.querySelector(".slider-nav li.active");
			if (active) {
				const left = active.getBoundingClientRect().left + window.pageXOffset;
				//const top = active.getBoundingClientRect().top + window.pageYOffset;
				const top = active.getBoundingClientRect().top;
				target.style.left = `${left}px`;
				target.style.top = `${top}px`;
			}
		}
	}
	jQuery(document).on('scroll', function(){
		scrollFunc();
	});
	
	jQuery('body').on('hover blur focus focusout mouseenter mouseleave','#hover-target',function(e){
		var $widgettitle = jQuery(this).parents('.widget').children('.widgettitle');
		if ((e.type === 'hover') || (e.type === 'focus') || (e.type === 'mouseenter')) {
			//setTimeout(function(){
				$widgettitle.addClass('text-focus-in');
			//},600);
		} else {
			//setTimeout(function(){
				$widgettitle.removeClass('text-focus-in');
			//},600);
		}
	});
	
})();