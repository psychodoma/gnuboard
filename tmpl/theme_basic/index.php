<?php
define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/index.php');
    return;
}
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/index.php');
    return;
}

include_once(G5_THEME_PATH.'/head.php');


$weather_result = get_weather();
$weather_result1 = get_weather1();
$Data = get_exchange_data();
$result_exchange = get_exchange();
$benefit_notice = get_main_benefit('tourinfo');
$allshop_notice = get_notice_random('allshop',3);
$prcenter_notice = get_notice_random1('prcenter',3, $g5['lang']);

?>



<script src="<?=G5_JS_URL?>/jquery.eislideshow.js"></script>

<div class="benefit">
	<div class="benefit_content">
		<div class="benefit_title">
			<p><?=_t('교통카드 기능 플러스 쇼핑, 관광지, 공연 할인까지!')?></p>
			<h2><?=_t('코리아투어카드 혜택')?></h2>
		</div>

		<ul class="benefit_btn">
			<li class="benefit4">
			<a href="/bbs/board.php?bo_table=cardbenefit&info=benefitshop&me_code=30&num=2&sca=Tourist attractions<?=lang_url_a($_SESSION['lang'])?>" class="benLink1">
					<div class="benefitBtn_txt">
						<img src="/img/main/benefit_icon3.jpg"/>
						<h4><?=_t('관광지')?></h4>
						<p><?=_t('코리아투어카드로 한국 방방곡곡<br/>관광지 할인을 한번에!')?></p>
					</div>
				</a>
				<a href="/bbs/board.php?bo_table=tourinfo&wr_id=46&sca=%ED%85%8C%EB%A7%88%EC%97%AC%ED%96%89+%EC%B6%94%EC%B2%9C%EC%BD%94%EC%8A%A4&info=event&me_code=40&num=3&g_id=18<?=lang_url_a($_SESSION['lang'])?>" class="benLink2">
					<div class="benefitBtn_photo">
						<img src="/img/main/benefit_photo3.jpg"/>
						<div>
							<p class="<?=set_class('benefit_us','en_US')?>" style="<?=set_class('padding:17px 0;','en_US')?>" ><?=_t('한국 관광지 즐기기')?> <span>></span></p>
						</div>
					</div>
				</a>

			</li>

			<li class="benefit2">
			<a href="/bbs/board.php?bo_table=cardbenefit&info=benefitshop&me_code=30&num=2&sca=Shopping %26 Duty-free<?=lang_url_a($_SESSION['lang'])?>" class="benLink1">
					<div class="benefitBtn_txt">
						<img src="/img/main/benefit_icon1.jpg" />
						<h4><?=_t('쇼핑 / 면세')?></h4>
						<p><?=_t('오직 코리아투어카드 소지자에게만<br/>제공되는 다양한 쇼핑 혜택!')?></p>
					</div>
				</a>
				<a href="/bbs/board.php?bo_table=tourinfo&info=event&me_code=40&num=3&sca=%EC%A7%80%EC%97%AD%EB%B3%84+%EC%97%AC%ED%96%89+%EC%B6%94%EC%B2%9C+%EC%BD%94%EC%8A%A4&g_id=23&wr_id=61<?=lang_url_a($_SESSION['lang'])?>" class="benLink2">
					<div class="benefitBtn_photo">
						<img src="/img/main/benefit_photo1.jpg"/>
						<div>
							<p class="<?=set_class('benefit_us','en_US')?>"><?=_t('여행의 꽃 쇼핑 시간')?> <span>></span></p>
						</div>
					</div>
				</a>
			</li>

			<li class="benefit3">

				<a href="/bbs/board.php?bo_table=cardbenefit&info=benefitshop&me_code=30&num=2&sca=Accommodation<?=lang_url_a($_SESSION['lang'])?>" class="benLink1">
					<div class="benefitBtn_txt">
						<img src="/img/main/benefit_icon9.jpg" />
						<h4><?=_t('숙박')?></h4>
						<p><?=_t('아직 숙박을 정하지 못했다면?<br/>코리아투어카드로 할인받으세요!')?></p>
					</div>
				</a>
				<a href="/bbs/board.php?bo_table=tourinfo&info=event&me_code=40&num=3&sca=%EC%A7%80%EC%97%AD%EB%B3%84+%EC%97%AC%ED%96%89+%EC%B6%94%EC%B2%9C+%EC%BD%94%EC%8A%A4&g_id=24&wr_id=38<?=lang_url_a($_SESSION['lang'])?>" class="benLink2">
					<div class="benefitBtn_photo">
						<img src="/img/main/benefit_photo8.jpg"/>
						<div>
							<p class="<?=set_class('benefit_us','en_US')?>" style="<?=set_class('padding:17px 0;','en_US')?>" ><?=_t('여행지의 달콤한 단잠')?> <span>></span></p>
						</div>
					</div>
				</a>
			</li>

			<li class="benefit1">

				<a href="/bbs/board.php?bo_table=cardbenefit&info=benefitshop&me_code=30&num=2&sca=Ski %26 Resort<?=lang_url_a($_SESSION['lang'])?>" class="benLink1">
					<div class="benefitBtn_txt">
						<img src="/img/main/benefit_icon7.jpg" />
						<h4><?=_t('스키 / 리조트')?></h4>
						<p><?=_t('여기서 겨울에 더 아름다워지는<br/>한국의 설원을 누비세요!')?></p>
					</div>
				</a>
				<a href="/bbs/board.php?bo_table=tourinfo&info=event&me_code=40&num=3&sca=%EC%A7%80%EC%97%AD%EB%B3%84+%EC%97%AC%ED%96%89+%EC%B6%94%EC%B2%9C+%EC%BD%94%EC%8A%A4&g_id=25&wr_id=37<?=lang_url_a($_SESSION['lang'])?>" class="benLink2">
					<div class="benefitBtn_photo">
						<img src="/img/main/benefit_photo7.jpg" />
						<div>
							<p class="<?=set_class('benefit_us','en_US')?>" style="<?=set_class('padding:17px 0;','en_US')?>" ><?=_t('겨울 스포츠 즐기기')?> <span>></span></p>
						</div>
					</div>
				</a>
			</li>

			<li class="benefit5 borderRight_no">

				<a href="/bbs/board.php?bo_table=cardbenefit&info=benefitshop&me_code=30&num=2&sca=Food %26 Beverage<?=lang_url_a($_SESSION['lang'])?>" class="benLink1">
					<div class="benefitBtn_txt">
						<img src="/img/main/benefit_icon2.jpg" />
						<h4><?=_t('식음료')?></h4>
						<p><?=_t('여행의 꽃, 다양한 식음료<br/>할인받고 먹자!')?></p>
					</div>
				</a>
				<a href="/bbs/board.php?bo_table=tourinfo&info=event&me_code=40&num=3&sca=%ED%85%8C%EB%A7%88%EC%97%AC%ED%96%89+%EC%B6%94%EC%B2%9C%EC%BD%94%EC%8A%A4&g_id=19&wr_id=45<?=lang_url_a($_SESSION['lang'])?>" class="benLink2">
					<div class="benefitBtn_photo">
						<img src="/img/main/benefit_photo2.jpg"/>
						<div>
							<p class="<?=set_class('benefit_us','en_US')?>" style="<?=set_class('padding:17px 0;','en_US')?>" ><?=_t('맛있는 한국 여행')?> <span>></span></p>
						</div>
					</div>
				</a>
			</li>

			<li class="benefit6">
			<a href="/bbs/board.php?bo_table=cardbenefit&info=benefitshop&me_code=30&num=2&sca=Performance %26 Exhibition<?=lang_url_a($_SESSION['lang'])?>" class="benLink1">
					<div class="benefitBtn_txt">
						<img src="/img/main/benefit_icon6.jpg" />
						<h4><?=_t('공연 / 전시')?></h4>
						<p><?=_t('문화 공연 매니아들 모이세요!<br/>전시부터 공연까지 혜택 가득!')?></p>
					</div>
				</a>
				<a href="/bbs/board.php?bo_table=tourinfo&info=event&me_code=40&num=3&sca=%ED%85%8C%EB%A7%88%EC%97%AC%ED%96%89+%EC%B6%94%EC%B2%9C%EC%BD%94%EC%8A%A4&g_id=17&wr_id=30<?=lang_url_a($_SESSION['lang'])?>" class="benLink2">
					<div class="benefitBtn_photo">
						<img src="/img/main/benefit_photo6.jpg" />
						<div>
							<p class="<?=set_class('benefit_us','en_US')?>"><?=_t('오늘은 문화 DAY')?> <span>></span></p>
						</div>
					</div>
				</a>

			</li>

			<li class="benefit7">


				<a href="/bbs/board.php?bo_table=cardbenefit&info=benefitshop&me_code=30&num=2&sca=Entertainment<?=lang_url_a($_SESSION['lang'])?>" class="benLink1">
					<div class="benefitBtn_txt">
						<img src="/img/main/benefit_icon4.jpg"/>
						<h4><?=_t('엔터')?></h4>
						<p><?=_t('K-POP부터 신나는 놀이공원까지<br/>즐기실 수 있습니다.')?></p>
					</div>
				</a>
				<a href="/bbs/board.php?bo_table=tourinfo&info=event&me_code=40&num=3&sca=%EC%A7%80%EC%97%AD%EB%B3%84+%EC%97%AC%ED%96%89+%EC%B6%94%EC%B2%9C+%EC%BD%94%EC%8A%A4&g_id=23&wr_id=39<?=lang_url_a($_SESSION['lang'])?>" class="benLink2">
					<div class="benefitBtn_photo">
						<img src="/img/main/benefit_photo4.jpg" />
						<div>
							<p class="<?=set_class('benefit_us','en_US')?>"><?=_t('꿈과 희망의 테마파크')?> <span>></span></p>
						</div>
					</div>
				</a>

			</li>

			<li class="benefit8">

				<a href="/bbs/board.php?bo_table=cardbenefit&info=benefitshop&me_code=30&num=2&sca=Experiences<?=lang_url_a($_SESSION['lang'])?>" class="benLink1">
					<div class="benefitBtn_txt">
						<img src="/img/main/benefit_icon5.jpg" />
						<h4><?=_t('체험')?></h4>
						<p><?=_t('한국의 다양한 문화를<br/>직접 체험해보세요!')?></p>
					</div>
				</a>
				<a href="/bbs/board.php?bo_table=tourinfo&info=event&me_code=40&num=3&sca=%ED%85%8C%EB%A7%88%EC%97%AC%ED%96%89+%EC%B6%94%EC%B2%9C%EC%BD%94%EC%8A%A4&g_id=18&wr_id=47<?=lang_url_a($_SESSION['lang'])?>" class="benLink2">
					<div class="benefitBtn_photo">
						<img src="/img/main/benefit_photo5.jpg"/>
						<div>
							<p class="<?=set_class('benefit_us','en_US')?>"><?=_t('전통을 체험하자')?> <span>></span></p>
						</div>
					</div>
				</a>
			</li>

			<li class="benefit9">
				<a href="/bbs/board.php?bo_table=cardbenefit&info=benefitshop&me_code=30&num=2&sca=Miscellaneous<?=lang_url_a($_SESSION['lang'])?>" class="benLink1">
					<div class="benefitBtn_txt">
						<img src="/img/main/benefit_icon10.jpg"/>
						<h4><?=_t('기타')?></h4>
						<p><?=_t('코리아투어카드로 더욱 다양한<br/>할인 혜택 받고 푸짐한 선물까지!')?></p>
					</div>
				</a>
				<a href="/bbs/board.php?bo_table=tourinfo&info=event&me_code=40&num=3&sca=%ED%85%8C%EB%A7%88%EC%97%AC%ED%96%89+%EC%B6%94%EC%B2%9C%EC%BD%94%EC%8A%A4&g_id=20&wr_id=44<?=lang_url_a($_SESSION['lang'])?>" class="benLink2">
					<div class="benefitBtn_photo">
						<img src="/img/main/benefit_photo9.jpg" />
						<div>
							<p class="<?=set_class('benefit_us','en_US')?>"><?=_t('더 많은 혜택 가득')?><span>></span></p>
						</div>
					</div>
				</a>
			</li>

			<li class="borderRight_no">
			<!--
				<a href="http://www.hotelnjoy.com/svc/main/" target="_blank">
					<img src="/img/main/benefit_banner.jpg" alt="호텔엔조이 5% HP적립"/>
				</a>
			-->
				<?php echo display_banner('mm2', 'mainbanner.cate.skin.php',$g5['lang']); ?>
			</li>
		</ul>

	</div>
</div>






<div class="thema">
	<div class="thema_content">
		<div class="thema_title">
			<p><?=_t('한국 관광의 필수품!')?></p>
			<h2><?=_t('코리아투어카드 테마여행정보')?></h2>
		</div>

		<ul class="thema_btn <?=set_class('thema_btn_cn','zh_CN/zh_TW')?>">

			 <? latest("good_main_gal", "gallery_main_ad", 5, 0, 1, $options, true);?>


			<?for($i=0; $i<count($benefit_notice); $i++ ){?>
				<? $row = get_notice_row('tourinfo', $benefit_notice[$i]);
					$thumb = get_list_thumbnail("tourinfo", $benefit_notice[$i], '308', '',false, true, 'center', true,'80/0.5/3',0);
				?>

				<?if($i != 5){?>
					<li>
						<a href="/bbs/board.php?bo_table=tourinfo&wr_id=<?=$row['wr_id']?>&sca=<?=$row['ca_name']?>&info=event&me_code=40&num=3&g_id=<?=$row['wr_1']?><?=lang_url_a($_SESSION['lang'])?>">
							<div class="grid">
								<div class="effect-duke">
									<img src="<?=$thumb['src']?>"/>
									<div class="figcap">

									</div>
								</div>
							</div>
							<div class="thema_btn_txt <?=set_class('thema_btn_txt_jp','ja_JP')?>">
								<h3><?=$row['wr_subject_'.$g5['lang']]?></h3>
								<p>
									<?if( $g5['lang'] != "en_US" ){?>
										<?=cut_str(strip_tags($row['wr_content_'.$g5['lang']]),50);?>
									<?}else{?>
										<?=cut_str(strip_tags($row['wr_content_'.$g5['lang']]),70);?>
									<?}?>
								</p>
							</div>
						</a>
					</li>
				<?}else{
					break;
				}?>
			<?}?>
		</ul>
	</div>
</div>



<div class="card">
	<div class="card_area">
		<script>
		cur_num=0;
		$(function(){
			total_num=$(".slideSelectors").find("a").length-1

			$("#next_btn").click(function(){
				cur_num++;
				//cur_num=cur_num+1;
				if(total_num<cur_num)
				{
					cur_num=0;
				}
				$(".slideSelectors").find("a").eq(cur_num).parent().click();
			//	if(cur_num)
			})


			$("#prev_btn").click(function(){
				cur_num--;
				if(0>cur_num)
				{
					cur_num=total_num;
				}
				$(".slideSelectors").find("a").eq(cur_num).parent().click();
			//	if(cur_num)
			})
		})
		</script>



		<div id="ei-slider" class="ei-slider">

			<div class="sliderContainer">
				<div id="prev_btn">prev</div>
				<div id="next_btn">next</div>

				<div class="iosSlider <?=set_class('iosSlider_jp','ja_JP')?>">
					<div class="slider">

						<div class="item item1">
							<div class="inner">
								<a href="/bbs/content.php?co_id=company&info=cardguide&me_code=10&num=0<?=lang_url_a($_SESSION['lang'])?>" class="inner_link">
									<div class="card_img"><img src="/img/main/main_card1.jpg"></div>
									<div class="text1"><span ><?=_t('코리아투어카드는?')?></span></div>
									<div class="text2">
										<span><?=_t('외국인 전용 교통관광카드로 대한민국의 교통수단을<br/>더욱 편리하게 이용하고 쇼핑, 식음료, 공연 등 다양한 관광콘텐츠</br>할인 혜택도 받으실 수 있습니다.')?></span>
									</div>
									<p class="text3"><?=_t('자세히보기')?> <span class="inArro">></span></p>
								</a>
							</div>
						</div>

						<div class="item item2">
							<div class="inner">
								<?if( $g5['lang'] == "ko_KR" || $g5['lang'] == "" ){?>
									<a href="http://khandsfree.com/ko/" class="inner_link" target="_blank">
								<?}else if( $g5['lang'] == "en_US" ){?>
									<a href="http://khandsfree.com/en/" class="inner_link" target="_blank">
								<?}else if( $g5['lang'] == "ja_JP" ){?>
									<a href="http://khandsfree.com/jp/" class="inner_link" target="_blank">
								<?}else if( $g5['lang'] == "zh_CN" ){?>
									<a href="http://khandsfree.com/cn/" class="inner_link" target="_blank">
								<?}else if( $g5['lang'] == "zh_TW" ){?>
									<a href="http://khandsfree.com/tw/" class="inner_link" target="_blank">
								<?}?>
									<div class="card_img"><img src="/img/main/slide_1.png" ></div>
									<div class="text1"><span class="<?if($g5['lang'] != 'ko_KR') echo $g5['lang'];?>"><?=_t("짐 걱정 없는 '핸즈프리서비스'")?></span></div>
									<div class="text2">
										<span><?=_t("여행 중 무거운 짐 때문에 불편하셨다면?<br/>핸즈프리서비스를 통해 한국에서 자유로운 여행을 즐기세요!")?></span>
									</div>
									<p class="text3"><?=_t('자세히보기')?> <span class="inArro">></span></p>
								</a>
							</div>
						</div>

						<div class="item item3">
							<div class="inner">

								<?if( $g5['lang'] == "ko_KR" || $g5['lang'] == "" ){?>
									<a href="http://vkc.or.kr/content/shopping_coupon/" class="inner_link" target="_blank">
								<?}else if( $g5['lang'] == "en_US" ){?>
									<a href="http://vkc.or.kr/en/special-offers/discount-coupons/" class="inner_link" target="_blank">
								<?}else if( $g5['lang'] == "ja_JP" ){?>
									<a href="http://vkc.or.kr/jp/special-offers/discount-coupons/" class="inner_link" target="_blank">
								<?}else if( $g5['lang'] == "zh_CN" ){?>
									<a href="http://vkc.or.kr/sc/special-offers/discount-coupons/" class="inner_link" target="_blank">
								<?}else if( $g5['lang'] == "zh_TW" ){?>
									<a href="http://vkc.or.kr/tc/special-offers/discount-coupons/" class="inner_link" target="_blank">
								<?}?>


									<div class="card_img"><img src="/img/main/slide_2<?if($g5['lang'] != 'ko_KR') echo '_eng';?>.png" ></div>
									<div class="text1"><span class="<?if($g5['lang'] != 'ko_KR') echo $g5['lang'];?>"><?=_t('다양한 쇼핑 할인 쿠폰 제공!')?></span></div>
									<div class="text2">
										<span><?=_t('한국방문위원회에서는 관광객들을 위해 연중 상시로 즐길 수 있는<br/>100여개 브랜드의 할인 쿠폰을 제공합니다.')?></span>
									</div>
									<p class="text3"><?=_t('자세히보기')?><span class="inArro">></span></p>
								</a>
							</div>
						</div>

					</div>
				</div>

				<div class="slideSelectors">
					<div class="item selected"><a href=""></a></div>
					<div class="item"><a href=""></a></div>
					<div class="item"><a href=""></a></div>
				</div>
			</div>

		</div>

		<script type="text/javascript">
			$(document).ready(function() {

				$('.iosSlider').iosSlider({
					desktopClickDrag: true,
					snapToChildren: true,
					navSlideSelector: '.sliderContainer .slideSelectors .item',
					onSlideComplete: slideComplete,
					onSliderLoaded: sliderLoaded,
					onSlideChange: slideChange,
					scrollbar: false,
					autoSlide: true,
					autoSlideTimer: 6000,
					infiniteSlider: true
				});

			});

			function slideChange(args) {

				$('.sliderContainer .slideSelectors .item').removeClass('selected');
				$('.sliderContainer .slideSelectors .item:eq(' + (args.currentSlideNumber - 1) + ')').addClass('selected');

			}

			function slideComplete(args) {

				if(!args.slideChanged) return false;

				$(args.sliderObject).find('.text1, .text2, .text3').attr('style', '');

				$(args.currentSlideObject).find('.text1').animate({
					right: '28px',
					opacity: '1'
				}, 1500, 'easeOutQuint');

				$(args.currentSlideObject).find('.text2').delay(200).animate({
					right: '28px',
					opacity: '1'
				}, 1500, 'easeOutQuint');

				$(args.currentSlideObject).find('.text3').delay(300).animate({
					left: '640px',
					opacity: '1'
				}, 1500, 'easeOutQuint');

			}

			function sliderLoaded(args) {

				$(args.sliderObject).find('.text1, .text2, .text3').attr('style', '');

				$(args.currentSlideObject).find('.text1').animate({
					right: '28px',
					opacity: '0.8'
				}, 1500, 'easeOutQuint');

				$(args.currentSlideObject).find('.text2').delay(200).animate({
					right: '28px',
					opacity: '0.8'
				}, 1500, 'easeOutQuint');

				$(args.currentSlideObject).find('.text3').delay(300).animate({
					left: '640px',
					opacity: '1'
				}, 1500, 'easeOutQuint');

				slideChange(args);

			}
		</script>

	</div>
</div>


<div class="banner">
	<div class="banner_content">

		<div class="banner_content_Ban1"><!--<a href="http://www.lwt.co.kr/tower/main/main.do" target="_blank"><img src="img/main/banner1.jpg" alt=""/></a>-->
			<?php echo display_banner('mtt', 'mainbanner.mtt.skin.php',$g5['lang']); ?>
		</div>

		<div class="banner_content_store">
			<div class="banner_content_storeArea <?if($g5['lang'] == 'en_US') echo 'en_style_over' ?>">
				<div class="banner_title <?=set_class('banner_title_jp','ja_JP')?> <?=set_class('banner_title_us','en_US')?>" style="margin-top:-8px;">
					<div class="banner_title_Btxt " >
						<h3 class="<?=set_class('banner_title_JP','ja_JP')?>"><?=_t('코리아투어카드 판매점')?></h3>
						<p class=""><?=_t('340여곳이 넘는 판매점에서 만나실 수 있습니다.')?></p>

						<a href="/bbs/board.php?bo_table=allshop&info=allstoresearch&me_code=20&num=1<?=lang_url_a($_SESSION['lang'])?>" class="morebtn"><?=_t('자세히보기')?></a>

					</div>

					<div class="banner_title_Stxt">
						<p class="title"><strong><?=_t('* 충전안내')?></strong></p>
						<p class="info" style='<?=set_class('line-height:24px;','en_US')?>'><?=_t('편의점, 카드자판기(1~4호선), 지하철 무인충전기,<br/>역사 서비스 센터 (서울 지하철 5~8호선), 은행 ATM<br/>* 판매처 지점별로 판매여부 상이함')?>
						</p>
					</div>
				</div>


				<ul class="banner_content_storePhoto">

					<?while($row = sql_fetch_array($allshop_notice) ){?>
						<?	$row = get_notice_row('allshop', $row['wr_id']);
							$thumb = get_list_thumbnail("allshop", $row['wr_id'], '148', '',false, true, 'center', true,'80/0.5/3',1);
						?>

						<li class="">

								<a href="/bbs/board.php?bo_table=map&info=search&me_code=20&num=1&search=<?=$row['wr_id']?><?=lang_url_a($_SESSION['lang'])?>">

								<div>
									<?if( $thumb['src'] ){?>
										<img src="<?=$thumb['src']?>"  />
									<?}else{?>
										<img src="/img/default/ktc_main_allshop.png"  style='width:148px;' />
									<?}?>
								</div>
								<p><?=$row['wr_subject_'.$g5['lang']]?></p>
								<span>
									<?if( $g5['lang'] == "en_US" ){  echo $row['wr_3'];?>
									<?}else if( $g5['lang'] == "ja_JP" ){  echo $row['wr_4'];?>
									<?}else if( $g5['lang'] == "zh_CN" ){  echo $row['wr_5'];?>
									<?}else if( $g5['lang'] == "zh_TW" ){  echo $row['wr_6'];?>
									<?}else{ echo $row['wr_2'];}?>
								</span>
							</a>
						</li>
					<?}?>

				</ul>
			</div>


			<ul class="banner_content_Ban2">
				<!--<li><a href="http://www.7-eleven.co.kr/" target="_blank"><img src="img/main/banner2.jpg" alt=""/></a></li>
				<li><a href="http://www.jejuair.net/jejuair/main.jsp" target="_blank"><img src="img/main/banner3.jpg" alt=""/></a></li>
				<li class="li_margin_b"><a href="http://cu.bgfretail.com/index.do" target="_blank"><img src="img/main/banner4.jpg" alt=""/></a></li>-->
				<li><?php echo display_banner('mp4', 'mainbanner.shop.skin.php', $g5['lang']); ?></li>
			</ul>
		</div>


		<div class="banner_content_date">
			<ul class="banner_content_date_area">
				<li class="date bckimg1">
					<a href="/bbs/board.php?bo_table=festival&sca=<?=urlencode('축제&행사')?>&info=info&me_code=40&ck=1&num=3<?=lang_url_a($_SESSION['lang'])?>">
						<div class="dateTxt_area <?=set_class('dateTxt_area_jp','ja_JP/')?>">
							<h3 class="<?if($g5['lang'] == 'en_US') echo 'en_style_title_over'; ?>"><?=_t('2017 축제 / 행사 일정')?></h3>
							<p><?=_t('모두가 함께하는 현장으로 초대합니다.')?></p>
						</div>
					</a>
				</li>

				<li class="date bckimg2" style="border-bottom:0;">
					<a href="/bbs/board.php?bo_table=tourinfo&info=event&me_code=40&num=3&sca=지역별+여행+추천+코스<?=lang_url_a($_SESSION['lang'])?>">
						<div class="dateTxt_area <?=set_class('dateTxt_area_jp','ja_JP/')?>">
							<h3 class="<?if($g5['lang'] == 'en_US') echo 'en_style_title_over'; ?>"><?=_t('지역별 여행 추천 코스')?></h3>
							<p><?=_t('대한민국 곳곳에 숨어있는곳을 추천합니다.')?></p>
						</div>
					</a>
				</li>


				<li class="date_roll">
					<div class="date_roll_area <?=set_class('date_roll_area_cn','zh_CN/zh_TW')?>">
						<h3 style="<?=set_class('font-size:16px;','ja_JP')?>" class="<?=set_class('date_us','en_US/ja_JP')?>"><?=_t('코리아투어카드 홍보센터 ')?></h3>
						<ul id="slider1" >

							<?while($row = sql_fetch_array($prcenter_notice) ){?>
								<?	$row = get_notice_row('prcenter', $row['wr_id']);
									$thumb = get_list_thumbnail("prcenter", $row['wr_id'], '190', '',false, true, 'center', true,'80/0.5/3',0);
								?>
								<li>
									<a href="/bbs/board.php?bo_table=prcenter&wr_id=<?=$row['wr_id']?>&me_code=10&info=cardprcenter&num=0<?=lang_url_a($_SESSION['lang'])?>">
										<?if( $thumb['src'] ){?>
											<img src="<?=$thumb['src']?>"   />
										<?}else{?>
											<img src="/img/default/ktc_prcenter.png" />
										<?}?>
										<p>
											<?=$row['wr_subject_'.$g5['lang']]?>
										</p>
									</a>
								</li>
							<?}?>

						</ul>
					</div>
				</li>
			</ul>


			<div class="banner_content_date_Ban">
			<!--
				<p class="li_margin_l"><a href="http://seoulrose.jungnang.go.kr/seoulRose/main.do" target="_blank"><img src="img/main/banner5.jpg" alt=""/></a></p>
				<p><a href="http://ticket.yes24.com/Pages/Perf/Detail/Detail.aspx?IdPerf=22139" target="_blank"><img src="img/main/banner6.jpg" alt=""/></a></p>
			-->
				<div class="li_margin_l date_Ban"><?php echo display_banner('main_festival', 'mainbanner.event1.skin.php',$g5['lang']); ?></div>
				<div class="date_Ban"><?php echo display_banner('main_festival2', 'mainbanner.event2.skin.php',$g5['lang']); ?></div>

			</div>
		</div>


<!--<script>
  var callbackFunction = function(data) {
    var wind = data.query.results.channel.wind;
    //alert(wind.chill);
  };
</script>-->


<!--<script src="https://query.yahooapis.com/v1/public/yql?q=select * from weather.forecast where u='c' and woeid in (select woeid from geo.places(1) where text='seoul, il' or text='daejeon, il')&format=json&callback=callbackFunction"></script>-->

<!--         select * from weather.forecast where woeid in (select woeid from geo.places(1) where text="seoul, li" or text="daejeon, li")            -->


		<div class="banner_content_footer" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
			<ul class="banner_content_footer_area <?=set_class('banner_content_footer_area_jp','ja_JP')?>">
				<li class="winter" style='position:relative;'>
					<div class='weather_all_show'><?=_t('모두보기')?></div>

					<ul id="weather" >
						<?while($row = sql_fetch_array($weather_result) ){?>
							<li>

								<div class="weather_icon">
									<?if( $row['w_type'] == 0 ){?>
										<?get_sky_img($row['w_sky'])?>
									<?}else{?>
										<?get_type_img($row['w_type'])?>
									<?}?>
								</div>

								<div class="weather_txt1"><?=_t($row['w_name'])?> / <?=_t('온도')?> <?=$row['w_temp']?>℃</div>

								<?if( $row['w_type'] == 0 ){?>
									<div class="weather_txt2"><?get_sky($row['w_sky'])?> / <?=_t('강수확률')?> <?=$row['w_rain']?></div>
								<?}else{?>
									<div class="weather_txt2"><?get_type($row['w_type'])?> / <?=_t('강수확률')?> <?=$row['w_rain']?></div>
								<?}?>

							</li>
						<?}?>
					</ul>
				</li>

				<li class="winter_all">
					<div class="weatherall_label"><?=_t('전국 날씨')?></div>
					<div class='weather_all_show'><?=_t('닫기')?></div>
					<ul class="winter_all_llist <?=set_class('winter_all_llist_jp','ja_JP')?>">
						<?while($row = sql_fetch_array($weather_result1) ){?>
							<li>
								<div class="weather_icon">
									<?if( $row['w_type'] == 0 ){?>
										<?get_sky_img_s($row['w_sky'])?>
									<?}else{?>
										<?get_type_img_s($row['w_type'])?>
									<?}?>
								</div>

								<div class="weather_txt1"><?=_t($row['w_name'])?><br><?=$row['w_temp']?>℃</div>
							</li>
						<?}?>
					</ul>
				</li>


				<li class="exchange">
					<div class="exchange_area">
						<h3 class="<?=set_class('exchangeTitle_us','en_US')?>"><?=_t('오늘의 환율')?></h3>
						<!--<a href=""><img src="img/main/test_img1.jpg" alt=""/></a>-->

							<div class="state">
								<div>
									<div class="state_name_area"><span class="state_img"><img src="/img/main/ex1_usd.jpg" /></span><span class="state_name">USD</span></div>
									<?
									if( 0 < $result_exchange['ex_us'] - $Data['USD']['매매기준율'] ){
									?>
										<span class="stateUD"><img src="/img/main/ex_down.png" /></span><span class="state_ex" style='color:blue;'><?echo $Data['USD']['매매기준율'];?><span>
									<?
									}else if( 0 > $result_exchange['ex_us'] - $Data['USD']['매매기준율'] ){
									?>
										<span class="stateUD"><img src="/img/main/ex_up.png" /></span><span span class="state_ex" style='color:red;'><?echo $Data['USD']['매매기준율'];?><span>
									<?
									}else{
									?>
										<span class="stateUD"><img src="/img/main/ex_steadiness.png"/></span><span span class="state_ex" style='color:gray;'><?echo $Data['USD']['매매기준율'];?><span>
									<?
									}
									?>
								</div>
							</div>


							<div class="state">
								<div>
									<div class="state_name_area"><span class="state_img"><img src="/img/main/ex2_jpy.jpg"/></span><span class="state_name">JPY</span></div>
									<?
									if( 0 < $result_exchange['ex_jp'] - $Data['JPY']['매매기준율'] ){
									?>
										<span class="stateUD"><img src="/img/main/ex_down.png" /></span><span class="state_ex" style='color:blue;'><?echo $Data['JPY']['매매기준율'];?><span>
									<?
									}else if( 0 > $result_exchange['ex_jp'] - $Data['JPY']['매매기준율'] ){
									?>
										<span class="stateUD"><img src="/img/main/ex_up.png" /></span><span span class="state_ex" style='color:red;'><?echo $Data['JPY']['매매기준율'];?><span>
									<?
									}else{
									?>
										<span class="stateUD"><img src="/img/main/ex_steadiness.png" /></span><span span class="state_ex" style='color:gray;'><?echo $Data['JPY']['매매기준율'];?><span>
									<?
									}
									?>
								</div>
							</div>


							<div class="state">
								<div>
									<div class="state_name_area"><span class="state_img"><img src="/img/main/ex3_chn.jpg" /></span><span class="state_name">CNY</span></div>
									<?
									if( 0 < $result_exchange['ex_cn'] - $Data['CNY']['매매기준율'] ){
									?>
										<span class="stateUD"><img src="/img/main/ex_down.png" /></span><span class="state_ex" style='color:blue;'><?echo $Data['CNY']['매매기준율'];?><span>
									<?
									}else if( 0 > $result_exchange['ex_cn'] - $Data['CNY']['매매기준율'] ){
									?>
										<span class="stateUD"><img src="/img/main/ex_up.png" /></span><span span class="state_ex" style='color:red;'><?echo $Data['CNY']['매매기준율'];?><span>
									<?
									}else{
									?>
										<span class="stateUD"><img src="/img/main/ex_steadiness.png" /></span><span span class="state_ex" style='color:gray;'><?echo $Data['CNY']['매매기준율'];?><span>
									<?
									}
									?>
								</div>
							</div>



					</div>
				</li>

				<li class="traffic">
					<div>
						<a href="/bbs/board.php?bo_table=traffic&info=traffic&me_code=40&num=3<?=lang_url_a($_SESSION['lang'])?>">
							<h3 class="<?=set_class('trafficTitle_us','en_US')?>"><?=_t('교통정보 안내')?></h3>
							<!--<img src="img/main/main_traffic.jpg" alt=""/>-->
							<p class="traffic_btn"></p>
						</a>
					</div>
				</li>

				<li class="others">
					<ul class="others_btn">
						<li>
							<a href="<?=set_class_index($g5['lang'])?>" target="_blank">
								<img src="/img/main/others_1_ksmail.jpg"/>
								<p><?=_t('한국 방문의 해')?></p>
							</a>
						</li>

						<li>
							<a href="<?=set_class_index2($g5['lang'])?>" target="_blank">
								<img src="/img/main/others_2_handsfree.jpg" />
								<p><?=_t('한국스마트카드')?></p>
							</a>
						</li>

						<li>
							<a href="<?=set_class_index3($g5['lang'])?>" target="_blank">
								<?if( $g5['lang'] == "zh_CN" ){?>
									<img src="/img/main/others_5_weibo.png" />
								<?}else{?>
									<img src="/img/main/others_3_facebook.png" />
								<?}?>

								<p><?=_t('페이스북')?></p>
							</a>
						</li>

						<li>
							<a href="https://www.youtube.com/channel/UC9mKxPyNKr9HbYJsBPbTrDQ" target="_blank">
								<img src="/img/main/others_4_YouTube.png" />
								<p><?=_t('유튜브')?></p>
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>


	</div><!-- banner_content -->

</div>


<?php
include_once(G5_THEME_PATH.'/tail.php');
?>
