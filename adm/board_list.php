<?php
$sub_menu = "300100";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$sql_common = " from {$g5['board_table']} a ";
$sql_search = " where (1) ";

if ($is_admin != "super") {
    $sql_common .= " , {$g5['group_table']} b ";
    $sql_search .= " and (a.gr_id = b.gr_id and b.gr_admin = '{$member['mb_id']}') ";
}

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "bo_table" :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
        case "a.gr_id" :
            $sql_search .= " ($sfl = '$stx') ";
            break;
        default :
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "a.gr_id, a.bo_table";
    $sod = "asc";
}
$sql_order = " order by $sst $sod ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';

$g5['title'] = '게시판관리';
include_once('./admin.head.php');

$colspan = 15;
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
            <h3>게시판관리</h3>
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






                        <p class="local_ov01 local_ov bg-info" style='padding:15px;'>
                            <span class='btn btn-default' ><?php echo $listall ?></span>
                            생성된 게시판수 <?php echo number_format($total_count) ?>개
                        </p>



                        <form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">
                            
                            <div class="title_right">
                                
                                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                    
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="단어를 입력하세요..."  name="stx" value="<?php echo $stx ?>" id="stx" required >
                                    
                              
                                    <span class="input-group-btn">
                                        
                                        <select class='form-control' name="sfl" id="sfl" style='width:130px;'>
                                            <option value="bo_table"<?php echo get_selected($_GET['sfl'], "bo_table", true); ?>>TABLE</option>
                                            <option value="bo_subject"<?php echo get_selected($_GET['sfl'], "bo_subject"); ?>>제목</option>
                                            <option value="a.gr_id"<?php echo get_selected($_GET['sfl'], "a.gr_id"); ?>>그룹ID</option>
                                        </select>

                                    </span>

                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn_submit" type="submit"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                                </div>
                            </div>
                        </form>



                        <?php if ($is_admin == 'super') { ?>
                        <div class="btn_add01 btn_add">
                            <a  class='btn btn-default' href="./board_form.php" id="bo_add">게시판 추가</a>
                        </div>
                        <?php } ?>

                        <form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
                        <input type="hidden" name="sst" value="<?php echo $sst ?>">
                        <input type="hidden" name="sod" value="<?php echo $sod ?>">
                        <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
                        <input type="hidden" name="stx" value="<?php echo $stx ?>">
                        <input type="hidden" name="page" value="<?php echo $page ?>">
                        <input type="hidden" name="token" value="<?php echo $token ?>">

                        <div class="tbl_head01 tbl_wrap table-responsive">
                            <table class='table table-striped table-bordered' >

                            <thead>
                            <tr>
                                <th scope="col">
                                    <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
                                </th>
                                <th scope="col"><?php echo subject_sort_link('a.gr_id') ?>그룹</a></th>
                                <th scope="col"><?php echo subject_sort_link('bo_table') ?>TABLE</a></th>
                                <th scope="col"><?php echo subject_sort_link('bo_skin', '', 'desc') ?>스킨</a></th>
                                <th scope="col"><?php echo subject_sort_link('bo_mobile_skin', '', 'desc') ?>모바일<br>스킨</span></a></th>
                                <th scope="col"><?php echo subject_sort_link('bo_subject') ?>제목</a><font color='red'> *</font></th>
                                <th scope="col">읽기P<span class="sound_only">포인트</span></th>
                                <th scope="col">쓰기P<span class="sound_only">포인트</span></th>
                                <th scope="col">댓글P<span class="sound_only">포인트</span></th>
                                <th scope="col">다운P<span class="sound_only">포인트</span></th>
                                <th scope="col"><?php echo subject_sort_link('bo_use_sns') ?>SNS<br>사용</a></th>
                                <th scope="col"><?php echo subject_sort_link('bo_use_search') ?>검색<br>사용</a></th>
                                <th scope="col"><?php echo subject_sort_link('bo_order') ?>출력<br>순서</a></th>
                                <th scope="col">접속기기</th>
                                <th scope="col">관리</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            for ($i=0; $row=sql_fetch_array($result); $i++) {
                                $one_update = '<a class="btn btn-default" href="./board_form.php?w=u&amp;bo_table='.$row['bo_table'].'&amp;'.$qstr.'">수정</a>';
                                $one_copy = '<a class="btn btn-default" href="./board_copy.php?bo_table='.$row['bo_table'].'" class="board_copy" target="win_board_copy">복사</a>';

                                $bg = 'bg'.($i%2);
                            ?>

                            <tr class="<?php echo $bg; ?>">
                                <td class="td_chk">
                                    <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
                                </td>
                                <td>
                                    <?php if ($is_admin == 'super'){ ?>
                                        <?php echo get_group_select("gr_id[$i]", $row['gr_id']) ?>
                                    <?php }else{ ?>
                                        <input type="hidden" name="gr_id[<?php echo $i ?>]" value="<?php echo $row['gr_id'] ?>"><?php echo $row['gr_subject'] ?>
                                    <?php } ?>
                                </td>
                                <td>
                                    <input type="hidden" name="board_table[<?php echo $i ?>]" value="<?php echo $row['bo_table'] ?>">
                                    <a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $row['bo_table'] ?>"><?php echo $row['bo_table'] ?></a>
                                </td>
                                <td>
                                    <?php echo get_skin_select('board', 'bo_skin_'.$i, "bo_skin[$i]", $row['bo_skin']); ?>
                                </td>
                                <td>
                                    <?php echo get_mobile_skin_select('board', 'bo_mobile_skin_'.$i, "bo_mobile_skin[$i]", $row['bo_mobile_skin']); ?>
                                </td>
                                <td>
                                    <input type="text" name="bo_subject[<?php echo $i ?>]" value="<?php echo get_text($row['bo_subject']) ?>" id="bo_subject_<?php echo $i ?>" required class="form-control required frm_input bo_subject full_input" size="10">
                                </td>
                                <td class="td_numsmall">
                                    <input type="text" name="bo_read_point[<?php echo $i ?>]" value="<?php echo $row['bo_read_point'] ?>" id="bo_read_point_<?php echo $i; ?>" class="form-control frm_input" size="2">
                                </td>
                                <td class="td_numsmall">
                                    <input type="text" name="bo_write_point[<?php echo $i ?>]" value="<?php echo $row['bo_write_point'] ?>" id="bo_write_point_<?php echo $i; ?>" class="form-control frm_input" size="2">
                                </td>
                                <td class="td_numsmall">
                                    <input type="text" name="bo_comment_point[<?php echo $i ?>]" value="<?php echo $row['bo_comment_point'] ?>" id="bo_comment_point_<?php echo $i; ?>" class="form-control frm_input" size="2">
                                </td>
                                <td class="td_numsmall">
                                    <input type="text" name="bo_download_point[<?php echo $i ?>]" value="<?php echo $row['bo_download_point'] ?>" id="bo_download_point_<?php echo $i; ?>" class="form-control frm_input" size="2">
                                </td>
                                <td class="td_chk">
                                    <input type="checkbox" class='flat' name="bo_use_sns[<?php echo $i ?>]" value="1" id="bo_use_sns_<?php echo $i ?>" <?php echo $row['bo_use_sns']?"checked":"" ?>>
                                </td>
                                <td class="td_chk">
                                    <input type="checkbox" class='flat' name="bo_use_search[<?php echo $i ?>]" value="1" id="bo_use_search_<?php echo $i ?>" <?php echo $row['bo_use_search']?"checked":"" ?>>
                                </td>
                                <td class="td_chk">
                                    <input type="text" name="bo_order[<?php echo $i ?>]" value="<?php echo $row['bo_order'] ?>" id="bo_order_<?php echo $i ?>" class="form-control frm_input" size="2">
                                </td>
                                <td class="td_mngsmall">
                                    <select class='form-control' name="bo_device[<?php echo $i ?>]" id="bo_device_<?php echo $i ?>">
                                        <option value="both"<?php echo get_selected($row['bo_device'], 'both', true); ?>>모두</option>
                                        <option value="pc"<?php echo get_selected($row['bo_device'], 'pc'); ?>>PC</option>
                                        <option value="mobile"<?php echo get_selected($row['bo_device'], 'mobile'); ?>>모바일</option>
                                    </select>
                                </td>
                                <td class="td_mngsmall">
                                    <?php echo $one_update ?>
                                    <?php echo $one_copy ?>
                                </td>
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
                            <input type="submit" name="act_button" class='btn btn-default' value="선택수정" onclick="document.pressed=this.value">
                            <?php if ($is_admin == 'super') { ?>
                            <input type="submit" name="act_button" class='btn btn-default' value="선택삭제" onclick="document.pressed=this.value">
                            <?php } ?>
                        </div>

                        </form>

                        <?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>








                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>










<script>
function fboardlist_submit(f)
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

$(function(){
    $(".board_copy").click(function(){
        window.open(this.href, "win_board_copy", "left=100,top=100,width=550,height=450");
        return false;
    });
});
</script>

<?php
include_once('./admin.tail.php');
?>
