<?php
$sub_menu = "200900";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');

$html_title = '투표';
if ($w == '')
    $html_title .= ' 생성';
else if ($w == 'u')  {
    $html_title .= ' 수정';
    $sql = " select * from {$g5['poll_table']} where po_id = '{$po_id}' ";
    $po = sql_fetch($sql);
} else
    alert('w 값이 제대로 넘어오지 않았습니다.');

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





                        <form name="fpoll" id="fpoll" action="./poll_form_update.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="po_id" value="<?php echo $po_id ?>">
                        <input type="hidden" name="w" value="<?php echo $w ?>">
                        <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
                        <input type="hidden" name="stx" value="<?php echo $stx ?>">
                        <input type="hidden" name="sst" value="<?php echo $sst ?>">
                        <input type="hidden" name="sod" value="<?php echo $sod ?>">
                        <input type="hidden" name="page" value="<?php echo $page ?>">
                        <input type="hidden" name="token" value="">

                        <div class="tbl_frm01 tbl_wrap table-responsive">

                            <table class='table table-striped table-bordered' >

                            <tbody>
                            <tr>
                                <th scope="row"><label for="po_subject">투표 제목<span class="required red"> *</span></label></th>
                                <td><input type="text" name="po_subject" value="<?php echo $po['po_subject'] ?>" id="po_subject" required class="required frm_input form-control" size="80" maxlength="125"></td>
                            </tr>

                            <?php
                            for ($i=1; $i<=9; $i++) {
                                $required = '';
                                if ($i==1 || $i==2) {
                                    $required = 'required';
                                    $sound_only = '<span class="required red"> *</span>';
                                }

                                $po_poll = get_text($po['po_poll'.$i]);
                            ?>

                            <tr>
                                <th scope="row"><label for="po_poll<?php echo $i ?>">항목 <?php echo $i ?><?php echo $sound_only ?></label></th>
                                <td>
                                    <input type="text" style='width:200px; display:initial;' name="po_poll<?php echo $i ?>" value="<?php echo $po_poll ?>" id="po_poll<?php echo $i ?>" <?php echo $required ?> class="frm_input form-control <?php echo $required ?>" maxlength="125">
                                    <label for="po_cnt<?php echo $i ?>">항목 <?php echo $i ?> 투표수</label>
                                    <input type="text" style='width:150px; display:initial;' name="po_cnt<?php echo $i ?>" value="<?php echo $po['po_cnt'.$i] ?>" id="po_cnt<?php echo $i ?>" class="form-control frm_input" size="3">
                            </td>
                            </tr>

                            <?php } ?>

                            <tr>
                                <th scope="row"><label for="po_etc">기타의견</label></th>
                                <td>
                                    <?php echo help('기타 의견을 남길 수 있도록 하려면, 간단한 질문을 입력하세요.') ?>
                                    <input type="text" name="po_etc" value="<?php echo get_text($po['po_etc']) ?>" id="po_etc" class="frm_input form-control" size="80" maxlength="125">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="po_level">투표가능 회원레벨</label></th>
                                <td>
                                    <?php echo help("레벨을 1로 설정하면 손님도 투표할 수 있습니다.") ?>
                                    <div class='input-group'>
                                        <?php echo get_member_level_select('po_level', 1, 10, $po['po_level']) ?>
                                        <div class='input-group-addon' >이상 투표할 수 있음</div>
                                        
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="po_point">포인트</label></th>
                                <td>
                                    <?php echo help('투표에 참여한 회원에게 포인트를 부여합니다.') ?>
                                    <div class='input-group'>
                                        <input type="text" name="po_point" value="<?php echo $po['po_point'] ?>" id="po_point" class="frm_input form-control"> 
                                        <div class='input-group-addon' >점</div>
                                    </div>
                                </td>
                            </tr>

                            <?php if ($w == 'u') { ?>
                            <tr>
                                <th scope="row">투표등록일</th>
                                <td><?php echo $po['po_date']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="po_ips">투표참가 IP</label></th>
                                <td><textarea class='form-control' name="po_ips" id="po_ips" readonly rows="10"><?php echo preg_replace("/\n/", " / ", $po['po_ips']) ?></textarea></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="mb_ids">투표참가 회원</label></th>
                                <td><textarea class='form-control' name="mb_ids" id="mb_ids" readonly rows="10"><?php echo preg_replace("/\n/", " / ", $po['mb_ids']) ?></textarea></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                            </table>

                        </div>

                        <div class="btn_confirm01 btn_confirm">
                            <input type="submit" value="확인" class="btn_submit btn btn-default" accesskey="s">
                            <a class='btn btn-default' href="./poll_list.php?<?php echo $qstr ?>">목록</a>
                        </div>

                        </form>









                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
































<?php
include_once('./admin.tail.php');
?>
