<?php
$sub_menu = "100520";
include_once('./_common.php');

if(!(version_compare(phpversion(), '5.3.0', '>=') && defined('G5_BROWSCAP_USE') && G5_BROWSCAP_USE))
    alert('사용할 수 없는 기능입니다.', G5_ADMIN_URL);

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

$rows = preg_replace('#[^0-9]#', '', $_GET['rows']);
if(!$rows)
    $rows = 100;

$g5['title'] = '접속로그 변환';
include_once('./admin.head.php');
?>








<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
            <h3>접속로그 변환</h3>
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
                        <p class='bg-info' style='padding:15px;'>접속로그 정보를 Browscap 정보로 변환하시려면 아래 업데이트 버튼을 클릭해 주세요.</p>

                        <div id="processing">
                            <button type="button" id="run_update" class="btn btn-default">업데이트</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<script>
$(function() {
    $(document).on("click", "#run_update", function() {
        $("#processing").html('<div class="update_processing"></div><p><i class="fa fa-spinner fa-spin fa-fw"></i> Browscap 정보로 변환 중입니다.</p>');

        $.ajax({
            method: "GET",
            url: "./browscap_converter.php",
            data: { rows: "<?php echo $rows; ?>" },
            async: true,
            cache: false,
            dataType: "html",
            success: function(data) {
                $("#processing").html(data);
            }
        });
    });
});
</script>

<?php
include_once('./admin.tail.php');
?>