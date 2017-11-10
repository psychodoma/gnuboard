<?php
$sub_menu = '300700';
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "w");

$sql = " select * from {$g5['faq_master_table']} where fm_id = '$fm_id' ";
$fm = sql_fetch($sql);

$html_title = 'FAQ '.$fm['fm_subject'];

if ($w == "u")
{
    $html_title .= " 수정";
    $readonly = " readonly";

    $sql = " select * from {$g5['faq_table']} where fa_id = '$fa_id' ";
    $fa = sql_fetch($sql);
    if (!$fa['fa_id']) alert("등록된 자료가 없습니다.");
}
else
    $html_title .= ' 항목 입력';

$g5['title'] = $html_title.' 관리';

include_once (G5_ADMIN_PATH.'/admin.head.php');
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



                        <form name="frmfaqform" action="./faqformupdate.php" onsubmit="return frmfaqform_check(this);" method="post">
                        <input type="hidden" name="w" value="<?php echo $w; ?>">
                        <input type="hidden" name="fm_id" value="<?php echo $fm_id; ?>">
                        <input type="hidden" name="fa_id" value="<?php echo $fa_id; ?>">
                        <input type="hidden" name="token" value="">

                        <div class="tbl_frm01 tbl_wrap table-responsive">
                            <table class='table table-striped table-bordered'>

                            <tbody>
                            <tr>
                                <th scope="row"><label for="fa_order">출력순서</label></th>
                                <td>
                                    <p><?php echo help('숫자가 작을수록 FAQ 페이지에서 먼저 출력됩니다.'); ?></p>
                                    <input type="text" name="fa_order" value="<?php echo $fa['fa_order']; ?>" id="fa_order" class="frm_input form-control" maxlength="10" size="10">
                                    <?php if ($w == 'u') { ?><br><a href="<?php echo G5_BBS_URL; ?>/faq.php?fm_id=<?php echo $fm_id; ?>" class="btn btn-default btn_frmline">내용보기</a><?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">질문</th>
                                <td><?php echo editor_html('fa_subject', get_text($fa['fa_subject'], 0)); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">답변</th>
                                <td><?php echo editor_html('fa_content', get_text($fa['fa_content'], 0)); ?></td>
                            </tr>
                            </tbody>
                            </table>
                        </div>

                        <div class="btn_confirm01 btn_confirm">
                            <input type="submit" value="확인" class="btn_submit btn btn-default" accesskey="s">
                            <a href="./faqlist.php?fm_id=<?php echo $fm_id; ?>" class='btn btn-default'>목록</a>
                        </div>

                        </form>

                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






<script>
function frmfaqform_check(f)
{
    errmsg = "";
    errfld = "";

    //check_field(f.fa_subject, "제목을 입력하세요.");
    //check_field(f.fa_content, "내용을 입력하세요.");

    if (errmsg != "")
    {
        alert(errmsg);
        errfld.focus();
        return false;
    }

    <?php echo get_editor_js('fa_subject'); ?>
    <?php echo get_editor_js('fa_content'); ?>

    return true;
}

// document.getElementById('fa_order').focus(); 포커스 해제
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
