(function($) {

	"use strict";

	$(window).on("load", function() {

		// PRELOADER
		$("body").toggleClass("loaded");
		setTimeout(function() {
			$("body").addClass("loaded");
		}, 3000);

	});

	$(document).ready(function() {
    
    // SMOOTH SCROLLING
	$('a.scrollto').on('click', function(e){
        //store hash
        var target = this.hash;    
        e.preventDefault();
		$('body').scrollTo(target, 800, {offset: 0, 'axis':'y'});
	});

	// SUBSCRIBE FIELD ANIMATION
	var buttonsubscribe = document.getElementById('subscribe');
	buttonsubscribe.addEventListener('click', function(e){
		e.preventDefault();
		this.classList.add('is-done','is-active');
		setTimeout(function(){
			buttonsubscribe.innerHTML = "Thanks ! Check Your Email."
		}, 500);
	});

});
})(jQuery);