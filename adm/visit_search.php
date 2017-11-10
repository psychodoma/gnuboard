<?php
$sub_menu = '200810';
include_once('./_common.php');
include_once(G5_PATH.'/lib/visit.lib.php');

auth_check($auth[$sub_menu], 'r');

$g5['title'] = '접속자검색';
include_once('./admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

$colspan = 6;
$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'">처음</a>'; //페이지 처음으로 (초기화용도)
?>







<style>

table{
    text-align:center;
}
table th{
    text-align:center;
}
.table>thead>tr>th{
    vertical-align: inherit;
}

.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
    vertical-align: inherit;
}
</style>


<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
            <h3>접속자검색</h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class='row' >
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        
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





                        <form name="fvisit" method="get" onsubmit="return fvisit_submit(this);">
                            
                            <div class="title_right">
                                
                                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                    
                                <div class="input-group">
                                    <input type="text" name="stx" size="20" value="<?php echo stripslashes($stx); ?>" id="sch_word" class="frm_input form-control" placeholder="단어를 입력하세요...">
                              
                                    <span class="input-group-btn">
                                        
                                        <select class='search_sort form-control' name="sfl" id="sch_sort" style='width:130px;'>
                                            <option value="vi_ip"<?php echo get_selected($sfl, 'vi_ip'); ?>>IP</option>
                                            <option value="vi_referer"<?php echo get_selected($sfl, 'vi_referer'); ?>>접속경로</option>
                                            <option value="vi_date"<?php echo get_selected($sfl, 'vi_date'); ?>>날짜</option>
                                        </select>
                                    
                                    </span>

                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn_submit" type="submit"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                                </div>
                            </div>
                        </form>



                        <div class="tbl_wrap tbl_head01 table-responsive">
                            <table class='table table-striped table-bordered' >
                            <thead>
                            <tr>
                                <th scope="col">IP</th>
                                <th scope="col">접속 경로</th>
                                <th scope="col">브라우저</th>
                                <th scope="col">OS</th>
                                <th scope="col">접속기기</th>
                                <th scope="col">일시</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql_common = " from {$g5['visit_table']} ";
                            if ($sfl) {
                                if($sfl=='vi_ip' || $sfl=='vi_date'){
                                    $sql_search = " where $sfl like '$stx%' ";
                                }else{
                                    $sql_search = " where $sfl like '%$stx%' ";
                                }
                            }
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

                            for ($i=0; $row=sql_fetch_array($result); $i++) {
                                $brow = $row['vi_browser'];
                                if(!$brow)
                                    $brow = get_brow($row['vi_agent']);

                                $os = $row['vi_os'];
                                if(!$os)
                                    $os = get_os($row['vi_agent']);

                                $device = $row['vi_device'];

                                $link = "";
                                $referer = "";
                                $title = "";
                                if ($row['vi_referer']) {

                                    $referer = get_text(cut_str($row['vi_referer'], 255, ""));
                                    $referer = urldecode($referer);

                                    if (!is_utf8($referer)) {
                                        $referer = iconv('euc-kr', 'utf-8', $referer);
                                    }

                                    $title = str_replace(array("<", ">"), array("&lt;", "&gt;"), $referer);
                                    $link = '<a href="'.$row['vi_referer'].'" target="_blank" title="'.$title.'">';
                                }

                                if ($is_admin == 'super')
                                    $ip = $row['vi_ip'];
                                else
                                    $ip = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", G5_IP_DISPLAY, $row['vi_ip']);

                                $bg = 'bg'.($i%2);
                            ?>
                            <tr class="<?php echo $bg; ?>">
                                <td class="td_id"><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?sfl=vi_ip&amp;stx=<?php echo $ip; ?>"><?php echo $ip; ?></a></td>
                                <td><?php echo $link.$title; ?></a></td>
                                <td class="td_idsmall td_category1"><?php echo $brow; ?></td>
                                <td class="td_idsmall td_category3"><?php echo $os; ?></td>
                                <td class="td_idsmall td_category2"><?php echo $device; ?></td>
                                <td class="td_datetime"><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?sfl=vi_date&amp;stx=<?php echo $row['vi_date']; ?>"><?php echo $row['vi_date']; ?></a> <?php echo $row['vi_time']; ?></td>
                            </tr>
                            <?php } ?>
                            <?php if ($i == 0) echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>'; ?>
                            </tbody>
                            </table>
                        </div>

                        <?php
                        $pagelist = kim_get_paging($config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;domain='.$domain.'&amp;page=');
                        if ($pagelist) {
                            echo $pagelist;
                        }
                        ?>


                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>







































<script>
$(function(){
    $("#sch_sort").change(function(){ // select #sch_sort의 옵션이 바뀔때
        if($(this).val()=="vi_date"){ // 해당 value 값이 vi_date이면
            $("#sch_word").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" }); // datepicker 실행
        }else{ // 아니라면
            $("#sch_word").datepicker("destroy"); // datepicker 미실행
        }
    });

    if($("#sch_sort option:selected").val()=="vi_date"){ // select #sch_sort 의 옵션중 selected 된것의 값이 vi_date라면
        $("#sch_word").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" }); // datepicker 실행
    }
});

function fvisit_submit(f)
{
    return true;
}
</script>

<?php
include_once('./admin.tail.php');
?>
