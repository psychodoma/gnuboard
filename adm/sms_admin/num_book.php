<?php
$sub_menu = "900800";
include_once("./_common.php");

$page_size = 20;
$colspan = 9;

auth_check($auth[$sub_menu], "r");

$token = get_token();

$g5['title'] = "휴대폰번호 관리";

if ($page < 1) $page = 1;

if (is_numeric($bg_no))
    $sql_group = " and bg_no='$bg_no' ";
else
    $sql_group = "";

if ($st == 'all') {
    $sql_search = "and (bk_name like '%{$sv}%' or bk_hp like '%{$sv}%')";
} else if ($st == 'name') {
    $sql_search = "and bk_name like '%{$sv}%'";
} else if ($st == 'hp') {
    $sql_search = "and bk_hp like '%{$sv}%'";
} else {
    $sql_search = '';
}

if ($ap > 0)
    $sql_korean = korean_index('bk_name', $ap-1);
else {
    $sql_korean = '';
    $ap = 0;
}

if ($no_hp == 'yes') {
    set_cookie('cookie_no_hp', 'yes', 60*60*24*365);
    $no_hp_checked = 'checked';
} else if ($no_hp == 'no') {
    set_cookie('cookie_no_hp', '', 0);
    $no_hp_checked = '';
} else {
    if (get_cookie('cookie_no_hp') == 'yes')
        $no_hp_checked = 'checked';
    else
        $no_hp_checked = '';
}

if ($no_hp_checked == 'checked')
    $sql_no_hp = "and bk_hp <> ''";

$total_res = sql_fetch("select count(*) as cnt from {$g5['sms5_book_table']} where 1 $sql_group $sql_search $sql_korean $sql_no_hp");
$total_count = $total_res['cnt'];

$total_page = (int)($total_count/$page_size) + ($total_count%$page_size==0 ? 0 : 1);
$page_start = $page_size * ( $page - 1 );

$vnum = $total_count - (($page-1) * $page_size);

$res = sql_fetch("select count(*) as cnt from {$g5['sms5_book_table']} where bk_receipt=1 $sql_group $sql_search $sql_korean $sql_no_hp");
$receipt_count = $res['cnt'];
$reject_count = $total_count - $receipt_count;

$res = sql_fetch("select count(*) as cnt from {$g5['sms5_book_table']} where mb_id='' $sql_group $sql_search $sql_korean $sql_no_hp");
$no_member_count = $res['cnt'];
$member_count = $total_count - $no_member_count;

$no_group = sql_fetch("select * from {$g5['sms5_book_group_table']} where bg_no = 1");

$group = array();
$qry = sql_query("select * from {$g5['sms5_book_group_table']} where bg_no>1 order by bg_name");
while ($res = sql_fetch_array($qry)) array_push($group, $res);

include_once(G5_ADMIN_PATH.'/admin.head.php');
?>

<script>

function book_all_checked(chk)
{
    if (chk) {
        jQuery('[name="bk_no[]"]').attr('checked', true);
    } else {
        jQuery('[name="bk_no[]"]').attr('checked', false);
    }
}

function no_hp_click(val)
{
    var url = './num_book.php?bg_no=<?php echo $bg_no?>&st=<?php echo $st?>&sv=<?php echo $sv?>';

    if (val == true)
        location.href = url + '&no_hp=yes';
    else
        location.href = url + '&no_hp=no';
}
</script>









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
            <h3>휴대폰번호 관리</h3>
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
                            <span class="ov_listall">회원정보 최근 업데이트 <?php echo $sms5['cf_datetime']?>&nbsp;&nbsp;</span>
                            <span class="ov_listall">총 건수 <?php echo number_format($total_count)?>명&nbsp;&nbsp;</span>
                            <span class="ov_listall">회원 <?php echo number_format($member_count)?>명&nbsp;&nbsp;</span>
                            <span class="ov_listall">비회원 <?php echo number_format($no_member_count)?>명&nbsp;&nbsp;</span>
                            <span class="ov_listall">수신 <?php echo number_format($receipt_count)?>명&nbsp;&nbsp;</span>
                            <span class="ov_listall">거부 <?php echo number_format($reject_count)?>명&nbsp;&nbsp;</span>
                        </p>





                        <form name="search_form" method="get" action="<?php echo $_SERVER['SCRIPT_NAME']?>" class="local_sch01 local_sch">
                        <input type="hidden" name="bg_no" value="<?php echo $bg_no?>" >
                            <div class="title_right">
                                
                                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                    
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="단어를 입력하세요..."  name="sv" value="<?php echo $sv?>" id="sv" required >
                                    
                              
                                    <span class="input-group-btn">
                                        
                                        <select class='form-control' name="st" id="st" style='width:200px;'>
                                            <option value="all"<?php echo get_selected('all', $st); ?>>이름 + 휴대폰번호</option>
                                            <option value="name"<?php echo get_selected('name', $st); ?>>이름</option>
                                            <option value="hp" <?php echo get_selected('hp', $st); ?>>휴대폰번호</option>
                                        </select>

                                    </span>

                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn_submit" type="submit"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                                </div>
                            </div>
                        </form>



                        <form name="search_form" class="local_sch01 local_sch">

                        <div class='input-group'>
                            <div class='input-group-addon'>그룹명</div>
                            <select class='form-control' name="bg_no" id="bg_no" onchange="location.href='<?php echo $_SERVER['SCRIPT_NAME']?>?bg_no='+this.value;">
                                <option value=""<?php echo get_selected('', $bg_no); ?>> 전체 </option>
                                <option value="<?php echo $no_group['bg_no']?>"<?php echo get_selected($bg_no, $no_group['bg_no']); ?>> <?php echo $no_group['bg_name']?> (<?php echo number_format($no_group['bg_count'])?> 명) </option>
                                <?php for($i=0; $i<count($group); $i++) {?>
                                <option value="<?php echo $group[$i]['bg_no']?>"<?php echo get_selected($bg_no, $group[$i]['bg_no']);?>> <?php echo $group[$i]['bg_name']?> (<?php echo number_format($group[$i]['bg_count'])?> 명) </option>
                                <?php } ?>
                            </select>
                        </div>

                        <input  type="checkbox" name="no_hp" id="no_hp" <?php echo $no_hp_checked?> onclick="no_hp_click(this.checked)">
                        <label for="no_hp">휴대폰 소유자만 보기</label>
                        </form><br>

                        <p>
                            <a class='btn btn-default' href="./num_book_write.php?page=<?php echo $page?>&amp;bg_no=<?php echo $bg_no?>">번호추가</a>
                        </p>

                        <form name="hp_manage_list" id="hp_manage_list" method="post" action="./num_book_multi_update.php" onsubmit="return hplist_submit(this);" >
                        <input type="hidden" name="page" value="<?php echo $page; ?>">
                        <input type="hidden" name="token" value="<?php echo $token; ?>">
                        <input type="hidden" name="sw" value="">
                        <input type="hidden" name="atype" value="del">
                        <input type="hidden" name="str_query" value="<?php echo clean_query_string($_SERVER['QUERY_STRING']); ?>" >

                        <div class="tbl_head01 tbl_wrap table-responsive">
                            <table class='table table-striped table-bordered'>

                            <thead>
                            <tr>
                                <th scope="col">
                                    <input type="checkbox" id="chk_all" onclick="book_all_checked(this.checked)">
                                </th>
                                <th scope="col">번호</th>
                                <th scope="col">그룹</th>
                                <th scope="col">이름</th>
                                <th scope="col">휴대폰</th>
                                <th scope="col">수신</th>
                                <th scope="col">아이디</th>
                                <th scope="col">업데이트</th>
                                <th scope="col">관리</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!$total_count) { ?>
                            <tr>
                                <td colspan="<?php echo $colspan?>" class="empty_table">데이터가 없습니다.</td>
                            </tr>
                            <?php
                            }
                            $line = 0;
                            $qry = sql_query("select * from {$g5['sms5_book_table']} where 1 $sql_group $sql_search $sql_korean $sql_no_hp order by bk_no desc limit $page_start, $page_size");
                            while($res = sql_fetch_array($qry))
                            {
                                $bg = 'bg'.($line++%2);

                                $tmp = sql_fetch("select bg_name from {$g5['sms5_book_group_table']} where bg_no='{$res['bg_no']}'");
                                $group_name = $tmp['bg_name'];
                            ?>
                            <tr class="<?php echo $bg; ?>">
                                <td class="td_chk">
                                    <input type="checkbox" name="bk_no[]" value="<?php echo $res['bk_no']?>" id="bk_no_<?php echo $i; ?>">
                                </td>
                                <td class="td_num"><?php echo number_format($vnum--)?></td>
                                <td><?php echo $group_name?></td>
                                <td class="td_mbname"><?php echo get_text($res['bk_name']) ?></td>
                                <td class="td_numbig"><?php echo $res['bk_hp']?></td>
                                <td class="td_boolean"><?php echo $res['bk_receipt'] ? '<font color=blue>수신</font>' : '<font color=red>거부</font>'?></td>
                                <td class="td_mbid"><?php echo $res['mb_id'] ? $res['mb_id'] : '비회원'?></td>
                                <td class="td_datetime"><?php echo $res['bk_datetime']?></td>
                                <td class="td_mng">
                                    <a class='btn btn-default' href="./num_book_write.php?w=u&amp;bk_no=<?php echo $res['bk_no']?>&amp;page=<?php echo $page?>&amp;bg_no=<?php echo $bg_no?>&amp;st=<?php echo $st?>&amp;sv=<?php echo $sv?>&amp;ap=<?php echo $ap?>">수정</a>
                                    <a class='btn btn-default' href="./sms_write.php?bk_no=<?php echo $res['bk_no']?>">보내기</a>
                                    <a class='btn btn-default' href="./history_num.php?st=hs_hp&amp;sv=<?php echo $res['bk_hp']?>">내역</a>
                                </td>
                            </tr>
                            <?php } ?>
                            </tbody>
                            </table>
                        </div>

                        <div class="btn_list01 btn_list">
                            <input class='btn btn-default' type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value">
                            <input class='btn btn-default' type="submit" name="act_button" value="수신허용" onclick="document.pressed=this.value">
                            <input class='btn btn-default' type="submit" name="act_button" value="수신거부" onclick="document.pressed=this.value">
                            <input class='btn btn-default' type="submit" name="act_button" value="선택이동" onclick="document.pressed=this.value">
                            <input class='btn btn-default' type="submit" name="act_button" value="선택복사" onclick="document.pressed=this.value">
                        </div>
                        </form>


                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script>
function hplist_submit(f){
    if (!is_checked("bk_no[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }
    if(document.pressed == "선택이동") {
        select_copy("move", f);
        return;
    }
    if(document.pressed == "선택복사") {
        select_copy("copy", f);
        return;
    }
    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }
    if(document.pressed == "수신허용") {
        f.atype.value="receipt";
    }
    if(document.pressed == "수신거부") {
        f.atype.value="reject";
    }
    return true;
}
// 선택한 이모티콘 그룹 이동
function select_copy(sw, f) {
    if( !f ){
        var f = document.emoticonlist;
    }
    if (sw == "copy")
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./num_book_move.php";
    f.submit();
}
</script>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME']."?bg_no=$bg_no&amp;st=$st&amp;sv=$sv&amp;ap=$ap&amp;page="); ?>

<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>