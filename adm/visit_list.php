<?php
$sub_menu = "200800";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');
?>

<?
$g5['title'] = '접속자집계';
include_once('./visit.sub.php');

$colspan = 6;

$sql_common = " from {$g5['visit_table']} ";
$sql_search = " where vi_date between '{$fr_date}' and '{$to_date}' ";
if (isset($domain))
    $sql_search .= " and vi_referer like '%{$domain}%' ";

$sql = " select count(*) as cnt
            {$sql_common}
            {$sql_search} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
            {$sql_common}
            {$sql_search}
            order by vi_id desc
            limit {$from_record}, {$rows} ";
$result = sql_query($sql);
?>


<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?=$g5['title'];?> <small>전체 리스트</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Settings 1</a></li>
                                <li><a href="#">Settings 2</a></li>
                            </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
            <div class="clearfix"></div>


            </div>
                <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                    홈페이지에 접속한 유저들의 정보를 볼 수 있는 페이지 입니다. 기간, 접속자, 도메인, 브라우저, 운영체제, 접속기기 등.. 다양한 방법으로 정보를 확인해 볼 수 있습니다.
                    </p>

                    
                    <form name="fvisit" id="fvisit" class="local_sch02 local_sch" method="get">
                        <div class="container">
                        <div class="row">
                            <div class='col-sm-5'>
                                <div class="form-group">
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input type='date' name="fr_date" class="form-control" value="<?php echo $fr_date ?>" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class='col-sm-5'>
                                <div class="form-group">
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input type='date' name="to_date" class="form-control" value="<?php echo $to_date ?>" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class='col-sm-2'>
                                <input type="submit"  value="검색" class="btn btn-default">
                            </div>
        
                        </div>
                        </div>
                    </form>
                    
                    </br>

                    <a class='btn btn-default' href="./visit_list.php<?php echo $query_string ?>">접속자</a>
                    <a class='btn btn-default' href="./visit_domain.php<?php echo $query_string ?>">도메인</a>
                    <a class='btn btn-default' href="./visit_detect.php<?php echo $query_string ?>">접속기기</a>
                    <a class='btn btn-default' href="./visit_detect_browser.php<?php echo $query_string ?>">모바일 브라우저</a>
                    <a class='btn btn-default' href="./visit_detect_os.php<?php echo $query_string ?>">모바일 운영체제</a>
                    <a class='btn btn-default' href="./visit_browser.php<?php echo $query_string ?>">브라우저</a>
                    <a class='btn btn-default' href="./visit_os.php<?php echo $query_string ?>">운영체제</a>
                    <a class='btn btn-default' href="./visit_hour.php<?php echo $query_string ?>">시간</a>
                    <a class='btn btn-default' href="./visit_week.php<?php echo $query_string ?>">요일</a>
                    <a class='btn btn-default' href="./visit_date.php<?php echo $query_string ?>">일</a>
                    <a class='btn btn-default' href="./visit_month.php<?php echo $query_string ?>">월</a>
                    <a class='btn btn-default' href="./visit_year.php<?php echo $query_string ?>">년</a>

                    </br></br>

                    <div class='table-responsive' >
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>IP</th>
                                <th>접속 경로</th>
                                <th>브라우저</th>
                                <th>OS</th>
                                <th>접속기기</th>
                                <th>일시</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            for ($i=0; $row=sql_fetch_array($result); $i++) {
                            $brow = $row['vi_browser'];
                            if(!$brow)
                            $brow = get_brow($row['vi_agent']);

                            $os = $row['vi_os'];
                            if(!$os)
                            $os = get_os($row['vi_agent']);

                            $device = $row['vi_device'];

                            $link = '';
                            $link2 = '';
                            $referer = '';
                            $title = '';
                            if ($row['vi_referer']) {

                            $referer = get_text(cut_str($row['vi_referer'], 255, ''));
                            $referer = urldecode($referer);

                            if (!is_utf8($referer)) {
                            $referer = iconv_utf8($referer);
                            }

                            $title = str_replace(array('<', '>', '&'), array("&lt;", "&gt;", "&amp;"), $referer);
                            $link = '<a href="'.$row['vi_referer'].'" target="_blank">';
                            $link = str_replace('&', "&amp;", $link);
                            $link2 = '</a>';
                            }

                            if ($is_admin == 'super')
                            $ip = $row['vi_ip'];
                            else
                            $ip = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", G5_IP_DISPLAY, $row['vi_ip']);

                            if ($brow == '기타') { $brow = '<span title="'.get_text($row['vi_agent']).'">'.$brow.'</span>'; }
                            if ($os == '기타') { $os = '<span title="'.get_text($row['vi_agent']).'">'.$os.'</span>'; }

                            $bg = 'bg'.($i%2);
                            ?>
                            <tr class="<?php echo $bg; ?>">
                            <td><?php echo $ip ?></td>
                            <td><?php echo $link ?><?php echo $title ?><?php echo $link2 ?></td>
                            <td><?php echo $brow ?></td>
                            <td><?php echo $os ?></td>
                            <td><?php echo $device; ?></td>
                            <td><?php echo $row['vi_date'] ?> <?php echo $row['vi_time'] ?></td>
                            </tr>

                            <?php
                            }
                            if ($i == 0)
                            echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없거나 관리자에 의해 삭제되었습니다.</td></tr>';
                            ?>

                        </tbody>
                    </table>
                    </div>


                    <?php
                    if (isset($domain))
                        $qstr .= "&amp;domain=$domain";
                    $qstr .= "&amp;page=";

                    $pagelist = kim_get_paging($config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr");
                    echo $pagelist;

                    include_once('./admin.tail.php');
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>


