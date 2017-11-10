<?php
$sub_menu = "200300";
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], 'r');

$html_title = '회원메일';

if ($w == 'u') {
    $html_title .= '수정';
    $readonly = ' readonly';

    $sql = " select * from {$g5['mail_table']} where ma_id = '{$ma_id}' ";
    $ma = sql_fetch($sql);
    if (!$ma['ma_id'])
        alert('등록된 자료가 없습니다.');
} else {
    $html_title .= '입력';
}

$g5['title'] = $html_title;
include_once('./admin.head.php');
?>






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
            <h3>회원메일</h3>
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
                        <p class='bg-info' style='padding:15px;'>메일 내용에 {이름} , {닉네임} , {회원아이디} , {이메일} 처럼 내용에 삽입하면 해당 내용에 맞게 변환하여 메일을 발송합니다.</p>
                    



                        <form name="fmailform" id="fmailform" action="./mail_update.php" onsubmit="return fmailform_check(this);" method="post">
                        <input type="hidden" name="w" value="<?php echo $w ?>" id="w">
                        <input type="hidden" name="ma_id" value="<?php echo $ma['ma_id'] ?>" id="ma_id">
                        <input type="hidden" name="token" value="" id="token">

                        <div class="tbl_frm01 tbl_wrap table-responsive">
                            <table class='table table-striped table-bordered' >

                            <tbody>
                            <tr>
                                <th scope="row"><label for="ma_subject">메일 제목<span class="required red"> *</span></label></th>
                                <td><input type="text" name="ma_subject" value="<?php echo $ma['ma_subject'] ?>" id="ma_subject" required class="required frm_input form-control" size="100"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="ma_content">메일 내용<span class="required red"> *</span></label></th>
                                <td><?php echo editor_html("ma_content", get_text($ma['ma_content'], 0)); ?></td>
                            </tr>
                            </tbody>
                            </table>
                        </div>

                        <div class="btn_confirm01 btn_confirm">
                            <input type="submit" class="btn_submit btn btn-default" accesskey="s" value="확인">
                        </div>
                        </form>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<script>
function fmailform_check(f)
{
    errmsg = "";
    errfld = "";

    check_field(f.ma_subject, "제목을 입력하세요.");
    //check_field(f.ma_content, "내용을 입력하세요.");

    if (errmsg != "") {
        alert(errmsg);
        errfld.focus();
        return false;
    }

    <?php echo get_editor_js("ma_content"); ?>
    <?php echo chk_editor_js("ma_content"); ?>

    return true;
}

document.fmailform.ma_subject.focus();
</script>

<?php
include_once('./admin.tail.php');
?>
