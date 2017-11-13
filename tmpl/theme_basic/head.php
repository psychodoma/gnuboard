<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가




if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/head.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/shop.head.php');
    return;
}

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/banner.lib.php');

?>


<div class="logo_search">
    <h1><a href="/<?=lang_url($_SESSION['lang'])?>" class="logo"><img src="/img/main/logo_<?=substr(strtolower($g5['lang']),-2,2)?>.png"/></a></h1>
    
        
        <form name="fsearchbox" method="get" action="<?php echo G5_BBS_URL ?>/search_ktc.php" onsubmit="return fsearchbox_submit(this);">
            <fieldset>
                <input type="hidden" name="page" value=1 >
                <input type="hidden" name="card_page" value=1 >
				<input type="hidden" name="lang" value="<?=lang_url($_SESSION['lang'])?>" >
                <label for="sch_stx" class="sound_only hide"><?php echo _t('검색어'); ?><strong class="sound_only"> <?php echo _t('필수'); ?></strong></label>
               
				<ul id="search">
					<li class="search_input">
						<label for="" class="hide">검색창</label>
						<input type="text" class="searchbar" name="word" id="sch_stx" maxlength="" placeholder="<?=_t('검색')?>">
					</li>

					<li class="search_btn">
						<input type="image" class="loginbtn" id="sch_submit" src="/img/main/serach_btn.jpg"  title="검색" />
					</li>
				</ul>
               
               
<!--               
               
                <input type="text" name="stx" id="sch_stx" maxlength="20">
                <input type="submit" id="sch_submit" value="<?php echo _t('검색'); ?>">-->
            </fieldset>
        </form>

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
                    f.stx.select();
                    f.stx.focus();
                    return false;
                }

                return true;
            }
            </script>
         
</div>

<style>
	.bxslider li {	display: none; }

    .bxslider li:first-child {
      display: block;
    }
</style>

<div class="main_slide">
	<!--<ul class="bxslider" >
		<li style="min-width: 1270px;"><img src="/img/main/main_visual1.jpg" style="width:100%;" alt="메인1"/></li>
		<li style="min-width: 1270px;"><img src="/img/main/main_visual2.jpg" style="width:100%;" alt="메인2"/></li>
		<li style="min-width: 1270px;"><img src="/img/main/main_visual3.jpg" style="width:100%;" alt="메인3"/></li>
	</ul>
	-->
	<?php echo display_banner('mv1', 'main_visual.skin.php'); ?>
</div>




<div class="navi">
    <ul>
        <?php
        $sql = " select *
                    from {$g5['menu_table']}
                    where me_use = '1'
                        and length(me_code) = '2'
                    order by me_order, me_id ";
        $result = sql_query($sql, false);
        $gnb_zindex = 999; // gnb_1dli z-index 값 설정용
        for ($i=0; $row=sql_fetch_array($result); $i++) {
            $j = $i+1;
            if(preg_match('|/'.G5_SHOP_DIR.'|', $row['me_link'])) continue;
            if(!preg_match('|^http://|', $row['me_link'])) $row['me_link'] = G5_URL.$row['me_link'];
            $_SESSION['me_code'.$row['me_code']] = $row['me_code'];
            $_SESSION['me_id'.$row['me_code']] = $row['me_id'];
            $_SESSION['me_name'.$row['me_code']] = $row['me_name'];
        ?>
        <li class="icon<?=$j?>">
            <a href="<?php echo $row['me_link']."&info=".$row['me_url']."&me_code=".$row['me_code']."&num=".$i ?><?=lang_url_a($_SESSION['lang'])?>" target="_<?php echo $row['me_target']; ?>" ><img src="/img/main/navi<?=$i+1?>.png" /><?php echo _t($row['me_name']) ?></a>
            <?php
            // $sql2 = " select *
            //             from {$g5['menu_table']}
            //             where me_use = '1'
            //                 and length(me_code) = '4'
            //                 and substring(me_code, 1, 2) = '{$row['me_code']}'
            //             order by me_order, me_id ";
           // $result2 = sql_query($sql2);

            for ($k=0; $row2=sql_fetch_array($result2); $k++) {
                if(preg_match('|/'.G5_SHOP_DIR.'|', $row2['me_link'])) continue;
                if(!preg_match('|^http://|', $row2['me_link'])) $row2['me_link'] = G5_URL.$row2['me_link'];
                if($k == 0)
                    echo '<ul class="gnb_2dul">'.PHP_EOL;
            ?>
                <li class="gnb_2dli"><a href="<?php echo $row2['me_link']; ?><?=lang_url_a($_SESSION['lang'])?>" target="_<?php echo $row2['me_target']; ?>" class="gnb_2da"><?php echo _t($row2['me_name']) ?></a></li>
            <?php
            }

            if($k > 0)
                echo '</ul>'.PHP_EOL;
            ?>
        </li>
        <?php
        }

        if ($i == 0) {  ?>
            <li id="gnb_empty"><?php echo _t('메뉴 준비 중입니다.'); ?><?php if ($is_admin) { ?> <br><a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php"><?php echo _t('관리자모드'); ?> &gt; <?php echo _t('환경설정'); ?> &gt; <?php echo _t('메뉴설정'); ?></a><?php echo _t('에서 설정하실 수 있습니다.'); ?><?php } ?></li>
        <?php } ?>
    </ul>
</div>






<!-- 콘텐츠 시작 { -->

 
