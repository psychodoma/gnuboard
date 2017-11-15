<!-- page content -->
<?//$pc_mobile = get_pc_visit_week($pc,$mobile);?>
<?//$pc_mobile_per = get_pc_visit_week_before_per($pc,$mobile);?>


  <!-- top tiles -->
  <div class="row tile_count">


    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-user"></i> 총 방문자</span>
      <div class="count"><?=number_format(get_total_visit())?></div>
      <span class="count_bottom">오늘 방문자 <i class="green"><?=number_format(get_total_visit_today())?>명 </i></span>
    </div>




    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-clock-o"></i> 최근 일주일 방문자</span>
      <div class="count"><?=number_format(get_total_visit_week())?></div>
        <?if(  get_total_visit_week_before_per() > 0 ){?>
          <span class="count_bottom">지난 주보다&nbsp;&nbsp;&nbsp;<i class="green"><i class="fa fa-sort-asc"></i>
        <?}else if( get_total_visit_week_before_per() < 0 ){?>
          <span class="count_bottom">지난 주보다&nbsp;&nbsp;&nbsp;<i class="red"><i class="fa fa-sort-desc"></i>
        <?}else{?>
          <span class="count_bottom">지난 주보다&nbsp;&nbsp;&nbsp;<i class="gray"><i class="fa fa-minus"></i>
        <?}?>
        <?=get_total_visit_week_before_per()?>% </i></span>
    </div>


    <!-- <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-desktop"></i> 어제 PC 접속자</span>
      <div class="count green"><?=$pc_mobile['pc']?></div>
        <?if(  $pc_mobile_per['pc'] > 0 ){?>
          <span class="count_bottom">지난 주보다&nbsp;&nbsp;&nbsp;<i class="green"><i class="fa fa-sort-asc"></i>
        <?}else if( $pc_mobile_per['pc'] < 0 ){?>
          <span class="count_bottom">지난 주보다&nbsp;&nbsp;&nbsp;<i class="red"><i class="fa fa-sort-desc"></i>
        <?}else{?>
          <span class="count_bottom">지난 주보다&nbsp;&nbsp;&nbsp;<i class="gray"><i class="fa fa-minus"></i>
        <?}?>
        <?=$pc_mobile_per['pc']?>% </i></span>
    </div>


    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-mobile fa-lg"></i> 어제 모바일 접속자</span>
      <div class="count"><?=$pc_mobile['mobile']?></div>
        <?if(  $pc_mobile_per['mobile'] > 0 ){?>
          <span class="count_bottom">지난 주보다&nbsp;&nbsp;&nbsp;<i class="green"><i class="fa fa-sort-asc"></i>
        <?}else if( $pc_mobile_per['mobile'] < 0 ){?>
          <span class="count_bottom">지난 주보다&nbsp;&nbsp;&nbsp;<i class="red"><i class="fa fa-sort-desc"></i>
        <?}else{?>
          <span class="count_bottom">지난 주보다&nbsp;&nbsp;&nbsp;<i class="gray"><i class="fa fa-minus"></i>
        <?}?>
        <?=$pc_mobile_per['mobile']?>% </i></span>
    </div> -->


    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-users"></i> 총 회원</span>
      <div class="count"><?=number_format(get_join_visit())?></div>
      <span class="count_bottom">일주일간 가입한 회원 <i class="green"> <?=get_join_visit_week()?>명</i></span>
    </div>


    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-table"></i> 총 공지사항</span>
      <div class="count"> <?=get_table_cnt('notice')?></div>
      <span class="count_bottom">일주일간 작성된 글 <i class="green"><?=get_table_week('notice')?>개</i></span>
    </div>

    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-table"></i> 총 이벤트</span>
      <div class="count"> <?=get_table_cnt('event')?></div>
      <span class="count_bottom">일주일간 작성된 글 <i class="green"><?=get_table_week('event')?>개</i></span>
    </div>


  </div>
