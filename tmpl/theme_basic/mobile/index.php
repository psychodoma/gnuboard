<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
//include_once(G5_THEME_PATH.'/head.sub.php');
//include_once(G5_PATH.'/locale/basic/lang_button_mobile.inc.php');
include_once(G5_THEME_MOBILE_PATH.'/head.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
include_once(G5_LIB_PATH.'/banner.lib.php');

$weather_result = get_weather();
$Data = get_exchange_data();
$result_exchange = get_exchange();
$benefit_notice = get_main_benefit('tourinfo');
$allshop_notice = get_notice_random('allshop',3);
$weather_result1 = get_weather1();

?>

<!-- 메인화면 최신글 시작 -->
<?php

// $sql = " select bo_table
//             from `{$g5['board_table']}` a left join `{$g5['group_table']}` b on (a.gr_id=b.gr_id)
//             where a.bo_device <> 'pc' ";
// if(!$is_admin)
//     $sql .= " and a.bo_use_cert = '' ";
// $sql .= " order by b.gr_order, a.bo_order ";
// $result = sql_query($sql);
// for ($i=0; $row=sql_fetch_array($result); $i++) {
//     // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
//     // 스킨은 입력하지 않을 경우 관리자 > 환경설정의 최신글 스킨경로를 기본 스킨으로 합니다.

//     // 사용방법
//     // latest(스킨, 게시판아이디, 출력라인, 글자수);
//     echo latest('theme/basic', $row['bo_table'], 5, 25);
// }
?>



<link rel="stylesheet" href="/tmpl/theme_basic/css/font-awesome.css">

<script type="text/javascript" src="/js/jquery.loading.min.js"></script>

	<div style="overflow:hidden;">
		<div id="black_bg" style="display: none;" onclick="javascript:potfol_close()"></div>

		<div class="search_bg">
			<div class="search_area">
				<form name="fsearchbox" method="get" action="/bbs/search.php" onsubmit="return fsearchbox_submit(this);" class="">
					<input type='hidden' name='lang' value='<?=lang_url($_SESSION['lang'])?>' >
					<fieldset>
						<label for="sch_stx" class="sound_only hide">검색어<strong class="sound_only"> 필수</strong></label>


						<p class="serch_close" onclick="javascript:search_close()"><a href="#"><img src="/img/mobile/main/search_close.jpg" alt="검색창 닫기"/></a></p>
						<ul id="search">
							<li class="search_input">
								<label for="" class="hide">검색창</label>
								<input type="text" class="searchbar" name="word" id="sch_stx" maxlength="" placeholder="<?=_t('검색어를 입력하세요.')?>">
							</li>

							<li class="search_btn">
								<input type="image" class="loginbtn" id="sch_submit" src="/img/mobile/main/serach_btn.png" alt="검색" title="검색" />
							</li>
						</ul>
				

						<script>

							$('body').loadingModal({text: 'Loading...'}).loadingModal('animation', 'cubeGrid');
							
							function fsearchbox_submit(f)
							{
								if (f.word.value.length < 2) {
									alert("<?=_t('검색어는 두글자 이상 입력하십시오.')?>");
									f.word.select();
									f.word.focus();
									return false;
								}

								// 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
								var cnt = 0;
								for (var i=0; i<f.word.value.length; i++) {
									if (f.word.value.charAt(i) == ' ')
										cnt++;
								}

								if (cnt > 1) {
									alert("<?php echo _t('빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.'); ?>");
									f.word.select();
									f.word.focus();
									return false;
								}

								return true;
							}
						</script>
					</fieldset>
				</form>
			</div>
		</div>

		<style>
			.logo{}
			.logo img{max-height:50px;margin:3px 0 2px;}
		</style>

		<!--헤드 시작-->
		<div id="headerBG_m">
			<h1 class="logo_m"><a href="/<?=lang_url($_SESSION['lang'])?>" class="logo"><img src="/img/main/logo_<?=substr(strtolower($g5['lang']),-2,2)?>.png" alt="Korea tour card"/></a></h1>
			<p class="serch_btn" onclick="javascript:search_fn()"><img src="/img/mobile/main/search.png" alt="검색버튼"/></p>

			<header class="headSect" id="header_768">
				<p class="menu" id="open_btn" onclick="javascript:potfol_fn()"><img src="/img/mobile/main/menu.png" alt="전체메뉴열기"/></p>
				<div id="allmenuH" class="allmenu">
					<div class="allmenuIn">
			
						<div id="navigation">

							<ul class="navigation_list">

								<li class="b_sub TopAreaNavi">
									<ul class="top_munu">
										<li>
											<a href="/<?=lang_url($_SESSION['lang'])?>"><img src="/img/mobile/main/navi_home_btn.png" alt="홈"/></a>
										</li>

										<li class="top_imgBtn">
											<div id="select_box">
												<label for="Scolor"><img src="/img/mobile/main/navi_lan_btn.png" alt="언어선택"/></label>
												<form name="change" id="change" method="post">	
													<select id="Scolor" title="select Scolor">
															

														<?
														
														$url_m = $_SERVER["REQUEST_URI"];
														$url_m = explode( "/",$url_m ); 
														if( $url_m[1] == "en" || $url_m[1] == "kr" || $url_m[1] == "ko" || $url_m[1] == "jp" || $url_m[1] == "cn" || $url_m[1] == "tw" ){
															include("../locale/basic/lang_button_mobile.inc.php");
														}else{
															include("locale/basic/lang_button_mobile.inc.php");
														}
														
														?>
													</select>
												</form>
											</div>
										</li>

										<!--<li class="font_size">
											<a id="size_down" onclick="font_resize('container', 'ts_up ts_up2', '');" class="size1">가</a>
											<a id="size_def" onclick="font_resize('container', 'ts_up ts_up2', 'ts_up');" class="size2">가</a>
											<a id="size_up" onclick="font_resize('container', 'ts_up ts_up2', 'ts_up2');" class="size3">가</a>
										</li>-->
									</ul>

									<p class="top_MenuClose"><a href="javascript:potfol_close()"><img src="/img/mobile/main/navi_close_btn.png" alt="전체메뉴 닫기" id="close_btn"/></a></p>
								</li>



								<?php
								$sql = " select *
											from {$g5['menu_table']}
											where me_mobile_use = '1'
											and length(me_code) = '2'
											order by me_order, me_id ";
								$result = sql_query($sql, false);

								for ($i=0; $row=sql_fetch_array($result); $i++) {
									if(preg_match('|/'.G5_SHOP_DIR.'|', $row['me_link'])) continue;
									if(!preg_match('|^http://|', $row['me_link'])) $row['me_link'] = G5_URL.$row['me_link'];
									$_SESSION['me_code'.$row['me_code']] = $row['me_code'];
									$_SESSION['me_id'.$row['me_code']] = $row['me_id'];
									$_SESSION['me_name'.$row['me_code']] = $row['me_name'];
								
								?>

								<li class="b_sub"><a href="#" class="drop link1"><?php echo _t($row['me_name']) ?></a>
									<ul class="sssub">

										<?php
										//    $sql2 = "";
										$sql2 = " select *
													from {$g5['menu_table']}
													where me_use = '1'
													and length(me_code) = '4'
													and substring(me_code, 1, 2) = '{$row['me_code']}'
													order by me_order, me_id ";
										$result2 = sql_query($sql2);

										for ($k=0; $row2=sql_fetch_array($result2); $k++) {
											if(!preg_match('|^http://|', $row2['me_link'])) $row2['me_link'] = G5_URL.$row2['me_link'];
											if($k == 0)
												//echo '<ul class="gnb_2dul">'.PHP_EOL;
										?>

											<li class="dr_sub"><a href="<?php echo $row2['me_link']."&info=".$row2['me_url']."&me_code=". $row['me_code']."&num=".$i; ?><?=lang_url_a($_SESSION['lang'])?>" target="_<?php echo $row2['me_target']; ?>"><?php echo _t($row2['me_name']) ?></a></li>
										<?}?>
									</ul>
								</li>
								
								<?}?>

							</ul><!-- navigation_list 끝 -->

							<ul class="sns_btn">
								<li>
									<a href="<?=set_class('http://vkc.or.kr/','ko_KR')?><?=set_class('http://vkc.or.kr/en/','en_US')?><?=set_class('http://vkc.or.kr/jp/','ja_JP')?><?=set_class('http://vkc.or.kr/sc/','zh_CN')?><?=set_class('http://vkc.or.kr/tc/','zh_TW')?>" target="_blank">
										<img src="/img/mobile/main/navi_sns_hand.png" alt="한국 방문의 해" style="width:100%;"/>
									</a>
								</li>
								<li>
									<a href="<?=set_class('https://www.t-money.co.kr/','ko_KR')?><?=set_class('
https://www.t-money.co.kr/ncs/pct/tmnyintd/ReadFrgnKoreaTourCardEngIntd.dev;jsessionid=ds0pkB7L96TK0MMI8emZXb6nz5C0Uvr1VRqI2fmMCfgIWlT59rc6kL1NaQBg4InU.czzw01ip_servlet_tmyweb','en_US/ja_JP/zh_CN/zh_TW')?>" target="_blank">
										<img src="/img/mobile/main/navi_sns_happy.png" alt="한국스마트카드" style="width:100%;"/>
									</a>
								</li>
								<li>
									<a href="<?=set_class_index3($_SESSION['lang'])?>" target="_blank">
										
										<?if( $_SESSION['lang'] == "zh_CN" ){?>
											<img src="/img/main/others_6_weibo.png" style="width:100%;"/>
										<?}else{?>
											<img src="/img/mobile/main/navi_sns_face.png" alt="페이스북" style="width:100%;"/>
										<?}?>

									</a>
								</li>
								<li>
									<a href="https://www.youtube.com/channel/UC9mKxPyNKr9HbYJsBPbTrDQ" target="_blank">
										<img src="/img/mobile/main/navi_sns_ut.png" alt="유투브" style="width:100%;"/>
									</a>
								</li>
							</ul>

						</div><!-- navigation 끝 -->

					</div><!-- allmenuIn 끝 -->

				</div>
			</header>
		</div>

		<!--헤드 끝-->


		<!--컨텐츠 시작-->
		<div class="moble_wrap">
			<div class="main_slide">
				<ul class="bxslider">
					<li>
						<a href="/bbs/content.php?co_id=company&info=cardguide&me_code=10&num=0<?=lang_url_a($_SESSION['lang'])?>">
							<div class="slideTop_txt">
								<h3 ><?=_t('코리아투어카드는?')?></h3>
								<p><?=_t('외국인 전용 교통관광카드로 대한민국의 교통수단을 더욱 편리하게 이용하고 쇼핑, 식음료, 공연 등 다양한 관광콘텐츠 할인 혜택도 받으실 수 있습니다.')?></p>
							</div>
							<div class="slideTop_img"><img src="/img/mobile/main/main_slideCard1.png" style="width:100%;" alt="메인카드1"/></div>
							<img src="/img/mobile/main/main_visual1.jpg" style="width:100%;" alt="메인1"/>
						</a>
					</li>

					<li>
						<a href="/bbs/content.php?co_id=company&info=cardguide&me_code=10&num=0<?=lang_url_a($_SESSION['lang'])?>">
							<div class="slideTop_txt">
								<h3 class="<?if($g5['lang'] != 'ko_KR') echo $g5['lang'];?>"><?=_t("짐 걱정 없는 '핸즈프리서비스'")?></h3>
								<p><?=_t('여행 중 무거운 짐 때문에 불편하셨다면? 핸즈프리서비스를 통해 한국에서 자유로운 여행을 즐기세요.')?></p>
							</div>
							<div class="slideTop_img"><img src="/img/mobile/main/main_slideCard2.png" style="width:100%;" alt="메인카드2"/></div>
							<img src="/img/mobile/main/main_visual1.jpg" style="width:100%;" alt="메인2"/>
						</a>
					</li>

					<li>
						<a href="/bbs/content.php?co_id=company&info=cardguide&me_code=10&num=0<?=lang_url_a($_SESSION['lang'])?>">
							<div class="slideTop_txt">
								<h3 class="<?if($g5['lang'] != 'ko_KR') echo $g5['lang'];?>"><?=_t("다양한 쇼핑 할인 쿠폰 제공! ")?></h3>
								<p><?=_t("한국방문위원회에서는 관광객들을 위해 연중 상시로 즐길 수 있는 100여개 브랜드의 할인 쿠폰을 제공합니다.")?></p>
							</div>
							<div class="slideTop_img"><img src="/img/mobile/main/main_slideCard3.png" style="width:100%;" alt="메인카드3"/></div>
							<img src="/img/mobile/main/main_visual1.jpg" style="width:100%;" alt="메인3"/>
						</a>
					</li>
				</ul>
			</div>
			
			<script type="text/javascript">
				$(document).ready(function(){
					$(function () {
								 
						$(".benfit_mask").scroll(function () {
							//alert(1);
							var w = $('.benefit_btn').css('width');  //컨텐츠 전체 가로길이

							var window_w = $(window).width();	//현재 보여지는 가로길이
							
							w = w.split('px')[0];

							var result = w - window_w;	//전체 가로길이 - 현재 가로길이 
							var cur_w =  $(this).scrollLeft();
							//result = result + cur_w;
							
							//alert(result);
							//alert(w);

							if(cur_w == 0){
								$('.benfit_maskArrow').fadeIn();
								$('.benfit_maskArrow1').fadeOut();
							}
							if( cur_w > 30){
								$('.benfit_maskArrow1').fadeIn();
							}
							if( cur_w > result){
								$('.benfit_maskArrow').fadeOut();
							}
						});
							


						$('.benfit_maskArrow1').click(function () {
							$('.benfit_maskArrow').fadeIn();
							$('.benfit_mask').animate({
								scrollLeft: 0
							}, 300, function(){
								$('.benfit_maskArrow1').fadeOut();
								
							});  // 이동 스크롤 속도
							return false;
						});

								
						$('.benfit_maskArrow').click(function () {
							$('.benfit_maskArrow1').fadeIn();
							var w = $('.benefit_btn').css('width');
							$('.benfit_mask').animate({
								scrollLeft: w
							}, 500, function(){
								$('.benfit_maskArrow').fadeOut();
								
							});  // 이동 스크롤 속도
							return false;
						});

					});
				 
				});
			</script>	





			<div class="benefit">
				<div class="benefit_content">
					<h2><?=_t('코리아투어카드 혜택')?></h2>
					
					<div class="benfit_mask">
						<p class="benfit_maskArrow"><img src="/img/mobile/main/btn_benefit_arrow_r.jpg"  alt="오른쪽 이동"/></p>
						<p class="benfit_maskArrow1"><img src="/img/mobile/main/btn_benefit_arrow_l.jpg" alt="왼쪽 이동"/></p>
						<ul class="benefit_btn">
							<li>
								<a href="/bbs/board.php?bo_table=cardbenefit&info=benefitshop&me_code=30&num=2&sca=Tourist attractions<?=lang_url_a($_SESSION['lang'])?>" class="benefit_btnIcon">
									<img src="/img/mobile/main/benefit_icon3.jpg" alt="관광지"/>
									<p class="btnIcon4"><?=_t('관광지')?></p>
								</a>
							</li>
							<li>
								<a href="/bbs/board.php?bo_table=cardbenefit&info=benefitshop&me_code=30&num=2&sca=Shopping %26 Duty-free<?=lang_url_a($_SESSION['lang'])?>" class="benefit_btnIcon">
									<img src="/img/mobile/main/benefit_icon1.jpg" alt="쇼핑"/>
									<p class="btnIcon2"><?=_t('쇼핑 / 면세')?></p>
								</a>
							</li>
							<li>
								<a href="/bbs/board.php?bo_table=cardbenefit&info=benefitshop&me_code=30&num=2&sca=Accommodation<?=lang_url_a($_SESSION['lang'])?>" class="benefit_btnIcon">
									<img src="/img/mobile/main/benefit_icon8.jpg" alt="숙박"/>
									<p class="btnIcon3"><?=_t('숙박')?></p>
								</a>
							</li>
							<li>
								<a href="/bbs/board.php?bo_table=cardbenefit&info=benefitshop&me_code=30&num=2&sca=Ski %26 Resort<?=lang_url_a($_SESSION['lang'])?>" class="benefit_btnIcon">
									<img src="/img/mobile/main/benefit_icon7.jpg" alt="스키리조트"/>
									<p class="btnIcon1"><?=_t('스키 / 리조트')?></p>
								</a>
							</li>
							<li class="borderRig">
								<a href="/bbs/board.php?bo_table=cardbenefit&info=benefitshop&me_code=30&num=2&sca=Food %26 Beverage<?=lang_url_a($_SESSION['lang'])?>" class="benefit_btnIcon">
									<img src="/img/mobile/main/benefit_icon2.jpg" alt="식음료"/>
									<p class="btnIcon5"><?=_t('식음료')?></p>
								</a>
							</li>

							<!-- 4개 -->
							
							<li class="borderBottom_no bn">
								<?php echo display_banner('mm2', 'mainbanner.cate.skin.php',$g5['lang']); ?>
							</li>
							<li class="borderBottom_no">
								<a href="/bbs/board.php?bo_table=cardbenefit&info=benefitshop&me_code=30&num=2&sca=Performance %26 Exhibition<?=lang_url_a($_SESSION['lang'])?>" class="benefit_btnIcon">
									<img src="/img/mobile/main/benefit_icon6.jpg" alt="한류"/>
									<p class="btnIcon6"><?=_t('공연 / 전시')?></p>
								</a>
							</li>
							<li class="borderBottom_no">
								<a href="/bbs/board.php?bo_table=cardbenefit&info=benefitshop&me_code=30&num=2&sca=Entertainment<?=lang_url_a($_SESSION['lang'])?>" class="benefit_btnIcon">
									<img src="/img/mobile/main/benefit_icon4.jpg" alt="식품"/>
									<p class="btnIcon7"><?=_t('엔터')?></p>
								</a>
							</li>
							<li class="borderBottom_no">
								<a href="/bbs/board.php?bo_table=cardbenefit&info=benefitshop&me_code=30&num=2&sca=Experiences<?=lang_url_a($_SESSION['lang'])?>" class="benefit_btnIcon">
									<img src="/img/mobile/main/benefit_icon5.jpg" alt="관광지"/>
									<p class="btnIcon8"><?=_t('체험')?></p>
								</a>
							</li>
							
							<li class="borderBottom_no borderRig">
								<a href="/bbs/board.php?bo_table=cardbenefit&info=benefitshop&me_code=30&num=2&sca=Miscellaneous<?=lang_url_a($_SESSION['lang'])?>" class="benefit_btnIcon">
									<img src="/img/mobile/main/benefit_icon9.jpg" alt="기타"/>
									<p class="btnIcon9"><?=_t('기타')?></p>
								</a>
							</li>
						</ul>
					</div>
					
				</div>
			</div>
			


			



			<div class="store">
				<div class="store_area">
					<h3><?=_t('판매점')?></h3>
					
					<div class="store_SlideArea">
						<ul class="storeBan1">
							<li>
								<a href="/bbs/board.php?bo_table=map&info=search&me_code=20&num=1<?=lang_url_a($_SESSION['lang'])?>">
									<img src="/img/mobile/main/main_store1_search.jpg" style="width:100%;" alt=""/>
									<p class="store_srTxt"><?=_t('판매점 찾기')?></p>
								</a>
							</li>
							<li>
								<?php echo display_banner('mp4', 'mainbanner.shop.skin.php',$g5['lang']); ?>
								<!--<ul id="slider1">
									<li>
										<a href="http://www.7-eleven.co.kr/" target="_blank">
											<img src="/img/mobile/main/main_store1_ban1.jpg" style="width:100%;" alt=""/>
										</a>
									</li>
									<li>
										<a href="http://www.jejuair.net/jejuair/main.jsp" target="_blank">
											<img src="/img/mobile/main/main_store1_ban2.jpg" style="width:100%;" alt=""/>
										</a>
									</li>
									<li>
										<a href="http://cu.bgfretail.com/index.do" target="_blank">
											<img src="/img/mobile/main/main_store1_ban3.jpg" style="width:100%;" alt=""/>
										</a>
									</li>
								</ul>-->
							</li>
						</ul>

						<div class="storeBan2">
							<ul id="slider2">
								<?while($row = sql_fetch_array($allshop_notice) ){?>
									<?	$row = get_notice_row('allshop', $row['wr_id']);
										$thumb = get_list_thumbnail("allshop", $row['wr_id'], '306', '',false, true, 'center', true,'80/0.5/3',1);
									?>

									<li>
										<a href="/bbs/board.php?bo_table=map&info=search&me_code=20&num=1&search=<?=$row['wr_id']?><?=lang_url_a($_SESSION['lang'])?>">
										<p class="storeBan2_name nameColor1"><?=$row['wr_subject_'.$_SESSION['lang']]?></p>

											<?if( $thumb['src'] ){?>
												<img src="<?=$thumb['src']?>" alt="" style="width:100%;" />
											<?}else{?>
												<img src="/img/default/ktc_m_main_allshop.jpg" alt="" style='width:100%;' />
											<?}?>
										</a>
									</li>

								<?}?>
							</ul>
							<!--
							<div class="slider2_bt">
								<h4><?=_t('대표판매점')?></h3>
							</div>
							-->
						</div>
					</div>

				</div>
			</div>







			<div class="thema">
				<div class="thema_content">
					<div class="thema_title">
						<h3><?=_t('테마여행')?></h3>
						<p><a href="/bbs/board.php?bo_table=tourinfo&sca=테마여행%20추천코스&info=event&me_code=40&num=3<?=lang_url_a($_SESSION['lang'])?>"><img src="/img/mobile/main/m_more.png" style="width:100%;" alt=""/></a></p>
					</div>
				</div>

				<ul id="slider3">


					<?for($i=0; $i<count($benefit_notice); $i++ ){?>
						<?	$row = get_notice_row('tourinfo', $benefit_notice[$i]);
							$thumb = get_list_thumbnail("tourinfo", $benefit_notice[$i], '308', '',false, true, 'center', true,'80/0.5/3',0);
						?>
						
						<?if($i != 5){?>


						<li>
							<a href="/bbs/board.php?bo_table=tourinfo&wr_id=<?=$row['wr_id']?>&sca=<?=$row['ca_name']?>&info=event&me_code=40&num=3<?=lang_url_a($_SESSION['lang'])?>">
								<div class="themaBan2_txt">
									<h3><?=$row['wr_subject_'.$_SESSION['lang']]?></h3>
									<?if($_SESSION['lang'] == "en_US" ) {$str_number = 100;}else{$str_number = 50;} ?>
									<p><?=cut_str(strip_tags($row['wr_content_'.$_SESSION['lang']]),$str_number);?></p>
								</div>
								<img src="<?=$thumb['src']?>" style="width:100%;" alt=""/>
								<div class="themaBan2_BG"></div>
							</a>
						</li>						

						<?}else{
							break;
						}?>
					<?}?>	


				</ul>
				
			</div>








			<div class="M_banner1">
				<div class="M_banner1_area">
					<!--<a href="http://www.lwt.co.kr/tower/main/main.do" target="_blank"><img src="/img/mobile/main/banner1.jpg" style="width:100%;" alt=""/></a>-->
					<?php echo display_banner('mtt', 'mainbanner.mtt.skin.php',$g5['lang']); ?>
				</div>
			</div>






			<div class="course">
				<div class="course_area">
					<ul>
						<li>
							<a href="/bbs/board.php?bo_table=festival&sca=<?=urlencode('축제&행사')?>&info=info&me_code=40&&num=3<?=lang_url_a($_SESSION['lang'])?>">
								<div class="course_title <?=set_class('course_title_us','en_US/zh_CN/zh_TW')?> <?=set_class('test13','ja_JP')?>">
									<h3 class="<?=set_class('test12','en_US')?>"><?=_t('축제 / 공연')?></h3>
									<p><img src="/img/mobile/main/m_more.png" alt="더 보기"/></p>
								</div>
								<img src="/img/mobile/main/date_img1.jpg" class="course_img" style="width:100%" alt=""/>
								<p class="course_txt <?=set_class('course_txt_lan','en_US/ja_JP/zh_CN/zh_TW')?>"><?=_t('2017 축제 / 행사 일정')?></p>
							</a>
						</li>

						<li class="fl_right">
							<a href="/bbs/board.php?bo_table=tourinfo&info=event&me_code=40&num=3&sca=지역별+여행+추천+코스<?=lang_url_a($_SESSION['lang'])?>">
								<div class="course_title <?=set_class('course_title_us','en_US/zh_CN/zh_TW')?> <?=set_class('test13','ja_JP')?>">
									<h3 class="<?=set_class('test11','en_US')?>">
										<?if($_SESSION['lang'] != "en_US" ){?>
											<?=_t('여행추천코스')?>
										<?}else{?>
											Travel courses
										<?}?>
									</h3>
									<p><img src="/img/mobile/main/m_more.png" alt="더 보기"/></p>
								</div>
								<img src="/img/mobile/main/date_img2.jpg" class="course_img" style="width:100%" alt=""/>
								<p class="course_txt <?=set_class('course_txt_lan','en_US/ja_JP/zh_CN/zh_TW')?>"><?=_t('지역별 여행 추천코스')?></p>
							</a>
						</li>
					</ul>
				</div>
			</div>






			<div class="M_banner2">
				<div class="M_banner2_area">
					<div class="M_ban">
						<a href="/bbs/board.php?bo_table=traffic&info=traffic&me_code=40&num=3<?=lang_url_a($_SESSION['lang'])?>">
							<p><img src="/img/mobile/main/main_fraffic.png" style="width:100%;" alt="교통정보 아이콘"/></p>
							<h3><?=_t('교통정보 안내')?></h3>
						</a>
					</div>

					<ul>
						<li class="weather-temp weather <?=set_class('weather_ar_jp','ja_JP')?>">
							
							<img class='weatehr_bg_img' src="/img/mobile/main/we_bg.jpg" style="width:100%;" alt=""/>
							<ul id="m_weather">
								<?while($row = sql_fetch_array($weather_result) ){?>
									<li class='weather_one_shop'>
										<div class="weather_icon">
											<?if( $row['w_type'] == 0 ){?>
												<?get_sky_img($row['w_sky'])?>
											<?}else{?>
												<?get_type_img($row['w_type'])?>
											<?}?>
										</div>

										<div class="weather_txt1 <?if($g5['lang'] == 'en_US') echo 'exchange_us_weather_txt1' ?>"><?=_t($row['w_name'])?> / <?=_t('온도')?> <?=$row['w_temp']?>℃</div>

										<?if( $row['w_type'] == 0 ){?>
											<div class="weather_txt2"><?get_sky($row['w_sky'])?> / <?=_t('강수확률')?> <?=$row['w_rain']?></div>
										<?}else{?>
											<div class="weather_txt2"><?get_type($row['w_type'])?> / <?=_t('강수확률')?> <?=$row['w_rain']?></div>
										<?}?>

									</li>
								<?}?>
							</ul>


							<div id='m_weather_all' class="<?=set_class('m_weather_all_cn','zh_CN/zh_TW')?>">

								<?while( $row = sql_fetch_array($weather_result1) ){?>

									<div class="m_weather_allList">

										<div class="weather_icon">
											<?if( $row['w_type'] == 0 ){?>
												<?get_sky_img($row['w_sky'])?>
											<?}else{?>
												<?get_type_img($row['w_type'])?>
											<?}?>
										</div>

										<div class="m_weather_txt1"><?=_t($row['w_name'])?></div>
										<div class="m_weather_txt2"><?=$row['w_temp']?>℃</div>
									</div>
									
								<?}?>

							</div>
							<div class='weather_all_show weather_all_show1' val='1' style='z-index:9999'><i class="fa fa-plus" aria-hidden="true"></i></div>
						</li>






						<li class='exchage <?=set_class('weather_ex_jp','ja_JP')?>'>

							<div id='m_exchange_all' class="<?if($g5['lang'] == 'en_US') echo 'exchange_us_allList' ?>">

								<div class="m_exchange_allList">
									<img src='/img/mobile/main/ex3_chn.jpg' class="flag <?if($g5['lang'] == 'en_US') echo 'exchange_us_flag' ?>">

									<?
									if( 0 < $result_exchange['ex_cn'] - $Data['CNY']['매매기준율'] ){
									?>
										<span class="stateUD"><img src="/img/mobile/main/ex_down.png" alt="down"/></span><span class="state_ex" style='color:blue;'><?echo $Data['CNY']['매매기준율'];?><span>
									<?
									}else if( 0 > $result_exchange['ex_cn'] - $Data['CNY']['매매기준율'] ){
									?>
										<span class="stateUD"><img src="/img/mobile/main/ex_up.png" alt="up"/></span><span span class="state_ex" style='color:red;'><?echo $Data['CNY']['매매기준율'];?><span>
									<?
									}else{
									?>
										<span class="stateUD"><img src="/img/mobile/main/ex_steadiness.png" alt="steadiness"/></span><span span class="state_ex" style='color:gray;'><?echo $Data['CNY']['매매기준율'];?><span>
									<?
									}
									?>
								</div>

								<div class="m_exchange_allList">
									<img src='/img/mobile/main/ex2_jpy.jpg' class="flag <?if($g5['lang'] == 'en_US') echo 'exchange_us_flag' ?>">

									<?
									if( 0 < $result_exchange['ex_jp'] - $Data['JPY']['매매기준율'] ){
									?>
										<span class="stateUD"><img src="/img/mobile/main/ex_down.png" alt="down"/></span><span class="state_ex" style='color:blue;'><?echo $Data['JPY']['매매기준율'];?><span>
									<?
									}else if( 0 > $result_exchange['ex_jp'] - $Data['JPY']['매매기준율'] ){
									?>
										<span class="stateUD"><img src="/img/mobile/main/ex_up.png" alt="up"/></span><span span class="state_ex" style='color:red;'><?echo $Data['JPY']['매매기준율'];?><span>
									<?
									}else{
									?>
										<span class="stateUD"><img src="/img/mobile/main/ex_steadiness.png" alt="steadiness"/></span><span span class="state_ex" style='color:gray;'><?echo $Data['JPY']['매매기준율'];?><span>
									<?
									}
									?>
								</div>

								<div class="m_exchange_allList">
									<img src='/img/mobile/main/ex1_usd.jpg' class="flag <?if($g5['lang'] == 'en_US') echo 'exchange_us_flag' ?>">

									<?
									if( 0 < $result_exchange['ex_us'] - $Data['USD']['매매기준율'] ){
									?>
										<span class="stateUD"><img src="/img/mobile/main/ex_down.png" alt="down"/></span><span class="state_ex" style='color:blue;'><?echo $Data['USD']['매매기준율'];?><span>
									<?
									}else if( 0 > $result_exchange['ex_us'] - $Data['USD']['매매기준율'] ){
									?>
										<span class="stateUD"><img src="/img/mobile/main/ex_up.png" alt="up"/></span><span span class="state_ex" style='color:red;'><?echo $Data['USD']['매매기준율'];?><span>
									<?
									}else{
									?>
										<span class="stateUD"><img src="/img/mobile/main/ex_steadiness.png" alt="steadiness"/></span><span span class="state_ex" style='color:gray;'><?echo $Data['USD']['매매기준율'];?><span>
									<?
									}
									?>
								</div>

							</div>


							<div class="exchange_area">
								<div class='weather_all_show exchage_all_show' val='1' style='z-index:9999'><i class="fa fa-plus" aria-hidden="true"></i></div>
								<img class='weatehr_bg_img' src="/img/mobile/main/ex_bg.jpg" style="width:100%;" alt=""/>
								<h3 class="<?if($g5['lang'] == 'en_US') echo 'exchange_us' ?>"><?=_t('오늘의 환율')?></h3>
								<ul id='m_exchage'>
									<li>
										<div class="state <?if($g5['lang'] == 'en_US') echo 'exchange_us_state' ?>">
											<div>
												<span class="state_img <?if($g5['lang'] == 'en_US') echo 'exchange_us_img' ?>"><img src="/img/mobile/main/ex1_usd.jpg" style="width:100%;" alt="USA"/></span>
												<span class="state_name">USD</span>
												<?
												if( 0 < $result_exchange['ex_us'] - $Data['USD']['매매기준율'] ){
												?>
													<span class="stateUD"><img src="/img/mobile/main/ex_down.png" alt="down"/></span><span class="state_ex" style='color:blue;'><?echo $Data['USD']['매매기준율'];?><span>
												<?
												}else if( 0 > $result_exchange['ex_us'] - $Data['USD']['매매기준율'] ){
												?>
													<span class="stateUD"><img src="/img/mobile/main/ex_up.png" alt="up"/></span><span span class="state_ex" style='color:red;'><?echo $Data['USD']['매매기준율'];?><span>
												<?
												}else{
												?>
													<span class="stateUD"><img src="/img/mobile/main/ex_steadiness.png" alt="steadiness"/></span><span span class="state_ex" style='color:gray;'><?echo $Data['USD']['매매기준율'];?><span>
												<?
												}
												?>
											</div>
										</div>
									</li>
									
									<li>
										<div class="state <?if($g5['lang'] == 'en_US') echo 'exchange_us_state' ?>">
											<div>
												<span class="state_img <?if($g5['lang'] == 'en_US') echo 'exchange_us_img' ?>"><img src="/img/mobile/main/ex2_jpy.jpg" alt="JPN"/></span>
												<span class="state_name">JPY</span>
												<?
												if( 0 < $result_exchange['ex_jp'] - $Data['JPY']['매매기준율'] ){
												?>
													<span class="stateUD"><img src="/img/mobile/main/ex_down.png" alt="down"/></span><span class="state_ex" style='color:blue;'><?echo $Data['JPY']['매매기준율'];?><span>
												<?
												}else if( 0 > $result_exchange['ex_jp'] - $Data['JPY']['매매기준율'] ){
												?>
													<span class="stateUD"><img src="/img/mobile/main/ex_up.png" alt="up"/></span><span span class="state_ex" style='color:red;'><?echo $Data['JPY']['매매기준율'];?><span>
												<?
												}else{
												?>
													<span class="stateUD"><img src="/img/mobile/main/ex_steadiness.png" alt="steadiness"/></span><span span class="state_ex" style='color:gray;'><?echo $Data['JPY']['매매기준율'];?><span>
												<?
												}
												?>
											</div>
										</div>
									</li>

									<li>
										<div class="state <?if($g5['lang'] == 'en_US') echo 'exchange_us_state' ?>">
											<div>
												<span class="state_img <?if($g5['lang'] == 'en_US') echo 'exchange_us_img' ?>"><img src="/img/mobile/main/ex3_chn.jpg" alt="CHN"/></span>
												<span class="state_name">CNY</span>
												<?
												if( 0 < $result_exchange['ex_cn'] - $Data['CNY']['매매기준율'] ){
												?>
													<span class="stateUD"><img src="/img/mobile/main/ex_down.png" alt="down"/></span><span class="state_ex" style='color:blue;'><?echo $Data['CNY']['매매기준율'];?><span>
												<?
												}else if( 0 > $result_exchange['ex_cn'] - $Data['CNY']['매매기준율'] ){
												?>
													<span class="stateUD"><img src="/img/mobile/main/ex_up.png" alt="up"/></span><span span class="state_ex" style='color:red;'><?echo $Data['CNY']['매매기준율'];?><span>
												<?
												}else{
												?>
													<span class="stateUD"><img src="/img/mobile/main/ex_steadiness.png" alt="steadiness"/></span><span span class="state_ex" style='color:gray;'><?echo $Data['CNY']['매매기준율'];?><span>
												<?
												}
												?>
											</div>
										</div>
									</li>
									
								</ul>						
							</div>
						</li>


						
					</ul>


				</div>
			</div>




			<div class="M_banner3">
				<div class="M_banner3_area">
					
					<ul class="M_ban3">
						<li>
							<?php echo display_banner('main_festival', 'mainbanner.event1.skin.php',$g5['lang']); ?>
     						<!--
							<a href="http://seoulrose.jungnang.go.kr/seoulRose/main.do" target="_blank">
								<img src="/img/mobile/main/banner2.jpg" style="width:100%;" alt=""/>
							</a>
							-->
						</li>
						<li>
							<?php echo display_banner('main_festival2', 'mainbanner.event2.skin.php',$g5['lang']); ?>
						<!--
							<a href="http://ticket.yes24.com/Pages/Perf/Detail/Detail.aspx?IdPerf=22139" target="_blank">
								<img src="/img/mobile/main/banner3.jpg" style="width:100%;" alt=""/>
							</a>
							-->
						</li>
					</ul>

					<ul class="M_notice3">
						<li>
							<a href="/bbs/board.php?bo_table=knotice&info=notice&me_code=40&num=3<?=lang_url_a($_SESSION['lang'])?>">
								<div class="M_notice3_area">
									<p class="no3_icon1"><img src="/img/mobile/main/notice_icon1.jpg" style="width:100%;" alt="공지사항"/></p>
									<h4><?=_t('공지 및 이용안내')?></h4>
									<p class="no3_icon2"><img src="/img/mobile/main/notice_iconArow.jpg" style="width:100%;" alt="바로가기"/></p>
								</div>
							</a>
						</li>

						<li>
							<a href="/bbs/faq.php?&info=qa&me_code=40&num=3<?=lang_url_a($_SESSION['lang'])?>">
								<div class="M_notice3_area">
									<p class="no3_icon1"><img src="/img/mobile/main/notice_icon2.jpg" style="width:100%;" alt="자주묻는 질문"/></p>
									<h4><?=_t('자주묻는 질문')?></h4>
									<p class="no3_icon2"><img src="/img/mobile/main/notice_iconArow.jpg" style="width:100%;" alt="바로가기"/></p>
								</div>
							</a>
						</li>

						<li>
							<a href="/bbs/board.php?bo_table=prcenter&info=cardprcenter&me_code=10&num=0<?=lang_url_a($_SESSION['lang'])?>">
								<div class="M_notice3_area">
									<p class="no3_icon1"><img src="/img/mobile/main/notice_icon3.jpg" style="width:100%;" alt="홍보센터"/></p>
									<h4><?=_t('홍보센터')?></h4>
									<p class="no3_icon2"><img src="/img/mobile/main/notice_iconArow.jpg" style="width:100%;" alt="바로가기"/></p>
								</div>
							</a>
						</li>
					</ul>
				</div>
			</div>


		</div>
		<!--컨텐츠 끝-->


	</div><!-- overflow 영역 끝 -->

<?
include_once('footer.php')
?>


