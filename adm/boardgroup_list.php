<?php
$sub_menu = "300200";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

if (!isset($group['gr_device'])) {
    // 게시판 그룹 사용 필드 추가
    // both : pc, mobile 둘다 사용
    // pc : pc 전용 사용
    // mobile : mobile 전용 사용
    // none : 사용 안함
    sql_query(" ALTER TABLE  `{$g5['board_group_table']}` ADD  `gr_device` ENUM(  'both',  'pc',  'mobile' ) NOT NULL DEFAULT  'both' AFTER  `gr_subject` ", false);
}

$sql_common = " from {$g5['group_table']} ";

$sql_search = " where (1) ";
if ($is_admin != 'super')
    $sql_search .= " and (gr_admin = '{$member['mb_id']}') ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "gr_id" :
        case "gr_admin" :
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if ($sst)
    $sql_order = " order by {$sst} {$sod} ";
else
    $sql_order = " order by gr_id asc ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">처음</a>';

$g5['title'] = '게시판그룹설정';
include_once('./admin.head.php');

$colspan = 10;
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
            <h3>게시판그룹설정</h3>
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
                            전체그룹 <?php echo number_format($total_count) ?>개
                        </p>




                        <form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">
                            
                            <div class="title_right">
                                
                                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                    
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="단어를 입력하세요..."  name="stx" value="<?php echo $stx ?>" id="stx" required >
                                    
                              
                                    <span class="input-group-btn">
                                        
                                        <select class='form-control' name="sfl" id="sfl" style='width:130px;'>
                                            <option value="gr_subject"<?php echo get_selected($_GET['sfl'], "gr_subject"); ?>>제목</option>
                                            <option value="gr_id"<?php echo get_selected($_GET['sfl'], "gr_id"); ?>>ID</option>
                                            <option value="gr_admin"<?php echo get_selected($_GET['sfl'], "gr_admin"); ?>>그룹관리자</option>
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
                            <a class='btn btn-default' href="./boardgroup_form.php" id="bo_gr_add">게시판그룹 추가</a>
                        <?php } ?>
                        <br><br>
                        <form name="fboardgrouplist" id="fboardgrouplist" action="./boardgroup_list_update.php" onsubmit="return fboardgrouplist_submit(this);" method="post">
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
                                <th scope="col"><?php echo subject_sort_link('gr_id') ?>그룹아이디</a></th>
                                <th scope="col"><?php echo subject_sort_link('gr_subject') ?>제목</a></th>
                                <th scope="col"><?php echo subject_sort_link('gr_admin') ?>그룹관리자</a></th>
                                <th scope="col">게시판</th>
                                <th scope="col">접근사용</th>
                                <th scope="col">접근회원수</th>
                                <th scope="col"><?php echo subject_sort_link('gr_order') ?>출력순서</a></th>
                                <th scope="col">접속기기</th>
                                <th scope="col">관리</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            for ($i=0; $row=sql_fetch_array($result); $i++)
                            {
                                // 접근회원수
                                $sql1 = " select count(*) as cnt from {$g5['group_member_table']} where gr_id = '{$row['gr_id']}' ";
                                $row1 = sql_fetch($sql1);

                                // 게시판수
                                $sql2 = " select count(*) as cnt from {$g5['board_table']} where gr_id = '{$row['gr_id']}' ";
                                $row2 = sql_fetch($sql2);

                                $s_upd = '<a class="btn btn-default" href="./boardgroup_form.php?'.$qstr.'&amp;w=u&amp;gr_id='.$row['gr_id'].'">수정</a>';

                                $bg = 'bg'.($i%2);
                            ?>

                            <tr class="<?php echo $bg; ?>">
                                <td class="td_chk">
                                    <input type="hidden" name="group_id[<?php echo $i ?>]" value="<?php echo $row['gr_id'] ?>">
                                    <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
                                </td>
                                <td class="td_grid"><a class='btn btn-default' href="<?php echo G5_BBS_URL ?>/group.php?gr_id=<?php echo $row['gr_id'] ?>"><?php echo $row['gr_id'] ?></a></td>
                                <td class="td_input">
                                    <div class='input-group' >
                                        <div class='input-group-addon'>그룹제목</div>
                                        <input type="text" name="gr_subject[<?php echo $i ?>]" value="<?php echo get_text($row['gr_subject']) ?>" id="gr_subject_<?php echo $i ?>" class="frm_input form-control">
                                    </div>
                                </td>
                                <td class="td_mng td_input">
                                <?php if ($is_admin == 'super'){ ?>
                                    <div class='input-group' >
                                        <div class='input-group-addon'>
                                            그룹관리자
                                        </div>
                                        <input type="text" name="gr_admin[<?php echo $i ?>]" value="<?php echo $row['gr_admin'] ?>" id="gr_admin_<?php echo $i ?>" class="form-control frm_input" size="10" maxlength="20">
                                    </div>
                                    <?php }else{ ?>
                                    <input type="hidden" name="gr_admin[<?php echo $i ?>]" value="<?php echo $row['gr_admin'] ?>"><?php echo $row['gr_admin'] ?>
                                <?php } ?>
                                </td>
                                <td class="td_numsmall"><a href="./board_list.php?sfl=a.gr_id&amp;stx=<?php echo $row['gr_id'] ?>"><?php echo $row2['cnt'] ?></a></td>
                                <td class="td_chk">
                                    <label for="gr_use_access_<?php echo $i; ?>" class="sound_only">접근회원 사용</label>
                                    <input type="checkbox" class='flat' name="gr_use_access[<?php echo $i ?>]" <?php echo $row['gr_use_access']?'checked':'' ?> value="1" id="gr_use_access_<?php echo $i ?>">
                                </td>
                                <td class="td_numsmall"><a href="./boardgroupmember_list.php?gr_id=<?php echo $row['gr_id'] ?>"><?php echo $row1['cnt'] ?></a></td>
                                <td class="td_chk">
                                    <div class='input-group' >
                                        <div class='input-group-addon' >메인메뉴 출력순서</div>
                                        <input type="text" name="gr_order[<?php echo $i ?>]" value="<?php echo $row['gr_order'] ?>" id="gr_order_<?php echo $i ?>" class="form-control frm_input" size="2">
                                    </div>
                                </td>
                                <td class="td_mng">
                                    <div class='input-group' >
                                        <div class='input-group-addon' >
                                            접속기기
                                        </div>

                                        <select class='form-control' name="gr_device[<?php echo $i ?>]" id="gr_device_<?php echo $i ?>">
                                            <option value="both"<?php echo get_selected($row['gr_device'], 'both'); ?>>모두</option>
                                            <option value="pc"<?php echo get_selected($row['gr_device'], 'pc'); ?>>PC</option>
                                            <option value="mobile"<?php echo get_selected($row['gr_device'], 'mobile'); ?>>모바일</option>
                                        </select>
                                    </div>
                                </td>
                                <td class="td_mngsmall"><?php echo $s_upd ?></td>
                            </tr>

                            <?php
                                }
                            if ($i == 0)
                                echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
                            ?>
                            </table>
                        </div>

                        <div class="btn_list01 btn_list">
                            <input type="submit" class='btn btn-default' name="act_button" onclick="document.pressed=this.value" value="선택수정">
                            <input type="submit" class='btn btn-default' name="act_button" onclick="document.pressed=this.value" value="선택삭제">
                            <a class='btn btn-default' href="./boardgroup_form.php">게시판그룹 추가</a>
                        </div>
                        </form>

                        <div class="local_desc01 local_desc">
                            <br>
                            <p class='bg-success' style='padding:15px;' >
                                접근사용 옵션을 설정하시면 관리자가 지정한 회원만 해당 그룹에 접근할 수 있습니다.<br>
                                접근사용 옵션은 해당 그룹에 속한 모든 게시판에 적용됩니다.
                            </p>
                        </div>

                        <?php
                        $pagelist = get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page=');
                        echo $pagelist;
                        ?>







                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






<script>
function fboardgrouplist_submit(f)
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
include_once('./admin.tail.php');
?>
