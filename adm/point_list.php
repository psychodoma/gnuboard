<?php
$sub_menu = "200200";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$sql_common = " from {$g5['point_table']} ";

$sql_search = " where (1) ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'mb_id' :
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "po_id";
    $sod = "desc";
}
$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt
            {$sql_common}
            {$sql_search}
            {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
            {$sql_common}
            {$sql_search}
            {$sql_order}
            limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';

$mb = array();
if ($sfl == 'mb_id' && $stx)
    $mb = get_member($stx);

$g5['title'] = '포인트관리';
include_once ('./admin.head.php');

$colspan = 9;

$po_expire_term = '';
if($config['cf_point_term'] > 0) {
    $po_expire_term = $config['cf_point_term'];
}

if (strstr($sfl, "mb_id"))
    $mb_id = $stx;
else
    $mb_id = "";
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
            <h3>포인트관리</h3>
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
     




                        <p class="bg-info" style='padding:15px;'>

                            <span class='btn btn-default'><?php echo $listall ?></span>
                            전체 <?php echo number_format($total_count) ?> 건
                            <?php
                            if (isset($mb['mb_id']) && $mb['mb_id']) {
                                echo '&nbsp;(' . $mb['mb_id'] .' 님 포인트 합계 : ' . number_format($mb['mb_point']) . '점)';
                            } else {
                                $row2 = sql_fetch(" select sum(po_point) as sum_point from {$g5['point_table']} ");
                                echo '&nbsp;(전체 합계 '.number_format($row2['sum_point']).'점)';
                            }
                            ?>
                        </p>




                        <form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">
                            
                            <div class="title_right">
                                
                                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                    
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="단어를 입력하세요..."  name="stx" value="<?php echo $stx ?>" id="stx" required >
                                    
                              
                                    <span class="input-group-btn">
                                        
                                        <select class='form-control' name="sfl" id="sfl" style='width:130px;'>
                                            <option value="mb_id"<?php echo get_selected($_GET['sfl'], "mb_id"); ?>>회원아이디</option>
                                            <option value="po_content"<?php echo get_selected($_GET['sfl'], "po_content"); ?>>내용</option>
                                        </select>

                                    </span>

                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn_submit" type="submit"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                                </div>
                            </div>
                        </form>




                        <form name="fpointlist" id="fpointlist" method="post" action="./point_list_delete.php" onsubmit="return fpointlist_submit(this);">
                        <input type="hidden" name="sst" value="<?php echo $sst ?>">
                        <input type="hidden" name="sod" value="<?php echo $sod ?>">
                        <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
                        <input type="hidden" name="stx" value="<?php echo $stx ?>">
                        <input type="hidden" name="page" value="<?php echo $page ?>">
                        <input type="hidden" name="token" value="">

                        <div class="tbl_head01 tbl_wrap table-responsive">
                            <table class='table table-striped table-bordered' >
  
                            <thead>
                            <tr>
                                <th scope="col">
                                    <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
                                </th>
                                <th scope="col"><?php echo subject_sort_link('mb_id') ?>회원아이디</a></th>
                                <th scope="col">이름</th>
                                <th scope="col">닉네임</th>
                                <th scope="col"><?php echo subject_sort_link('po_content') ?>포인트 내용</a></th>
                                <th scope="col"><?php echo subject_sort_link('po_point') ?>포인트</a></th>
                                <th scope="col"><?php echo subject_sort_link('po_datetime') ?>일시</a></th>
                                <th scope="col">만료일</th>
                                <th scope="col">포인트합</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            for ($i=0; $row=sql_fetch_array($result); $i++) {
                                if ($i==0 || ($row2['mb_id'] != $row['mb_id'])) {
                                    $sql2 = " select mb_id, mb_name, mb_nick, mb_email, mb_homepage, mb_point from {$g5['member_table']} where mb_id = '{$row['mb_id']}' ";
                                    $row2 = sql_fetch($sql2);
                                }

                                $mb_nick = get_sideview($row['mb_id'], $row2['mb_nick'], $row2['mb_email'], $row2['mb_homepage']);

                                $link1 = $link2 = '';
                                if (!preg_match("/^\@/", $row['po_rel_table']) && $row['po_rel_table']) {
                                    $link1 = '<a href="'.G5_BBS_URL.'/board.php?bo_table='.$row['po_rel_table'].'&amp;wr_id='.$row['po_rel_id'].'" target="_blank">';
                                    $link2 = '</a>';
                                }

                                $expr = '';
                                if($row['po_expired'] == 1)
                                    $expr = ' txt_expired';

                                $bg = 'bg'.($i%2);
                            ?>

                            <tr class="<?php echo $bg; ?>">
                                <td class="td_chk">
                                    <input type="hidden" name="mb_id[<?php echo $i ?>]" value="<?php echo $row['mb_id'] ?>" id="mb_id_<?php echo $i ?>">
                                    <input type="hidden" name="po_id[<?php echo $i ?>]" value="<?php echo $row['po_id'] ?>" id="po_id_<?php echo $i ?>">
                                    <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
                                </td>
                                <td class="td_mbid"><a href="?sfl=mb_id&amp;stx=<?php echo $row['mb_id'] ?>"><?php echo $row['mb_id'] ?></a></td>
                                <td class="td_mbname"><?php echo get_text($row2['mb_name']); ?></td>
                                <td class="td_name sv_use"><div><?php echo $row2['mb_nick'] ?></div></td>
                                <td class="td_pt_log"><?php echo $link1 ?><?php echo $row['po_content'] ?><?php echo $link2 ?></td>
                                <td class="td_num td_pt"><?php echo number_format($row['po_point']) ?></td>
                                <td class="td_datetime"><?php echo $row['po_datetime'] ?></td>
                                <td class="td_date<?php echo $expr; ?>">
                                    <?php if ($row['po_expired'] == 1) { ?>
                                    만료<?php echo substr(str_replace('-', '', $row['po_expire_date']), 2); ?>
                                    <?php } else echo $row['po_expire_date'] == '9999-12-31' ? '&nbsp;' : $row['po_expire_date']; ?>
                                </td>
                                <td class="td_num td_pt"><?php echo number_format($row['po_mb_point']) ?></td>
                            </tr>

                            <?php
                            }

                            if ($i == 0)
                                echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
                            ?>
                            </tbody>
                            </table>
                        </div>

                        <div class="btn_list01 btn_list">
                            <input class='btn btn-default' type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value">
                        </div>

                        </form>

                        <?php echo kim_get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>



                            <h2 class="h2_frm">개별회원 포인트 증감 설정</h2>

                            <form name="fpointlist2" method="post" id="fpointlist2" action="./point_update.php" autocomplete="off">
                            <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
                            <input type="hidden" name="stx" value="<?php echo $stx ?>">
                            <input type="hidden" name="sst" value="<?php echo $sst ?>">
                            <input type="hidden" name="sod" value="<?php echo $sod ?>">
                            <input type="hidden" name="page" value="<?php echo $page ?>">
                            <input type="hidden" name="token" value="<?php echo $token ?>">

                            <div class="tbl_frm01 tbl_wrap table-responsive">
                                <table class='table table-striped table-bordered' >
                                <colgroup>
                                    <col class="grid_4">
                                    <col>
                                </colgroup>
                                <tbody>
                                <tr>
                                    <th scope="row"><label for="mb_id">회원아이디<span class="required red"> *</span></label></th>
                                    <td><input type="text" name="mb_id" value="<?php echo $mb_id ?>" id="mb_id" class="required frm_input form-control" required></td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="po_content">포인트 내용<span class="required red"> *</span></label></th>
                                    <td><input type="text" name="po_content" id="po_content" required class="required frm_input form-control" size="80"></td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="po_point">포인트<span class="required red"> *</span></label></th>
                                    <td><input type="text" name="po_point" id="po_point" required class="required frm_input form-control"></td>
                                </tr>
                                <?php if($config['cf_point_term'] > 0) { ?>
                                <tr>
                                    <th scope="row"><label for="po_expire_term">포인트 유효기간</label></th>
                                    <td><input type="text" name="po_expire_term" value="<?php echo $po_expire_term; ?>" id="po_expire_term" class="frm_input form-control" size="5"> 일</td>
                                </tr>
                                <?php } ?>
                                </tbody>
                                </table>
                            </div>

                            <div class="btn_confirm01 btn_confirm">
                                <input type="submit" value="확인" class="btn_submit btn btn-default">
                            </div>

                            </form>











                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>








<script>
function fpointlist_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}
</script>

<?php
include_once ('./admin.tail.php');
?>
