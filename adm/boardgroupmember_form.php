<?php
$sub_menu = "300200";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');

$mb = get_member($mb_id);
if (!$mb['mb_id'])
    alert('존재하지 않는 회원입니다.');

$g5['title'] = '접근가능그룹';
include_once('./admin.head.php');

$colspan = 4;
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
            <h3>접근가능그룹</h3>
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







                        <form name="fboardgroupmember_form" id="fboardgroupmember_form" action="./boardgroupmember_update.php" onsubmit="return boardgroupmember_form_check(this)" method="post">
                        <input type="hidden" name="mb_id" value="<?php echo $mb['mb_id'] ?>" id="mb_id">
                        <input type="hidden" name="token" value="" id="token">
                        <div class="local_cmd01 local_cmd">
                            <p class='bg-info' style='padding:15px;' >아이디 <b><?php echo $mb['mb_id'] ?></b>, 이름 <b><?php echo get_text($mb['mb_name']); ?></b>, 닉네임 <b><?php echo $mb['mb_nick'] ?></b></p>
                            <label for="gr_id">그룹지정</label>
                            <select class='form-control' style='width:300px; display:initial;' name="gr_id" id="gr_id">
                                <option value="">접근가능 그룹을 선택하세요.</option>
                                <?php
                                $sql = " select *
                                            from {$g5['group_table']}
                                            where gr_use_access = 1 ";
                                //if ($is_admin == 'group') {
                                if ($is_admin != 'super')
                                    $sql .= " and gr_admin = '{$member['mb_id']}' ";
                                $sql .= " order by gr_id ";
                                $result = sql_query($sql);
                                for ($i=0; $row=sql_fetch_array($result); $i++) {
                                    echo "<option value=\"".$row['gr_id']."\">".$row['gr_subject']."</option>";
                                }
                                ?>
                            </select>
                            <input type="submit" value="선택" class="btn_submit btn btn-default" accesskey="s">
                        </div>
                        </form>

                        <form name="fboardgroupmember" id="fboardgroupmember" action="./boardgroupmember_update.php" onsubmit="return fboardgroupmember_submit(this);" method="post">
                        <input type="hidden" name="sst" value="<?php echo $sst ?>" id="sst">
                        <input type="hidden" name="sod" value="<?php echo $sod ?>" id="sod">
                        <input type="hidden" name="sfl" value="<?php echo $sfl ?>" id="sfl">
                        <input type="hidden" name="stx" value="<?php echo $stx ?>" id="stx">
                        <input type="hidden" name="page" value="<?php echo $page ?>" id="page">
                        <input type="hidden" name="token" value="<?php echo $token ?>" id="token">
                        <input type="hidden" name="mb_id" value="<?php echo $mb['mb_id'] ?>" id="mb_id">
                        <input type="hidden" name="w" value="d" id="w">

                        <div class="tbl_head01 tbl_wrap table-responsive">
                            <table class='table table-striped table-bordered' >


                            <thead>
                            <tr>
                                <th scope="col">
                                    <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
                                </th>
                                <th scope="col">그룹아이디</th>
                                <th scope="col">그룹</th>
                                <th scope="col">처리일시</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql = " select * from {$g5['group_member_table']} a, {$g5['group_table']} b
                                        where a.mb_id = '{$mb['mb_id']}'
                                        and a.gr_id = b.gr_id ";
                            if ($is_admin != 'super')
                                $sql .= " and b.gr_admin = '{$member['mb_id']}' ";
                            $sql .= " order by a.gr_id desc ";
                            $result = sql_query($sql);
                            for ($i=0; $row=sql_fetch_array($result); $i++) {
                            ?>
                            <tr>
                                <td class="td_chk">
                                    <input type="checkbox" name="chk[]" value="<?php echo $row['gm_id'] ?>" id="chk_<?php echo $i ?>">
                                </td>
                                <td class="td_grid"><a href="<?php echo G5_BBS_URL; ?>/group.php?gr_id=<?php echo $row['gr_id'] ?>"><?php echo $row['gr_id'] ?></a></td>
                                <td class="td_category"><?php echo $row['gr_subject'] ?></td>
                                <td class="td_datetime"><?php echo $row['gm_datetime'] ?></td>
                            </tr>
                            <?php
                            }

                            if ($i == 0) {
                                echo '<tr><td colspan="'.$colspan.'" class="empty_table">접근가능한 그룹이 없습니다.</td></tr>';
                            }
                            ?>
                            </tbody>
                            </table>
                        </div>

                        <div class="btn_list01 btn_list">
                            <input type="submit" name="" class='btn btn-default' value="선택삭제">
                        </div>
                        </form>


                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script>
function fboardgroupmember_submit(f)
{
    if (!is_checked("chk[]")) {
        alert("선택삭제 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    return true;
}

function boardgroupmember_form_check(f)
{
    if (f.gr_id.value == '') {
        alert('접근가능 그룹을 선택하세요.');
        return false;
    }

    return true;
}
</script>

<?php
include_once('./admin.tail.php');
?>
