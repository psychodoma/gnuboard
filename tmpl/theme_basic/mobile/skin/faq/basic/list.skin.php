<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨

/*
if ($admin_href)
    echo '<div class="faq_admin"><a href="'.$admin_href.'" class="btn_admin">'._t('FAQ 수정').'</a></div>';*/
?>

<!-- FAQ 시작 { -->
<?php

if ($himg_src)
    echo '<div id="faq_himg" class="faq_img"><img src="'.$himg_src.'" alt=""></div>';

// 상단 HTML
echo '<div id="faq_hhtml">'.conv_content($fm['fm_head_html'], 1).'</div>';
?>
<script>
$(function(){
    $('.cate_btn').each(function(){
        var th = $(this);
        th.click(function(){
            $('#cate').attr('value', $(this).attr('valCate'));
            $('#cate_serach').click();
        })
    })
})


</script>
<link rel="stylesheet" href="<?=$faq_skin_url?>/style.css">

<div class='remember_page' valPage='<?=$page?>' valRow='<?=10?>' ></div>
 
<div class="sub3_1area">
    <div class="sub31_tab">	

        <form method='get' class="faq_tabBtn">
            <ul class="FAQTab <?=set_class('FAQTab_us','en_US/ja_JP')?>">
                <li class='cate_btn fap_Tab <?if($cate == "") echo "faq_acv";?>' valCate=''><?=_t('전체')?></li>
                <li class='cate_btn fap_Tab <?if($cate == "코리아투어카드 이용안내") echo "faq_acv";?>' valCate='코리아투어카드 이용안내'><?=_t('이용안내')?></li>
                <li class='cate_btn fap_Tab <?if($cate == "국내관광안내") echo "faq_acv";?>' valCate='국내관광안내'><?=_t('관광안내')?></li>
                <li class='cate_btn fap_Tab <?if($cate == "기타") echo "faq_acv";?>' valCate='기타'><?=_t('기타')?></li>
                <input type='hidden' name='cate' id='cate' value='<?=$cate?>' >
                <input type='hidden' name='info' id='info' value='<?=$info?>' >
                <input type='hidden' name='me_code' id='me_code' value='<?=$me_code?>' >
                <input type='hidden' name='num' id='num' value='<?=$num?>' >
                <input type='submit' id='cate_serach' style='display:none;' >
				<input type='hidden' name='lang' value='<?=lang_url($_SESSION['lang'])?>' >
            </ul>
        </form>

        <div class="tabDetails">
            <div id="tab1" class="tabContents1">

						<div class="sub4_5form_area">
							<div class="sub4_5form">
								
								<form name="fsearchbox" method="get" action="" onsubmit="return fsearchbox_submit(this);" class="">
									<fieldset>
                                        <input type="hidden" name="fm_id" value="<?php echo $fm_id;?>">
                                        <input type="hidden" name="info" value="<?php echo $info;?>">
                                        <input type="hidden" name="me_code" value="<?php echo $me_code;?>">
                                        <input type="hidden" name="num" value="<?php echo $num;?>">
										<input type='hidden' name='lang' value='<?=lang_url($_SESSION['lang'])?>' >
										<label for="sch_stx" class="sound_only hide">검색어<strong class="sound_only"> 필수</strong></label>

										<ul>
											<li class="search45_input">
												<label for="" class="hide">검색창</label>
												<input type="text" class="sub45_bar" name="stx" id="sch_stx" value='<?=$stx?>' maxlength="" placeholder="<?=_t('검색어를 입력하세요.')?>">
											</li>

											<li class="search45_btn">
												<input type="image" class="syb21_loginbtn" id="sch_submit" src="/img/mobile/main/search.png" alt="검색" title="검색" />
											</li>
										</ul>
								   
										<script>
											function fsearchbox_submit(f)
											{
												if (f.stx.value.length < 2) {
													alert("<?=_t('검색어는 두글자 이상 입력하십시오.')?>");
													f.stx.select();
													f.stx.focus();
													return false;
												}

												// 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
												var cnt = 0;
												for (var i=0; i<f.stx.value.length; i++) {
													if (f.stx.value.charAt(i) == ' ')
														cnt++;
												}

												if (cnt > 1) {
													alert("<?php echo _t('빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.'); ?>");
													f.stx.select();
													f.stx.focus();
													return false;
												}

												return true;
											}
										</script>
									</fieldset>
								</form>

							</div><!-- sub4_5form 끝 -->
						</div><!-- sub4_5form_area 끝 -->

						


               
        <?php // FAQ 내용
        if( count($faq_list) ){
        ?>   
            <div class="sub45_storeChoi">

                <?php
                foreach($faq_list as $key=>$v){
                    if(empty($v))
                        continue;
                ?>


				<div class="sub4_5info_area">
                                   
                    <div class="sub45_info" style='background-image: url("/img/mobile/sub/sub4/sub4_5/sub41_arrow2.png")'>
                        <h3>[<?echo _t(conv_content($v['fa_cate'], 1));?>]</h3>
						
						<!--
                        <p class="sub45_info_q">
							<span><img src="/img/mobile/sub/sub4/sub4_5/faq_q.jpg" alt="질문"/></span>
							<?php echo conv_content($v['fa_subject'], 1);?>
						</p>
						-->
						<table>
							<tr>
								<td style="padding-right:7px; width:23px; vertical-align: top;"><img src="/img/mobile/sub/sub4/sub4_5/faq_q.jpg" alt="질문"/></td>
								<td><?php echo conv_content($v['fa_subject'], 1);?></td>
							</tr>
						</table>

                        <p class="sub45_info_date"><?=substr($v['wr_datetime'],0,10);?></p>
                    </div>
                   
                    <div class="sub45_a">
                        <div class="sub45_a_area">
                            <table>
                                <tr>
                                    <td style="padding-right:7px; vertical-align: top;"><img src="/img/mobile/sub/sub4/sub4_5/faq_a.jpg" alt="답변"/></td>
                                    <td><?php echo conv_content($v['fa_content'], 1); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>               
                   
                </div>


                <?php
                }
                ?>
        <?php

        } else {
            if($stx){
                echo '<p class="empty_list" style="text-align: center; font-size: 15px; color: #868686; padding: 10% 0;">'._t('검색된 게시물이 없습니다.').'</p>';
            } else {
                echo '<div class="empty_list" style="font-size: 20px; text-align: center; padding: 80px 0; color: #888;">'._t('등록된 FAQ가 없습니다.');
                if($is_admin)
                    //echo '<br><a href="'.G5_ADMIN_URL.'/faqmasterlist.php">'._t('FAQ를 새로 등록하시려면').' '._t('FAQ관리').'</a> '._t('메뉴를 이용하십시오.');
                echo '</div>';
            }
        }
        ?>
        
                <?if($total_count > 10){?>
                <div class="subMore_btn" style='padding-top:30px;'>
                    <div class="subMore_btn_area">
                        <a>
                            <p class="subMore_icon"></p>
                            <?if( $total_count < 10 ){
                                $total_count_view = 10;
                            }else{
                                $total_count_view = $total_count;
                            }
                            ?>
                            <p class="subMore_info">(<?=($page-1)*10 + count($faq_list)?> / <?=$total_count?>)</p>
                        </a>
                    </div>
                </div>
                <?}?>

            </div>
    


</div>

<?if( $total_count >= 10 ){?>
<script type="text/javascript">

$(function(){

    $('.subMore_btn_area a').click(function(){
		$(this).html('<div style="padding-top:10px;" ><i class="fa fa-spinner fa-spin fa-2x fa-fw "></i><span class="sr-only">Loading...</span></div>');
		$('.subMore_btn_area a').unbind('click');
        $.ajax({
            url: "/bbs/ajax.listadd_faq.php",
            data: {
                    'page': $('.remember_page').attr('valPage'),
                    'page_rows': '10',
                    'info': '<?=$info?>',
                    'me_code': '<?=$me_code?>',
                    'num': '<?=$num?>',
                    'cate': '<?=$cate?>',
                    'stx': '<?=$stx?>',
					'fm_id': '<?=$fm_id?>'
                  },
            success:function(data){
                $('.subMore_btn').remove();
                var page_num = parseInt($('.remember_page').attr('valPage'))+1;
                var page_row = parseInt($('.remember_page').attr('valRow'));
                $('.sub45_storeChoi').append(data);
                $('.remember_page').attr('valPage',page_num);
                
            }
        })
    })

})


</script>

<?}?>

<script type="text/javascript">

    $(document).ready(function(){

        $(".sub45_info").click(function(){
            var thisel = $(this).parent().find(".sub45_a").css("display");
                $(".sub45_info").each(function(){
                    var thatel = $(this).parent().find(".sub45_a").css("display");
                    if(thisel != thatel){
                    $(this).parent().find(".sub45_a").hide();
                    }
                });
                $(this).parent().find(".sub45_a").slideToggle("");			

            return false;
        });



        $(".sub45_info").click(function(){
            var ck = $(this).hasClass('sub45_active1');
            
            var class_name = $(this).attr("class"); 
            var class_name_arr = class_name.split(" ");
            var menu_number = class_name_arr[0];
            $("#" + menu_number).slideToggle();
            

            $('.sub45_active1').each(function(){
                $(this).removeClass("sub45_active1");
                //$(this).toggleClass("naviClick").siblings("#navigation .navigation_list li.b_sub .drop").removeClass("naviClick");
            })
                    
            $(this).toggleClass("sub45_active1").siblings(".sub45_info").removeClass("sub45_active1");

            if(ck){
                $('.sub45_info').each(function(){
                    $(this).removeClass("sub45_active1");
                    //$(this).toggleClass("naviClick").siblings("#navigation .navigation_list li.b_sub .drop").removeClass("naviClick");
                })	
            }

        });


    });

</script>


<?php
// 하단 HTML
echo '<div id="faq_thtml">'.conv_content($fm['fm_tail_html'], 1).'</div>';

if ($timg_src)
    echo '<div id="faq_timg" class="faq_img"><img src="'.$timg_src.'" alt=""></div>';
?>


<!-- } FAQ 끝 -->


<!--
<?php
if ($admin_href)
    echo '<div class="faq_admin"><a href="'.$admin_href.'" class="btn_admin">'._t('FAQ 수정').'</a></div>';
?>
-->


<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!--
<script>
$(function() {
    $(".closer_btn").on("click", function() {
        $(this).closest(".con_inner").slideToggle();
    });
});

function faq_open(el)
{
    var $con = $(el).closest("li").find(".con_inner");

    if($con.is(":visible")) {
        $con.slideUp();
    } else {
        $("#faq_con .con_inner:visible").css("display", "none");

        $con.slideDown(
            function() {
                // 이미지 리사이즈
                $con.viewimageresize2();
            }
        );
    }

    return false;
}
</script>
-->

