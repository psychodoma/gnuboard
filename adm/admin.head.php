<?php
if (!defined('_GNUBOARD_')) exit;

$begin_time = get_microtime();

include_once(G5_PATH.'/head.sub.php');

function print_menu1($key, $no)
{
    global $menu;

    $str = print_menu2($key, $no);

    return $str;
}

function print_menu2($key, $no)
{
    global $menu, $auth_menu, $is_admin, $auth, $g5;

    $str .= "<ul class=\"gnb_2dul\">";
    for($i=1; $i<count($menu[$key]); $i++)
    {
        if ($is_admin != 'super' && (!array_key_exists($menu[$key][$i][0],$auth) || !strstr($auth[$menu[$key][$i][0]], 'r')))
            continue;

        if (($menu[$key][$i][4] == 1 && $gnb_grp_style == false) || ($menu[$key][$i][4] != 1 && $gnb_grp_style == true)) $gnb_grp_div = 'gnb_grp_div';
        else $gnb_grp_div = '';

        if ($menu[$key][$i][4] == 1) $gnb_grp_style = 'gnb_grp_style';
        else $gnb_grp_style = '';

        $str .= '<li class="gnb_2dli"><a href="'.$menu[$key][$i][2].'" class="gnb_2da '.$gnb_grp_style.' '.$gnb_grp_div.'">'.$menu[$key][$i][1].'</a></li>';

        $auth_menu[$menu[$key][$i][0]] = $menu[$key][$i][1];
    }
    $str .= "</ul>";

    return $str;
}

function print_menu_bootstrap1($key, $no)
{
    global $menu;

    $str = print_menu_bootstrap2($key, $no);

    return $str;
}

function print_menu_bootstrap2($key, $no)
{
    global $menu, $auth_menu, $is_admin, $auth, $g5;

    $str .= "<ul class='nav child_menu'>";
    for($i=1; $i<count($menu[$key]); $i++)
    {
        if ($is_admin != 'super' && (!array_key_exists($menu[$key][$i][0],$auth) || !strstr($auth[$menu[$key][$i][0]], 'r')))
            continue;

        if (($menu[$key][$i][4] == 1 && $gnb_grp_style == false) || ($menu[$key][$i][4] != 1 && $gnb_grp_style == true)) $gnb_grp_div = 'gnb_grp_div';
        else $gnb_grp_div = '';

        if ($menu[$key][$i][4] == 1) $gnb_grp_style = 'gnb_grp_style';
        else $gnb_grp_style = '';

        $str .= '<li class="gnb_2dli"><a href="'.$menu[$key][$i][2].'" class="gnb_2da '.$gnb_grp_style.' '.$gnb_grp_div.'">'.$menu[$key][$i][1].'</a></li>';

        $auth_menu[$menu[$key][$i][0]] = $menu[$key][$i][1];
    }
    $str .= "</ul>";

    return $str;
}



?>

<script>
var tempX = 0;
var tempY = 0;

function imageview(id, w, h)
{

    menu(id);

    var el_id = document.getElementById(id);

    //submenu = eval(name+".style");
    submenu = el_id.style;
    submenu.left = tempX - ( w + 11 );
    submenu.top  = tempY - ( h / 2 );

    selectBoxVisible();

    if (el_id.style.display != 'none')
        selectBoxHidden(id);
}
</script>









    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="/adm" class="site_title"><i class="fa fa-paw"></i> <span>관리자페이지</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="/img/login.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>환영합니다!</span>
                <h2><?=$member['mb_name']?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>관리자 기본 메뉴</h3>
                    <?php
                    $gnb_str = "<ul class='nav side-menu'>";
                    //$icon_arr = array('home','user','table','comments','home','user','home','user');
                    $icon_cnt = 0;
                    foreach($amenu as $key=>$value) {
                        $href1 = $href2 = '';
                        if ($menu['menu'.$key][0][2]) {
                            //$href1 = '<li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span>';
                            //$href2 = '</a>';
                        } else {
                            continue;
                        }
                        $current_class = "";
                        if (isset($sub_menu) && (substr($sub_menu, 0, 3) == substr($menu['menu'.$key][0][0], 0, 3)))
                            $current_class = " gnb_1dli_air";

                        if($menu['menu'.$key][0][5] == 0){
                            continue;
                        } 
                        $gnb_str .= '<li><a><i class="fa fa-'.$menu['menu'.$key][0][4].'"></i> '.$menu['menu'.$key][0][1].' <span class="fa fa-chevron-down"></span></a>';
                        $gnb_str .=  print_menu_bootstrap1('menu'.$key, 1);
                        $gnb_str .=  "</li>";



                    }
                    $gnb_str .= "</ul>";
                    echo $gnb_str;
                    ?>
              </div>


              <div class="menu_section">
                <h3>관리자 추가 메뉴</h3>
                    <?php
                    $gnb_str = "<ul class='nav side-menu'>";
                    //$icon_arr = array('home','user','table','comments','home','user','home','user');
                    $icon_cnt = 0;
                    foreach($amenu as $key=>$value) {
                        $href1 = $href2 = '';
                        if ($menu['menu'.$key][0][2]) {
                            //$href1 = '<li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span>';
                            //$href2 = '</a>';
                        } else {
                            continue;
                        }
                        $current_class = "";
                        if (isset($sub_menu) && (substr($sub_menu, 0, 3) == substr($menu['menu'.$key][0][0], 0, 3)))
                            $current_class = " gnb_1dli_air";

                        if($menu['menu'.$key][0][5] == 1){
                            continue;
                        } 
                        $gnb_str .= '<li><a><i class="fa fa-'.$menu['menu'.$key][0][4].'"></i> '.$menu['menu'.$key][0][1].' <span class="fa fa-chevron-down"></span></a>';
                        $gnb_str .=  print_menu_bootstrap1('menu'.$key, 1);
                        $gnb_str .=  "</li>";



                    }
                    $gnb_str .= "</ul>";
                    echo $gnb_str;
                    ?>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="관리자정보" href='/adm/member_form.php?w=u&mb_id=<?=$member['mb_id']?>'>
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="기능없음">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="홈페이지">
                <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="로그아웃" href="<?=G5_BBS_URL?>/logout.php">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="/img/login.jpg" alt=""><?=$member['mb_name']?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="/adm/member_form.php?w=u&mb_id=<?=$member['mb_id']?>"> 관리자정보</a></li>
                    <li><a href="/">사이트바로가기</a></li>
                    <li><a href="<?=G5_BBS_URL?>/logout.php"><i class="fa fa-sign-out pull-right"></i> 로그아웃</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->





