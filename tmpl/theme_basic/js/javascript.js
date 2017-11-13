//�׺�

/*

SMINT V1.0 by Robert McCracken

SMINT is my first dabble into jQuery plugins!

http://www.outyear.co.uk/smint/

If you like Smint, or have suggestions on how it could be improved, send me a tweet @rabmyself

*/
(function(){

	
	$.fn.smint = function( options ) {
		// adding a class to users div
		$(this).addClass('sub_navi')

		var settings = $.extend({
            'scrollSpeed '  : 500
            }, options);

		return $('.sub_navi').each( function() {

			if ( settings.scrollSpeed ) {
				var scrollSpeed = settings.scrollSpeed
			}

			// get initial top offset for the menu 
			var stickyTop = $('.sub_navi').offset().top;	

			// check position and make sticky if needed
			var stickyMenu = function(){
				
				// current distance top
				var scrollTop = $(window).scrollTop(); 
							
				// if we scroll more than the navigation, change its position to fixed and add class 'fxd', otherwise change it back to absolute and remove the class
				if (scrollTop > stickyTop) { 
					$('.sub_navi').css({ 'position': 'fixed', 'top':0 }).addClass('fxd');

					} else {
						$('.sub_navi').css({ 'position': 'absolute', 'top':stickyTop }).removeClass('fxd'); 
					}   
			};
					
			// run function
			stickyMenu();
					
			// run function every time you scroll
			$(window).scroll(function() {
				 stickyMenu();
			});
		});
	}
})();

/*
var speed=500;
	$(function(){
		$("#header").find("ul").mouseover(function(){
			$(this).find(".icon1 a").css("color","#00aee9")
			$(this).find(".icon2 a").css("color","#ff60c2")
			$(this).find(".icon3 a").css("color","#9ed249")
			$(this).find(".icon4 a").css("color","#f3c139")
			$(this).find(".sub").stop().animate({
				
				height: $(this).find(".subsub").innerHeight()+'px'
			  }, speed, function() {
				// Animation complete.
			  });
			  $(this).find(".subsub").stop().animate({
				marginTop:0+"px"
			  }, speed, function() {
				// Animation complete.
			  });
		})
		
		$("#header").find("ul").mouseout(function(){
			$(this).find(".icon1 a").css("color","#fff")
			$(this).find(".icon2 a").css("color","#fff")
			$(this).find(".icon3 a").css("color","#fff")
			$(this).find(".icon4 a").css("color","#fff")
			$(this).find(".sub").stop().animate({
				height: 0+'px'
			  }, speed, function() {
				// Animation complete.
			  });
			   $(this).find(".subsub").stop().animate({
				marginTop:-100+"px"
			  }, speed, function() {
				// Animation complete.
			  });
		})
	})
*/

















//��1
$(document).ready(function(){
	$(".tabContents,.tabContents1,.tabContents2,.tabContents3").hide(); // Hide all tab content divs by default
	$(".tabDetails,.tabDetails1").each(function(index){
		$(this).find(".tabContents:first,.tabContents1:first,.tabContents2:first,.tabContents3:first").show();
	});
	
	$(".tab_link").click(function(){ 
		var activeTab = $(this).attr("href"); 
		//$(this).removeClass("active"); 
		$(this).parent().parent().find("li a").removeClass("active")
		$(this).addClass("active"); 
		$(this).parent().parent().siblings("div").find(".tabContents,.tabContents1,.tabContents2,.tabContents3").hide();
		//$(".tabContents").hide();
		$(activeTab).fadeIn(); 
		
		return false; 
	});
});