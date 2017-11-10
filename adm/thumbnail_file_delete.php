<?php
$sub_menu = '100920';
include_once('./_common.php');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.', G5_URL);

$g5['title'] = '썸네일 일괄삭제';
include_once('./admin.head.php');
?>





<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
            <h3>썸네일파일 일괄삭제</h3>
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
                            $directory = array();
                            $dl = array('file', 'editor');

                            foreach($dl as $val) {
                                if($handle = opendir(G5_DATA_PATH.'/'.$val)) {
                                    while(false !== ($entry = readdir($handle))) {
                                        if($entry == '.' || $entry == '..')
                                            continue;

                                        $path = G5_DATA_PATH.'/'.$val.'/'.$entry;

                                        if(is_dir($path))
                                            $directory[] = $path;
                                    }
                                }
                            }

                            flush();

                            if (empty($directory)) {
                                echo '<p>썸네일디렉토리를 열지못했습니다.</p>';
                            }

                            $cnt=0;
                            echo '<br><ul>'.PHP_EOL;

                            foreach($directory as $dir) {
                                $files = glob($dir.'/thumb-*');
                                if (is_array($files)) {
                                    foreach($files as $thumbnail) {
                                        $cnt++;
                                        @unlink($thumbnail);

                                        echo '<li>'.$thumbnail.'</li>'.PHP_EOL;

                                        flush();

                                        if ($cnt%10==0)
                                            echo PHP_EOL;
                                    }
                                }
                            }

                            echo '<li>완료됨</li></ul><br>'.PHP_EOL;
                            echo '<div class="local_desc01 local_desc bg-success" style="padding:15px;" ><p><strong style="color:red;" >썸네일 '.$cnt.'건의 삭제 완료됐습니다.</strong><br>프로그램의 실행을 끝마치셔도 좋습니다.</p></div>'.PHP_EOL;
                            ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






<?php
include_once('./admin.tail.php');
?>