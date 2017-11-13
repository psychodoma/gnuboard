$(function(){
  $('.topImg img').css('width','100%');
	$('.grid').hover(function(){
		$(this).children('.effect-bubba').children('.bgss').css('opacity',0.7);
		$('.bgss').css('z-index',10);
	},function(){
		$(this).children('.effect-bubba').children('.bgss').css('opacity',0);
	})


	//$('.figcap').mouseenter($('.figcaps').fadeOut(200)).mouseleave($('.figcaps').fadeIn(200));



	$('.bgss').each(function(index){
		var src = $(this).attr('valid');

		var str = "<style>.effect-bubba .figcap.bg"+index+"::before{ background-image:url('"+src+"');background-repeat:no-repeat;background-position:center center; background-size:255px 255px; }</style>";

		$(str).appendTo('head');

	})


})


//메인1슬라이드
$(document).ready(function(){
	var slider = "";
		slider = $('.bxslider').bxSlider({
		mode:'fade',
		auto: true
	});
	$(document).on('click','.bx-next, .bx-prev, .bx-pager-link',function() {
		slider.stopAuto();
		slider.startAuto();
	});
});


//메인 중간 카드소개 슬라이드
$(document).ready(function(){
	var slider = "";
		slider = $('#slider1').bxSlider({
		mode:'fade',
		auto: true,
		controls: false,
		autoControls: false,
		pager: true
	});
	$(document).on('click','.bx-pager-link',function() {
		slider.stopAuto();
		slider.startAuto();
	});
});


//메인 하단 제휴 슬라이드
$(document).ready(function(){
	$('.slider1').bxSlider({
		slideWidth: 170,
		minSlides: 2,
		maxSlides: 7,
		moveSlides: 1,
		//slideMargin: 1,
		//autoHover: true,
        //useCSS: false,
		auto: true,
		controls: false,
		pager: false,
		autoControls: true,
		speed: 1200
	});
});
