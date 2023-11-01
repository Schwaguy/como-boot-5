// Image Slider
var config = {
  img1: document.querySelector('.image-slider .image-1'),
  img2: document.querySelector('.image-slider .image-2'),
  maxBlurPx: 10
}
function getInput(value, max) {
	var sliderPercentage = (value / max).toFixed(2);
	config.img1.style.opacity = 1 - sliderPercentage;
	setBlur(config.img1, (10*sliderPercentage).toFixed(2));
	config.img2.style.opacity = sliderPercentage;
	setBlur(config.img2, 10-(10*sliderPercentage).toFixed(2));
	config.img2.style.webkitFilter = "blur(" + (10 - (10 * sliderPercentage).toFixed(1)) + "px)";
}
function setBlur(el, value) {
	if (el.style.hasOwnProperty('filter')) {
		el.style.filter = "blur("+value+"px)";
	}
	if (el.style.hasOwnProperty('webkitFilter')) {
		el.style.webkitFilter = "blur("+value+"px)";
	}
	if (el.style.hasOwnProperty('mozFilter')) {
		el.style.mozFilter = "blur("+value+"px)";
	}
	if (el.style.hasOwnProperty('oFilter')) {
		el.style.oFilter = "blur("+value+"px)";
	}
	if (el.style.hasOwnProperty('msFilter')) {
		el.style.msFilter = "blur("+value+"px)";
	}
}
jQuery(document).on('input', '#imageRange', function() {
	var sliderVal = jQuery(this).val();
	getInput(sliderVal, 100);
});