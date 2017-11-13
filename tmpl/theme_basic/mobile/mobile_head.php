<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/banner.lib.php');

if(!(isset($_SESSION['lang']))){
    $_SESSION['lang'] = "ko_KR";
}
//include_once(G5_LIB_PATH.'/../locale/basic/lang_button_mobile.inc.php');
echo '<script type="text/javascript" src="/js/mobile/jquery.word-break-keep-all.min.js"></script>';

$result_cate = sql_fetch( "select * from {$g5['menu_table']} where me_url = '".$info."' order by me_id desc" );
?>




<script>
	$(function(){
		resize_fn();
		$(window).resize(function(){
			resize_fn();
		})
	})

	var img_width=976;
	var img_height=300;
	function resize_fn()
	{
		par_num=$(document).width()/img_width*100;
		if(par_num>100)
		{	
			par_num=100;
		}
		height_number=par_num/100*img_height;
		$(".sub3_1view_top").height(height_number)
	}
</script>

<div style="overflow:hidden; position: relative;">

	<div id="black_bg" onclick="javascript:potfol_close()"></div>

	<div class="search_bg">
		<div class="search_area">
			<form name="fsearchbox" method="get" action="/bbs/search.php" onsubmit="return fsearchbox_submit1(this);" class="">
				<input type='hidden' name='lang' value='<?=lang_url($_SESSION['lang'])?>' >
				<fieldset>
					<label for="sch_stx" class="sound_only hide">검색어<strong class="sound_only"> 필수</strong></label>


					<p class="serch_close" onclick="javascript:search_close()"><a href="#"><img src="/img/mobile/main/search_close.jpg"/></a></p>
					<ul id="search">
						<li class="search_input">
							<label for="" class="hide">검색창</label>
							<input type="text" class="searchbar" name="word" id="sch_stx" maxlength="" placeholder="<?=_t('검색어를 입력하세요.')?>">
						</li>

						<li class="search_btn">
							<input type="image" class="loginbtn" id="sch_submit" src="/img/mobile/main/serach_btn.png" alt="<?=_t('검색')?>" title="<?=_t('검색')?>" />
						</li>
					</ul>
			   

					<script>
						function fsearchbox_submit1(f)
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



	<!--헤드 시작-->

	<div id="headerBG_Sm">
		<div class="headerBG_Sm_area">



		<?if($info == "benefit" && $wr_id || $info == "benefitshop" && $wr_id){?>
			<!-- 서브메뉴 -->
			<p class="top_prev"><a onclick='history.back();' style='cursor:pointer;'><img src="/img/mobile/main/prev_icon.png" alt="<?=_t('뒤로가기')?>"/></a></p>
			<p class="serch_btn" onclick="javascript:search_fn()"><img src="/img/mobile/main/search.png" alt="<?=_t('검색버튼')?>"/></p>

		<?}else if($info == "event" && $wr_id){?>
			<!-- 서브메뉴 -->
			<p class="top_prev"><a onclick='history.back();' style='cursor:pointer;' ><img src="/img/mobile/main/prev_icon.png" alt="<?=_t('뒤로가기')?>"/></a></p>
			<p class="serch_btn" onclick="javascript:search_fn()"><img src="/img/mobile/main/search.png" alt="<?=_t('검색버튼')?>"/></p>

		<?}else{?>
			<!-- 서브메뉴 -->
			<p class="top_prev"><a onclick='history.back();' style='cursor:pointer;'><img src="/img/mobile/main/prev_icon.png" alt="<?=_t('뒤로가기')?>"/></a></p>
			<p class="serch_btn" onclick="javascript:search_fn()"><img src="/img/mobile/main/search.png" alt="<?=_t('검색버튼')?>"/></p>
			<?if( $me_code ){?>
				<ul class="Sub_pgMenu">
					<?
						$sql3 = " select *
									from {$g5['menu_table']}
									where me_use = '1'
									and length(me_code) = '4'
									and substring(me_code, 1, 2) = '{$me_code}'
									order by me_order, me_id ";
						$result3 = sql_query($sql3);

						$sql4 = sql_fetch(" select * from  {$g5['menu_table']} where me_code = '{$me_code}'");


					?>
					
					

					<li class="submenu SCmenu3"><a href="#" class="sb_link"><?echo _t($sql4['me_name'])?><span class="sna_icon"></span></a>
						<ul style='display:none;'>
							<?for ($k=0; $row3=sql_fetch_array($result3); $k++) {?>
								<li class="ssbumenu SCmenu1"><a href="<?php echo $row3['me_link']."&info=".$row3['me_url']."&me_code=".$me_code."&num=".$num ?><?=lang_url_a($_SESSION['lang'])?>" target="_<?php echo $row3['me_target']; ?>"  <?if($info == $row3['me_url'] ) echo "style='color:#ff60c2;'"; ?>     ><?=_t($row3['me_name'])?></a></li>
							<?}?> 
						</ul>
						<div class="submenuShadow" style="display: none;"></div>
					</li>
				</ul>
			<?}else{?>
				<div class="sub_title2 <?=set_class('sub_title2_us','en_US')?>">
					<h2><?=_t('통합검색')?></h2>
				</div>
			<?}?>


			<!-- 서브메뉴 끝 -->
		<?}?>

			<header class="headSect" id="header_768">
				<p class="menu" id="open_btn" onclick="javascript:potfol_fn()"><img src="/img/mobile/main/menu.png" alt="<?=_t('전체메뉴열기')?>"/></p>
				<div id="allmenuH" class="allmenu">
					<div class="allmenuIn">
			
						<div id="navigation">

							<ul class="navigation_list">

								<li class="b_sub TopAreaNavi">
									<ul class="top_munu">
										<li>
											<a href="/<?=lang_url($_SESSION['lang'])?>"><img src="/img/mobile/main/navi_home_btn.png" alt="<?=_t('홈')?>"/></a>
										</li>

										<li class="top_imgBtn">
											<div id="select_box">
												<label for="Scolor"><img src="/img/mobile/main/navi_lan_btn.png" alt="<?=_t('언어선택')?>"/></label>
												<form name="change" id="change" method="post">	
													<select id="Scolor" title="select Scolor">
														<?include('../locale/basic/lang_button_mobile.inc.php');?>
													</select>
												</form>
											</div>
										</li>
										<!--
										<li class="font_size">
											<a id="size_down" onclick="font_resize('container', 'ts_up ts_up2', '');" class="size1">가</a>
											<a id="size_def" onclick="font_resize('container', 'ts_up ts_up2', 'ts_up');" class="size2">가</a>
											<a id="size_up" onclick="font_resize('container', 'ts_up ts_up2', 'ts_up2');" class="size3">가</a>
										</li>
										-->
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
										<img src="/img/mobile/main/navi_sns_ut.png" alt="<?=_t('유투브')?>" style="width:100%;"/>
									</a>
								</li>
							</ul>

						</div><!-- navigation 끝 -->

					</div><!-- allmenuIn 끝 -->

				</div>
			</header>




		</div><!-- headerBG_Sm_area 끝 -->
	</div>

    <div style="margin-top:55px;"></div>

	<?

	if($info == "benefit" && $wr_id || $info == "benefitshop" && $wr_id){
		
	}else if($info == "event" && $wr_id){
		 
	}else{?>
		<div class="moble_wrap">
			<?if( $result_cate['me_name'] ){?>
				<div class="sub_title">
					<h2><?=_t($result_cate['me_name'])?></h2>
				</div>
			<?}?>
	<?}?>
