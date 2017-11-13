
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
            var width = <?php echo $max_width; ?>;
            var height = <?php echo $max_height; ?>;
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

            $bnnr.not(".sbn_first").css("left", width+"px");

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
                var slide_button = "<div id=\"sbn_btn_p\" class=\"sbn_btn\"><button type=\"button\" id=\"sbn_btn_prev\" class=\"sbn_btn_slide\"><span></span><?php echo _t('이전'); ?></button></div>\n";
                slide_button += "<div id=\"sbn_btn_n\" class=\"sbn_btn\"><button type=\"button\" id=\"sbn_btn_next\" class=\"sbn_btn_slide\"><span></span><?php echo _t('다음'); ?></button></div>";

                this.find("ul").before(slide_button);

                var $bnnr_btn = this.find(".sbn_btn_slide");

                $bnnr_btn.on("focusin", function() {
                    clear_interval();
                });

                $bnnr_btn.on("focusout", function() {
                    set_interval();
                });
            }

            set_interval();

            $(".sbn_btn_slide").on("click", function() {
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

    $.fn.bannerRolling = function(option) {
        if (methods[option])
            return methods[option].apply(this, Array.prototype.slice.call(arguments, 1));
        else
            return methods.init.apply(this, arguments);
    }
}(jQuery));




