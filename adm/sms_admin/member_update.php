<?php
$sub_menu = "900200";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$g5['title'] = "회원정보 업데이트";

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
            <h3>회원정보 업데이트</h3>
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


                        <div id="sms5_mbup">
                            <form name="mb_update_form" id="mb_update_form" action="./member_update_run.php" >
                            <div class="local_desc02 local_desc">
                                <p class='bg-info' style='padding:15px;'>
                                    새로운 회원정보로 업데이트 합니다.<br>
                                    실행 후 '완료' 메세지가 나오기 전에 프로그램의 실행을 중지하지 마십시오.
                                </p>
                            </div>
                            <div class="local_desc01 local_desc">
                                <p>
                                    마지막 업데이트 일시 : <span id="datetime"><?php echo $sms5['cf_datetime']?></span> <br>
                                </p>
                            </div>

                            <div id="res_msg" class="local_desc01 local_desc">
                            </div>

                            <div class="btn_confirm01 btn_confirm">
                                <input type="submit" value="실행" class="btn_submit btn btn-default">
                            </div>
                            </form>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script>
(function($){
    $( "#mb_update_form" ).submit(function( e ) {
        e.preventDefault();
        $("#res_msg").html('업데이트 중입니다. 잠시만 기다려 주십시오...');
        var params = { mtype : 'json' };
        $.ajax({
            url: $(this).attr("action"),
            cache:false,
            timeout : 30000,
            dataType:"json",
            data:params,
            success: function(data) {
                if(data.error){
                    alert( data.error );
                    $("#res_msg").html("");
                } else {
                    $("#datetime").html( data.datetime );
                    $("#res_msg").html( data.res_msg );
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
        return false;
    });
})(jQuery);
</script>

<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>