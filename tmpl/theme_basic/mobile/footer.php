<img class="top_btn" src="/img/main/top_btn.png" alt="TOP"/>



<div class="partner">
	<div class="partner_wp">
		<div class="partner_clear"></div>
		<div class="partner_area">
		<?php echo display_banner('partner', 'partner.skin.php',$g5['lang']); ?>
		<!--
			<div class="slider1">
				<div class="slide"><a href="http://www.7-eleven.co.kr/" target="_blank"><img src="/img/mobile/main/f_ban1.jpg" alt="1"/></a></div>
				<div class="slide"><a href="http://cu.bgfretail.com/index.do" target="_blank"><img src="/img/mobile/main/f_ban2.jpg" alt="2"/></a></div>
				<div class="slide"><a href="http://www.shinsegae.com/" target="_blank"><img src="/img/mobile/main/f_ban3.jpg" alt="3"/></a></div>
				<div class="slide"><a href="http://www.doota-mall.com/index.do" target="_blank"><img src="/img/mobile/main/f_ban4.jpg" alt="4"/></a></div>
				<div class="slide"><a href="http://www.ehyundai.com/newPortal/outlet/main.do" target="_blank"><img src="/img/mobile/main/f_ban5.jpg" alt="5"/></a></div>
				<div class="slide"><a href="http://www.iparkmall.co.kr/main/main.asp" target="_blank"><img src="/img/mobile/main/f_ban6.jpg" alt="6"/></a></div>
				<div class="slide"><a href="http://www.lwt.co.kr/tower/main/main.do" target="_blank"><img src="/img/mobile/main/f_ban7.jpg" alt="7"/></a></div>
				<div class="slide"><a href="http://www.smtown.com/" target="_blank"><img src="/img/mobile/main/f_ban8.jpg" alt="8"/></a></div>
			</div>
			-->
		</div>
	</div>
</div>





<div class="footer">
	<div class="footer_area">
		<!--<div class="top_btn"><a href="javascript:void(0);"><img src="/img/main/top_btn.jpg" alt="TOP"/></a></div>-->
		<div class="ft_pad">
			<ul class="ft_btn">
				<li>
					<a href="<?=set_class_index3($_SESSION['lang'])?>" target="_blank">
						<?if( $_SESSION['lang'] == "zh_CN" ){?>
							<img src="/img/main/others_7_weibo.png"/>
						<?}else{?>
							<img src="/img/mobile/main/ft_face.png" alt="페이스북 이동"/>
						<?}?>
					</a>
				</li>

				<li><a href="https://www.youtube.com/channel/UC9mKxPyNKr9HbYJsBPbTrDQ" target="_blank"><img src="/img/mobile/main/ft_ut.png" alt="유튜브 이동"/></a></li>
			</ul>

			<p class="address <?=set_class('address_lan','ja_JP')?>">
				<?=_t('(재)한국방문위원회(고유번호 : 104-82-10669)<br/>')?>
				<?=_t('서울특별시 종로구 인사동 5길 29 (인사동 194-27) 태화빌딩 802호<br/>')?>
				Tel : +82–(0)2–6272 7300 ㅣ Fax : +82-(0)2-6272 7400
			</p>
			<p class="copy">Copyright 2017. ⓒ KOREA TOUR CARD. All Right Reserved.</p>
		</div>
	</div>
</div>
</div>
	</div>



<?php
//include_once(G5_THEME_PATH."/tail.sub.php");
?>
<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
});
</script>