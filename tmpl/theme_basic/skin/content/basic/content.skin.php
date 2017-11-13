<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

header("Content-Type: text/html; charset=UTF-8");
$str = $info;
if($HTTP_REFERER == "")
$info = iconv("euc-kr", "utf-8", $str);


// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$content_skin_url.'/style.css">', 0);
?>

<?php echo $co['co_content']; ?>

<!--<article id="ctt" class="ctt_<?php echo $co_id; ?>">
    <header>
        <h1><?php echo $g5['title']; ?></h1>
    </header>

    <div id="ctt_con">
        <?php echo _t($str); ?>
    </div>

</article>-->
