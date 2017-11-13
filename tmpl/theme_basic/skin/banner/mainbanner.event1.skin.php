<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/skin/banner'.'/style.css">', 2);
?>

<?php
$mc_max_width = '245';
$mc_max_height = '340';
$bn_first_class = ' class="bbsn_first"';

//if($_SERVER["REMOTE_ADDR"] == "210.96.212.116" ) print_r($resul['bn_id']. "/" . $lang);

for ($i=0; $row=sql_fetch_array($result); $i++)
{

	

    if ($i==0) echo '<section id="spn_idx_'.$position.'" class="bbsn">'.PHP_EOL.'<h2>'._t('쇼핑분류배너영역').'</h2>'.PHP_EOL.'<ul>'.PHP_EOL;
    //print_r2($row);
	if($row['bn_id'] == 56 && $lang != 'ko_KR'){
		
	}else{
    // 테두리 있는지
    $bn_border  = ($row['bn_border']) ? ' class="bbsn_border"' : '';
    // 새창 띄우기인지
    $bn_new_win = ($row['bn_new_win']) ? ' target="_blank"' : '';
    
	$bimg_lang= G5_DATA_PATH.'/banner/'.bannerLang($lang).$row['bn_id'];
	$bimg = G5_DATA_PATH.'/banner/'.$row['bn_id'];

	//echo G5_DATA_PATH.'/banner/'.bannerLang($lang).$row['bn_id'];

	if(file_exists($bimg_lang)){
		$bimg_URL = G5_DATA_URL.'/banner/'.bannerLang($lang).$row['bn_id'];
	}else{
		$bimg_URL = G5_DATA_URL.'/banner/'.$row['bn_id'];
	}

	$blinke_URL = 'bn_url'.bannerURL($lang);

    if (file_exists($bimg))
    {
        $banner = '';
        $size = getimagesize($bimg);

		if(!$row[$blinke_URL]){
			$blinke_URL = 'bn_url';
			//echo $blinke_URL;
		};

        if($size[2] < 1 || $size[2] > 16)
            continue;
	
        echo '<li'.$bn_first_class.'>'.PHP_EOL;
        if ($row['bn_url'][0] == '#')
            $banner .= '<a href="'.$row['bn_url'].'">';
        else if ($row['bn_url'] && $row['bn_url'] != 'http://') {
            $banner .= '<a href="'.G5_URL.'/bannerhit.php?bn_id='.$row['bn_id'].'&amp;url='.urlencode($row[$blinke_URL]).'"'.$bn_new_win.'>';
        }

        echo $banner.'<img src="'.$bimg_URL.'" width="'.$mc_max_width.'" height="'.$mc_max_height.'" alt="'._t($row['bn_alt']).'"'.$bn_border.'>';
		
        if($banner)
            echo '</a>'.PHP_EOL;
        echo '</li>'.PHP_EOL;

        $bn_first_class = '';
}
}
}

if ($i>0) echo '</ul>'.PHP_EOL.'</section>'.PHP_EOL;
?>


<script>
(function($) {
    var intervals = {};

    var methods = {
        init: function(option)
        {
            if(this.length < 1)
                return false;

            var $bnnr = this.find("li:has(img)");
            var count = $bnnr.size();
            var $bnnr_a = $bnnr.find("a");
            var width = <?php echo $mc_max_width; ?>;
            var height = <?php echo $mc_max_height; ?>;
            var wrap_width = this.parent().width();
            var c_idx = o_idx = 0;
            var el_id = this[0].id;
            var $this = this;

            if(width > wrap_width) {
                height = parseInt(height * (wrap_width / width));
            }
            width = wrap_width;

            this.width(wrap_width).height(height)
                .find("ul").width(width).height(height)
                .find("li").width(width).height(height);

            $bnnr.not(".bbsn_first").css("left", width+"px");

            $bnnr.each(function() {
                var $img = $(this).find("img");
                var img_width = parseInt($img.attr("width"));
                if(img_width > width)
                    img_width = width;

                $img.removeAttr("width");
                $img.width(img_width);
            });

            // 기본 설정값
            var settings = $.extend({
                interval: 5000,
                duration: 500
            }, option);

            if(count > 1) {
                var slide_button = "<div id=\"bbsn_btn_p\" class=\"bbsn_btn\"><button type=\"button\" id=\"bbsn_btn_prev\" class=\"bbsn_btn_slide\"><span></span><?php echo _t('이전'); ?></button></div>\n";
                slide_button += "<div id=\"bbsn_btn_n\" class=\"bbsn_btn\"><button type=\"button\" id=\"bbsn_btn_next\" class=\"bbsn_btn_slide\"><span></span><?php echo _t('다음'); ?></button></div>";

                this.find("ul").before(slide_button);

                var $bnnr_btn = this.find(".bbsn_btn_slide");

                $bnnr_btn.on("focusin", function() {
                    clear_interval();
                });

                $bnnr_btn.on("focusout", function() {
                    set_interval();
                });
            }

            set_interval();

            $(".bbsn_btn_slide").on("click", function() {
                if($this.find(":animated").size() > 0)
                    return false;

                clear_interval();

                var id = $(this).attr("id");
                if(id.search("prev") > -1) {
                    right_rolling();
                } else {
                    left_rolling();
                }
            });

            $bnnr.hover(
                function() {
                    clear_interval();
                },
                function() {
                    set_interval();
                }
            );

            $bnnr_a.on("focusin", function() {
                clear_interval();
            });

            $bnnr_a.on("focusout", function() {
                set_interval();
            });

            function left_rolling() {
                $bnnr.each(function(index) {
                    if($(this).is(":visible")) {
                        o_idx = index;
                        return false;
                    }
                });

                $bnnr.not(":visible").css({
                    display: "none",
                    left: "+"+width+"px"
                });

                $bnnr.eq(o_idx).animate(
                    { left: "-="+width+"px" }, settings.duration,
                    function() {
                        $(this).css("display", "none").css("left", width+"px");
                    }
                );

                c_idx = (o_idx + 1) % count;

                $bnnr.eq(c_idx).css("display", "block").animate(
                    { left: "-="+width+"px" }, settings.duration,
                    function() {
                        o_idx = c_idx;
                    }
                );
            }

            function right_rolling() {
                $bnnr.each(function(index) {
                    if($(this).is(":visible")) {
                        o_idx = index;
                        return false;
                    }
                });

                $bnnr.not(":visible").css({
                    display: "none",
                    left: "-"+width+"px"
                });

                $bnnr.eq(o_idx).animate(
                    { left: "+="+width+"px" }, settings.duration,
                    function() {
                        $(this).css("display", "none").css("left", "-"+width+"px");
                    }
                );

                c_idx = (o_idx + 1) % count;

                $bnnr.eq(c_idx).css("display", "block").animate(
                    { left: "+="+width+"px" }, settings.duration,
                    function() {
                        o_idx = c_idx;
                    }
                );
            }

            function set_interval() {
                if(count > 1) {
                    clear_interval();

                    intervals[el_id] = setInterval(left_rolling, settings.interval);
                }
            }

            function clear_interval() {
                if(intervals[el_id]) {
                    clearInterval(intervals[el_id]);
                }
            }
        },
        stop: function()
        {
            var el_id = this[0].id;
            if(intervals[el_id])
                clearInterval(intervals[el_id]);
        }
    };

    $.fn.bannerRolling2 = function(option) {
        if (methods[option])
            return methods[option].apply(this, Array.prototype.slice.call(arguments, 1));
        else
            return methods.init.apply(this, arguments);
    }
}(jQuery));

$(function() {
    $("#spn_idx_<?=$position?>").bannerRolling2();
    // 기본 설정값을 변경하려면 아래처럼 사용
    //$("#bbsn_idx").leftRolling({ interval: 6000, duration: 2000 });
});
</script>