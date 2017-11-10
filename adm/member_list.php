<?php
$sub_menu = "200100";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$sql_common = " from {$g5['member_table']} ";

$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'mb_point' :
            $sql_search .= " ({$sfl} >= '{$stx}') ";
            break;
        case 'mb_level' :
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
        case 'mb_tel' :
        case 'mb_hp' :
            $sql_search .= " ({$sfl} like '%{$stx}') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

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

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

// 탈퇴회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and mb_leave_date <> '' {$sql_order} ";
$row = sql_fetch($sql);
$leave_count = $row['cnt'];

// 차단회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and mb_intercept_date <> '' {$sql_order} ";
$row = sql_fetch($sql);
$intercept_count = $row['cnt'];

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';

$g5['title'] = '회원관리';
include_once('./admin.head.php');

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$colspan = 16;
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
            <h3><?=$g5['title']?></h3>
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
                    


                        <div class="title_left">
                            <div class="col-md-7 col-sm-7 col-xs-12 form-group pull-left top_search">
                            <div class="input-group">
                                <?php echo $listall ?>
                                총회원수 <?php echo number_format($total_count) ?>명 중,
                                <a href="?sst=mb_intercept_date&amp;sod=desc&amp;sfl=<?php echo $sfl ?>&amp;stx=<?php echo $stx ?>">차단 <?php echo number_format($intercept_count) ?></a>명,
                                <a href="?sst=mb_leave_date&amp;sod=desc&amp;sfl=<?php echo $sfl ?>&amp;stx=<?php echo $stx ?>">탈퇴 <?php echo number_format($leave_count) ?></a>명
                            </div>
                            </div>
                        </div>

                        <form id="fsearch" name="fsearch" class="local_sch01 local_sch" method="get">
                            
                            <div class="title_right">
                                
                                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                    
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="단어를 입력하세요..."  name="stx" value="<?php echo $stx ?>" id="stx" required >
                                    
                              
                                    <span class="input-group-btn">
                                        
                                        <select class='form-control' name="sfl" id="sfl" style='width:130px;'>
                                            <option value="mb_id"<?php echo get_selected($_GET['sfl'], "mb_id"); ?>>회원아이디</option>
                                            <option value="mb_nick"<?php echo get_selected($_GET['sfl'], "mb_nick"); ?>>닉네임</option>
                                            <option value="mb_name"<?php echo get_selected($_GET['sfl'], "mb_name"); ?>>이름</option>
                                            <option value="mb_level"<?php echo get_selected($_GET['sfl'], "mb_level"); ?>>권한</option>
                                            <option value="mb_email"<?php echo get_selected($_GET['sfl'], "mb_email"); ?>>E-MAIL</option>
                                            <option value="mb_tel"<?php echo get_selected($_GET['sfl'], "mb_tel"); ?>>전화번호</option>
                                            <option value="mb_hp"<?php echo get_selected($_GET['sfl'], "mb_hp"); ?>>휴대폰번호</option>
                                            <option value="mb_point"<?php echo get_selected($_GET['sfl'], "mb_point"); ?>>포인트</option>
                                            <option value="mb_datetime"<?php echo get_selected($_GET['sfl'], "mb_datetime"); ?>>가입일시</option>
                                            <option value="mb_ip"<?php echo get_selected($_GET['sfl'], "mb_ip"); ?>>IP</option>
                                            <option value="mb_recommend"<?php echo get_selected($_GET['sfl'], "mb_recommend"); ?>>추천인</option>
                                        </select>
                                    
                                    </span>

                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn_submit" type="submit"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                                </div>
                            </div>
                        </form>




                        <div class="local_desc01 local_desc">
                            <p class='bg-info' style='padding:15px;'> 
                                회원자료 삭제 시 다른 회원이 기존 회원아이디를 사용하지 못하도록 회원아이디, 이름, 닉네임은 삭제하지 않고 영구 보관합니다.
                            </p>
                        </div>

                        <?php if ($is_admin == 'super') { ?>
                        <div class="btn_add01 btn_add">
                            <a class='btn btn-default' href="./member_form.php" id="member_add">회원추가</a>
                        </div>
                        <?php } ?>

                        <form name="fmemberlist" id="fmemberlist" action="./member_list_update.php" onsubmit="return fmemberlist_submit(this);" method="post">
                        <input type="hidden" name="sst" value="<?php echo $sst ?>">
                        <input type="hidden" name="sod" value="<?php echo $sod ?>">
                        <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
                        <input type="hidden" name="stx" value="<?php echo $stx ?>">
                        <input type="hidden" name="page" value="<?php echo $page ?>">
                        <input type="hidden" name="token" value="">

                        <div class="tbl_head02 tbl_wrap table-responsive">
                            <table class='table table-striped table-bordered'>

                            <thead>
                            <tr>
                                <th scope="col" rowspan="2" id="mb_list_chk">
                                    <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
                                </th>
                                <th scope="col" rowspan="2" id="mb_list_id"><?php echo subject_sort_link('mb_id') ?>아이디</a></th>
                                <th scope="col" id="mb_list_name"><?php echo subject_sort_link('mb_name') ?>이름</a></th>
                                <th scope="col" colspan="6" id="mb_list_cert"><?php echo subject_sort_link('mb_certify', '', 'desc') ?>본인확인</a></th>
                                <th scope="col" id="mb_list_mobile">휴대폰</th>
                                <th scope="col" id="mb_list_auth">상태/<?php echo subject_sort_link('mb_level', '', 'desc') ?>권한</a></th>
                                <th scope="col" id="mb_list_lastcall"><?php echo subject_sort_link('mb_today_login', '', 'desc') ?>최종접속</a></th>
                                <th scope="col" rowspan="2" id="mb_list_grp">접근그룹</th>
                                <th scope="col" rowspan="2" id="mb_list_mng">관리</th>
                            </tr>
                            <tr>
                                <th scope="col" id="mb_list_nick"><?php echo subject_sort_link('mb_nick') ?>닉네임</a></th>
                                <th scope="col" id="mb_list_mailc"><?php echo subject_sort_link('mb_email_certify', '', 'desc') ?>메일인증</a></th>
                                <th scope="col" id="mb_list_open"><?php echo subject_sort_link('mb_open', '', 'desc') ?>정보공개</a></th>
                                <th scope="col" id="mb_list_mailr"><?php echo subject_sort_link('mb_mailling', '', 'desc') ?>메일수신</a></th>
                                <th scope="col" id="mb_list_sms"><?php echo subject_sort_link('mb_sms', '', 'desc') ?>SMS수신</a></th>
                                <th scope="col" id="mb_list_adultc"><?php echo subject_sort_link('mb_adult', '', 'desc') ?>성인인증</a></th>
                                <th scope="col" id="mb_list_deny"><?php echo subject_sort_link('mb_intercept_date', '', 'desc') ?>접근차단</a></th>
                                <th scope="col" id="mb_list_tel">전화번호</th>
                                <th scope="col" id="mb_list_point"><?php echo subject_sort_link('mb_point', '', 'desc') ?> 포인트</a></th>
                                <th scope="col" id="mb_list_join"><?php echo subject_sort_link('mb_datetime', '', 'desc') ?>가입일</a></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            for ($i=0; $row=sql_fetch_array($result); $i++) {
                                // 접근가능한 그룹수
                                $sql2 = " select count(*) as cnt from {$g5['group_member_table']} where mb_id = '{$row['mb_id']}' ";
                                $row2 = sql_fetch($sql2);
                                $group = '';
                                if ($row2['cnt'])
                                    $group = '<a href="./boardgroupmember_form.php?mb_id='.$row['mb_id'].'">'.$row2['cnt'].'</a>';

                                if ($is_admin == 'group') {
                                    $s_mod = '';
                                } else {
                                    $s_mod = '<a class="btn btn-default" href="./member_form.php?'.$qstr.'&amp;w=u&amp;mb_id='.$row['mb_id'].'">수정</a>';
                                }
                                $s_grp = '<a class="btn btn-default" href="./boardgroupmember_form.php?mb_id='.$row['mb_id'].'">그룹</a>';

                                $leave_date = $row['mb_leave_date'] ? $row['mb_leave_date'] : date('Ymd', G5_SERVER_TIME);
                                $intercept_date = $row['mb_intercept_date'] ? $row['mb_intercept_date'] : date('Ymd', G5_SERVER_TIME);

                                $mb_nick = get_sideview($row['mb_id'], get_text($row['mb_nick']), $row['mb_email'], $row['mb_homepage']);

                                $mb_id = $row['mb_id'];
                                $leave_msg = '';
                                $intercept_msg = '';
                                $intercept_title = '';
                                if ($row['mb_leave_date']) {
                                    $mb_id = $mb_id;
                                    $leave_msg = '<span class="mb_leave_msg">탈퇴함</span>';
                                }
                                else if ($row['mb_intercept_date']) {
                                    $mb_id = $mb_id;
                                    $intercept_msg = '<span class="mb_intercept_msg">차단됨</span>';
                                    $intercept_title = '차단해제';
                                }
                                if ($intercept_title == '')
                                    $intercept_title = '차단하기';

                                $address = $row['mb_zip1'] ? print_address($row['mb_addr1'], $row['mb_addr2'], $row['mb_addr3'], $row['mb_addr_jibeon']) : '';

                                $bg = 'bg'.($i%2);

                                switch($row['mb_certify']) {
                                    case 'hp':
                                        $mb_certify_case = '휴대폰';
                                        $mb_certify_val = 'hp';
                                        break;
                                    case 'ipin':
                                        $mb_certify_case = '아이핀';
                                        $mb_certify_val = '';
                                        break;
                                    case 'admin':
                                        $mb_certify_case = '관리자';
                                        $mb_certify_val = 'admin';
                                        break;
                                    default:
                                        $mb_certify_case = '&nbsp;';
                                        $mb_certify_val = 'admin';
                                        break;
                                }
                            ?>

                            <tr class="<?php echo $bg; ?>">
                                <td headers="mb_list_chk" class="td_chk" rowspan="2">
                                    <input type="hidden" name="mb_id[<?php echo $i ?>]" value="<?php echo $row['mb_id'] ?>" id="mb_id_<?php echo $i ?>">
                                    
                                    <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
                                </td>
                                <td headers="mb_list_id" rowspan="2" class="td_name sv_use"><?php echo $mb_id ?></td>
                                <td headers="mb_list_name" class="td_mbname"><?php echo get_text($row['mb_name']); ?></td>
                                <td headers="mb_list_cert" colspan="6" class="td_mbcert">
                                    <input type="radio" class='flat' name="mb_certify[<?php echo $i; ?>]" value="ipin" id="mb_certify_ipin_<?php echo $i; ?>" <?php echo $row['mb_certify']=='ipin'?'checked':''; ?>>
                                    <label for="mb_certify_ipin_<?php echo $i; ?>">아이핀</label>
                                    <input type="radio" class='flat' name="mb_certify[<?php echo $i; ?>]" value="hp" id="mb_certify_hp_<?php echo $i; ?>" <?php echo $row['mb_certify']=='hp'?'checked':''; ?>>
                                    <label for="mb_certify_hp_<?php echo $i; ?>">휴대폰</label>
                                </td>
                                <td headers="mb_list_mobile" class="td_tel"><?php echo get_text($row['mb_hp']); ?></td>
                                <td headers="mb_list_auth" class="td_mbstat">
                                    <?php
                                    if ($leave_msg || $intercept_msg) echo $leave_msg.' '.$intercept_msg;
                                    else echo "정상";
                                    ?>
                                    <?php echo get_member_level_select("mb_level[$i]", 1, $member['mb_level'], $row['mb_level']) ?>
                                </td>
                                <td headers="mb_list_lastcall" class="td_date"><?php echo substr($row['mb_today_login'],2,8); ?></td>
                                <td headers="mb_list_grp" rowspan="2" class="td_numsmall"><?php echo $group ?></td>
                                <td headers="mb_list_mng" rowspan="2" class="td_mngsmall"><?php echo $s_mod ?> <?php echo $s_grp ?></td>
                            </tr>
                            <tr class="<?php echo $bg; ?>">
                                <td headers="mb_list_nick" class="td_name sv_use"><div><?php echo $row['mb_nick'] ?></div></td>
                                <td headers="mb_list_mailc" class="td_chk"><?php echo preg_match('/[1-9]/', $row['mb_email_certify'])?'<span class="txt_true">Yes</span>':'<span class="txt_false">No</span>'; ?></td>
                                <td headers="mb_list_open" class="td_chk">
                                    <label for="mb_open_<?php echo $i; ?>" class="sound_only">정보공개</label>
                                    <input type="checkbox" class='flat' name="mb_open[<?php echo $i; ?>]" <?php echo $row['mb_open']?'checked':''; ?> value="1" id="mb_open_<?php echo $i; ?>">
                                </td>
                                <td headers="mb_list_mailr" class="td_chk">
                                    <label for="mb_mailling_<?php echo $i; ?>" class="sound_only">메일수신</label>
                                    <input type="checkbox" class='flat' name="mb_mailling[<?php echo $i; ?>]" <?php echo $row['mb_mailling']?'checked':''; ?> value="1" id="mb_mailling_<?php echo $i; ?>">
                                </td>
                                <td headers="mb_list_sms" class="td_chk">
                                    <label for="mb_sms_<?php echo $i; ?>" class="sound_only">SMS수신</label>
                                    <input type="checkbox" class='flat' name="mb_sms[<?php echo $i; ?>]" <?php echo $row['mb_sms']?'checked':''; ?> value="1" id="mb_sms_<?php echo $i; ?>">
                                </td>
                                <td headers="mb_list_adultc" class="td_chk">
                                    <label for="mb_adult_<?php echo $i; ?>" class="sound_only">성인인증</label>
                                    <input type="checkbox" class='flat' name="mb_adult[<?php echo $i; ?>]" <?php echo $row['mb_adult']?'checked':''; ?> value="1" id="mb_adult_<?php echo $i; ?>">
                                </td>
                                <td headers="mb_list_deny" class="td_chk">
                                    <?php if(empty($row['mb_leave_date'])){ ?>
                                    <input type="checkbox" class='flat' name="mb_intercept_date[<?php echo $i; ?>]" <?php echo $row['mb_intercept_date']?'checked':''; ?> value="<?php echo $intercept_date ?>" id="mb_intercept_date_<?php echo $i ?>" title="<?php echo $intercept_title ?>">
                                    <label for="mb_intercept_date_<?php echo $i; ?>" class="sound_only">접근차단</label>
                                    <?php } ?>
                                </td>
                                <td headers="mb_list_tel" class="td_tel"><?php echo get_text($row['mb_tel']); ?></td>
                                <td headers="mb_list_point" class="td_num"><a href="point_list.php?sfl=mb_id&amp;stx=<?php echo $row['mb_id'] ?>"><?php echo number_format($row['mb_point']) ?></a></td>
                                <td headers="mb_list_join" class="td_date"><?php echo substr($row['mb_datetime'],2,8); ?></td>
                            </tr>

                            <?php
                            }
                            if ($i == 0)
                                echo "<tr><td colspan=\"".$colspan."\" class=\"empty_table\">자료가 없습니다.</td></tr>";
                            ?>
                            </tbody>
                            </table>
                        </div>

                        <div class="btn_list01 btn_list">
                            <input type="submit" name="act_button" value="선택수정" class='btn btn-default' onclick="document.pressed=this.value">
                            <input type="submit" name="act_button" value="선택삭제" class='btn btn-default' onclick="document.pressed=this.value">
                        </div>

                        </form>

                        <?php echo kim_get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?'.$qstr.'&amp;page='); ?>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






<script>
function fmemberlist_submit(f)
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
