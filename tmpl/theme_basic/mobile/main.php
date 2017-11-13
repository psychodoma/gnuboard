<?
$url = urlencode($_SERVER["REQUEST_URI"]);
?>

<meta charset="UTF-8">
<meta name="Generator" content="EditPlus®">
<meta name="Author" content="">
<meta name="Keywords" content="">
<meta name="Description" content="">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0" />



<script  src="http://code.jquery.com/jquery-latest.min.js"></script>


<link rel="stylesheet" href="<?=G5_TMPL_URL?>/css/mobile/mobile_main.css">
<link rel="stylesheet" href="<?=G5_TMPL_URL?>/css/mobile/mobile_sub.css">


<script>
$(function(){
	resize_fn();
	$(window).resize(function(){
		resize_fn();
	})
})

var img_width=720;
var img_height=1250;
function resize_fn()
{
	par_num=$(document).width()/img_width*100;
	if(par_num>100)
	{	
		par_num=100;
	}
	height_number=par_num/100*img_height;
	$(".m_intro").height(height_number)
}

function change_lang(lang, url) {
    var f = document.change;
    f.action = '<?php echo G5_BBS_URL; ?>/change_lang.php?l='+lang+'&u='+url;
    f.submit();
}
function toggle() {
    var f = document.getElementById('flags');
    f.style.display = (f.style.display != 'none' ? 'none' : '' );
    f.style.visibility = (f.style.visibility != 'hidden' ? 'hidden' : '' );
}
</script>


<title>모바일_코리아투어카드</title>
</head>
<body>

<div class="m_intro_wrap">
	<div class="m_intro">
		<h1><img src="/img/mobile/intro_logo.png" alt="korea tour card"/></h1>
		<p><img src="/img/mobile/intro_txt.png" alt="Enjoy your trip in Korea with just one card!"/></p>

		<ul>

			<?php
			echo '<form name="change" id="change" method="post">'.PHP_EOL;
				for($i=0; $i<count($g5['lang_list']); $i++) {
					if($g5['lang_name_list_en'][$g5['lang_list'][$i]] == "Korean (South Korea)"){
							echo '<li><a href="#" onclick="javascript:change_lang(\''.$g5['lang_list'][$i].'\', \''.$url.'\');" alt="'._t($g5['lang_name_list'][$g5['lang_list'][$i]]).'">한국어</a></li>';
					}
				}

				for($i=0; $i<count($g5['lang_list']); $i++) {
					if($g5['lang_name_list_en'][$g5['lang_list'][$i]] == "English (United States)"){
							echo '<li><a href="#" onclick="javascript:change_lang(\''.$g5['lang_list'][$i].'\', \''.$url.'\');" alt="'._t($g5['lang_name_list'][$g5['lang_list'][$i]]).'">English</a></li>';
					}
				}

				for($i=0; $i<count($g5['lang_list']); $i++) {
					if($g5['lang_name_list_en'][$g5['lang_list'][$i]] == "Japanese (Japan)"){
							echo '<li><a href="#" onclick="javascript:change_lang(\''.$g5['lang_list'][$i].'\', \''.$url.'\');" alt="'._t($g5['lang_name_list'][$g5['lang_list'][$i]]).'">日本語</a></li>';
					}
				}


				for($i=0; $i<count($g5['lang_list']); $i++) {
					if($g5['lang_name_list_en'][$g5['lang_list'][$i]] == "Chinese (Simplified, China)"){
							echo '<li><a href="#" onclick="javascript:change_lang(\''.$g5['lang_list'][$i].'\', \''.$url.'\');" alt="'._t($g5['lang_name_list'][$g5['lang_list'][$i]]).'">中文(简体)</a></li>';
					}
				}

				for($i=0; $i<count($g5['lang_list']); $i++) {
					if($g5['lang_name_list_en'][$g5['lang_list'][$i]] == "Chinese (Traditional, Taiwan)"){
							echo '<li><a href="#" onclick="javascript:change_lang(\''.$g5['lang_list'][$i].'\', \''.$url.'\');" alt="'._t($g5['lang_name_list'][$g5['lang_list'][$i]]).'">中文(繁體)</a></li>';
					}
				}					
			echo '</form>'.PHP_EOL;
			?>

		</ul>
	</div>
</div>




