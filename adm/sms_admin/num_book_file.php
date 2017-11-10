<?php
$sub_menu = "900900";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$g5['title'] = "휴대폰번호 파일";

$no_group = sql_fetch("select * from {$g5['sms5_book_group_table']} where bg_no = 1");

$group = array();
$qry = sql_query("select * from {$g5['sms5_book_group_table']} where bg_no > 1 order by bg_name");
while ($res = sql_fetch_array($qry)) array_push($group, $res);

include_once(G5_ADMIN_PATH.'/admin.head.php');
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
            <h3>휴대폰번호 파일</h3>
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




                   
                        <h2>파일 업로드</h2>

                        <ol class='bg-info' style='padding:15px 30px; line-height:25px;'>
                            <li>
                                엑셀에 저장된 휴대폰번호 목록을 데이터베이스에 저장할 수 있습니다.
                            </li>

                            <li>
                                엑셀에는 이름과 휴대폰번호 두개만 저장해주세요. 첫번째 라인부터 저장됩니다.<br>
                                ※ 휴대폰번호에 하이픈(-)은 포함되어도 되고 포함되지 않아도 됩니다.
                            </li>

                            <li>
                                엑셀파일은 XLS( Excel 97 - 2003 통합 문서 ) 또는 CSV형식만 업로드 할수 있습니다. (xlsx 불가)<br>
                                <strong>CSV 저장방법 : 파일 > 다른 이름으로 저장 > 파일형식 : CSV (쉼표로 분리) (*.CSV)</strong>
                            </li>

                            <li>
                                이 작업을 실행하기 전에 <a href="<?php echo G5_SMS5_ADMIN_URL; ?>/member_update.php" target="_blank">회원정보업데이트</a>를 먼저 실행해주세요.
                            </li>
                        </ol>
                   

                        <form name="upload_form" method="post" enctype="multipart/form-data" id="sms5_fileup_frm">

                            <p>그룹선택</p>
                            <select class='form-control' name="upload_bg_no" id="upload_bg_no">
                                <option value=""></option>
                                <option value="1"> <?php echo $no_group['bg_name']?> (<?php echo number_format($no_group['bg_count'])?>) </option>
                                <?php for ($i=0; $i<count($group); $i++) { ?>
                                <option value="<?php echo $group[$i]['bg_no']?>"> <?php echo $group[$i]['bg_name']?> (<?php echo number_format($group[$i]['bg_count'])?>) </option>
                                <?php } ?>
                            </select>

                            <p for="csv">파일선택</p>
                            <input type="file" name="csv" id="csv" onchange="document.getElementById('upload_info').style.display='none';">
                            <span id="upload_button">
                                <br>
                                <input type="button" value="파일전송" onclick="upload();" class="btn_submit btn btn-default">
                            </span>
                            <span id="uploading" class="sms_fileup_hide">
                                파일을 업로드 중입니다. 잠시만 기다려주세요.
                            </span>

                            <div id="upload_info" class="sms_fileup_hide"></div>
                            <div id="register" class="sch_last sms_fileup_hide">
                                휴대폰번호를 DB에 저장중 입니다. 잠시만 기다려주세요.
                            </div>
                       
                        </form>

                        <h2>파일 다운로드</h2>
                        <ol class='bg-info' style='padding:15px 30px; line-height:25px;'>
                            <li>
                                저장된 휴대폰번호 목록을 엑셀(xls) 파일로 다운로드 할 수 있습니다.<br>
                                다운로드 할 휴대폰번호 그룹을 선택해주세요.
                            </li>
                        </ol>

                        <div class="local_sch01 local_sch">
                            <p>
                                <input class='flat' type="checkbox" value="1" id="no_hp">
                                <label for="no_hp">휴대폰 번호 없는 회원 포함</label><br>
                                <input class='flat' type="checkbox" value="1" id="hyphen">
                                <label for="hyphen">하이픈 '―' 포함</label>
                            </p>

                            <p for="download_bg_no">그룹선택</p>
                            <select class='form-control' name="download_bg_no" id="download_bg_no">
                                <option value=""> </option>
                                <option value="all"> 전체 </option>
                                <option value="1"> <?php echo $no_group['bg_name']?> (<?php echo number_format($no_group['bg_count'])?>) </option>
                                <?php for ($i=0; $i<count($group); $i++) { ?>
                                <option value="<?php echo $group[$i]['bg_no']?>"> <?php echo $group[$i]['bg_name']?> (<?php echo number_format($group[$i]['bg_count'])?>) </option>
                                <?php } ?>
                            </select><br>
                            <button type="button" onclick="download()" class="btn_submit btn btn-default">다운로드</button>
                        </div>


                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<script>
function upload(w)
{
    var f = document.upload_form;

    if (typeof w == 'undefined') {
        document.getElementById('upload_button').style.display = 'none';
        document.getElementById('uploading').style.display = 'inline';
        document.getElementById('upload_info').style.display = 'none';
        f.action = 'num_book_file_upload.php?confirm=1';
    } else {
        document.getElementById('upload_button').style.display = 'none';
        document.getElementById('upload_info').style.display = 'none';
        document.getElementById('register').style.display = 'block';
        f.action = 'num_book_file_upload.php';
    }
    (function($){
        if(!document.getElementById("fileupload_fr")){
            var i = document.createElement('iframe');
            i.setAttribute('id', 'fileupload_fr');
            i.setAttribute('name', 'fileupload_fr');
            i.style.display = 'none';
            document.body.appendChild(i);
        }
        f.target = 'fileupload_fr';
        f.submit();
    })(jQuery);
}

function download()
{
    var bg_no = document.getElementById('download_bg_no');
    var no_hp = document.getElementById('no_hp');
    var hyphen = document.getElementById('hyphen');
    var par = '';

    if (!bg_no.value.length) {
        alert('다운로드 할 휴대폰번호 그룹을 선택해주세요.');
        return;
    }

    if (no_hp.checked) no_hp = 1; else no_hp = 0;
    if (hyphen.checked) hyphen = 1; else hyphen = 0;

    par += '?bg_no=' + bg_no.value;
    par += '&no_hp=' + no_hp;
    par += '&hyphen=' + hyphen;

    (function($){
        if(!document.getElementById("fileupload_fr")){
            var i = document.createElement('iframe');
            i.setAttribute('id', 'fileupload_fr');
            i.setAttribute('name', 'fileupload_fr');
            i.style.display = 'none';
            document.body.appendChild(i);
        }
        fileupload_fr.location.href = './num_book_file_download.php' + par;
    })(jQuery);
}
</script>
<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>