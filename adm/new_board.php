<?php
$new_write_rows = 8;

$sql_common = " from {$g5['board_new_table']} a, {$g5['board_table']} b, {$g5['group_table']} c where a.bo_table = b.bo_table and b.gr_id = c.gr_id ";

if ($gr_id)
    $sql_common .= " and b.gr_id = '$gr_id' ";
if ($view) {
    if ($view == 'w')
        $sql_common .= " and a.wr_id = a.wr_parent ";
    else if ($view == 'c')
        $sql_common .= " and a.wr_id <> a.wr_parent ";
}

$sql_common .= " and a.wr_id = a.wr_parent ";

$sql_order = " order by a.bn_id desc ";

$sql = " select count(*) as cnt {$sql_common} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$colspan = 5;
?>


<div class="col-md-8 col-sm-8 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>최근게시물 <small><?php echo $total_count ?>건 목록</small></h2>
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












          <section>
              <div class="tbl_head01 tbl_wrap">
                  <table class='table table-striped table-bordered'>
                  <br>
                  <thead>
                  <tr>
                      <th scope="col" class='moblie_hide'>그룹</th>
                      <th scope="col">게시판</th>
                      <th scope="col">제목</th>
                      <th scope="col">이름</th>
                      <th scope="col" class='moblie_hide'>일시</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  $sql = " select a.*, b.bo_subject, c.gr_subject, c.gr_id {$sql_common} {$sql_order} limit {$new_write_rows} ";
                  $result = sql_query($sql);
                  for ($i=0; $row=sql_fetch_array($result); $i++)
                  {
                      $tmp_write_table = $g5['write_prefix'] . $row['bo_table'];

                      if ($row['wr_id'] == $row['wr_parent']) // 원글
                      {
                          $comment = "";
                          $comment_link = "";
                          $row2 = sql_fetch(" select * from $tmp_write_table where wr_id = '{$row['wr_id']}' ");

                          $name = get_sideview_admin($row2['mb_id'], get_text(cut_str($row2['wr_name'], $config['cf_cut_name'])), $row2['wr_email'], $row2['wr_homepage']);
                          // 당일인 경우 시간으로 표시함
                          $datetime = substr($row2['wr_datetime'],0,10);
                          $datetime2 = $row2['wr_datetime'];
                          if ($datetime == G5_TIME_YMD)
                              $datetime2 = substr($datetime2,11,5);
                          else
                              $datetime2 = substr($datetime2,5,5);

                      }
                      else // 코멘트
                      {
                          $comment = '댓글 -> ';
                          $comment_link = '#c_'.$row['wr_id'];
                          $row2 = sql_fetch(" select * from {$tmp_write_table} where wr_id = '{$row['wr_parent']}' ");
                          $row3 = sql_fetch(" select mb_id, wr_name, wr_email, wr_homepage, wr_datetime from {$tmp_write_table} where wr_id = '{$row['wr_id']}' ");

                          $name = get_sideview_admin($row3['mb_id'], get_text(cut_str($row3['wr_name'], $config['cf_cut_name'])), $row3['wr_email'], $row3['wr_homepage']);
                          // 당일인 경우 시간으로 표시함
                          $datetime = substr($row3['wr_datetime'],0,10);
                          $datetime2 = $row3['wr_datetime'];
                          if ($datetime == G5_TIME_YMD)
                              $datetime2 = substr($datetime2,11,5);
                          else
                              $datetime2 = substr($datetime2,5,5);
                      }
                  ?>

                  <tr>
                      <td class="td_category moblie_hide"><a href="<?php echo G5_BBS_URL ?>/new.php?gr_id=<?php echo $row['gr_id'] ?>" target='_blank' ><?php echo cut_str($row['gr_subject'],10) ?></a></td>
                      <td class="td_category"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $row['bo_table'] ?>" target='_blank' ><?php echo cut_str($row['bo_subject'],20) ?></a></td>
                      <td><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $row['bo_table'] ?>&amp;wr_id=<?php echo $row2['wr_id'] ?><?php echo $comment_link ?>" target='_blank' ><?php echo $comment ?><?php echo conv_subject($row2['wr_subject'], 30) ?></a></td>
                      <td class="td_mbname"><div><?php echo $name ?></div></td>
                      <td class="td_datetime moblie_hide"><?php echo $datetime ?></td>
                  </tr>

                  <?php
                  }
                  if ($i == 0)
                      echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
                  ?>
                  </tbody>
                  </table>
              </div>

              <div class="btn_list03 btn_list">
                  <a href="<?php echo G5_BBS_URL ?>/new.php"><button class='btn btn-default'>최근게시물 더보기</button></a>
              </div>
          </section>







        </div>
      </div>
    </div>
