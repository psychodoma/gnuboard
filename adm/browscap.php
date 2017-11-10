<?php
$sub_menu = "100510";
include_once('./_common.php');

if(!(version_compare(phpversion(), '5.3.0', '>=') && defined('G5_BROWSCAP_USE') && G5_BROWSCAP_USE))
    alert('사용할 수 없는 기능입니다.', G5_ADMIN_URL);

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

$g5['title'] = 'Browscap 업데이트';
include_once('./admin.head.php');
?>





<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
            <h3>Browscap 업데이트</h3>
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
                        <p class='bg-info' style='padding:15px;'>Browscap 정보를 업데이트하시려면 아래 업데이트 버튼을 클릭해 주세요.</p>

                        <div id="processing">  
                            <button type="button" id="run_update" class="btn btn-default" >업데이트</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<script>
$(function() {
    $("#run_update").on("click", function() {
        $("#processing").html('<div class="update_processing"></div><p><i class="fa fa-spinner fa-spin fa-fw"></i> Browscap 정보를 업데이트 중입니다.</p>');

        $.ajax({
            url: "./browscap_update.php",
            async: true,
            cache: false,
            dataType: "html",
            success: function(data) {
                if(data != "") {
                    alert(data);
                    return false;
                }

                $("#processing").html("<div class='check_processing'></div><p><i class='fa fa-bell-o' aria-hidden='true'></i>&nbsp;&nbsp;Browscap 정보를 업데이트 했습니다.</p>");
            }
        });
    });
});
</script>

<?php
include_once('./admin.tail.php');
?>