<?php
$sub_menu = "100800";
include_once("./_common.php");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.", G5_URL);

$g5['title'] = "세션파일 일괄삭제";
include_once("./admin.head.php");
?>



<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
            <h3>세션파일 일괄삭제</h3>
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

                        <p class='bg-warning' style='padding:15px;'>
                            완료 메세지가 나오기 전에 프로그램의 실행을 중지하지 마십시오.
                        </p>
                    

                        <?php
                        flush();

                        $list_tag_st = "";
                        $list_tag_end = "";
                        if (!$dir=@opendir(G5_DATA_PATH.'/session')) {
                        echo "<p>세션 디렉토리를 열지못했습니다.</p>";
                        } else {
                            $list_tag_st = "<br><ul>\n<li>완료됨</li>\n";
                            $list_tag_end = "</ul>\n<br>";
                        }

                        $cnt=0;
                        echo $list_tag_st;
                        while($file=readdir($dir)) {

                            if (!strstr($file,'sess_')) continue;
                            if (strpos($file,'sess_')!=0) continue;

                            $session_file = G5_DATA_PATH.'/session/'.$file;

                            if (!$atime=@fileatime($session_file)) {
                                continue;
                            }
                            if (time() > $atime + (3600 * 6)) {  // 지난시간을 초로 계산해서 적어주시면 됩니다. default : 6시간전
                                $cnt++;
                                $return = unlink($session_file);
                                //echo "<script>document.getElementById('ct').innerHTML += '{$session_file}<br/>';</script>\n";
                                echo "<li>{$session_file}</li>\n";

                                flush();

                                if ($cnt%10==0)
                                    //echo "<script>document.getElementById('ct').innerHTML = '';</script>\n";
                                    echo "\n";
                            }
                        }
                        echo $list_tag_end;
                        echo '<div class="local_desc01 local_desc bg-success" style="padding:15px;"><p><strong style="color:red;">세션데이터 '.$cnt.'건 삭제 완료됐습니다.</strong><br>프로그램의 실행을 끝마치셔도 좋습니다.</p></div>'.PHP_EOL;
                    ?>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<?php
include_once("./admin.tail.php");
?>
