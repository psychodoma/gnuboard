<?php
$sub_menu = "100280";
include_once('./_common.php');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

// 테마 필드 추가
if(!isset($config['cf_theme'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_theme` varchar(255) NOT NULL DEFAULT '' AFTER `cf_title` ", true);
}

$theme = get_theme_dir();
if($config['cf_theme'] && in_array($config['cf_theme'], $theme))
    array_unshift($theme, $config['cf_theme']);
$theme = array_values(array_unique($theme));
$total_count = count($theme);

// 설정된 테마가 존재하지 않는다면 cf_theme 초기화
if($config['cf_theme'] && !in_array($config['cf_theme'], $theme))
    sql_query(" update {$g5['config_table']} set cf_theme = '' ");

$g5['title'] = "테마설정";
include_once('./admin.head.php');
?>

<script src="<?php echo G5_ADMIN_URL; ?>/theme.js"></script>






<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
            <h3>테마설정</h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class='row' >





             <!-- 홈페이지 기본환경 설정 끝! 두번째 첫번째         2017-09-22에는 여기서부터 하면됩니다!!           -->
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
                 


                    <h4 class="theme_p">설치된 테마 : <?php echo number_format($total_count); ?></h4>






<?php if($total_count > 0) { ?>
<ul id="theme_list">
    <?php
    for($i=0; $i<$total_count; $i++) {
        $info = get_theme_info($theme[$i]);

        $name = get_text($info['theme_name']);
        if($info['screenshot'])
            $screenshot = '<img src="'.$info['screenshot'].'" alt="'.$name.'">';
        else
            $screenshot = '<img src="'.G5_ADMIN_URL.'/img/theme_img.jpg" alt="">';

        if($config['cf_theme'] == $theme[$i]) {
            $btn_active = '<span class="theme_sl theme_sl_use" class="btn btn-default"></span><button type="button" class="theme_sl theme_deactive btn btn-danger" data-theme="'.$theme[$i].'" '.'data-name="'.$name.'">사용안함</button>';
        } else {
            $tconfig = get_theme_config_value($theme[$i], 'set_default_skin');
            if($tconfig['set_default_skin'])
                $set_default_skin = 'true';
            else
                $set_default_skin = 'false';

            $btn_active = '<button type="button" class="theme_sl theme_active btn btn-success" data-theme="'.$theme[$i].'" '.'data-name="'.$name.'" data-set_default_skin="'.$set_default_skin.'">테마적용</button>';
        }
    ?>
    <li>
        <div class="tmli_if">
            <?php echo $screenshot; ?>
            <div class="tmli_tit">
                <p><?php echo get_text($info['theme_name']); ?></p>
            </div>
        </div>
        <?php echo $btn_active; ?>
        <a href="./theme_preview.php?theme=<?php echo $theme[$i]; ?>" class="theme_pr btn btn-default" target="theme_preview">미리보기</a>
        <button type="button" class="tmli_dt theme_preview btn btn-default" data-theme="<?php echo $theme[$i]; ?>">상세보기</button>
    </li>
    <?php
    }
    ?>
</ul>
<?php } else { ?>
<p class="no_theme">설치된 테마가 없습니다.</p>
<?php } ?>








                  </div>
                </div>
              </div>
              <!-- /form input mask -->








        </div>
        
    </div>
</div>
















<?php
include_once ('./admin.tail.php');
?>