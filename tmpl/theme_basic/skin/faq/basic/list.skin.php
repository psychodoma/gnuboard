<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


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



<div class="sub2_2center">
    <div class="sub2_1form_area">
        <div class="sub4_5form">
            <form name="faq_search_form" method="get" onsubmit="return fsearchbox_submit(this);" >
                <input type="hidden" name="fm_id" value="<?php echo $fm_id;?>">
                <input type="hidden" name="info" value="<?php echo $info;?>">
                <input type="hidden" name="me_code" value="<?php echo $me_code;?>">
                <input type="hidden" name="num" value="<?php echo $num;?>">
				<input type="hidden" name="cate" value="<?php echo $cate;?>">
				<input type='hidden' name='lang' value='<?=lang_url($_SESSION['lang'])?>'>
                <fieldset>
                    <ul>
                        <li class="input">
                            <label for="" class="hide">검색창</label>
                            <input type="text" name="stx" value="<?php echo $stx;?>"  id="stx" class="frm_input required" size="15" maxlength="15" placeholder="<?=_t('검색어를 입력하세요.')?>">
                        </li>

                        <li class="btn">
                            <input type="submit" value="<?php echo _t('검색'); ?>" class="btn_submit">
                        </li>
                    </ul>
                </fieldset>
            </form>


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


        </div>   
    </div>
	
	 
	

    <form method='get' class="faq_tabBtn">
        <div class='cate_btn fap_Tab <?if($cate == "") echo "faq_acv";?>' valCate=''><?=_t('전체')?></div>
        <div class='cate_btn fap_Tab <?if($cate == "코리아투어카드 이용안내") echo "faq_acv";?>' valCate='코리아투어카드 이용안내'><?=_t('코리아투어카드 이용안내')?></div>
        <div class='cate_btn fap_Tab <?if($cate == "국내관광안내") echo "faq_acv";?>' valCate='국내관광안내'><?=_t('국내관광안내')?></div>
        <div class='cate_btn fap_Tab <?if($cate == "기타") echo "faq_acv";?>' valCate='기타'><?=_t('기타')?></div>
        <input type='hidden' name='cate' id='cate' value='<?=$cate?>' >
        <input type='hidden' name='info' id='info' value='<?=$info?>' >
        <input type='hidden' name='me_code' id='me_code' value='<?=$me_code?>' >
        <input type='hidden' name='num' id='num' value='<?=$num?>' >
		<input type='hidden' name='lang' value='<?=lang_url($_SESSION['lang'])?>'>
        <input type='submit' id='cate_serach' style='display:none;' >
    </form>


	<div class="faq_top">
		<p class="faq_top_1"><?=_t('구분')?></p>
		<p class="faq_top_2"><?=_t('내용')?></p>
	</div>
	
        <?php // FAQ 내용
        if( count($faq_list) ){
        ?>   
            <ul class="faq_area">

                <?php
                foreach($faq_list as $key=>$v){
                    if(empty($v))
                        continue;
                ?>
				<li>
                    <div class="faq_q">
                        <h3 class="faq_q_list"><?echo _t(conv_content($v['fa_cate'], 1));?></h3>
                        <div class="faq_q_qusetion faq_acv">

							<table>
								<tr>
									<td style="vertical-align:top; width:30px;"><span class="faq_a_icon"><img src="/img/sub/sub4/sub4_5/faq_q.jpg" alt="질문Q"/></span></td>
									<td style="width:620px;"><a href="#none" onclick="return faq_open(this);"><?php echo conv_content($v['fa_subject'], 1);?></a></td>
								</tr>
							</table> 

                        </div>
                        <!--<p class="faq_q_icon"><img src="/img/sub/sub4/sub4_5/faq_arw.jpg" alt="화살"/></p>-->
                    </div>

                    <div class="con_inner faq_a" style='display:none;'>
                        <table class="faq_aTable">
                            <tr>
                                <td width="205px;"></td>
                                <td width="35px;" class="faq_aTable_icon"><img src="/img/sub/sub4/sub4_5/faq_a.jpg" alt="답변A"/></td>
                                <td class="faq_aTable_ans">
                                    <p>
                                    <?php echo conv_content($v['fa_content'], 1); ?>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </li>


                <?php
                }
                ?>








            </ul>
        <?php

        } else {
            if($stx){
                echo '<p class="sub5_search_false">'._t('검색 결과가 없습니다.').'</p>';
            } else {
                echo '<p class="sub5_search_false">'._t('게시물이 없습니다.');
                if($is_admin)
                  //  echo '<br><a href="'.G5_ADMIN_URL.'/faqmasterlist.php">'._t('FAQ를 새로 등록하시려면').' '._t('FAQ관리').'</a> '._t('메뉴를 이용하십시오.');
                echo '</p>';
            }
        }
        ?>

    

<?php 
$write_pages = get_paging_ktc($config[cf_write_pages], $page, $total_page, "./faq.php?&info=".$info."&page=","&me_code=".$me_code."&num=".$num."&cate=".$cate.lang_url_a($_SESSION['lang']));
echo $write_pages; 
?>


</div>





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



<script type="text/javascript">

	$(document).ready(function(){

		$(".faq_q").click(function(){
			var thisel = $(this).parent().find(".con_inner").css("display");
				$(".faq_q").each(function(){
					var thatel = $(this).parent().find(".con_inner").css("display");
					if(thisel != thatel){
					$(this).parent().find(".con_inner").hide();
					}
				});
				$(this).parent().find(".con_inner").slideToggle("");			

			return false;
		});



		$(".faq_q").click(function(){
			var ck = $(this).hasClass('faq_q_act');
			
			var class_name = $(this).attr("class"); 
			var class_name_arr = class_name.split(" ");
			var menu_number = class_name_arr[0];
			$("#" + menu_number).slideToggle();
			

			$('.faq_q_act').each(function(){
				$(this).removeClass("faq_q_act");
			})
					
			$(this).toggleClass("faq_q_act").siblings(".faq_q").removeClass("faq_q_act");

			if(ck){
				$('.faq_q').each(function(){
					$(this).removeClass("faq_q_act");
				})	
			}

		});


	});

</script>
