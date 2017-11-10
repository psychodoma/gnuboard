<?php
$sub_menu = '100310';
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "w");

$nw_id = preg_replace('/[^0-9]/', '', $nw_id);

$html_title = "팝업레이어";
if ($w == "u")
{
    $html_title .= " 수정";
    $sql = " select * from {$g5['new_win_table']} where nw_id = '$nw_id' ";
    $nw = sql_fetch($sql);
    if (!$nw['nw_id']) alert("등록된 자료가 없습니다.");
}
else
{
    $html_title .= " 입력";
    $nw['nw_device'] = 'both';
    $nw['nw_disable_hours'] = 24;
    $nw['nw_left']   = 10;
    $nw['nw_top']    = 10;
    $nw['nw_width']  = 450;
    $nw['nw_height'] = 500;
    $nw['nw_content_html'] = 2;
}

$g5['title'] = $html_title;
include_once (G5_ADMIN_PATH.'/admin.head.php');
?>


<style>
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{  
        vertical-align: initial;
    }
</style>


<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
            <h3>관리권한설정</h3>
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


                        <form name="frmnewwin" action="./newwinformupdate.php" onsubmit="return frmnewwin_check(this);" method="post">
                        <input type="hidden" name="w" value="<?php echo $w; ?>">
                        <input type="hidden" name="nw_id" value="<?php echo $nw_id; ?>">
                        <input type="hidden" name="token" value="">

                        <div class="local_desc01 local_desc">
                            <p class='bg-info' style='padding:15px;'>초기화면 접속 시 자동으로 뜰 팝업레이어를 설정합니다.</p>
                        </div>

                        <div class="tbl_frm01 tbl_wrap table-responsive">
                            <table class="table table-striped table-bordered" >


                            <tbody>
                            <tr>
                                <th scope="row"><label for="nw_device">접속기기</label></th>
                                <td>
                                    <?php echo help("팝업레이어가 표시될 접속기기를 설정합니다."); ?>
                                    <select class='form-control' name="nw_device" id="nw_device">
                                        <option value="both"<?php echo get_selected($nw['nw_device'], 'both', true); ?>>PC와 모바일</option>
                                        <option value="pc"<?php echo get_selected($nw['nw_device'], 'pc'); ?>>PC</option>
                                        <option value="mobile"<?php echo get_selected($nw['nw_device'], 'mobile'); ?>>모바일</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="nw_disable_hours">시간<span class="required red"> *</span></label></th>
                                <td>
                                    <div><?php echo help("고객이 다시 보지 않음을 선택할 시 몇 시간동안 팝업레이어를 보여주지 않을지 설정합니다."); ?></div>
                                    <input type="text" name="nw_disable_hours" value="<?php echo $nw['nw_disable_hours']; ?>" id="nw_disable_hours" required class="frm_input required form-control" style="width:100px; float:left;" size="5"><span>&nbsp;&nbsp;시간<span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="nw_begin_time">시작일시<span class="required red"> *</span></label></th>
                                <td>
                                    <input type="text" name="nw_begin_time" value="<?php echo $nw['nw_begin_time']; ?>" id="nw_begin_time" required class="frm_input required form-control" size="21" maxlength="19">
                                    
                                    <input  type="checkbox" name="nw_begin_chk" value="<?php echo date("Y-m-d 00:00:00", G5_SERVER_TIME); ?>" id="nw_begin_chk" onclick="if (this.checked == true) this.form.nw_begin_time.value=this.form.nw_begin_chk.value; else this.form.nw_begin_time.value = this.form.nw_begin_time.defaultValue;">
                                    <label for="nw_begin_chk">시작일시를 오늘로</label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="nw_end_time">종료일시<span class="required red"> *</span></label></th>
                                <td>
                                    <input type="text" name="nw_end_time" value="<?php echo $nw['nw_end_time']; ?>" id="nw_end_time" required class="frm_input form-control required" size="21" maxlength="19">
                                    
                                    <input  type="checkbox" name="nw_end_chk" value="<?php echo date("Y-m-d 23:59:59", G5_SERVER_TIME+(60*60*24*7)); ?>" id="nw_end_chk" onclick="if (this.checked == true) this.form.nw_end_time.value=this.form.nw_end_chk.value; else this.form.nw_end_time.value = this.form.nw_end_time.defaultValue;">
                                    <label for="nw_end_chk">종료일시를 오늘로부터 7일 후로</label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="nw_left">팝업레이어 좌측 위치<span class="required red"> *</span></label></th>
                                <td>
                                <input type="text" name="nw_left" value="<?php echo $nw['nw_left']; ?>" id="nw_left" required class="frm_input required form-control" style="width:100px; float:left;" size="5"><span>&nbsp;&nbsp;px<span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="nw_top">팝업레이어 상단 위치<span class="required red"> *</span></label></th>
                                <td>
                                    <input type="text" name="nw_top" value="<?php echo $nw['nw_top']; ?>" id="nw_top" required class="frm_input required form-control" style="width:100px; float:left;"  size="5"><span>&nbsp;&nbsp;px<span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="nw_width">팝업레이어 넓이<span class="required red"> *</span></label></th>
                                <td>
                                    <input type="text" name="nw_width" value="<?php echo $nw['nw_width'] ?>" id="nw_width" required class="frm_input required form-control" style="width:100px; float:left;" size="5"><span>&nbsp;&nbsp;px<span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="nw_height">팝업레이어 높이<span class="required red"> *</span></label></th>
                                <td>
                                    <input type="text" name="nw_height" value="<?php echo $nw['nw_height'] ?>" id="nw_height" required class="frm_input required form-control" style="width:100px; float:left;" size="5"><span>&nbsp;&nbsp;px<span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="nw_subject">팝업 제목<span class="required red"> *</span></label></th>
                                <td>
                                    <input type="text" name="nw_subject" value="<?php echo stripslashes($nw['nw_subject']) ?>" id="nw_subject" required class="frm_input required form-control" size="80">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="nw_content">내용</label></th>
                                <td><?php echo editor_html('nw_content', get_text($nw['nw_content'], 0)); ?></td>
                            </tr>
                            </tbody>
                            </table>
                        </div>

                        <div class="btn_confirm01 btn_confirm">
                            <input type="submit" value="확인" class="btn_submit btn btn-default" accesskey="s">
                            <a href="./newwinlist.php" class='btn btn-default'>목록</a>
                        </div>
                        </form>

                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script>
function frmnewwin_check(f)
{
    errmsg = "";
    errfld = "";

    <?php echo get_editor_js('nw_content'); ?>

    check_field(f.nw_subject, "제목을 입력하세요.");

    if (errmsg != "") {
        alert(errmsg);
        errfld.focus();
        return false;
    }
    return true;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
