<?php
$sub_menu = '300700';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = 'FAQ 상세관리';
if ($fm_subject) $g5['title'] .= ' : '.$fm_subject;
include_once (G5_ADMIN_PATH.'/admin.head.php');

$sql = " select * from {$g5['faq_master_table']} where fm_id = '$fm_id' ";
$fm = sql_fetch($sql);

$sql_common = " from {$g5['faq_table']} where fm_id = '$fm_id' ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row[cnt];

$sql = "select * $sql_common order by fa_order , fa_id ";
$result = sql_query($sql);
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
            <h3>FAQ 상세관리</h3>
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
                            등록된 FAQ 상세내용 <?php echo $total_count; ?>건
                        </p>

                        <ol class='bg-success' style='padding:15px 30px;'>
                            <li>FAQ는 무제한으로 등록할 수 있습니다</li>
                            <li><strong>FAQ 상세내용 추가</strong>를 눌러 자주하는 질문과 답변을 입력합니다.</li>
                        </ol>

                        <p class="btn_add01 btn_add">
                            <a class='btn btn-default' href="./faqform.php?fm_id=<?php echo $fm['fm_id']; ?>">FAQ 상세내용 추가</a>
                        </p>

                        <div class="tbl_head01 tbl_wrap table-responsive">
                            <table class='table table-striped table-bordered'>

                            <thead>
                            <tr>
                                <th scope="col">번호</th>
                                <th scope="col">제목</th>
                                <th scope="col">순서</th>
                                <th scope="col">관리</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            for ($i=0; $row=sql_fetch_array($result); $i++)
                            {
                                $row1 = sql_fetch(" select COUNT(*) as cnt from {$g5['faq_table']} where fm_id = '{$row['fm_id']}' ");
                                $cnt = $row1[cnt];

                                $s_mod = icon("수정", "");
                                $s_del = icon("삭제", "");

                                $num = $i + 1;

                                $bg = 'bg'.($i%2);
                            ?>

                            <tr class="<?php echo $bg; ?>">
                                <td class="td_num"><?php echo $num; ?></td>
                                <td><?php echo stripslashes($row['fa_subject']); ?></td>
                                <td class="td_num"><?php echo $row['fa_order']; ?></td>
                                <td class="td_mngsmall">
                                    <a class='btn btn-default' href="./faqform.php?w=u&amp;fm_id=<?php echo $row['fm_id']; ?>&amp;fa_id=<?php echo $row['fa_id']; ?>">수정</a>
                                    <a class='btn btn-default' href="./faqformupdate.php?w=d&amp;fm_id=<?php echo $row['fm_id']; ?>&amp;fa_id=<?php echo $row['fa_id']; ?>" onclick="return delete_confirm(this);">삭제</a>
                                </td>
                            </tr>

                            <?php
                            }

                            if ($i == 0) {
                                echo '<tr><td colspan="4" class="empty_table">자료가 없습니다.</td></tr>';
                            }
                            ?>
                            </tbody>
                            </table>

                        </div>

                        <div class="btn_confirm01 btn_confirm">
                            <a class='btn btn-default' href="./faqmasterlist.php">FAQ 관리</a>
                        </div>

                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
