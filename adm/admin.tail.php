<?php
if (!defined('_GNUBOARD_')) exit;

$print_version = defined('G5_YOUNGCART_VER') ? 'YoungCart Version '.G5_YOUNGCART_VER : 'Version '.G5_GNUBOARD_VER;
?>



        <!-- footer content -->
        <footer>
        <div class="pull-right">
          Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
        </div>
        <div class="clearfix"></div>
      </footer>
      <!-- /footer content -->
    </div>




<!-- <script src="<? echo G5_VENDORS ?>/jquery/dist/jquery.min.js"></script> -->
<script src="<? echo G5_VENDORS ?>/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- <script src="<? echo G5_VENDORS ?>/fastclick/lib/fastclick.js"></script> -->
<!-- <script src="<? echo G5_VENDORS ?>/nprogress/nprogress.js"></script> -->
<!-- <script src="<? echo G5_VENDORS ?>/Chart.js/dist/Chart.min.js"></script> -->
<!-- <script src="<? echo G5_VENDORS ?>/gauge.js/dist/gauge.min.js"></script> -->
<script src="<? echo G5_VENDORS ?>/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<script src="<? echo G5_VENDORS ?>/iCheck/icheck.min.js"></script>
<!-- <script src="<? echo G5_VENDORS ?>/skycons/skycons.js"></script> -->
<!-- <script src="<? echo G5_VENDORS ?>/Flot/jquery.flot.js"></script>
<script src="<? echo G5_VENDORS ?>/Flot/jquery.flot.pie.js"></script>
<script src="<? echo G5_VENDORS ?>/Flot/jquery.flot.time.js"></script>
<script src="<? echo G5_VENDORS ?>/Flot/jquery.flot.stack.js"></script>
<script src="<? echo G5_VENDORS ?>/Flot/jquery.flot.resize.js"></script>
<script src="<? echo G5_VENDORS ?>/flot.orderbars/js/jquery.flot.orderBars.js"></script>
<script src="<? echo G5_VENDORS ?>/flot-spline/js/jquery.flot.spline.min.js"></script>
<script src="<? echo G5_VENDORS ?>/flot.curvedlines/curvedLines.js"></script> -->
<script src="<? echo G5_VENDORS ?>/DateJS/build/date.js"></script>
<!-- <script src="<? echo G5_VENDORS ?>/jqvmap/dist/jquery.vmap.js"></script>
<script src="<? echo G5_VENDORS ?>/jqvmap/dist/maps/jquery.vmap.world.js"></script> -->
<!-- <script src="<? echo G5_VENDORS ?>/jqvmap/examples/js/jquery.vmap.sampledata.js"></script> -->
<!-- <script src="<? echo G5_VENDORS ?>/moment/min/moment.min.js"></script> -->
<!-- <script src="<? echo G5_VENDORS ?>/bootstrap-daterangepicker/daterangepicker.js"></script> -->
<script src="<? echo G5_BUILD ?>/js/custom.min.js"></script>

<!-- <script src="<?php echo G5_ADMIN_URL ?>/admin.js?ver=<?php echo G5_JS_VER; ?>"></script> -->



<?if(strpos($_SERVER['PHP_SELF'],'adm/bbs') !== false) {  ?>
<script src="<?php echo G5_ADMIN_URL ?>/admin_no_token.js?ver=<?php echo G5_JS_VER; ?>"></script>
<?php } else {  ?>
<script src="<?php echo G5_ADMIN_URL ?>/admin.js?ver=<?php echo G5_JS_VER; ?>"></script>
<?php } ?>





<script>
$(function(){
    var hide_menu = false;
    var mouse_event = false;
    var oldX = oldY = 0;

    $(document).mousemove(function(e) {
        if(oldX == 0) {
            oldX = e.pageX;
            oldY = e.pageY;
        }

        if(oldX != e.pageX || oldY != e.pageY) {
            mouse_event = true;
        }
    });

    // 주메뉴
    var $gnb = $(".gnb_1dli > a");
    $gnb.mouseover(function() {
        if(mouse_event) {
            $(".gnb_1dli").removeClass("gnb_1dli_over gnb_1dli_over2 gnb_1dli_on");
            $(this).parent().addClass("gnb_1dli_over gnb_1dli_on");
            menu_rearrange($(this).parent());
            hide_menu = false;
        }
    });

    $gnb.mouseout(function() {
        hide_menu = true;
    });

    $(".gnb_2dli").mouseover(function() {
        hide_menu = false;
    });

    $(".gnb_2dli").mouseout(function() {
        hide_menu = true;
    });

    $gnb.focusin(function() {
        $(".gnb_1dli").removeClass("gnb_1dli_over gnb_1dli_over2 gnb_1dli_on");
        $(this).parent().addClass("gnb_1dli_over gnb_1dli_on");
        menu_rearrange($(this).parent());
        hide_menu = false;
    });

    $gnb.focusout(function() {
        hide_menu = true;
    });

    $(".gnb_2da").focusin(function() {
        $(".gnb_1dli").removeClass("gnb_1dli_over gnb_1dli_over2 gnb_1dli_on");
        var $gnb_li = $(this).closest(".gnb_1dli").addClass("gnb_1dli_over gnb_1dli_on");
        menu_rearrange($(this).closest(".gnb_1dli"));
        hide_menu = false;
    });

    $(".gnb_2da").focusout(function() {
        hide_menu = true;
    });

    $('#gnb_1dul>li').bind('mouseleave',function(){
        submenu_hide();
    });

    $(document).bind('click focusin',function(){
        if(hide_menu) {
            submenu_hide();
        }
    });

    // 폰트 리사이즈 쿠키있으면 실행
    var font_resize_act = get_cookie("ck_font_resize_act");
    if(font_resize_act != "") {
        font_resize("container", font_resize_act);
    }
});

function submenu_hide() {
    $(".gnb_1dli").removeClass("gnb_1dli_over gnb_1dli_over2 gnb_1dli_on");
}

function menu_rearrange(el)
{
    var width = $("#gnb_1dul").width();
    var left = w1 = w2 = 0;
    var idx = $(".gnb_1dli").index(el);

    for(i=0; i<=idx; i++) {
        w1 = $(".gnb_1dli:eq("+i+")").outerWidth();
        w2 = $(".gnb_2dli > a:eq("+i+")").outerWidth(true);

        if((left + w2) > width) {
            el.removeClass("gnb_1dli_over").addClass("gnb_1dli_over2");
        }

        left += w1;
    }
}

</script>

<?php
include_once(G5_PATH.'/tail.sub.php');
?>
