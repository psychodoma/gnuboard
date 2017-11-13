<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$search_skin_url.'/style.css">', 0);
include_once('../lib/thumbnail.lib.php');


	$v_map_info = " ( SELECT A.store_detail, wr_6, A.wr_7, A.wr_8, A.wr_9, A.wr_10, A.wr_1, A.wr_link1, A.wr_id, A.info_name_ko_KR, A.info_name_en_US, A.info_name_ja_JP, A.info_name_zh_CN, A.info_name_zh_TW, A.info_address_ko_KR, A.info_address_en_US, A.info_address_ja_JP, A.info_address_zh_CN, A.info_address_zh_TW, A.info_lat, A.info_lng, A.store_id, A.info_phone, A.service_id, A.info_servicetime_ko_KR, A.info_servicetime_en_US, A.info_servicetime_ja_JP, A.info_servicetime_zh_CN, A.info_servicetime_zh_TW, A.info_write_time, B.name, B.name_ko_KR, B.name_en_US, B.name_ja_JP, B.name_zh_CN, B.name_zh_TW, B.write_time, B.type_ko_KR, B.type_en_US, B.type_ja_JP, B.type_zh_CN, B.type_zh_TW, B.type_color
	FROM g5_write_map AS A
	INNER JOIN g5_map_store AS B
	ON A.store_id = B.id ) v_map_info ";



$query = " select * from ".$v_map_info." where wr_1 = 0 and info_name_ko_KR like '%".$word."%'  or info_name_en_US like '%".$word."%'  or info_name_ja_JP like '%".$word."%' or info_name_zh_CN like '%".$word."%'  or  info_name_zh_TW like '%".$word."%'  or info_address_ko_KR like '%".$word."%' and info_address_ko_KR like '%".$word1."%' or info_address_en_US like '%".$word."%'  or info_address_ja_JP like '%".$word."%'  or info_address_zh_CN like '%".$word."%'  or info_address_zh_TW like '%".$word."%' order by info_name_".$_SESSION['lang']." limit 0,5 ";
$query_cnt = " select count(*) cnt from ".$v_map_info." where wr_1 = 0 and info_name_ko_KR like '%".$word."%'  or info_name_en_US like '%".$word."%'  or info_name_ja_JP like '%".$word."%' or info_name_zh_CN like '%".$word."%'  or  info_name_zh_TW like '%".$word."%'  or info_address_ko_KR like '%".$word."%' and info_address_ko_KR like '%".$word1."%' or info_address_en_US like '%".$word."%'  or info_address_ja_JP like '%".$word."%'  or info_address_zh_CN like '%".$word."%'  or info_address_zh_TW like '%".$word."%' ";
$row = sql_fetch($query_cnt);
$total_count_map = $row['cnt'];

$result = sql_query($query);










// $query_card = " select * from g5_write_cardbenefit where wr_subject_ko_KR like '%".$word."%'  or wr_subject_en_US like '%".$word."%'  or wr_subject_ja_JP like '%".$word."%' or wr_subject_zh_CN like '%".$word."%'  or  wr_subject_zh_TW like '%".$word."%' limit 0,5 ";
// $query_cnt_card = " select count(*) cnt from g5_write_cardbenefit where wr_subject_ko_KR like '%".$word."%'  or wr_subject_en_US like '%".$word."%'  or wr_subject_ja_JP like '%".$word."%' or wr_subject_zh_CN like '%".$word."%'   ";
// $row_card = sql_fetch($query_cnt_card);/
// $total_count_card = $row_card['cnt'];/
// $result_card = sql_query($query_card);/

$word = trim($word);
if ($sca || $word) {
    $sql_search = ktc_get_sql_search($sca, $sfl, $word, $sop);



    // 가장 작은 번호를 얻어서 변수에 저장 (하단의 페이징에서 사용)
    $sql = " select MIN(wr_num) as min_wr_num from g5_write_cardbenefit ";
    $row = sql_fetch($sql);
    $min_spt = (int)$row['min_wr_num'];

    if (!$spt) $spt = $min_spt;




        $sql = " SELECT COUNT(DISTINCT `wr_group`) AS `cnt` FROM g5_write_cardbenefit WHERE {$sql_search} and wr_group != 0 ";
        $row = sql_fetch($sql);

        $sql = " SELECT COUNT(DISTINCT `wr_parent`) AS `cnt` FROM g5_write_cardbenefit WHERE {$sql_search} and wr_group = 0 ";
        $srow = sql_fetch($sql);

        $total_count = $row['cnt'] + $srow['cnt'];


    // 원글만 얻는다. (코멘트의 내용도 검색하기 위함)
    // 라엘님 제안 코드로 대체 http://sir.kr/bbs/board.php?bo_table=g5_bug&wr_id=2922
    /*
    $sql = " select distinct wr_parent from g5_write_cardbenefit where {$sql_search} ";
    $result = sql_query($sql);
    $total_count = sql_num_rows($result);
    */
} else {
    $sql_search = "";
    $sql_beneift_cnt_val = sql_fetch(" SELECT COUNT(DISTINCT `wr_parent`) AS `cnt` FROM g5_write_cardbenefit where wr_title_ko_KR != '' ");
    $total_count = $sql_beneift_cnt_val['cnt'];
}
$m_sql_total = $total_count;


$card_pagecnt = 5;
$card_totalPage  = ceil($total_count / $card_pagecnt);  // 전체 페이지 계산
$total_count_card = $total_count;

if(!(isset($card_page))){
    $card_page = 1;
}



$card_pagecnt = 5;

$from_record = ($card_page - 1) * $card_pagecnt; // 시작 열을 구함

// 공지글이 있으면 변수에 반영
if(!empty($notice_array)) {
    if( !($info == "notice") ){
        $from_record -= count($notice_array);
    }

    if($from_record < 0)
        $from_record = 0;

    if($notice_count > 0)
        $card_pagecnt -= $notice_count;

    if($card_pagecnt < 0)
        $card_pagecnt = $list_card_pagecnt;
}


if(!$sst)
    $sst  = "wr_num, wr_reply";

if ($sst) {
    $sql_order = " order by {$sst} {$sod} ";
}

if ($sca || $word) {

    $sql = " ( select * from (select * from g5_write_cardbenefit where {$sql_search} and wr_group != 0 order by wr_title_ko_KR desc) a group by wr_group ) union";
    $sql .= " (select * from g5_write_cardbenefit where {$sql_search} and wr_group = 0) ";
    $sql .= " limit {$from_record}, $card_pagecnt ";

} else {

    $sql = " select * from g5_write_cardbenefit where wr_is_comment = 0 ";

    $sql .= " and wr_title_ko_KR != '' ";

    if(!empty($notice_array))
        $sql .= " and wr_id not in (".implode(', ', $notice_array).") ";
    $sql .= " {$sql_order} limit {$from_record}, $card_pagecnt ";

}
$m_sql = $sql;

$result_card = sql_query($sql);














?>

<div class='remember_page1' valPage='1' valRow='5' ></div>
<div class='remember_page2' valPage='1' valRow='5' ></div>


		<div class="sub5_1form_area">
			<div class="sub2_1form">

				<form name="fsearchbox" method="get" action="/bbs/search.php" onsubmit="return fsearchbox_submit(this);" class="">
					<input type='hidden' name='lang' value='<?=lang_url($_SESSION['lang'])?>' >
					<fieldset>
						<label for="sch_stx" class="sound_only hide">검색어<strong class="sound_only"> 필수</strong></label>

						<ul>
							<li class="search21_input">
								<label for="" class="hide">검색창</label>
								<input type="text" class="sub21_bar" name="word" value='<?=$word?>' id="sch_stx" maxlength="" placeholder="<?=_t('검색어를 입력하세요.')?>">
							</li>

							<li class="search21_btn">
								<input type="image" class="syb21_loginbtn" id="sch_submit" src="/img/sub/sub5/sub2_1search.png"  title="검색" />
							</li>
						</ul>

						<script>
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

			</div><!-- sub2_1form 끝 -->
		</div><!-- sub2_1form_area 끝 -->








		<div class="sub5_1List">
			<div class="sub51List_title">
				<h2><?=_t('판매점 안내')?></h2>
			</div>


            <?if($total_count_map){?>
                <ul class="sub51List sub51List3">
                    <?$cnt=0; while( $row = sql_fetch_array($result) ){?>
                        <li>
                            <div class="sub51List_area">
                                <div class="sub51List_info">
                                    <a style='cursor:pointer;' href="/bbs/board.php?bo_table=map&info=search&me_code=20&num=1&word=<?=$row['info_name_'.$_SESSION['lang']]?><?=lang_url_a($_SESSION['lang'])?>">
										<div class="sub51List_info_txt">
											<h3><?=$row['info_name_'.$_SESSION['lang']]?></h3>
											<p class="sub51info_add"><?=$row['info_address_'.$_SESSION['lang']]?></p>
										</div>
										<p class="sub51List_icon"><img src="/img/sub/sub5/m_more1.png" ></p>
                                    </a>
                                </div>

								<p class="sub51info_tel" style='padding-bottom:5px;'>
									<?if($row['info_phone']){?>
										<a href="tel:<?=$row['info_phone']?>"><?=$row['info_phone']?></a>
									<?}?>
								</p>
								<?if( $row['info_servicetime_'.$_SESSION['lang']] ){?>
									<p class="sub21_info_tel" style='background-image: url(/img/mobile/sub/sub3/sub3_1/sub31list_icon3.jpg' ><?=$row['info_servicetime_'.$_SESSION['lang']]?></p>
								<?}?>
                            </div>

                        </li>
                    <?$cnt++;}?>


                    <?if($total_count_map > 5){?>
                        <div class="subMore_btn subMore_btn1" style='margin-top:30px;'>
                            <div class="subMore_btn_area subMore_btn_area1">
                                <a>
                                    <p class="subMore_icon"></p>
                                    <?if( $total_count_map < 5 ){
                                        $total_count_view = 5;
                                    }else{
                                        $total_count_view = $total_count_map;
                                    }
                                    ?>
                                    <p class="subMore_info">(<?=$cnt?> / <?=$total_count_view?>)</p>
                                </a>
                            </div>
                        </div>
                    <?}?>
                </ul>
            <?}else{?>
                <div style="text-align:center; font-size:15px; color:#868686; padding:10% 0;"><?=_t('검색 결과가 없습니다.')?></div>
            <?}?>

		</div><!-- sub5_1List 끝 -->



		<div class="sub5_1List">
			<div class="sub51List_title">
				<h2><?=_t('카드 혜택 안내')?></h2>
			</div>



            <?if($total_count_card){?>
                <table class="sub51List1 sub51List4">
                    <?$cnt_card=0; while( $row = sql_fetch_array($result_card) ){
                        $thumb1 = get_list_thumbnail("cardbenefit", $row['wr_id'], '120', '',true, true, 'left', false,'80/0.5/3',1);
                        $thumb = get_list_thumbnail("cardbenefit", $row['wr_id'], $thumb1['width'], $thumb1['height'],true, true, 'left', false,'80/0.5/3',1);?>
                        <tr>
                            <td class="sub51info_img" style="width: 26%;">

                                <?if($_SESSION['lang'] != "ko_KR"){?>
                                    <?if(  strpos( $row['wr_img_append_'.$_SESSION['lang']], "src=" ) ){?>
                                        <?=$row['wr_img_append_'.$_SESSION['lang']]?>
                                    <?}else if($thumb['src']){?>
                                        <img src="<?=$thumb['src']?>" >
                                    <?}else{?>
                                        <img src="/img/default/ktc_cardbenefit_list.png">
                                    <?}?>
                                <?}else{?>
                                    <?if($thumb['src']){?>
                                            <img src="<?=$thumb['src']?>" >
                                    <?}else{?>
                                        <img src="/img/default/ktc_cardbenefit_list.png">
                                    <?}?>
                                <?}?>

                            </td>
                            <td class="sub51List_info1" style="position: relative;">
                                <a href="/bbs/board.php?bo_table=cardbenefit&wr_id=<?=$row['wr_id']?>&info=benefit&me_code=30&num=2<?=lang_url_a($_SESSION['lang'])?>">
									<div class="sub51List_info1_txt">
										<h3>
											<?if( $word ){?>
												<?if( $row['wr_title_'.$_SESSION['lang']] == ''){?>
													<?=$row['wr_subject_'.$_SESSION['lang']]?>
												<?}else{?>
													<?=$row['wr_title_'.$_SESSION['lang']]?>
												<?}?>
											<?}else{?>
												<?=$row['wr_title_'.$_SESSION['lang']]?>
											<?}?>
										</h3>
										<p>
											<? $sql_bene = sql_fetch("select * from g5_board_file where bo_table='cardbenefit' and bf_no=4 and wr_id =".$row['wr_id']." order by bf_no");
											$sql_bene_cnt = sql_fetch("select count(*) cnt from g5_board_file where bo_table='cardbenefit' and wr_id =".$row['wr_id']);
											$sql_bene_cnts = $sql_bene_cnt['cnt'] - 4;
											?>

											<?if($sql_bene_cnts <= 0){?>
											<?=_t('혜택없음')?>
											<?}else{?>
												<?if($_SESSION['lang'] == "ko_KR"){?>
													<?=$sql_bene['bf_content']?> <?=_t('혜택 등 총')?> <?=$sql_bene_cnts?><?=_t('건')?>
												<?}else if($_SESSION['lang'] == "en_US"){?>
													<?=$sql_bene_cnts?> results in total such as <?=$sql_bene['bf_content_'.$_SESSION['lang']]?> benefits
												<?}else{?>
													<?=$sql_bene['bf_content_'.$_SESSION['lang']]?> <?=_t('혜택 등 총')?> <?=$sql_bene_cnts?><?=_t('건')?>
												<?}?>
											<?}?>
										</p>
									</div>

									<div class="sub51List_more">
										<img src="/img/sub/sub5/m_more1.png" >
									</div>
								</a>
                            </td>

							<!--
                            <td class="sub51List_more">
								<a href="/bbs/board.php?bo_table=cardbenefit&wr_id=<?=$row['wr_id']?>&info=benefit&me_code=30&num=2"><img src="/img/sub/sub5/m_more1.png" ></a>
							</td>
							-->

                        </tr>
                    <?$cnt_card++;}?>

                        <?if($total_count_card > 5){?>
                        <tr>
                        <td class='sub5_1List_more_btn' colspan=3>


                            <div class="subMore_btn subMore_btn2" style='margin-top:30px;'>
                                <div class="subMore_btn_area subMore_btn_area2">
                                    <a>
                                        <p class="subMore_icon"></p>
                                        <?if( $total_count_card < 5 ){
                                            $total_count_view1 = 5;
                                        }else{
                                            $total_count_view1 = $total_count_card;
                                        }
                                        ?>
                                        <p class="subMore_info">(<?=$cnt_card?> / <?=$total_count_view1?>)</p>
                                    </a>
                                </div>
                            </div>


                        </td>
                        </tr>
                        <?}?>

                </table>
            <?}else{?>
                <div style="text-align:center; font-size:15px; color:#868686; padding:10% 0;"><?=_t('검색 결과가 없습니다.')?></div>
            <?}?>

		</div><!-- sub5_1List 끝 -->
















<script>
$(function(){


	if(document.location.hash){
		$('.sub51List3 li').each(function(){
			$(this).remove();
		})

		$('.sub51List4 tr').each(function(){
			$(this).remove();
		})
		var HashLocationName = document.location.hash;
		HashLocationName = HashLocationName.split(',');
		var div_tag = HashLocationName[1];
		var HashLocationName1 = HashLocationName[2];

		HashLocationName = HashLocationName[0].replace('#','');

		if(HashLocationName != ''){

			$(".subMore_btn_area a").html('<div style="padding-top:10px;" ><i class="fa fa-spinner fa-spin fa-2x fa-fw "></i><span class="sr-only">Loading...</span></div>');
			$('.subMore_btn_area a').unbind('click');
			$.ajax({
				url: "/bbs/ajax.listadd_search.php",
				type: "post",
				data: {
						'page': HashLocationName,
						'page_rows': 5,
						'bo_table': 'map',
						'word': '<?=$word?>',
						'type': '1',
						'hash_ck': true
					  },
				success:function(data){
					$('.subMore_btn1').remove();
					var page_row = parseInt($('.remember_page1').attr('valRow'));
					$('.sub51List3').append(data);

					if( $('.subMore_btn1 .subMore_info').text() ){
						var page_value = $('.subMore_btn1 .subMore_info').text().split('(')[1].split('/')[0].trim();
						if(page_value%page_row == 0){
							$('.remember_page1').attr('valPage',page_value/page_row);
						}else{
							$('.remember_page1').attr('valPage',(page_value+1)/page_row);
						}
					}

					$('html, body').animate({scrollTop : div_tag},0);

					$('.link').click(function(){
						if( $('.subMore_btn1 .subMore_info').text() ){
							var page_value = $('.subMore_btn1 .subMore_info').text().split('(')[1].split('/')[0].trim();
							if( $('.subMore_btn2 .subMore_info').text() ){
								var page_value1 = $('.subMore_btn2 .subMore_info').text().split('(')[1].split('/')[0].trim();
							}else{
								var page_value1 = "<?=$total_count_card?>";
							}
							document.location.hash = "#"+page_value+","+$(document).scrollTop()+","+page_value1;
						}else{
							if( $('.subMore_btn2 .subMore_info').text() ){
								var page_value1 = $('.subMore_btn2 .subMore_info').text().split('(')[1].split('/')[0].trim();
							}else{
								var page_value1 = "<?=$total_count_card?>";
							}
							document.location.hash = "#<?=$total_count_map?>,"+$(document).scrollTop()+","+page_value1;
						}
					})

				}
			})




			$.ajax({
				url: "/bbs/ajax.listadd_search1.php",
				type: "post",
				data: {
						'page': HashLocationName1,
						'page_rows': 5,
						'bo_table': 'map',
						'word': '<?=$word?>',
						'm_sql': "<?=$m_sql?>",
						'm_sql_total': "<?=$m_sql_total?>",
						'hash_ck': true
					  },
				success:function(data){
					$('.subMore_btn2').remove();
					var page_row = parseInt($('.remember_page2').attr('valRow'));
					$('.sub51List4').append(data);

					if( $('.subMore_btn2 .subMore_info').text() ){
						var page_value = $('.subMore_btn2 .subMore_info').text().split('(')[1].split('/')[0].trim();
						if(page_value%page_row == 0){
							$('.remember_page2').attr('valPage',page_value/page_row);
						}else{
							$('.remember_page2').attr('valPage',(page_value+1)/page_row);
						}
					}

					$('html, body').animate({scrollTop : div_tag},0);

					$('.link1').click(function(){

						if( $('.subMore_btn2 .subMore_info').text() ){
							var page_value = $('.subMore_btn2 .subMore_info').text().split('(')[1].split('/')[0].trim();
							if( $('.subMore_btn1 .subMore_info').text() ){
								var page_value1 = $('.subMore_btn1 .subMore_info').text().split('(')[1].split('/')[0].trim();
							}else{
								var page_value1 = "<?=$total_count_map?>";
							}
							document.location.hash = "#"+page_value1+","+$(document).scrollTop()+","+page_value;
						}else{
							if( $('.subMore_btn1 .subMore_info').text() ){
								var page_value1 = $('.subMore_btn1 .subMore_info').text().split('(')[1].split('/')[0].trim();
							}else{
								var page_value1 = "<?=$total_count_map?>";
							}
							document.location.hash = "#"+page_value1+","+$(document).scrollTop()+","+"<?=$total_count_card?>";
						}


					})
				}
			})








		}

	}









	$('.sub51List_info1 p').each(function(index){
		$(this).html($(this).text().replace(/\\/g,'<i class="fa fa-krw" style="font-size:12px;" aria-hidden="true"></i>'));
	})

    $('.subMore_btn_area1 a').click(function(){
		$(this).html('<div style="padding-top:10px;" ><i class="fa fa-spinner fa-spin fa-2x fa-fw "></i><span class="sr-only">Loading...</span></div>');
		$('.subMore_btn_area1 a').unbind('click');
        $.ajax({
            url: "/bbs/ajax.listadd_search.php",
            data: {
                    'page': $('.remember_page1').attr('valPage'),
                    'page_rows': 5,
                    'bo_table': 'map',
                    'word': '<?=$word?>',
                    'type': '1',
                  },
            success:function(data){
                $('.subMore_btn1').remove();
                var page_num = parseInt($('.remember_page1').attr('valPage'))+1;
                var page_row = parseInt($('.remember_page1').attr('valRow'));
                $('.sub51List3').append(data);
                $('.remember_page1').attr('valPage',page_num);



				$('.link').click(function(){
					if( $('.subMore_btn1 .subMore_info').text() ){
						var page_value = $('.subMore_btn1 .subMore_info').text().split('(')[1].split('/')[0].trim();
						if( $('.subMore_btn2 .subMore_info').text() ){
							var page_value1 = $('.subMore_btn2 .subMore_info').text().split('(')[1].split('/')[0].trim();
						}else{
							var page_value1 = "<?=$total_count_card?>";
						}
						document.location.hash = "#"+page_value+","+$(document).scrollTop()+","+page_value1;
					}else{
						if( $('.subMore_btn2 .subMore_info').text() ){
							var page_value1 = $('.subMore_btn2 .subMore_info').text().split('(')[1].split('/')[0].trim();
						}else{
							var page_value1 = "<?=$total_count_card?>";
						}
						document.location.hash = "#<?=$total_count_map?>,"+$(document).scrollTop()+","+page_value1;
					}
				})




            }
        })
    })










    $('.subMore_btn_area2 a').click(function(){
		$(this).html('<div style="padding-top:10px;" ><i class="fa fa-spinner fa-spin fa-2x fa-fw "></i><span class="sr-only">Loading...</span></div>');
		$('.subMore_btn_area2 a').unbind('click');
        $.ajax({
            url: "/bbs/ajax.listadd_search1.php",
			type: "post",
            data: {
                    'page': $('.remember_page2').attr('valPage'),
                    'page_rows': 5,
                    'bo_table': 'cardbenefit',
                    'word': '<?=$word?>',
                    'm_sql': "<?=$m_sql?>",
                    'm_sql_total': "<?=$m_sql_total?>",
                  },
            success:function(data){
                $('.sub5_1List_more_btn').remove();
                var page_num = parseInt($('.remember_page2').attr('valPage'))+1;
                var page_row = parseInt($('.remember_page2').attr('valRow'));
                $('.sub51List4').append(data);
                $('.remember_page2').attr('valPage',page_num);


					$('.link1').click(function(){

						if( $('.subMore_btn2 .subMore_info').text() ){
							var page_value = $('.subMore_btn2 .subMore_info').text().split('(')[1].split('/')[0].trim();
							if( $('.subMore_btn1 .subMore_info').text() ){
								var page_value1 = $('.subMore_btn1 .subMore_info').text().split('(')[1].split('/')[0].trim();
							}else{
								var page_value1 = "<?=$total_count_map?>";
							}
							document.location.hash = "#"+page_value1+","+$(document).scrollTop()+","+page_value;
						}else{
							if( $('.subMore_btn1 .subMore_info').text() ){
								var page_value1 = $('.subMore_btn1 .subMore_info').text().split('(')[1].split('/')[0].trim();
							}else{
								var page_value1 = "<?=$total_count_map?>";
							}
							document.location.hash = "#"+page_value1+","+$(document).scrollTop()+","+"<?=$total_count_card?>";
						}


					})


            }
        })
    })



})
</script>
