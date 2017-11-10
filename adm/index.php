<?php
include_once('./_common.php');

$g5['title'] = '관리자메인';
include_once ('./admin.head.php');

$new_member_rows = 5;
$new_point_rows = 5;
$new_write_rows = 5;

$sql_common = " from {$g5['member_table']} ";

$sql_search = " where (1) ";

if ($is_admin != 'super')
    $sql_search .= " and mb_level <= '{$member['mb_level']}' ";

if (!$sst) {
    $sst = "mb_datetime";
    $sod = "desc";
}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

// 탈퇴회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and mb_leave_date <> '' {$sql_order} ";
$row = sql_fetch($sql);
$leave_count = $row['cnt'];

// 차단회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and mb_intercept_date <> '' {$sql_order} ";
$row = sql_fetch($sql);
$intercept_count = $row['cnt'];

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$new_member_rows} ";
$result = sql_query($sql);

$colspan = 12;

?>

<!-- <section>
    <h2>신규가입회원 <?php echo $new_member_rows ?>건 목록</h2>
    <div class="local_desc02 local_desc">
        총회원수 <?php echo number_format($total_count) ?>명 중 차단 <?php echo number_format($intercept_count) ?>명, 탈퇴 : <?php echo number_format($leave_count) ?>명
    </div>

    <div class="tbl_head01 tbl_wrap">
        <table>
        <caption>신규가입회원</caption>
        <thead>
        <tr>
            <th scope="col">회원아이디</th>
            <th scope="col">이름</th>
            <th scope="col">닉네임</th>
            <th scope="col">권한</th>
            <th scope="col">포인트</th>
            <th scope="col">수신</th>
            <th scope="col">공개</th>
            <th scope="col">인증</th>
            <th scope="col">차단</th>
            <th scope="col">그룹</th>
        </tr>
        </thead>
        <tbody>
        <?php
        for ($i=0; $row=sql_fetch_array($result); $i++)
        {
            // 접근가능한 그룹수
            $sql2 = " select count(*) as cnt from {$g5['group_member_table']} where mb_id = '{$row['mb_id']}' ";
            $row2 = sql_fetch($sql2);
            $group = "";
            if ($row2['cnt'])
                $group = '<a href="./boardgroupmember_form.php?mb_id='.$row['mb_id'].'">'.$row2['cnt'].'</a>';

            if ($is_admin == 'group')
            {
                $s_mod = '';
                $s_del = '';
            }
            else
            {
                $s_mod = '<a href="./member_form.php?$qstr&amp;w=u&amp;mb_id='.$row['mb_id'].'">수정</a>';
                $s_del = '<a href="./member_delete.php?'.$qstr.'&amp;w=d&amp;mb_id='.$row['mb_id'].'&amp;url='.$_SERVER['SCRIPT_NAME'].'" onclick="return delete_confirm(this);">삭제</a>';
            }
            $s_grp = '<a href="./boardgroupmember_form.php?mb_id='.$row['mb_id'].'">그룹</a>';

            $leave_date = $row['mb_leave_date'] ? $row['mb_leave_date'] : date("Ymd", G5_SERVER_TIME);
            $intercept_date = $row['mb_intercept_date'] ? $row['mb_intercept_date'] : date("Ymd", G5_SERVER_TIME);

            $mb_nick = get_sideview($row['mb_id'], get_text($row['mb_nick']), $row['mb_email'], $row['mb_homepage']);

            $mb_id = $row['mb_id'];
            if ($row['mb_leave_date'])
                $mb_id = $mb_id;
            else if ($row['mb_intercept_date'])
                $mb_id = $mb_id;

        ?>
        <tr>
            <td class="td_mbid"><?php echo $mb_id ?></td>
            <td class="td_mbname"><?php echo get_text($row['mb_name']); ?></td>
            <td class="td_mbname sv_use"><div><?php echo $mb_nick ?></div></td>
            <td class="td_num"><?php echo $row['mb_level'] ?></td>
            <td><a href="./point_list.php?sfl=mb_id&amp;stx=<?php echo $row['mb_id'] ?>"><?php echo number_format($row['mb_point']) ?></a></td>
            <td class="td_boolean"><?php echo $row['mb_mailling']?'예':'아니오'; ?></td>
            <td class="td_boolean"><?php echo $row['mb_open']?'예':'아니오'; ?></td>
            <td class="td_boolean"><?php echo preg_match('/[1-9]/', $row['mb_email_certify'])?'예':'아니오'; ?></td>
            <td class="td_boolean"><?php echo $row['mb_intercept_date']?'예':'아니오'; ?></td>
            <td class="td_category"><?php echo $group ?></td>
        </tr>
        <?php
            }
        if ($i == 0)
            echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
        ?>
        </tbody>
        </table>
    </div>

    <div class="btn_list03 btn_list">
        <a href="./member_list.php">회원 전체보기</a>
    </div>

</section> -->

<?php
$sql_common = " from {$g5['board_new_table']} a, {$g5['board_table']} b, {$g5['group_table']} c where a.bo_table = b.bo_table and b.gr_id = c.gr_id ";

if ($gr_id)
    $sql_common .= " and b.gr_id = '$gr_id' ";
if ($view) {
    if ($view == 'w')
        $sql_common .= " and a.wr_id = a.wr_parent ";
    else if ($view == 'c')
        $sql_common .= " and a.wr_id <> a.wr_parent ";
}
$sql_order = " order by a.bn_id desc ";

$sql = " select count(*) as cnt {$sql_common} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$colspan = 5;
?>

<!-- <section>
    <h2>최근게시물</h2>

    <div class="tbl_head01 tbl_wrap">
        <table>
        <caption>최근게시물</caption>
        <thead>
        <tr>
            <th scope="col">그룹</th>
            <th scope="col">게시판</th>
            <th scope="col">제목</th>
            <th scope="col">이름</th>
            <th scope="col">일시</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = " select a.*, b.bo_subject, c.gr_subject, c.gr_id {$sql_common} {$sql_order} limit {$new_write_rows} ";
        $result = sql_query($sql);
        for ($i=0; $row=sql_fetch_array($result); $i++)
        {
            $tmp_write_table = $g5['write_prefix'] . $row['bo_table'];

            if ($row['wr_id'] == $row['wr_parent']) // 원글
            {
                $comment = "";
                $comment_link = "";
                $row2 = sql_fetch(" select * from $tmp_write_table where wr_id = '{$row['wr_id']}' ");

                $name = get_sideview($row2['mb_id'], get_text(cut_str($row2['wr_name'], $config['cf_cut_name'])), $row2['wr_email'], $row2['wr_homepage']);
                // 당일인 경우 시간으로 표시함
                $datetime = substr($row2['wr_datetime'],0,10);
                $datetime2 = $row2['wr_datetime'];
                if ($datetime == G5_TIME_YMD)
                    $datetime2 = substr($datetime2,11,5);
                else
                    $datetime2 = substr($datetime2,5,5);

            }
            else // 코멘트
            {
                $comment = '댓글. ';
                $comment_link = '#c_'.$row['wr_id'];
                $row2 = sql_fetch(" select * from {$tmp_write_table} where wr_id = '{$row['wr_parent']}' ");
                $row3 = sql_fetch(" select mb_id, wr_name, wr_email, wr_homepage, wr_datetime from {$tmp_write_table} where wr_id = '{$row['wr_id']}' ");

                $name = get_sideview($row3['mb_id'], get_text(cut_str($row3['wr_name'], $config['cf_cut_name'])), $row3['wr_email'], $row3['wr_homepage']);
                // 당일인 경우 시간으로 표시함
                $datetime = substr($row3['wr_datetime'],0,10);
                $datetime2 = $row3['wr_datetime'];
                if ($datetime == G5_TIME_YMD)
                    $datetime2 = substr($datetime2,11,5);
                else
                    $datetime2 = substr($datetime2,5,5);
            }
        ?>

        <tr>
            <td class="td_category"><a href="<?php echo G5_BBS_URL ?>/new.php?gr_id=<?php echo $row['gr_id'] ?>"><?php echo cut_str($row['gr_subject'],10) ?></a></td>
            <td class="td_category"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $row['bo_table'] ?>"><?php echo cut_str($row['bo_subject'],20) ?></a></td>
            <td><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $row['bo_table'] ?>&amp;wr_id=<?php echo $row2['wr_id'] ?><?php echo $comment_link ?>"><?php echo $comment ?><?php echo conv_subject($row2['wr_subject'], 100) ?></a></td>
            <td class="td_mbname"><div><?php echo $name ?></div></td>
            <td class="td_datetime"><?php echo $datetime ?></td>
        </tr>

        <?php
        }
        if ($i == 0)
            echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
        ?>
        </tbody>
        </table>
    </div>

    <div class="btn_list03 btn_list">
        <a href="<?php echo G5_BBS_URL ?>/new.php">최근게시물 더보기</a>
    </div>
</section> -->

<?php
$sql_common = " from {$g5['point_table']} ";
$sql_search = " where (1) ";
$sql_order = " order by po_id desc ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$new_point_rows} ";
$result = sql_query($sql);

$colspan = 7;
?>













































<!-- <section>
    <h2>최근 포인트 발생내역</h2>
    <div class="local_desc02 local_desc">
        전체 <?php echo number_format($total_count) ?> 건 중 <?php echo $new_point_rows ?>건 목록
    </div>

    <div class="tbl_head01 tbl_wrap">
        <table>
        <caption>최근 포인트 발생내역</caption>
        <thead>
        <tr>
            <th scope="col">회원아이디</th>
            <th scope="col">이름</th>
            <th scope="col">닉네임</th>
            <th scope="col">일시</th>
            <th scope="col">포인트 내용</th>
            <th scope="col">포인트</th>
            <th scope="col">포인트합</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $row2['mb_id'] = '';
        for ($i=0; $row=sql_fetch_array($result); $i++)
        {
            if ($row2['mb_id'] != $row['mb_id'])
            {
                $sql2 = " select mb_id, mb_name, mb_nick, mb_email, mb_homepage, mb_point from {$g5['member_table']} where mb_id = '{$row['mb_id']}' ";
                $row2 = sql_fetch($sql2);
            }

            $mb_nick = get_sideview($row['mb_id'], $row2['mb_nick'], $row2['mb_email'], $row2['mb_homepage']);

            $link1 = $link2 = "";
            if (!preg_match("/^\@/", $row['po_rel_table']) && $row['po_rel_table'])
            {
                $link1 = '<a href="'.G5_BBS_URL.'/board.php?bo_table='.$row['po_rel_table'].'&amp;wr_id='.$row['po_rel_id'].'" target="_blank">';
                $link2 = '</a>';
            }
        ?>

        <tr>
            <td class="td_mbid"><a href="./point_list.php?sfl=mb_id&amp;stx=<?php echo $row['mb_id'] ?>"><?php echo $row['mb_id'] ?></a></td>
            <td class="td_mbname"><?php echo get_text($row2['mb_name']); ?></td>
            <td class="td_name sv_use"><div><?php echo $mb_nick ?></div></td>
            <td class="td_datetime"><?php echo $row['po_datetime'] ?></td>
            <td><?php echo $link1.$row['po_content'].$link2 ?></td>
            <td class="td_numbig"><?php echo number_format($row['po_point']) ?></td>
            <td class="td_numbig"><?php echo number_format($row['po_mb_point']) ?></td>
        </tr>

        <?php
        }

        if ($i == 0)
            echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
        ?>
        </tbody>
        </table>
    </div>

    <div class="btn_list03 btn_list">
        <a href="./point_list.php">포인트내역 전체보기</a>
    </div>
</section> -->














































        <!-- page content -->
        <?//$pc_mobile = get_pc_visit_week($pc,$mobile);?>
        <?//$pc_mobile_per = get_pc_visit_week_before_per($pc,$mobile);?>

        <div class="right_col" role="main">
          <!-- top tiles -->
          <div class="row tile_count">


            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> 총 방문자</span>
              <div class="count"><?=number_format(get_total_visit())?></div>
              <span class="count_bottom">오늘 방문자 <i class="green"><?=number_format(get_total_visit_today())?>명 </i></span>
            </div>
           
  


            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> 최근 일주일 방문자</span>
              <div class="count"><?=number_format(get_total_visit_week())?></div>
                <?if(  get_total_visit_week_before_per() > 0 ){?>
                  <span class="count_bottom">지난 주보다&nbsp;&nbsp;&nbsp;<i class="green"><i class="fa fa-sort-asc"></i>
                <?}else if( get_total_visit_week_before_per() < 0 ){?>
                  <span class="count_bottom">지난 주보다&nbsp;&nbsp;&nbsp;<i class="red"><i class="fa fa-sort-desc"></i>
                <?}else{?>
                  <span class="count_bottom">지난 주보다&nbsp;&nbsp;&nbsp;<i class="gray"><i class="fa fa-minus"></i>
                <?}?>
                <?=get_total_visit_week_before_per()?>% </i></span>
            </div>


            <!-- <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-desktop"></i> 어제 PC 접속자</span>
              <div class="count green"><?=$pc_mobile['pc']?></div>
                <?if(  $pc_mobile_per['pc'] > 0 ){?>
                  <span class="count_bottom">지난 주보다&nbsp;&nbsp;&nbsp;<i class="green"><i class="fa fa-sort-asc"></i>
                <?}else if( $pc_mobile_per['pc'] < 0 ){?>
                  <span class="count_bottom">지난 주보다&nbsp;&nbsp;&nbsp;<i class="red"><i class="fa fa-sort-desc"></i>
                <?}else{?>
                  <span class="count_bottom">지난 주보다&nbsp;&nbsp;&nbsp;<i class="gray"><i class="fa fa-minus"></i>
                <?}?>
                <?=$pc_mobile_per['pc']?>% </i></span>
            </div>


            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-mobile fa-lg"></i> 어제 모바일 접속자</span>
              <div class="count"><?=$pc_mobile['mobile']?></div>
                <?if(  $pc_mobile_per['mobile'] > 0 ){?>
                  <span class="count_bottom">지난 주보다&nbsp;&nbsp;&nbsp;<i class="green"><i class="fa fa-sort-asc"></i>
                <?}else if( $pc_mobile_per['mobile'] < 0 ){?>
                  <span class="count_bottom">지난 주보다&nbsp;&nbsp;&nbsp;<i class="red"><i class="fa fa-sort-desc"></i>
                <?}else{?>
                  <span class="count_bottom">지난 주보다&nbsp;&nbsp;&nbsp;<i class="gray"><i class="fa fa-minus"></i>
                <?}?>
                <?=$pc_mobile_per['mobile']?>% </i></span>
            </div> -->


            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-users"></i> 총 회원</span>
              <div class="count"><?=number_format(get_join_visit())?></div>
              <span class="count_bottom">일주일간 가입한 회원 <i class="green"> <?=get_join_visit_week()?>명</i></span>
            </div>


            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-table"></i> 총 공지사항</span>
              <div class="count"> <?=get_table_cnt('notice')?></div>
              <span class="count_bottom">일주일간 작성된 글 <i class="green"><?=get_table_week('notice')?>개</i></span>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-table"></i> 총 이벤트</span>
              <div class="count"> <?=get_table_cnt('event')?></div>
              <span class="count_bottom">일주일간 작성된 글 <i class="green"><?=get_table_week('event')?>개</i></span>
            </div>


          </div>
          <!-- /top tiles -->



          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="dashboard_graph">

                <div class="row x_title">
                  <div class="col-md-12">
                    <h3>방문자 통계 그래프<small> 사이트를 방문한 사용자 그래프</small></h3>
                  </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?include_once('/chart1.php')?>
                </div>
                
                <div class="clearfix"></div>
              </div>
            </div>

          </div>
          <br />

          <div class="row">



            <?
            //if (empty($fr_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date) ) $fr_date = G5_TIME_YMD;
            //if (empty($to_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date) ) $to_date = G5_TIME_YMD;

            //$qstr = "fr_date={$fr_date}{&amp;to_date}={$to_date}";

            $sql_common = " from {$g5['popular_table']} a ";
            $sql_search = " where trim(pp_word) <> '' ";
            $sql_group = " group by pp_word ";
            $sql_order = " order by cnt desc ";

            $sql = " select pp_word {$sql_common} {$sql_search} {$sql_group} ";
            $result = sql_query($sql);
            $total_count = sql_num_rows($result);

            $rows = $config['cf_page_rows'];
            $total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
            if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
            $from_record = ($page - 1) * $rows; // 시작 열을 구함

            $sql = " select pp_word, count(*) as cnt {$sql_common} {$sql_search} {$sql_group} {$sql_order} limit {$from_record}, 5 ";
            $result = sql_query($sql);
            $result1 = sql_query($sql);
            
            for ($i=0; $row=sql_fetch_array($result1); $i++) {
              $total_cnts += $row['cnt'];
            }
            ?>




            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="x_panel tile fixed_height_320">
                <div class="x_title">
                  <h2>인기 검색어</h2>
                  <ul class="nav navbar-right panel_toolbox">
                  <li style='float:right;'><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                    <li style='float:right;'><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <h4>검색어 Top 5</h4>

                  <?php
                      for ($i=0; $row=sql_fetch_array($result); $i++) {

                          $word = get_text($row['pp_word']);
                          $rank = ($i + 1 + ($rows * ($page - 1)));

                          $rate = 100 * $row['cnt'] / $total_cnts;

                  ?>

                  <div class="widget_summary">
                    <div class="w_left w_25">
                      <span style="font-size:14px;" ><?php echo $word ?></span>
                    </div>
                    <div class="w_center w_55">
                      <div class="progress">
                        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?=$rate?>%;">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </div>
                    <div class="w_right w_20">
                      <span style="font-size:15px;" ><?php echo $row['cnt'] ?>건</span>
                    </div>
                    <div class="clearfix"></div>
                  </div>

                  <?php
                  }
                  ?>

                </div>
              </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="x_panel tile fixed_height_320 overflow_hidden">
                <div class="x_title">
                  <h2>브라우저 사용</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li style='float:right;'><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                    <li style='float:right;' ><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  
                        <?include_once('/chart2.php')?>
                     
                </div>
              </div>
            </div>


            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="x_panel tile fixed_height_320">
                <div class="x_title">
                  <h2>Quick Settings</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                      </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <?include_once('/chart3.php')?>
                </div>
              </div>
            </div>

          </div>


          <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Recent Activities <small>Sessions</small></h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                      </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="dashboard-widget-content">

                    <ul class="list-unstyled timeline widget">
                      <li>
                        <div class="block">
                          <div class="block_content">
                            <h2 class="title">
                                              <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                          </h2>
                            <div class="byline">
                              <span>13 hours ago</span> by <a>Jane Smith</a>
                            </div>
                            <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                            </p>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="block">
                          <div class="block_content">
                            <h2 class="title">
                                              <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                          </h2>
                            <div class="byline">
                              <span>13 hours ago</span> by <a>Jane Smith</a>
                            </div>
                            <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                            </p>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="block">
                          <div class="block_content">
                            <h2 class="title">
                                              <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                          </h2>
                            <div class="byline">
                              <span>13 hours ago</span> by <a>Jane Smith</a>
                            </div>
                            <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                            </p>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="block">
                          <div class="block_content">
                            <h2 class="title">
                                              <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                          </h2>
                            <div class="byline">
                              <span>13 hours ago</span> by <a>Jane Smith</a>
                            </div>
                            <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                            </p>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>


            <div class="col-md-8 col-sm-8 col-xs-12">



              <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Visitors location <small>geo-presentation</small></h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                          </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <div class="dashboard-widget-content">
                        <div class="col-md-4 hidden-small">
                          <h2 class="line_30">125.7k Views from 60 countries</h2>

                          <table class="countries_list">
                            <tbody>
                              <tr>
                                <td>United States</td>
                                <td class="fs15 fw700 text-right">33%</td>
                              </tr>
                              <tr>
                                <td>France</td>
                                <td class="fs15 fw700 text-right">27%</td>
                              </tr>
                              <tr>
                                <td>Germany</td>
                                <td class="fs15 fw700 text-right">16%</td>
                              </tr>
                              <tr>
                                <td>Spain</td>
                                <td class="fs15 fw700 text-right">11%</td>
                              </tr>
                              <tr>
                                <td>Britain</td>
                                <td class="fs15 fw700 text-right">10%</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div id="world-map-gdp" class="col-md-8 col-sm-12 col-xs-12" style="height:230px;"></div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="row">


                <!-- Start to do list -->
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>To Do List <small>Sample tasks</small></h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                          </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                      <div class="">
                        <ul class="to_do">
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Schedule meeting with new client </p>
                          </li>
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Create email address for new intern</p>
                          </li>
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Have IT fix the network printer</p>
                          </li>
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Copy backups to offsite location</p>
                          </li>
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Food truck fixie locavors mcsweeney</p>
                          </li>
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Food truck fixie locavors mcsweeney</p>
                          </li>
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Create email address for new intern</p>
                          </li>
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Have IT fix the network printer</p>
                          </li>
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Copy backups to offsite location</p>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End to do list -->
                
                <!-- start of weather widget -->
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Daily active users <small>Sessions</small></h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                          </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <div class="row">
                        <div class="col-sm-12">
                          <div class="temperature"><b>Monday</b>, 07:30 AM
                            <span>F</span>
                            <span><b>C</b></span>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="weather-icon">
                            <canvas height="84" width="84" id="partly-cloudy-day"></canvas>
                          </div>
                        </div>
                        <div class="col-sm-8">
                          <div class="weather-text">
                            <h2>Texas <br><i>Partly Cloudy Day</i></h2>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="weather-text pull-right">
                          <h3 class="degrees">23</h3>
                        </div>
                      </div>

                      <div class="clearfix"></div>

                      <div class="row weather-days">
                        <div class="col-sm-2">
                          <div class="daily-weather">
                            <h2 class="day">Mon</h2>
                            <h3 class="degrees">25</h3>
                            <canvas id="clear-day" width="32" height="32"></canvas>
                            <h5>15 <i>km/h</i></h5>
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <div class="daily-weather">
                            <h2 class="day">Tue</h2>
                            <h3 class="degrees">25</h3>
                            <canvas height="32" width="32" id="rain"></canvas>
                            <h5>12 <i>km/h</i></h5>
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <div class="daily-weather">
                            <h2 class="day">Wed</h2>
                            <h3 class="degrees">27</h3>
                            <canvas height="32" width="32" id="snow"></canvas>
                            <h5>14 <i>km/h</i></h5>
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <div class="daily-weather">
                            <h2 class="day">Thu</h2>
                            <h3 class="degrees">28</h3>
                            <canvas height="32" width="32" id="sleet"></canvas>
                            <h5>15 <i>km/h</i></h5>
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <div class="daily-weather">
                            <h2 class="day">Fri</h2>
                            <h3 class="degrees">28</h3>
                            <canvas height="32" width="32" id="wind"></canvas>
                            <h5>11 <i>km/h</i></h5>
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <div class="daily-weather">
                            <h2 class="day">Sat</h2>
                            <h3 class="degrees">26</h3>
                            <canvas height="32" width="32" id="cloudy"></canvas>
                            <h5>10 <i>km/h</i></h5>
                          </div>
                        </div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                  </div>

                </div>
                <!-- end of weather widget -->
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

 



























<?php
include_once ('./admin.tail.php');
?>
