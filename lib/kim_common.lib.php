<?php
if (!defined('_GNUBOARD_')) exit;

function kim_get_paging($write_pages, $cur_page, $total_page, $url, $add="")
{
    //$url = preg_replace('#&amp;page=[0-9]*(&amp;page=)$#', '$1', $url);
    $url = preg_replace('#&amp;page=[0-9]*#', '', $url) . '&amp;page=';

    $str = '';
    //if ($cur_page > 1) {
        $str .= '<li class="page-item"><a href="'.$url.'1'.$add.'" class="page-link pg_page pg_start">처음</a></li>'.PHP_EOL;
    //}

    $start_page = ( ( (int)( ($cur_page - 1 ) / $write_pages ) ) * $write_pages ) + 1;
    $end_page = $start_page + $write_pages - 1;

    if ($end_page >= $total_page) $end_page = $total_page;

    if ($start_page > 1) $str .= '<li class="page-item"><a href="'.$url.($start_page-1).$add.'" class="page-link pg_page pg_prev" aria-label="Previous" ><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>'.PHP_EOL;

    if ($total_page > 1) {
        for ($k=$start_page;$k<=$end_page;$k++) {
            if ($cur_page != $k)
                $str .= '<li class="page-item"><a href="'.$url.$k.$add.'" class="page-link pg_page">'.$k.'</a><li>'.PHP_EOL;
            else
                $str .= '<li class="page-item active"><a href="'.$url.$k.$add.'" class="page-link pg_page">'.$k.'</a><li>'.PHP_EOL;
        }
    }

    if ($total_page > $end_page) $str .= '<li class="page-item"><a href="'.$url.($end_page+1).$add.'" class="page-link pg_page pg_next" aria-label="Next" ><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>'.PHP_EOL;

    //if ($cur_page < $total_page) {
        $str .= '<li class="page-item"><a href="'.$url.$total_page.$add.'" class="page-link pg_page pg_end">맨끝</a></li>'.PHP_EOL;
    //}

    if ($str)
        return "<nav class=\"my-4\"><ul class=\"pagination pagination-circle pg-blue mb-0\">{$str}</ul></nav>";
    else
        return "";
}



function kim_get_skin_path($dir, $skin)
{
    global $config;

    if(preg_match('#^theme/(.+)$#', $skin, $match)) { // 테마에 포함된 스킨이라면
        $theme_path = '';
        $cf_theme = trim($config['cf_theme']);

        $theme_path = G5_PATH.'/'.G5_THEME_DIR.'/'.$cf_theme;
        $skin_path = $theme_path.'/'.G5_SKIN_DIR.'/'.$dir.'/'.$match[1];

    } else {
        $skin_path = G5_SKIN_PATH.'/'.$dir.'/'.$skin;
    }

    return $skin_path;
}






function get_total_visit(){ //총 방문자
    $result = sql_query( " select vs_count from g5_visit_sum " );
    $total = 0;
    while( $row = sql_fetch_array( $result ) ){
        $total += $row['vs_count'];
    }
    return $total;
}

function get_total_visit_today(){ //오늘 방문자
    $result = sql_fetch( " select vs_count from g5_visit_sum where CURRENT_DATE( ) = vs_date " );
    return $result['vs_count'];
}



function get_total_visit_week(){ // 최근 일주일
    $result = sql_query( " select * from g5_visit_sum where date_add(now(), interval -8 day ) < vs_date and current_date() != vs_date  " );
    $total = 0;
    while( $row = sql_fetch_array( $result ) ){
        $total += $row['vs_count'];
    }
    return $total;
}


function get_total_visit_week_sql(){ // 최근 일주일
    $result = sql_query( " select * from g5_visit_sum where date_add(now(), interval -8 day ) < vs_date and current_date() != vs_date  " );
    return $result;
}


function get_total_visit_week_before(){ // 14일전 ~ 7일전
    $result = sql_query( " select * from g5_visit_sum where date_add(now(), interval -8 day ) > vs_date and current_date() != vs_date and date_add(now(), interval -15 day ) < vs_date " );
    $total = 0;
    while( $row = sql_fetch_array( $result ) ){
        $total += $row['vs_count'];
    }
    return $total;
}

function get_total_visit_week_before_per(){
    $week_num_1 = get_total_visit_week();
    $week_num_2 = get_total_visit_week_before();

    $week_num_1 = 900;
    $week_num_2 = 1000;

    $week_gab = ( $week_num_1 - $week_num_2 ) / $week_num_2 * 100;


    return round($week_gab,2);
}



function get_pc_visit_week(){
    require_once (G5_PATH.'/Mobile-Detect/Mobile_Detect.php'); // 모바일 Detect Class 파일
    $detect = new Mobile_Detect;

    $mobile =0;
    $pc = 0;

    $sql = " select * from g5_visit
             where date_add(now(), interval -2 day ) < vi_date and current_date() != vi_date ";
    $result = sql_query($sql);

    while ($row=sql_fetch_array($result)) {

        $detect->setUserAgent($row['vi_agent']);

        if($detect->isMobile() && ! $detect->isTablet()) { $mobile++; }
        else if($detect->isMobile() &&  $detect->isTablet()) { $mobile++; }
        else {
            $pc++;
        }
    }

    return array("pc"=>$pc, "mobile"=>$mobile);
}




function get_pc_visit_week_before(){ // 14일전 ~ 7일전
    $detect = new Mobile_Detect;

    $mobile =0;
    $pc = 0;

    $sql = " select * from g5_visit where date_add(now(), interval -2 day ) > vi_date and current_date() != vi_date and date_add(now(), interval -3 day ) < vi_date ";
    $result = sql_query($sql);

    while ($row=sql_fetch_array($result)) {

        $detect->setUserAgent($row['vi_agent']);

        if($detect->isMobile() && ! $detect->isTablet()) { $mobile++; }
        else if($detect->isMobile() &&  $detect->isTablet()) { $mobile++; }
        else {
            $pc++;
        }
    }

    return array("pc"=>$pc, "mobile"=>$mobile);
}

function get_pc_visit_week_before_per(){
    $week_num_1 = get_pc_visit_week($pc,$mobile);
    $week_num_2 = get_pc_visit_week_before($pc,$mobile);

    if( $week_num_2['pc'] != 0 ){
        $week_gab1 = ( $week_num_1['pc'] - $week_num_2['pc'] ) / $week_num_2['pc'] * 100;
        $week_gab1 = round($week_gab1,2);
    }else{
        $week_gab1 = $week_num_1['pc'] * 100;
    }

    if( $week_num_2['mobile'] != 0 ){
        $week_gab2 = ( $week_num_1['mobile'] - $week_num_2['mobile'] ) / $week_num_2['mobile'] * 100;
        $week_gab2 = round($week_gab2,2);
    }else{
        $week_gab2 = $week_num_1['mobile'] * 100;
    }

    return array("pc"=>$week_gab1, "mobile"=>$week_gab2);
}


function get_join_visit(){
    $sql = " select count(*) cnt from g5_member ";
    $result = sql_fetch($sql);
    return $result['cnt'];
}


function get_join_visit_week(){
    $sql = " select count(*) cnt from g5_member where date_add(now(), interval -8 day ) < mb_datetime and current_date() != mb_datetime ";
    $result = sql_fetch($sql);
    return $result['cnt'];
}



function get_table_week($table){ // 최근 일주일
    $result = sql_fetch( " select count(*) cnt from g5_write_".$table." where date_add(now(), interval -8 day ) < wr_last and current_date() != wr_last  " );

    return $result['cnt'];
}



function get_table_cnt($table){ // 최근 일주일
    $result = sql_fetch( " select bo_count_write from g5_board where bo_table='".$table."'" );

    return $result['bo_count_write'];
}

function get_sideview_admin($mb_id, $name='', $email='', $homepage='')
{
    global $config;
    global $g5;
    global $bo_table, $sca, $is_admin, $member;

    $email_enc = new str_encrypt();
    $email = $email_enc->encrypt($email);
    $homepage = set_http(clean_xss_tags($homepage));

    $name     = get_text($name, 0, true);
    $email    = get_text($email);
    $homepage = get_text($homepage);

    $tmp_name = "";
    if ($mb_id) {
        //$tmp_name = "<a href=\"".G5_BBS_URL."/profile.php?mb_id=".$mb_id."\" class=\"sv_member\" title=\"$name 자기소개\" target=\"_blank\" onclick=\"return false;\">$name</a>";
        $tmp_name = '<a href="'.G5_BBS_URL.'/profile.php?mb_id='.$mb_id.'" class="sv_member" title="'.$name.' 자기소개" target="_blank" onclick="return false;">';

        if ($config['cf_use_member_icon']) {
            $mb_dir = substr($mb_id,0,2);
            $icon_file = G5_DATA_PATH.'/member/'.$mb_dir.'/'.$mb_id.'.gif';

            if (file_exists($icon_file)) {
                $width = $config['cf_member_icon_width'];
                $height = $config['cf_member_icon_height'];
                $icon_file_url = G5_DATA_URL.'/member/'.$mb_dir.'/'.$mb_id.'.gif';
                $tmp_name .= '<img src="'.$icon_file_url.'" width="'.$width.'" height="'.$height.'" alt="">';

                if ($config['cf_use_member_icon'] == 2) // 회원아이콘+이름
                    $tmp_name = $tmp_name.' '.$name;
            } else {
                  $tmp_name = $tmp_name." ".$name;
            }
        } else {
            $tmp_name = $tmp_name.' '.$name;
        }
        $tmp_name .= '</a>';

        $title_mb_id = '['.$mb_id.']';
    } else {
        if(!$bo_table)
            return $name;

        $tmp_name = '<a href="'.G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;sca='.$sca.'&amp;sfl=wr_name,1&amp;stx='.$name.'" title="'.$name.' 이름으로 검색" class="sv_guest" onclick="return false;">'.$name.'</a>';
        $title_mb_id = '[비회원]';
    }

  //  $str = "<span class=\"sv_wrap\">\n";

    $str = '<div class="dropdown">';

    $str .= '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">';
    $str .= $tmp_name;
    $str .= '&nbsp;&nbsp;&nbsp;<span class="caret"></span></button>';

  //  $str .= $tmp_name."\n";

    //$str2 = "<span class=\"sv\">\n";
    $str2 = '<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">';

    if($mb_id)
        $str2 .= "<li><a class='dropdown-item' href=\"".G5_BBS_URL."/memo_form.php?me_recv_mb_id=".$mb_id."\" onclick=\"win_memo(this.href); return false;\"><i class='fa fa-commenting' aria-hidden='true'></i>&nbsp;&nbsp;&nbsp;쪽지보내기</a></li>";
    if($email)
        $str2 .= "<li><a class='dropdown-item' href=\"".G5_BBS_URL."/formmail.php?mb_id=".$mb_id."&amp;name=".urlencode($name)."&amp;email=".$email."\" onclick=\"win_email(this.href); return false;\"><i class='fa fa-envelope' aria-hidden='true'></i>&nbsp;&nbsp;&nbsp;메일보내기</a></li>";
    if($homepage)
        $str2 .= "<li><a class='dropdown-item' href=\"".$homepage."\" target=\"_blank\"><i class='fa fa-home' aria-hidden='true'></i>&nbsp;&nbsp;&nbsp;홈페이지</a></li>";
    if($mb_id)
        $str2 .= "<li><a class='dropdown-item' href=\"".G5_BBS_URL."/profile.php?mb_id=".$mb_id."\" onclick=\"win_profile(this.href); return false;\"><i class='fa fa-user' aria-hidden='true'></i>&nbsp;&nbsp;&nbsp;자기소개</a></li>";
    if($bo_table) {
        if($mb_id)
            $str2 .= "<li><a class='dropdown-item' href=\"".G5_BBS_URL."/board.php?bo_table=".$bo_table."&amp;sca=".$sca."&amp;sfl=mb_id,1&amp;stx=".$mb_id."\"><i class='fa fa-id-card' aria-hidden='true'></i>&nbsp;&nbsp;&nbsp;아이디로 검색</a></li>";
        else
            $str2 .= "<li><a class='dropdown-item' href=\"".G5_BBS_URL."/board.php?bo_table=".$bo_table."&amp;sca=".$sca."&amp;sfl=wr_name,1&amp;stx=".$name."\"><i class='fa fa-search' aria-hidden='true'></i>&nbsp;&nbsp;&nbsp;이름으로 검색</a></li>";
    }
    if($mb_id)
        $str2 .= "<li><a class='dropdown-item' href=\"".G5_BBS_URL."/new.php?mb_id=".$mb_id."\"><i class='fa fa-list' aria-hidden='true'></i>&nbsp;&nbsp;&nbsp;전체게시물</a></li>";
    if($is_admin == "super" && $mb_id) {
        $str2 .= "<li><a class='dropdown-item' href=\"".G5_ADMIN_URL."/member_form.php?w=u&amp;mb_id=".$mb_id."\" target=\"_blank\"><i class='fa fa-refresh' aria-hidden='true'></i>&nbsp;&nbsp;&nbsp;회원정보변경</a></li>";
        $str2 .= "<li><a class='dropdown-item' href=\"".G5_ADMIN_URL."/point_list.php?sfl=mb_id&amp;stx=".$mb_id."\" target=\"_blank\"><i class='fa fa-plus' aria-hidden='true'></i>&nbsp;&nbsp;&nbsp;포인트내역</a></li>";
    }
    $str2 .= "</ul>\n";
    $str .= $str2;
    $str .= "\n<noscript class=\"sv_nojs\">".$str2."</noscript>";

    $str .= "</div>";

    return $str;
}



?>
