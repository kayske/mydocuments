$(document).ready(function() {
	$().piroBox({
			my_speed: 400, //animation speed
			bg_alpha: 0.6, //background opacity
			slideShow : true, // true == slideshow on, false == slideshow off
			slideSpeed : 4, //slideshow duration in seconds(3 to 6 Recommended)
			close_all : '.piro_close,.piro_overlay'// add class .piro_overlay(with comma)if you want overlay click close piroBox

	});
});
/* //////////// Settings for fixed sidebar layout //////////// */
$(document).ready(function() {

	function staticNav() { 
		var sidenavHeight = $("#sidenav").height();
		var winHeight = $(window).height();
		var browserIE6 = (navigator.userAgent.indexOf("MSIE 6")>=0) ? true : false;

		if (browserIE6) {
			$("#sidenav").css({'position' : 'absolute'});
		} else {
			$("#sidenav").css({'position' : 'fixed'});
		}
	
		if (sidenavHeight > winHeight) {
			$("#sidenav").css({'position' : 'static'});
		}
	}
	
	staticNav();
	
	$(window).resize(function () { //Each time the viewport is adjusted/resized, execute the function
		staticNav();
	});

});
/* //////////// Settings for Nivo Slider //////////// */
$(window).load(function() {
	$('#slider').nivoSlider({
		effect:'random',
		slices:15,
		animSpeed:500,
		pauseTime:6000,
		startSlide:0, //Set starting Slide (0 index)
		directionNav:true, //Next &amp; Prev
		directionNavHide:true, //Only show on hover
		controlNav:true, //1,2,3...
		controlNavThumbs:false, //Use thumbnails for Control Nav
		controlNavThumbsSearch: '.jpg', //Replace this with...
		controlNavThumbsReplace: '_thumb.jpg', //...this in thumb Image src
		keyboardNav:true, //Use left &amp; right arrows
		pauseOnHover:true, //Stop animation while hovering
		manualAdvance:false, //Force manual transitions
		captionOpacity:0.8, //Universal caption opacity
		beforeChange: function(){},
		afterChange: function(){},
		slideshowEnd: function(){} //Triggers after all slides have been shown
	});
});

    $(document).ready(function () {

            // transition effect
            style = 'easeOutBounce';

            // if the mouse hover the image
            $('.photo').hover(
                    function() {
                            //display heading and caption
                            $(this).children('div:first').stop(false,true).animate({top:0},{duration:600, easing: style});
                            $(this).children('div:last').stop(false,true).animate({bottom:0},{duration:600, easing: style});
                    },

                    function() {
                            //hide heading and caption
                            $(this).children('div:first').stop(false,true).animate({top:-50},{duration:600, easing: style});
                            $(this).children('div:last').stop(false,true).animate({bottom:-50},{duration:600, easing: style});
                    }
            );

    });

$(function(){

	$('#contactform').slidinglabels({
	
		/* these are all optional */
		topPosition  : '8px',  // how far down you want each label to start
		leftPosition : '8px',  // how far left you want each label to start
		axis         : 'x',    // can take 'x' or 'y' for slide direction
		speed        : 'fast'  // can take 'fast', 'slow', or a numeric value

	});

});
