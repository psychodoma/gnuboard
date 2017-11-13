<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$search_skin_url.'/style.css">', 0);

?>

<!-- 전체검색 시작 { -->
		<div class="sub2_2center">

			<div class="sub5form">
				<form action="">
                    <input type="hidden" name="page" value=1 >
                    <input type="hidden" name="card_page" value=1 >
					<input type='hidden' name='lang' value='<?=lang_url($_SESSION['lang'])?>'>
					<fieldset>
						<ul>
							<li class="input">
								<label for="" class="hide">검색창</label>
								<input type="text" class="" name="word" id="" placeholder="<?=_t('검색어를 입력하세요.')?>" value='<?=$word?>'>
							</li>

							<li class="btn">
								<input type="submit" value="<?=_t('검색')?>" class="" id="" title="<?=_t('검색')?>" />
							</li>
						</ul>
					</fieldset>
				</form>
			</div>




			

			<div class="sub5_all">
				<?if(!$tatalCnt){ $tatalCnt = 0; }?>
				<h3>
				
					<?if($_SESSION['lang'] != "en_US"){?>
						<?=_t('판매점 검색결과')?> (<?=_t('총')?> <span style='font-size:18px; color:#b90808;'><?=$tatalCnt;?></span><?echo _t('개');?>)
					<?}else{?>
						<?=_t('판매점 검색결과')?> (<span style='font-size:18px; color:#b90808;'><?=$tatalCnt;?></span> <span style='font-size:18px;'>results in total</span>)
					<?}?>

				</h3>

				<table>
                    <?if($cnt_ck != 0){?>
                    <?while( $result = sql_fetch_array($row_shop) ){?>
                        <?if($result['info_table'] == 'map'){?>
                        <tr>
                            <td width="560px" class="sub5_tableInfo">  <!--width: 530 / 2017-10-27-->
                                <!--<h4>세븐일레븐 <span class="sub5_search">인천</span>공항점</h4>-->
                                <h4><?=$result['info_name_'.$_SESSION['lang']]?></h4>
                                <p>
                                    <?=$result['info_address_'.$_SESSION['lang']]?>
                                </p>
                            </td>
								<?if($result['info_address_'.$_SESSION['lang']]){?>
									<td width="202px" align="center" class="sub5_tell">
										<?=$result['info_phone']?>
									</td>
								<?}else{?>
									<td width="202px" align="center" class="sub5_tell" style='background-position: 1px 28px;'>
										<?=$result['info_phone']?>
									</td>
								<?}?>
                            
                            <td width="" class="sub5_tableBtn <?=set_class('sub5_tableBtn_us','en_US')?>" align="center">
                                <a href="/bbs/board.php?bo_table=map&info=search&me_code=20&num=1&word=<?=$result['info_name_'.$_SESSION['lang']]?><?=lang_url_a($_SESSION['lang'])?>"><?=_t('자세히보기')?> <span>></span></a>
                            </td>
                        </tr>
                        <?}else if($result['info_table'] == 'allshop'){?>
                        <tr>
                            <td width="560px" class="sub5_tableInfo">	<!--width: 530 / 2017-10-27-->
                                <!--<h4>세븐일레븐 <span class="sub5_search">인천</span>공항점</h4>-->
                                <h4><?=$result['wr_subject_'.$_SESSION['lang']]?></h4>
                            </td>
                            
                                <td width="202px" align="center" class="sub5_tell" style='background-image: url();'>
                                    <?=$result['info_phone']?>
                                </td>
                            
                            <td width="" class="sub5_tableBtn" align="center">
                                <a href="/bbs/board.php?bo_table=allshop&info=allstoresearch&me_code=20&word=<?=urlencode($result['wr_subject_'.$_SESSION['lang']]);?>&num=1<?=lang_url_a($_SESSION['lang'])?>"><?=_t('자세히보기')?> <span>></span></a>
                            </td>
                        </tr>
                        <?}?>
                    <?}}else{?>
                        <tr>
                            <p class="sub5_search_false"><?=_t('검색 결과가 없습니다.')?></p>
                        </tr>
                    <?}?>

				</table>
			</div>


            <?
            $write_pages = get_paging_ktc(9, $page, $totalPage, "/bbs/search_ktc.php?word=".$word."&card_page=".$card_page.lang_url_a($_SESSION['lang'])); 
            echo $write_pages;
            ?>


			<div class="sub5_card">
				<h3 class="sub5_cardTitle">

					<?if($_SESSION['lang'] != "en_US"){?>
						<?=_t('판매점 검색결과')?> (<?=_t('총')?> <span style='font-size:18px; color:#b90808;'><?=$card_tatalCnt;?></span><?echo _t('개');?>)
					<?}else{?>
						<?=_t('판매점 검색결과')?> (<span style='font-size:18px; color:#b90808;'><?=$card_tatalCnt;?></span> <span style='font-size:18px;'>results in total</span>)
					<?}?>

				</h3>
				<ul class="sub5card_list">
                    <?if($total_count != 0){?>
                    <?$cnt=0; while( $result = sql_fetch_array($row_card) ){ $cnt++;
                        $thumb = get_list_thumbnail("cardbenefit", $result['wr_id'], '178', '',true, true, 'left', false,'80/0.5/3',1);?>
                        <li <?if($cnt%3 == 0) echo 'class="li_margin_r"'; ?> >
                            <div class="sub5card_list_info">


                                <?if($_SESSION['lang'] != "ko_KR"){?>
                                    <?if(  strpos( $result['wr_img_append_'.$_SESSION['lang']], "img src=" ) ){?>
                                        <?=$result['wr_img_append_'.$_SESSION['lang']]?>
                                    <?}else if($thumb['src']){?>
                                        <img src="<?php echo $thumb['src']?>" alt=""/>
                                    <?}else{?>
                                        <img src="/img/default/ktc_cardbenefit_list.png" alt=""/>
                                    <?}?>
                                <?}else{?>
                                    <?if($thumb['src']){?>
                                            <img src="<?php echo $thumb['src']?>" alt=""/>
                                    <?}else{?>
                                        <img src="/img/default/ktc_cardbenefit_list.png" alt=""/>
                                    <?}?>
                                <?}?>



                                <h3>
                                    <?if( $word ){?>
                                        <?if( $result['wr_title_'.$_SESSION['lang']] == ''){?>
                                            <?=$result['wr_subject_'.$_SESSION['lang']]?>   
                                        <?}else{?>
                                            <?=$result['wr_title_'.$_SESSION['lang']]?>   
                                        <?}?>
                                    <?}else{?>
                                        <?=$result['wr_title_'.$_SESSION['lang']]?>   
                                    <?}?>
                                </h3>
                                <p class="sub5card_i">
                                    <? $sql_bene = sql_fetch("select * from g5_board_file where bo_table='cardbenefit' and bf_no=4 and wr_id =".$result['wr_id']." order by bf_no"); 
                                       $sql_bene_cnt = sql_fetch("select count(*) cnt from g5_board_file where bo_table='cardbenefit' and wr_id =".$result['wr_id']); 
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
                                <p class="sub5card_btn">
                                    <a href="/bbs/board.php?bo_table=cardbenefit&wr_id=<?=$result['wr_id']?>&info=benefit&me_code=30&num=2<?=lang_url_a($_SESSION['lang'])?>" target='_blank'><?=_t('자세히보기')?> <span>></span></a>
                                </p><!--3_2-->
                            </div>
                        </li>

                    <?}}else{?>
                        <tr>
                            <p class="sub5_search_false"><?=_t('검색 결과가 없습니다.')?></p>
                        </tr>
                    <?}?>
				</ul>
			</div>

            <?
            $write_pages = get_paging_ktc1(9, $card_page, $card_totalPage, "/bbs/search_ktc.php?word=".$word."&page=".$page.lang_url_a($_SESSION['lang'])); 
            echo $write_pages;
            ?>			

			
	
		</div><!--sub2_2center 끝-->
<!-- } 전체검색 끝 -->



<script>

$(function(){
	$('.sub5card_i').each(function(index){
		$(this).html($(this).text().replace(/\\/g,'<i class="fa fa-krw" style="font-size:12px;" aria-hidden="true"></i>'));
	})
})

</script>