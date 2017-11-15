<?
$sql_common = " from {$g5['popular_table']} a ";
$sql_search = " where trim(pp_word) <> '' ";
$sql_group = " group by pp_word ";
$sql_order = " order by cnt desc ";

$sql = " select pp_word {$sql_common} {$sql_search} {$sql_group} ";
$result = sql_query($sql);
$total_count = sql_num_rows($result);

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select pp_word, count(*) as cnt {$sql_common} {$sql_search} {$sql_group} {$sql_order} limit {$from_record}, 5 ";
$result = sql_query($sql);
$result1 = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result1); $i++) {
  $total_cnts += $row['cnt'];
}
?>

<div class="col-md-4 col-sm-4 col-xs-12">
  <div class="x_panel tile fixed_height_320">
    <div class="x_title">
      <h2>인기 검색어</h2>
      <ul class="nav navbar-right panel_toolbox">
      <li style='float:right;'><a class="close-link"><i class="fa fa-close"></i></a>
        </li>
        <li style='float:right;'><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </li>
      </ul>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <h4>검색어 Top 5</h4>

      <?php
          for ($i=0; $row=sql_fetch_array($result); $i++) {

              $word = get_text($row['pp_word']);
              $rank = ($i + 1 + ($rows * ($page - 1)));

              $rate = 100 * $row['cnt'] / $total_cnts;

      ?>

      <div class="widget_summary">
        <div class="w_left w_25">
          <span style="font-size:14px;" ><?php echo $word ?></span>
        </div>
        <div class="w_center w_55">
          <div class="progress">
            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?=$rate?>%;">
              <span class="sr-only">60% Complete</span>
            </div>
          </div>
        </div>
        <div class="w_right w_20">
          <span style="font-size:15px;" ><?php echo $row['cnt'] ?>건</span>
        </div>
        <div class="clearfix"></div>
      </div>

      <?php
      }
      ?>

    </div>
  </div>
</div>
