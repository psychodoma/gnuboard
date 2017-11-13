<?php
// 이 파일은 새로운 파일 생성시 반드시 포함되어야 함
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$begin_time = get_microtime();

if (!isset($g5['title'])) {
    $g5['title'] = $config['cf_title'];
    $g5_head_title = $g5['title'];
}
else {
    $g5_head_title = $g5['title']; // 상태바에 표시될 제목
    $g5_head_title .= " | ".$config['cf_title'];
}

// 현재 접속자
// 게시판 제목에 ' 포함되면 오류 발생
$g5['lo_location'] = addslashes($g5['title']);
if (!$g5['lo_location'])
    $g5['lo_location'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
$g5['lo_url'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
if (strstr($g5['lo_url'], '/'.G5_ADMIN_DIR.'/') || $is_admin == 'super') $g5['lo_url'] = '';


?>
<?php if($g5['tmpl'] == 'g4_basic_g4' && !defined('G5_IS_ADMIN')) { ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<?php } else { ?>
<!doctype html>
<?php } ?>


<html lang="ko">
<head>
<meta charset="utf-8">


<link rel="canonical" href="http://www.koreatourcard.kr">
<link rel="alternate" hreflang="x-default" href="http://koreatourcard.kr" />
<link rel="alternate" hreflang="en" href="http://koreatourcard.kr/en/" />
<link rel="alternate" hreflang="kr" href="http://koreatourcard.kr/kr/" />
<link rel="alternate" hreflang="jp" href="http://koreatourcard.kr/jp/" />
<link rel="alternate" hreflang="cn" href="http://koreatourcard.kr/cn/" />
<link rel="alternate" hreflang="tw" href="http://koreatourcard.kr/tw/" />

<meta name="description" content="<?=_t('외국인 전용 교통카드 기능 플러스 쇼핑, 관광지, 공연 할인까지!')._t('코리아투어카드')?>">
<meta name="keywords"
			content="외국인교통카드,외국인 전용 교통카드, 코리아투어카드, 코리아 투어 카드, 한국 관광 카드, 한국관광카드, 코투카, 한국 교통 카드,한국 교통 패스, 쇼핑 관광, 한국 방문, Korea, Shopping in Korea, Shopping Discount in Korea, Accommodations in Korea, K-POP, Korean Shuttle Bus, Travel in Korea, Winter Travel in Korea, Korean Tour, Travel Information in Korea, Korean Tour Information, Korean Festival, Visit Korea Year" />


<meta property="og:locale" content="ko-KR">
<meta property="og:site_name" content="<?=_t('코리아투어카드')?>">
<meta property="og:title" content="<?=_t('코리아투어카드')?>">
<meta property="og:image" content='./img/main/main_visual2.jpg'/>
<meta property="og:url" content="http://www.koreatourcard.kr">
<meta property="og:type" content="website">
<meta property="og:description" content="<?=_t('외국인 전용 교통카드 기능 플러스 쇼핑, 관광지, 공연 할인까지!')._t('코리아투어카드')?>">

<meta itemprop="description" content="<?=_t('외국인 전용 교통카드 기능 플러스 쇼핑, 관광지, 공연 할인까지!')._t('코리아투어카드')?>">
<meta itemprop="name" content="<?=_t('코리아투어카드')?>">
<meta itemprop="image" content="./img/main/main_visual2.jpg">

<meta name="twitter:title" content="<?=_t('코리아투어카드')?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="http://www.koreatourcard.kr">


<?php
echo '<meta http-equiv="imagetoolbar" content="no">'.PHP_EOL;
echo '<meta http-equiv="X-UA-Compatible" content="IE=10,chrome=1">'.PHP_EOL;
echo '<meta property="og:image" content="http://ktc.morucompany.com/img/brand2.png"/>'.PHP_EOL;

if(G5_IS_MOBILE){
    echo '<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0" />';
    echo '<meta name="format-detection" content="telephone=no">';
}

if($config['cf_add_meta'])
    echo $config['cf_add_meta'].PHP_EOL;
?>

<?php if(0) { ?><title><?php echo _t('') ?></title><?php } ?>

<?php /// New
if($site_name == '') $site_name = $config['cf_title'];
if($index_title)
    echo "<title>"._t($index_title)."</title>\n";
else if($g5[title])
    /// echo "<title>$g5[title] > $group[gr_subject] > $site_name</title>\n";
    echo "<title>"._t('코리아투어카드').' :: '._t('외국인 전용 교통카드 기능 플러스 쇼핑, 관광지, 공연 할인까지!')."</title>\n";
else
    echo "<title>"._t($site_name)."</title>\n";
?>

<?php
if (defined('G5_IS_ADMIN')) {
    if(!defined('_THEME_PREVIEW_'))
        echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/css/admin.css">'.PHP_EOL;
} else {
    $shop_css = '_shop';
    //echo '<link rel="stylesheet" href="'.G5_TMPL_URL.'/css/'.'default.css?ver='.G5_CSS_VER.'">'.PHP_EOL;
    /// echo '<link rel="stylesheet" href="'.G5_TMPL_URL.'/css/'.'style.css?ver='.G5_CSS_VER.'">'.PHP_EOL;
    //add_stylesheet('<link rel="stylesheet" href="'.G5_TMPL_URL.'/css/'.'style.css?ver='.G5_CSS_VER.'">', 0);
}
if($g5['def_font'] and file_exists($g5['path'].'/font/font_'.$g5['def_font'].'.css')) {
    if(!($g5['def_font_g4_no_use'] && preg_match('/^g4_/', $g5['tmpl'])))
    echo '<link rel="stylesheet" href="'.$g5['url'].'/font/'.'font_'.$g5['def_font'].'.css">'.PHP_EOL;
}



echo '<link rel="shortcut" href="'.G5_URL.'/img/logo_p.ico">';

if(G5_IS_MOBILE){
    echo '<link rel="stylesheet" href="'.G5_TMPL_URL.'/css/font-awesome.css">';
    echo '<link rel="stylesheet" href="'.G5_TMPL_URL.'/css/mobile/mobile_main.css">';
    echo '<link rel="stylesheet" href="'.G5_TMPL_URL.'/css/mobile/mobile_sub.css">';
    echo '<link rel="stylesheet" href="'.G5_TMPL_URL.'/css/mobile/mobile_jquery.bxslider.css">';
	echo '<link rel="stylesheet" href="'.G5_MOBILE_SKIN_URL.'/banner/style.css">';
	echo '<link rel="stylesheet" href="/js/jquery.loading.css">';
}else{
    echo '<link rel="stylesheet" href="'.G5_TMPL_URL.'/css/main.css">';
    echo '<link rel="stylesheet" href="'.G5_TMPL_URL.'/css/sub.css">';
    echo '<link rel="stylesheet" href="'.G5_TMPL_URL.'/css/font-awesome.css">';
    echo '<link rel="stylesheet" href="'.G5_TMPL_URL.'/css/jquery.bxslider.css">';  
}
?>






<!-- <link href="https://fonts.googleapis.com/earlyaccess/mplus1p.css" rel="stylesheet" /> -->







<!--[if lte IE 8]>
<script src="<?php echo G5_JS_URL ?>/html5.js"></script>
<![endif]-->
<script>
// 자바스크립트에서 사용하는 전역변수 선언
var g5_url       = "<?php echo G5_URL ?>";
var g5_bbs_url   = "<?php echo G5_BBS_URL ?>";
var g5_is_member = "<?php echo isset($is_member)?$is_member:''; ?>";
var g5_is_admin  = "<?php echo isset($is_admin)?$is_admin:''; ?>";
var g5_is_mobile = "<?php echo G5_IS_MOBILE ?>";
var g5_bo_table  = "<?php echo isset($bo_table)?$bo_table:''; ?>";
var g5_sca       = "<?php echo isset($sca)?$sca:''; ?>";
var g5_editor    = "<?php echo ($config['cf_editor'] && $board['bo_use_dhtml_editor'])?$config['cf_editor']:''; ?>";
var g5_cookie_domain = "<?php echo G5_COOKIE_DOMAIN ?>";
<?php
if ($is_admin) {
    echo 'var g5_admin_url = "'.G5_ADMIN_URL.'";'.PHP_EOL;
}

?>
// g4 자바스크립트에서 사용했던 전역변수 선언 추가. 호환성 고려
var g5_bbs       = "<?php echo $g5['bbs']?>";
var g5_bbs_img   = "<?php echo $g5['bbs_img']?>";
var g5_charset   = "<?php echo $g5['charset']?>";
var g5_is_gecko  = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;
var g5_is_ie     = navigator.userAgent.toLowerCase().indexOf("msie") != -1;
<?php if ($is_admin) { echo "var g5_admin = '{$g5['admin']}';".PHP_EOL; } ?>

</script>
<?php if(1) { ?>
<?php include_once $g5['locale_path'].'/basic/lang_js_var.inc.php'; ?>
<?php if (defined('_SHOP_') || defined('_CONTENTS_')) { ?>
<?php include_once $g5['locale_path'].'/basic/lang_shop_js_var.inc.php'; ?>
<?php } ?>
<?php } ?>
<?php if(0) { ?>
<script src="<?php echo G5_JS_URL ?>/jquery-1.8.3.min.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
<?php } ?>
<script src="<?php echo G5_JS_URL ?>/jquery-1.10.2.min.js"></script>
<script src="<?php echo G5_JS_URL ?>/jquery-migrate-1.2.1.js"></script>



<?php
if (defined('_SHOP_')) {
    if(!G5_IS_MOBILE) {
?>
<script src="<?php echo G5_JS_URL ?>/jquery.shop.menu.js?ver=<?php echo G5_JS_VER; ?>"></script>
<?php
    }
} else {
?>

<script src="<?php echo G5_JS_URL ?>/jquery.menu.js?ver=<?php echo G5_JS_VER; ?>"></script>
<?php } ?>
<script src="<?php echo G5_JS_URL ?>/common.js?ver=<?php echo G5_JS_VER; ?>"></script>
<!--<script src="<?php echo G5_JS_URL ?>/wrest.js?ver=<?php echo G5_JS_VER; ?>"></script>-->
<script src="<?php echo $g5['legacy_url'] ?>/js/wrest.js?ver=<?php echo G5_JS_VER; ?>"></script>


<?php
if(G5_IS_MOBILE) {
    echo '<script src="'.G5_JS_URL.'/modernizr.custom.70111.js"></script>'.PHP_EOL; // overflow scroll 감지
    //echo '<script type="text/javascript" src="/js/mobile/jquery.word-break-keep-all.min.js"></script>';
    echo '<script  src="http://code.jquery.com/jquery-latest.min.js"></script>';
    echo '<script src="/js/mobile/jquery.bxslider.js"></script>';
    echo '<script type="text/javascript" src="/js/mobile/javascript.js"></script>';
}
if(!defined('G5_IS_ADMIN'))
    echo $config['cf_add_script'];
?>

</head>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="<?=G5_JS_URL?>/jquery.bxslider.js"></script>
<!-- <script src="<?php echo G5_JS_URL ?>/jquery.word-break-keep-all.min.js"></script> -->
<script type="text/javascript" src="/js/jquery.ajax-cross-origin.min.js"></script>
<script type="text/javascript" src="/js/xdomainajax.js"></script>


<?if(!G5_IS_MOBILE){?>
    <script src="<?=G5_JS_URL?>/ktc.js"></script>
<?}else{?>
    <script src="<?=G5_JS_URL?>/ktc_mobile.js"></script>   
<?}?>

<?
if(!G5_IS_MOBILE) {
    echo '<script type="text/javascript" src="/js/javascript.js"></script>';
}
?>

<script type="text/javascript" src="<?=G5_JS_URL?>/jquery.easing-1.3.js"></script>
<script type="text/javascript" src="<?=G5_JS_URL?>/jquery.iosslider.min.js"></script>


<body<?php echo isset($g5['body_script']) ? $g5['body_script'] : ''; ?>>

<?php
if(!G5_IS_MOBILE) {
    if($g5['lang_button_ok']) include_once(G5_PATH.'/locale/basic/lang_button.inc.php');
}
?>

<style>
	#hd_login_msg{font-family:'돋움','dotum'; font-size:11px;letter-spacing:-0.5px;line-height:20px;}
	#hd_login_msg .adm_id{ background:#333;padding:5px 5px 3px 10px;border-radius:5px;color:white;}
	#hd_login_msg .adm_msg{margin-left:10px; }
	#hd_login_msg .adm_menu{margin-left:20px;margin-right:5px;}
	body,select,input,textarea{
        <?if($_SESSION['lang'] == "ko_KR"){?>
            font-family: 'Nanum Barun Gothic',sans-serif;
        <?}else if($_SESSION['lang'] == "en_US"){?>
            font-family: 'SourceSansPro-Regular';
        <?}else if($_SESSION['lang'] == "ja_JP"){?>
            font-family: 'mplus-1c-regular',sans-serif;
        <?}else if($_SESSION['lang'] == "zh_CN" || $_SESSION['lang'] == "zh_TW" ){?>
            font-family: '黑体','SimHei',sans-serif;
        <?}else{?>
            font-family: 'Nanum Barun Gothic',sans-serif;
        <?}?>
    }    
</style>
<?php
if ($is_member) { // 회원이라면 로그인 중이라는 메세지를 출력해준다.
    $sr_admin_msg = '';
    if ($is_admin == 'super') $sr_admin_msg = "최고관리자 ";
    else if ($is_admin == 'group') $sr_admin_msg = "그룹관리자 ";
    else if ($is_admin == 'board') $sr_admin_msg = "게시판관리자 ";

    echo '<div id="hd_login_msg"><span class="adm_id">'.$sr_admin_msg.' | '.$g5['lang'].'</span> <span class="adm_msg">' .get_text($member['mb_nick']).'</span>님 로그인 중 ';
    echo '<a href="'.G5_BBS_URL.'/logout.php" class="adm_menu">로그아웃</a>  |<a href="./adm/" class="" target="_blank">관리자바로가기</a></div>';
}
?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-103164390-1', 'auto');
  ga('send', 'pageview');

</script>