<?php
$sub_menu = "900500";
include_once("./_common.php");

$colspan = 5;

auth_check($auth[$sub_menu], "r");

$g5['title'] = "이모티콘 그룹";

$res = sql_fetch("select count(*) as cnt from {$g5['sms5_form_group_table']}");
$total_count = $res['cnt'];

$group = array();
$qry = sql_query("select * from {$g5['sms5_form_group_table']} order by fg_name");
while ($res = sql_fetch_array($qry)) array_push($group, $res);

include_once(G5_ADMIN_PATH.'/admin.head.php');
?>

<script>

function move(fg_no, fg_name, sel) {
    var msg = '';
    if (sel.value)
    {
        msg  = "'" + fg_name + "' 그룹에 속한 모든 데이터를\n\n'";
        msg += sel.options[sel.selectedIndex].text + "' 그룹으로 이동하시겠습니까?";

        if (confirm(msg))
            location.href = 'form_group_move.php?fg_no=' + fg_no + '&move_no=' + sel.value;
        else
            sel.selectedIndex = 0;
    }
}

function empty(fg_no) {
    if (confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n그룹에 속한 데이터를 정말로 비우시겠습니까?"))
        location.href = 'form_group_update.php?w='+ fg_no +'&fg_no=' + fg_no;
}

function grouplist_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n삭제되는 그룹에 속한 자료는 '미분류'로 이동됩니다.\n\n그래도 삭제하시겠습니까?")) {
            f.w.value = "de";
        } else {
            return false;
        }
    }

    if(document.pressed == "선택비우기") {
        if(confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n그룹에 속한 데이터를 정말로 비우시겠습니까?")) {
            f.w.value = "em";
        } else {
            return false;
        }
    }

    return true;
}

</script>








<style>

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
            <h3>이모티콘 그룹</h3>
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
                            <span class="count_add01">건수 : <?php echo $total_count ?></span>
                        </p>

                        <form name="group<?php echo $res['fg_no']?>" method="post" action="./form_group_update.php" class="local_sch02 local_sch">
                            
                            <div class="title_right">
                                
                                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                    
                                <div class="input-group">
                                    <input placeholder="그룹명을 입력하세요." type="text" id="fg_name" name="fg_name" required class="required frm_input form-control" >
                                    
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn_submit" type="submit"><i class="fa fa-plus"></i></button>
                                    </span>
                                </div>
                                </div>
                            </div>
                        </form>



                        <div class="local_desc01 local_desc">
                            <p>그룹명순으로 정렬됩니다.</p>
                        </div>

                        <form name="group<?php echo $group[$i]['fg_no']?>" method="post" action="./form_group_update.php" onsubmit="return grouplist_submit(this);">
                        <input type="hidden" name="w" value="u">

                        <div class="tbl_head01 tbl_wrap table-responsive">
                            <table class='table table-striped table-bordered'>

                            <thead>
                            <tr>
                                <th scope="col">
                                    <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
                                </th>
                                <th scope="col">그룹명</th>
                                <th scope="col">이모티콘수</th>
                                <th scope="col">이동</th>
                                <th scope="col">보기</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $qry = sql_query("select count(*) as cnt from {$g5['sms5_form_table']} where fg_no=0");
                            $res = sql_fetch_array($qry);
                            ?>
                            <tr>
                                <td></td>
                                <td style='text-align:center;'>미분류</td>
                                <td class="td_numbig" style='text-align:center;'><?php echo number_format($res['cnt'])?></td>
                                <td class="td_mng">
                                    <label for="select_fg_no_<?php echo $i; ?>" class="sound_only">그룹명</label>
                                    <select class='form-control' name="select_fg_no_999" id="select_fg_no_999" onchange="move(0, '미분류', this);">
                                        <option value=""></option>
                                        <?php for ($i=0; $i<count($group); $i++) { ?>
                                        <option value="<?php echo $group[$i]['fg_no']?>"> <?php echo $group[$i]['fg_name']?> </option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td class="td_mng" style='text-align:center;'>
                                    <a class='btn btn-default' href="./form_list.php?fg_no=0">보기</a>
                                    <!-- <button type="button" onclick="empty('no');">비우기</button> -->
                                </td>
                            </tr>
                            <?php
                            for ($i=0; $i<count($group); $i++) {
                                $bg = 'bg'.(($i + 1)%2);
                            ?>
                            <tr class="<?php echo $bg; ?>">
                                <td class="td_mng" style='text-align:center;'>
                                    <input type="hidden" name="fg_no[<?php echo $i ?>]" value="<?php echo $group[$i]['fg_no']?>" id="fg_no_<?php echo $i ?>">
                                    <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
                                </td>
                                <td>
                                    <input type="text" name="fg_name[<?php echo $i; ?>]" value="<?php echo $group[$i]['fg_name']?>" id="fg_name_<?php echo $i; ?>" class="form-control frm_input">
                                    <br><input class='flat' type="checkbox" name="fg_member[<?php echo $i; ?>]" value="1" id="fg_member_<?php echo $i; ?>" <?php if ($group[$i]['fg_member']) echo 'checked';?>>
                                    <label for="fg_member_<?php echo $i; ?>">회원</label>
                                </td>
                                <td class="td_numbig" style='text-align:center;'>
                                    <?php echo number_format($group[$i]['fg_count'])?>
                                </td>
                                <td class="td_mng">
                                    <label for="select_fg_no_<?php echo $i; ?>" class="sound_only">그룹명</label>
                                    <select class='form-control' name="select_fg_no[<?php echo $i; ?>]" id="select_fg_no_<?php echo $i; ?>" onchange="move(<?php echo $group[$i]['fg_no']?>, '<?php echo $group[$i]['fg_name']?>', this);">
                                        <option value=''></option>
                                        <option value='0'>미분류</option>
                                        <?php for ($j=0; $j<count($group); $j++) { ?>
                                        <?php if ($group[$i]['fg_no']==$group[$j]['fg_no']) continue; ?>
                                        <option value="<?php echo $group[$j]['fg_no']?>"> <?php echo $group[$j]['fg_name']?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td class="td_mng" style='text-align:center;'>
                                    <a class='btn btn-default' href="./form_list.php?fg_no=<?php echo $group[$i]['fg_no']?>">보기</a>
                                </td>
                            </tr>
                            <?php } ?>
                            </tbody>
                            </table>
                            
                        </div>

                        <div class="btn_list01 btn_list">
                            <input class='btn btn-default' type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value">
                            <input class='btn btn-default' type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value">
                            <input class='btn btn-default' type="submit" name="act_button" value="선택비우기" onclick="document.pressed=this.value">
                        </div>

                        </form>



                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>