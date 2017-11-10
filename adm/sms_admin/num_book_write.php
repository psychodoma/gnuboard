<?php
$sub_menu = "900800";
include_once("./_common.php");

$colspan = 4;

auth_check($auth[$sub_menu], "r");

$g5['title'] = "휴대폰번호 ";

$exist_hplist = array();

if ($w == 'u' && is_numeric($bk_no)) {
    $write = sql_fetch("select * from {$g5['sms5_book_table']} where bk_no='$bk_no'");
    if (!$write)
        alert('데이터가 없습니다.');

    if ($write['mb_id']) {
        $res = sql_fetch("select mb_id from {$g5['member_table']} where mb_id='{$write['mb_id']}'");
        $write['mb_id'] = $res['mb_id'];
        $sql = "select mb_id from {$g5['member_table']} where mb_hp = '{$write['bk_hp']}' and mb_id <> '{$write['mb_id']}' and mb_hp <> '' ";
        $result = sql_query($sql);
        while($tmp = sql_fetch_array($result)){
            $exist_hplist[] = $tmp;
        }
        $exist_msg_1 = '(수정시 회원정보에 반영되지 않습니다.)';
        $exist_msg_2 = '(수정시 회원정보에 반영됩니다.)';
        $exist_msg = count($exist_hplist) ? $exist_msg_1 : $exist_msg_2;
    }
    $g5['title'] .= '수정';
}
else  {
    $write['bg_no'] = $bg_no;
    $g5['title'] .= '추가';
}

if (!is_numeric($write['bk_receipt']))
    $write['bk_receipt'] = 1;

$no_group = sql_fetch("select * from {$g5['sms5_book_group_table']} where bg_no = 1");

include_once(G5_ADMIN_PATH."/admin.head.php");
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



                        <form name="book_form" id="book_form" method="post" action="./num_book_update.php">
                        <input type="hidden" name="w" value="<?php echo $w?>">
                        <input type="hidden" name="page" value="<?php echo $page?>">
                        <input type="hidden" name="ap" value="<?php echo $ap?>">
                        <input type="hidden" name="bk_no" value="<?php echo $write['bk_no']?>">
                        <input type="hidden" name="mb_id" id="mb_id" value="<?php echo $write['mb_id']?>">
                        <input type="hidden" name="get_bg_no" value="<?php echo $bg_no?>">

                        <div class="tbl_frm01 tbl_wrap table-responsive">
                            <table class='table table-striped table-bordered'>

                            <tbody>
                            <tr>
                                <th scope="row"><label for="bg_no">그룹 <span class="required red"> *</span></label></th>
                                <td>
                                    <select name="bg_no" id="bg_no" required class="form-control required">
                                        <option value="1"><?php echo $no_group['bg_name']?> (<?php echo number_format($no_group['bg_count'])?> 명)</option>
                                        <?php
                                        $qry = sql_query("select * from {$g5['sms5_book_group_table']} where bg_no> 1 order by bg_name");
                                        while($res = sql_fetch_array($qry)) {
                                        ?>
                                        <option value="<?php echo $res['bg_no']?>" <?php echo $res['bg_no']==$write['bg_no']?'selected':''?>> <?php echo $res['bg_name']?>  (<?php echo number_format($res['bg_count'])?> 명) </option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="bk_name">이름<span class="required red"> *</span></label></th>
                                <td><input type="text" name="bk_name" id="bk_name" maxlength="50" value="<?php echo $write['bk_name']?>" required class="form-control frm_input required"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="bk_hp">휴대폰번호<span class="required red"> *</span></label></th>
                                <td>
                                    <input type="text" name="bk_hp" id="bk_hp" value="<?php echo $write['bk_hp']?>" required class="form-control frm_input required">
                                    <?php if( count($exist_hplist) ) { // 중복되는 목록이 있다면 ?>
                                    <div id="hp_check_el">
                                        <ul>
                                        <?php

                                        foreach( $exist_hplist as $v ) {

                                            if( empty($v) ) continue;
                                            $href = G5_ADMIN_URL."/member_form.php?w=u&amp;mb_id={$v['mb_id']}";
                                        ?>
                                            <li><strong>중복됨 </strong><a href="<?php echo $href; ?>" target="_blank"><?php echo $v['mb_id']; ?></a></li>
                                        <?php
                                        }
                                        ?>
                                        </ul>
                                    </div>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">수신여부</th>
                                <td>
                                    <input class='flat' type="radio" name="bk_receipt" id="bk_receipt_1" value="1" <?php echo $write['bk_receipt']?'checked':''?>>
                                    <label for="bk_receipt_1">수신허용</label>
                                    <input class='flat' type="radio" name="bk_receipt" id="bk_receipt_2" value="0" <?php echo !$write['bk_receipt']?'checked':''?>>
                                    <label for="bk_receipt_2">수신거부</label>
                                </td>
                            </tr>
                            <?php if ($w == 'u') { ?>
                            <tr>
                                <th scope="row">회원아이디</th>
                                <td> <?php echo $write['mb_id'] ? '<a href="'.G5_ADMIN_URL.'/member_form.php?w=u&amp;mb_id='.$write['mb_id'].'">'.$write['mb_id'].'</a>' : '비회원'?> </td>
                            </tr>
                            <tr>
                                <th scope="row">업데이트</th>
                                <td> <?php echo $write['bk_datetime']?> </td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <th scope="row"><label for="bk_memo">메모</label></th>
                                <td>
                                    <textarea class='form-control' name="bk_memo" id="bk_memo"><?php echo $write['bk_memo']?></textarea>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        </div>

                        <div class="btn_confirm01 btn_confirm">
                            <input type="submit" value="확인" class="btn_submit btn btn-default" accesskey="s" onclick="return book_submit();">
                            <a class='btn btn-default' href="./num_book.php?<?php echo clean_query_string($_SERVER['QUERY_STRING']); ?>">목록</a>
                        </div>

                        </form>


                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






<script>
function book_submit(){
    var f = document.book_form;
    var regExp_hp = /^(01[016789]{1}|02|0[3-9]{1}[0-9]{1})-?[0-9]{3,4}-?[0-9]{4}$/;

    if(!f.bk_hp.value){
        f.bk_hp.focus();
        alert("휴대폰번호를 입력하세요.");
        return false;
    } else if ( !regExp_hp.test(f.bk_hp.value) )
    {
        f.bk_hp.focus();
        alert("휴대폰번호 입력이 올바르지 않습니다.");
        return false;
    }

    var w = "<?php echo $w; ?>";
    var bk_no = "<?php echo $bk_no; ?>";
    var mb_id = f.mb_id.value;
    var bk_hp = f.bk_hp.value;
    var params = { w: w, bk_no: bk_no, mb_id : mb_id, bk_hp : bk_hp };
    var is_submit;

    $.ajax({
        url: "./ajax.hp_chk.php",
        type: "POST",
        cache:false,
        timeout : 30000,
        dataType:"json",
        data:params,
        success: function(data) {
            if(data.error) {
                is_submit = false;
                alert( data.error );
            } else {
                var list_text = "";
                var list_data;

                $.each( data.exist , function(num) {
                    list_data = data.exist[num];

                    if(list_data) {
                        var href = "<?php echo G5_ADMIN_URL ?>/member_form.php?w=u&mb_id="+list_data;
                        list_text += "<li><a href=\""+href+"\" target=\"_blank\">"+list_data+"</a></li>";
                    }
                });

                var $check_msg = $("#hp_check_el");

                if( !list_text ){ // 중복 휴대폰 번호가 없다면 submit
                    if($check_msg.size()> 0)
                        $check_msg.remove();

//                    $("#exist_msg").text("<?php echo $exist_msg_2; ?>");
                    is_submit = true;
                } else {
                    if($check_msg.size() < 1)
                        $("input#bk_hp").after("<div id=\"hp_check_el\"><h3>이 번호를 쓰는 회원 정보</h3><ul></ul></div>");

                    $("#hp_check_el").find("ul").html( list_text );
//                    $("#exist_msg").html("<?php echo $exist_msg_1 ?>");

                    if(confirm("회원 정보에 중복 휴대폰 번호가 있습니다.수정하실 경우 회원정보에 반영되지 않습니다.\n수정하시겠습니까?"))
                        is_submit = true;
                    else
                        is_submit = false;
                }
            }

            if(is_submit)
                f.submit();
        }
    });

    return false;
}
</script>
<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>