<?php
$sub_menu = "200820";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$g5['title'] = '접속자로그삭제';
include_once('./admin.head.php');

// 최소년도 구함
$sql = " select min(vi_date) as min_date from {$g5['visit_table']} ";
$row = sql_fetch($sql);

$min_year = (int)substr($row['min_date'], 0, 4);
$now_year = (int)substr(G5_TIME_YMD, 0, 4);
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
            <h3>접속자로그삭제</h3>
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

                        <p class='bg-info' style='padding:15px;'>
                            접속자 로그를 삭제할 년도와 방법을 선택해주십시오.
                        </p><br>

                        <form name="fvisitdelete" class="local_sch02 local_sch" method="post" action="./visit_delete_update.php" onsubmit="return form_submit(this);">
                            <div>
                                <label for="year" class="sound_only">년도 선택</label>
                                <select class='form-control' name="year" id="year">
                                    <option value="">년도 선택</option>
                                    <?php
                                    for($year=$min_year; $year<=$now_year; $year++) {
                                    ?>
                                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select><br>
                                <label for="month" class="sound_only">월 선택</label>
                                <select class='form-control' name="month" id="month">
                                    <option value="">월 선택</option>
                                    <?php
                                    for($i=1; $i<=12; $i++) {
                                    ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select><br>
                                <label for="method" class="sound_only">삭제방법선택</label>
                                <select class='form-control' name="method" id="method">
                                    <option value="before">선택년월 이전 자료삭제</option>
                                    <option value="specific">선택년월의 자료삭제</option>
                                </select><br>
                            </div>
                            <div class="sch_last">
                                <label for="pass">관리자 비밀번호<strong class="sound_only"> 필수</strong></label>
                                <input type="password" name="pass" id="pass" class="frm_input required form-control"><br>
                                <input type="submit" value="확인" class="btn_submit btn btn-default">
                            </div>
                        </form>

                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
function form_submit(f)
{
    var year = $("#year").val();
    var month = $("#month").val();
    var method = $("#method").val();
    var pass = $("#pass").val();

    if(!year) {
        alert("년도를 선택해 주십시오.");
        return false;
    }

    if(!month) {
        alert("월을 선택해 주십시오.");
        return false;
    }

    if(!pass) {
        alert("관리자 비밀번호를 입력해 주십시오.");
        return false;
    }

    var msg = year+"년 "+month+"월";
    if(method == "before")
        msg += " 이전";
    else
        msg += "의";
    msg += " 자료를 삭제하시겠습니까?";

    return confirm(msg);
}
</script>

<?php
include_once('./admin.tail.php');
?>
