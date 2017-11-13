<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/tail.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
    return;
}
?>

    </div>
</div>

<img class="top_btn" src="/img/main/top_btn.png" alt="TOP"/>

<!-- } 콘텐츠 끝 -->


<!-- 하단 시작 { -->
<!-- 푸터 -->
<!--<div class="top_btn"><a href="#"><img src="img/main/top_btn.jpg" alt="TOP"/></a></div>-->
<div class="partner">
	<div class="slider1">
		<?php echo display_banner('partner', 'partner.skin.php',$g5['lang']); ?>
		<!--
		<div class="slide"><a href="http://www.7-eleven.co.kr/" target="_blank"><img src="<?echo $g5['tmpl_url']?>/img/main/f_ban1.jpg" alt="1"/></a></div>
		<div class="slide"><a href="http://cu.bgfretail.com/index.do" target="_blank"><img src="<?echo $g5['tmpl_url']?>/img/main/f_ban2.jpg" alt="2"/></a></div>
		<div class="slide"><a href="http://www.shinsegae.com/" target="_blank"><img src="<?echo $g5['tmpl_url']?>/img/main/f_ban3.jpg" alt="3"/></a></div>
		<div class="slide"><a href="http://www.doota-mall.com/index.do" target="_blank"><img src="<?echo $g5['tmpl_url']?>/img/main/f_ban4.jpg" alt="4"/></a></div>
		<div class="slide"><a href="http://www.ehyundai.com/newPortal/outlet/main.do" target="_blank"><img src="<?echo $g5['tmpl_url']?>/img/main/f_ban5.jpg" alt="5"/></a></div>
		<div class="slide"><a href="http://www.iparkmall.co.kr/main/main.asp" target="_blank"><img src="<?echo $g5['tmpl_url']?>/img/main/f_ban6.jpg" alt="6"/></a></div>
		<div class="slide"><a href="http://www.lwt.co.kr/tower/main/main.do" target="_blank"><img src="<?echo $g5['tmpl_url']?>/img/main/f_ban7.jpg" alt="7"/></a></div>
		<div class="slide"><a href="http://www.smtown.com/" target="_blank"><img src="<?echo $g5['tmpl_url']?>/img/main/f_ban8.jpg" alt="8"/></a></div>
		-->
	</div>
</div>



<div class="footer">
	<div class="footer_area">
		<!--<div class="top_btn"><a href="#"><img src="/img/main/top_btn.jpg" alt="TOP"/></a></div>-->
		<p class="address"><?=_t('(재)한국방문위원회<br/>서울특별시 종로구 인사동 5길 29 (인사동 194-27) 태화빌딩 802호 ㅣ Tel : +82–(0)2–6272 7300 ㅣ Fax : +82-(0)2-6272 7400')?>
		</p>
		<p class="copy">Copyright 2017. ⓒ KOREA TOUR CARD. All Right Reserved.</p>
	</div>
</div>
<!-- 푸터 끝 -->

<!-- } 하단 끝 -->

<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
});
</script>

<?php
include_once(G5_THEME_PATH."/tail.sub.php");
?>
