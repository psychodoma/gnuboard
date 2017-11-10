<?php
$sub_menu = "200800";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$g5['title'] = '연도별 접속자집계';
include_once('./visit.sub.php');

$colspan = 4;

$max = 0;
$sum_count = 0;
$sql = " select SUBSTRING(vs_date,1,4) as vs_year, SUM(vs_count) as cnt
            from {$g5['visit_sum_table']}
            where vs_date between '{$fr_date}' and '{$to_date}'
            group by vs_year
            order by vs_year desc ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $arr[$row['vs_year']] = $row['cnt'];

    if ($row['cnt'] > $max) $max = $row['cnt'];

    $sum_count += $row['cnt'];
}
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
                            <div class='col-sm-2'>
                                <div class="form-group">
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input type='date' name="fr_date" class="form-control" value="<?php echo $fr_date ?>" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class='col-sm-2'>
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

                    <div class='table-responsive'>
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="col-md-2" scope='col'>시간</th>
                                <th class="col-md-6" scope='col'>그래프</th>
                                <th class="col-md-2" scope='col'>접속자수</th>
                                <th class="col-md-2" scope='col'>비율(%)</th>
                            </tr>
                        </thead>

                        <tfoot>
                        <tr>
                            <td colspan="2">합계</td>
                            <td><strong><?php echo $sum_count ?></strong></td>
                            <td>100%</td>
                        </tr>
                        </tfoot>

                        <tbody>

                        <?php
                        $i = 0;
                        $k = 0;
                        $save_count = -1;
                        $tot_count = 0;
                        if (count($arr)) {
                            foreach ($arr as $key=>$value) {
                                $count = $value;

                                $rate = ($count / $sum_count * 100);
                                $s_rate = number_format($rate, 1);

                                $bg = 'bg'.($i%2);
                        ?>

                            <tr class="<?php echo $bg; ?>">
                                <td class="td_category"><a href="./visit_month.php?fr_date=<?php echo $key ?>-01-01&amp;to_date=<?php echo $key ?>-12-31"><?php echo $key ?></a></td>
                                <td>
                                    <div class='btn-primary' style="width:<?php echo $s_rate ?>%; height: 15px;"></div>
                                </td>
                                <td class="td_numbig"><?php echo number_format($value) ?></td>
                                <td class="td_num"><?php echo $s_rate ?></td>
                            </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
                            }
                            ?>


                        </tbody>
                    </table>
                        </div>


                    <?php
                    include_once('./admin.tail.php');
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>


