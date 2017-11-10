<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 6;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨

?>




<style>

table{
    text-align:center;
}
table th{
    text-align:center;
}
.table>thead>tr>th{
    vertical-align: inherit;
}

.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
    vertical-align: inherit;
}
</style>




<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
            <h3><?=$board['bo_subject']?></h3>
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


                        <!-- 게시판 카테고리 시작 { -->
                        <?php if ($is_category) { ?>
                        <br>
                        <nav id="bo_cate">
                            <ul class="nav nav-tabs ">
                                <?php echo $category_option ?>
                            </ul>
                        </nav>
                        <?php } ?>
                        <!-- } 게시판 카테고리 끝 -->
                        
                        <br><br>

                        <form name="fsearch" method="get">
                            <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
                            <input type="hidden" name="sca" value="<?php echo $sca ?>">
                            <input type="hidden" name="sop" value="and">
                            
                            <div class="title_right">
                                
                                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                    
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="단어를 입력하세요..."  name="stx" value="<?php echo stripslashes($stx) ?>" id="stx" required >
                                    
                              
                                    <span class="input-group-btn">
                                        
                                        <select class='form-control' name="sfl" id="sfl" style='width:130px;'>
                                            <option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
                                            <option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
                                            <option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
                                            <option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
                                            <option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option>
                                            <option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
                                            <option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option>
                                        </select>

                                    </span>

                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn_submit" type="submit"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                                </div>
                            </div>
                        </form>




                        <!-- 게시판 목록 시작 { -->
                        <div id="bo_list" style="width:<?php echo $width; ?>">



                            <!-- 게시판 페이지 정보 및 버튼 시작 { -->
                            <div class="bo_fx">
                                <p id="bg-info" style='padding:15px;'>
                                    <span>Total <?php echo number_format($total_count) ?>건</span>
                                    <?php echo $page ?> 페이지
                                </p>

                                <?php if ($rss_href || $write_href) { ?>
                                    <?php if ($rss_href) { ?><a href="<?php echo $rss_href ?>" class="btn_b01 btn btn-default">RSS</a><?php } ?>
                                    <?php if ($admin_href) { ?><a href="<?php echo $admin_href ?>" class="btn_admin btn btn-default">관리자</a><?php } ?>
                                    <?php if ($write_href) { ?><a href="<?php echo $write_href ?>" class="btn_b02 btn btn-default">글쓰기</a><?php } ?>
                                <?php } ?>
                            </div>
                            <!-- } 게시판 페이지 정보 및 버튼 끝 -->

                            <form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
                            <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
                            <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
                            <input type="hidden" name="stx" value="<?php echo $stx ?>">
                            <input type="hidden" name="spt" value="<?php echo $spt ?>">
                            <input type="hidden" name="sca" value="<?php echo $sca ?>">
                            <input type="hidden" name="sst" value="<?php echo $sst ?>">
                            <input type="hidden" name="sod" value="<?php echo $sod ?>">
                            <input type="hidden" name="page" value="<?php echo $page ?>">
                            <input type="hidden" name="sw" value="">
                                    <br>
                            <div class="tbl_head01 tbl_wrap table-responsive">
                                <table class='table table-striped table-bordered'> 

                                <thead>
                                <tr>
                                    <th scope="col">번호</th>
                                    <?php if ($is_checkbox) { ?>
                                    <th scope="col">
                                        <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
                                    </th>
                                    <?php } ?>
                                    <th scope="col">제목</th>
                                    <th scope="col">글쓴이</th>
                                    <th scope="col"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>날짜</a></th>
                                    <th scope="col"><?php echo subject_sort_link('wr_hit', $qstr2, 1) ?>조회</a></th>
                                    <?php if ($is_good) { ?><th scope="col"><?php echo subject_sort_link('wr_good', $qstr2, 1) ?>추천</a></th><?php } ?>
                                    <?php if ($is_nogood) { ?><th scope="col"><?php echo subject_sort_link('wr_nogood', $qstr2, 1) ?>비추천</a></th><?php } ?>
                                    <th scope="col">수정</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                for ($i=0; $i<count($list); $i++) {
                                ?>
                                <tr class="<?php if ($list[$i]['is_notice']) echo "bo_notice"; ?>">
                                    <td class="td_num">
                                    <?php
                                    if ($list[$i]['is_notice']) // 공지사항
                                        echo '<strong>공지</strong>';
                                    else if ($wr_id == $list[$i]['wr_id'])
                                        echo "<span class=\"bo_current\">열람중</span>";
                                    else
                                        echo $list[$i]['num'];
                                    ?>
                                    </td>
                                    <?php if ($is_checkbox) { ?>
                                    <td class="td_chk">
                                        <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
                                    </td>
                                    <?php } ?>
                                    <td class="td_subject" style='text-align:left;'>
                                        <?php
                                        echo $list[$i]['icon_reply'];
                                        if ($is_category && $list[$i]['ca_name']) {
                                        ?>
                                        <a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?>&nbsp;&nbsp;|&nbsp;&nbsp;</a>
                                        <?php } ?>

                                        <a href="<?php echo $list[$i]['href'] ?>">
                                            <?php echo $list[$i]['subject'] ?>
                                            <?php if ($list[$i]['comment_cnt']) { ?>&nbsp;&nbsp;[<?php echo $list[$i]['comment_cnt']; ?>]&nbsp;<i class="fa fa-commenting-o fa-lg" style='vertical-align:0;' aria-hidden="true"></i><?php } ?>
                                        </a>

                                        <?php
                                        // if ($list[$i]['link']['count']) { echo '['.$list[$i]['link']['count']}.']'; }
                                        // if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }

                                        if (isset($list[$i]['icon_new'])) echo "&nbsp;".$list[$i]['icon_new'];
                                        if (isset($list[$i]['icon_hot'])) echo "&nbsp;".$list[$i]['icon_hot'];
                                        if (isset($list[$i]['icon_file'])) echo '&nbsp;<i class="fa fa-file-o" style="vertical-align:0;" aria-hidden="true"></i>';
                                        if (isset($list[$i]['icon_link'])) echo '&nbsp;<i class="fa fa-link" style="vertical-align:0;" aria-hidden="true"></i>';
                                        if (isset($list[$i]['icon_secret'])) echo "&nbsp;".$list[$i]['icon_secret'];

                                        ?>
                                    </td>
                                    <td class="td_name sv_use"><?php echo $list[$i]['name'] ?></td>
                                    <td class="td_date"><?php echo $list[$i]['datetime2'] ?></td>
                                    <td class="td_num"><?php echo $list[$i]['wr_hit'] ?></td>
                                    <?php if ($is_good) { ?><td class="td_num"><?php echo $list[$i]['wr_good'] ?></td><?php } ?>
                                    <?php if ($is_nogood) { ?><td class="td_num"><?php echo $list[$i]['wr_nogood'] ?></td><?php } ?>
                                    <td class="td_num"><a href="<?php echo $write_href ?>&w=u&wr_id=<?=$list[$i]['wr_id']?>" class="btn_b02 btn btn-default">수정</a></td>
                                </tr>
                                <?php } ?>
                                <?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">게시물이 없습니다.</td></tr>'; } ?>
                                </tbody>
                                </table>
                            </div>

                            <?php if ($list_href || $is_checkbox || $write_href) { ?>
                            <div class="bo_fx">
                                <?php if ($is_checkbox) { ?>
                                
                                    <input class='btn btn-default' type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value">
                                    <input class='btn btn-default' type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value">
                                    <input class='btn btn-default' type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value">
                               
                                <?php } ?>

                                <?php if ($list_href || $write_href) { ?>
                                
                                    <?php if ($list_href) { ?><a href="<?php echo $list_href ?>" class="btn_b01 btn btn-default">목록</a><?php } ?>
                                    <?php if ($write_href) { ?><a href="<?php echo $write_href ?>" class="btn_b02 btn btn-default">글쓰기</a><?php } ?>
                                
                                <?php } ?>
                            </div>
                            <?php } ?>
                            </form>
                        </div>

                        <?php if($is_checkbox) { ?>
                        <noscript>
                        <p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
                        </noscript>
                        <?php } ?>

                        <!-- 페이지 -->
                        <?php echo $write_pages;  ?>

                        <!-- 게시판 검색 시작 { -->



                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<!-- } 게시판 검색 끝 -->

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = "./board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->
