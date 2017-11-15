<?php
$new_write_rows = 4;

$sql_common = " from {$g5['board_new_table']} a, {$g5['board_table']} b, {$g5['group_table']} c where a.bo_table = b.bo_table and b.gr_id = c.gr_id ";

if ($gr_id)
    $sql_common .= " and b.gr_id = '$gr_id' ";
if ($view) {
    if ($view == 'w')
        $sql_common .= " and a.wr_id = a.wr_parent ";
    else if ($view == 'c')
        $sql_common .= " and a.wr_id <> a.wr_parent ";
}

$sql_common .= " and a.wr_id != a.wr_parent ";

$sql_order = " order by a.bn_id desc ";

$sql = " select count(*) as cnt {$sql_common} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$colspan = 5;
?>



  <div class="col-md-4 col-sm-4 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>최근 댓글 <small><?php echo $total_count ?>건 목록</small></h2>
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



        <div class="dashboard-widget-content">

          <ul class="list-unstyled timeline widget">

            <?php
            $sql = " select a.*, b.bo_subject, c.gr_subject, c.gr_id {$sql_common} {$sql_order} limit {$new_write_rows} ";
            $result = sql_query($sql);
            for ($i=0; $row=sql_fetch_array($result); $i++){
              $sql_board_parent = sql_fetch(" select * from g5_write_".$row['bo_table']." where wr_id = ".$row['wr_parent']);
              $sql_board_reply = sql_fetch(" select * from g5_write_".$row['bo_table']." where wr_id = ".$row['wr_id']);
            ?>


            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">
                      <a><?=cut_str($sql_board_parent['wr_subject'],30)?></a>
                  </h2>
                  <div style='height:5px;'></div>


                  <p class="excerpt" style='padding-top:7px;'><img src='/adm/img/sub_menu_ico.gif' style='vertical-align:top;'>&nbsp;&nbsp;&nbsp;<?=cut_str($sql_board_reply['wr_content'],90)?><a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;더 보기</a></p>
                  <div class="byline">
                    <span><?=substr($sql_board_reply['wr_datetime'],0,10)?></span>&nbsp;&nbsp;&nbsp;by&nbsp;&nbsp;&nbsp;<a><?=$sql_board_reply['mb_id']?></a>
                  </div>
                </div>
              </div>
            </li>

            <?}?>




          </ul>
        </div>

      </div>
    </div>
</div>
