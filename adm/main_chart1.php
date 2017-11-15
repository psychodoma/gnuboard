<?
// 방문자 통꼐 그래프 일주일간 접속 없는 날 추가 하는 부분
for($i=1; $i<8; $i++){
  $today = date("Y-m-d", strtotime("-".$i." day", time()));
  $week_cnt = sql_fetch(" select count(*) cnt from g5_visit_sum where vs_date = '".$today."'");

  if($week_cnt['cnt'] == 0){
    sql_query(" insert into g5_visit_sum values('".$today."',0) ");
  }
}
//끝
?>

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="dashboard_graph">

      <div class="row x_title">
        <div class="col-md-12">
          <h3>방문자 통계 그래프<small> 사이트를 방문한 사용자 그래프</small></h3>
        </div>
      </div>

      <div class="col-md-12 col-sm-12 col-xs-12">
          <?include_once('/chart1.php')?>
      </div>

      <div class="clearfix"></div>
    </div>
  </div>

</div>
<br />
