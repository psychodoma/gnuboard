<?php
$sub_menu = "100200";
include_once('./_common.php');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

$sql_common = " from {$g5['auth_table']} a left join {$g5['member_table']} b on (a.mb_id=b.mb_id) ";

$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        default :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "a.mb_id, au_menu";
    $sod = "";
}
$sql_order = " order by $sst $sod ";

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

$g5['title'] = "관리권한설정";
include_once('./admin.head.php');

$colspan = 5;
?>




<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
            <h3>관리권한설정</h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class='row' >





             <!-- 홈페이지 기본환경 설정 끝! 두번째 첫번째         2017-09-22에는 여기서부터 하면됩니다!!           -->
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
                    <h4><?php echo $listall ?></h4>
                    설정된 관리권한 <?php echo number_format($total_count) ?>건
                  </div>
                </div>
              </div>

              <form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">
              <input type="hidden" name="sfl" value="a.mb_id" id="sfl">

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                  
                    <input type="text" class="form-control" placeholder="단어를 입력하세요..."  name="stx" value="<?php echo $stx ?>" id="stx" required >
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button"><i class="fa fa-search"></i></a></button>
                    </span>
                  </div>
                </div>
              </div>
              </form>

 

<style>

table{
    text-align:center;
}
table th{
    text-align:center;
}
</style>



<form name="fauthlist" id="fauthlist" method="post" action="./auth_list_delete.php" onsubmit="return fauthlist_submit(this);">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

    <div class='table-responsive' >
    <table class="table table-striped table-bordered"><br>
    <thead>
    <tr>
        <th scope="col">
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col"><?php echo subject_sort_link('a.mb_id') ?>회원아이디</a></th>
        <th scope="col"><?php echo subject_sort_link('mb_nick') ?>닉네임</a></th>
        <th scope="col">메뉴</th>
        <th scope="col">권한</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $count = 0;
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $is_continue = false;
        // 회원아이디가 없는 메뉴는 삭제함
        if($row['mb_id'] == '' && $row['mb_nick'] == '') {
            sql_query(" delete from {$g5['auth_table']} where au_menu = '{$row['au_menu']}' ");
            $is_continue = true;
        }

        // 메뉴번호가 바뀌는 경우에 현재 없는 저장된 메뉴는 삭제함
        if (!isset($auth_menu[$row['au_menu']]))
        {
            sql_query(" delete from {$g5['auth_table']} where au_menu = '{$row['au_menu']}' ");
            $is_continue = true;
        }

        if($is_continue)
            continue;

        $mb_nick = get_sideview($row['mb_id'], $row['mb_nick'], $row['mb_email'], $row['mb_homepage']);

        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">
        <td class="td_chk">
            <input type="hidden" name="au_menu[<?php echo $i ?>]" value="<?php echo $row['au_menu'] ?>">
            <input type="hidden" name="mb_id[<?php echo $i ?>]" value="<?php echo $row['mb_id'] ?>">
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
        </td>
        <td class="td_mbid"><a href="?sfl=a.mb_id&amp;stx=<?php echo $row['mb_id'] ?>"><?php echo $row['mb_id'] ?></a></td>
        <td class="td_auth_mbnick"><?php echo $row['mb_nick'] ?></td>
        <td class="td_menu">
            <?php echo $row['au_menu'] ?>
            <?php echo $auth_menu[$row['au_menu']] ?>
        </td>
        <td class="td_auth"><?php echo $row['au_auth'] ?></td>
    </tr>
    <?php
        $count++;
    }

    if ($count == 0)
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>


<div class="btn_list01 btn_list">
    <input type="submit" class='btn btn-default' name="act_button" value="선택삭제" onclick="document.pressed=this.value">
</div>

<?php
//if (isset($stx))
//    echo '<script>document.fsearch.sfl.value = "'.$sfl.'";</script>'."\n";

if (strstr($sfl, 'mb_id'))
    $mb_id = $stx;
else
    $mb_id = '';
?>
</form>

<?php
$pagelist = kim_get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page=');
echo $pagelist;
?>






<div class="ln_solid"></div>


<form name="fauthlist2" id="fauthlist2" action="./auth_update.php" method="post" autocomplete="off">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">


    <h2 class="h2_frm">관리권한 추가</h2>

        <p class='bg-info' style='padding:15px;'>
            다음 양식에서 회원에게 관리권한을 부여하실 수 있습니다.<br>
            권한 <strong>r</strong>은 읽기권한, <strong>w</strong>는 쓰기권한, <strong>d</strong>는 삭제권한입니다.
        </p>



    <div class="tbl_frm01 tbl_wrap col-md-6 col-sm-12 col-xs-12">
        <table class="table  table-bordered ">

  
        <tr>
            <th scope="row"><label for="mb_id">회원아이디</label></th>
            <td>
                <strong id="msg_mb_id" class="msg_sound_only"></strong>
                <input type="text" class='form-control' name="mb_id" value="<?php echo $mb_id ?>" id="mb_id" required class="required frm_input">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="au_menu">접근가능메뉴</label></th>
            <td>
                <select id="au_menu" name="au_menu" required class="required form-control">
                    <option value=''>선택하세요</option>
                    <?php
                    foreach($auth_menu as $key=>$value)
                    {
                        if (!(substr($key, -3) == '000' || $key == '-' || !$key))
                            echo '<option value="'.$key.'">'.$key.' '.$value.'</option>';
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row">권한지정</th>
            <td>
                <input type="checkbox" class='flat' name="r" value="r" id="r" checked>
                <sapn for="r">r (읽기)&nbsp;&nbsp;&nbsp;&nbsp;</sapn>
                <input type="checkbox" class='flat' name="w" value="w" id="w">
                <sapn for="w">w (쓰기)&nbsp;&nbsp;&nbsp;&nbsp;</sapn>
                <input type="checkbox" class='flat' name="d" value="d" id="d">
                <sapn for="d">d (삭제)&nbsp;&nbsp;&nbsp;&nbsp;</sapn>
            </td>
        </tr>

        </table>
    </div>

    <div class="btn_confirm01 btn_confirm col-md-12 col-sm-12 col-xs-12">
        <input class='btn btn-default' type="submit" value="추가" class="btn_submit">
    </div>


</form>
























                  </div>
                </div>
              </div>
              <!-- /form input mask -->






        </div>
    </div>

</div>














<script>
function fauthlist_submit(f)
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
