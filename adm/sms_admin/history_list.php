<?php
$sub_menu = "900400";
include_once("./_common.php");

$page_size = 20;
$colspan = 11;

auth_check($auth[$sub_menu], "r");

$g5['title'] = "문자전송 내역";

if ($page < 1) $page = 1;

if ($st && trim($sv))
    $sql_search = " and wr_message like '%$sv%' ";
else
    $sql_search = "";

$total_res = sql_fetch("select count(*) as cnt from {$g5['sms5_write_table']} where wr_renum=0 $sql_search");
$total_count = $total_res['cnt'];

$total_page = (int)($total_count/$page_size) + ($total_count%$page_size==0 ? 0 : 1);
$page_start = $page_size * ( $page - 1 );

$vnum = $total_count - (($page-1) * $page_size);

include_once(G5_ADMIN_PATH.'/admin.head.php');
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
            <h3>문자전송 내역</h3>
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

                        <form name="search_form" id="search_form" action=<?php echo $_SERVER['SCRIPT_NAME'];?> class="local_sch01 local_sch" method="get">
                            <input type="hidden" name="st" id="st" value="wr_message" >  

                            <div class="title_right">
                                
                                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                    
                                <div class="input-group">
                                    <input placeholder="단어를 입력하세요..."  type="text" name="sv" value="<?php echo $sv ?>" id="sv" required class="form-control required frm_input" >
                                    
                            
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn_submit" type="submit"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                                </div>
                            </div>
                        </form>






                        <div class="tbl_head01 tbl_wrap table-responsive">
                            <table class='table table-striped table-bordered'>

                            <thead>
                            <tr>
                                <th scope="col">번호</th>
                                <th scope="col">메세지</th>
                                <th scope="col">회신번호</th>
                                <th scope="col">전송일시</th>
                                <th scope="col">예약</th>
                                <th scope="col">총건수</th>
                                <th scope="col">성공</th>
                                <th scope="col">실패</th>
                                <th scope="col">중복</th>
                                <th scope="col">재전송</th>
                                <th scope="col">관리</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!$total_count) { ?>
                            <tr>
                                <td colspan="<?php echo $colspan?>" class="empty_table" >
                                    데이터가 없습니다.
                                </td>
                            </tr>
                            <?php
                            }
                            $qry = sql_query("select * from {$g5['sms5_write_table']} where wr_renum=0 $sql_search order by wr_no desc limit $page_start, $page_size");
                            while($res = sql_fetch_array($qry)) {
                                $bg = 'bg'.($line++%2);
                                $tmp_wr_memo = @unserialize($res['wr_memo']);
                                $dupli_count = $tmp_wr_memo['total'] ? $tmp_wr_memo['total'] : 0;
                            ?>
                            <tr class="<?php echo $bg; ?>">
                                <td class="td_numsmall"><?php echo $vnum--?></td>
                                <td><span title="<?php echo $res['wr_message']?>"><?php echo $res['wr_message']?></span></td>
                                <td class="td_numbig"><?php echo $res['wr_reply']?></td>
                                <td class="td_datetime"><?php echo date('Y-m-d H:i', strtotime($res['wr_datetime']))?></td>
                                <td class="td_boolean"><?php echo $res['wr_booking']!='0000-00-00 00:00:00'?"<span title='{$res['wr_booking']}'>예약</span>":'';?></td>
                                <td class="td_num"><?php echo number_format($res['wr_total'])?></td>
                                <td class="td_num"><?php echo number_format($res['wr_success'])?></td>
                                <td class="td_num"><?php echo number_format($res['wr_failure'])?></td>
                                <td class="td_num"><?php echo $dupli_count;?></td>
                                <td class="td_num"><?php echo number_format($res['wr_re_total'])?></td>
                                <td class="td_mngsmall">
                                    <a href="./history_view.php?page=<?php echo $page;?>&amp;st=<?php echo $st;?>&amp;sv=<?php echo $sv;?>&amp;wr_no=<?php echo $res['wr_no'];?>" class='btn btn-default'>수정</a>
                                    <!-- <a href="./history_del.php?page=<?php echo $page;?>&amp;st=<?php echo $st;?>&amp;sv=<?php echo $sv;?>&amp;wr_no=<?php echo $res['wr_no'];?>">삭제</a> -->
                                </td>
                            </tr>
                            <?php } ?>
                            </tbody>
                            </table>
                        </div>

                        <?php echo kim_get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME']."?st=$st&amp;sv=$sv&amp;page="); ?>

                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>