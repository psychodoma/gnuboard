<?php
include_once('./_common.php');

$g5['title'] = '관리자메인';
include_once ('./admin.head.php');
?>

<style>
table{text-align:center;}
table th{text-align:center;}
.table>thead>tr>th{vertical-align: inherit;}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{vertical-align: inherit;}
</style>

<div class="right_col" role="main">

  <!-- 상단 총방문자등.. 리스트들.. -->
  <?include_once('main_top_list.php')?>

  <!-- 방문자 통계 그래프 -->
  <?include_once('main_chart1.php')?>

  <div class="row">
    <!-- 인기 검색어 -->
    <?include_once("popular_word.php");?>

    <!-- 브라우저 사용 (chart2) -->
    <?include_once("main_chart2.php");?>

    <!-- 브라우저 사용 (chart3) -->
    <?include_once("main_chart3.php");?>
  </div>

  <!-- 신규가입회원 -->
  <?include_once("new_join.php")?>


  <div class="row">
    <!-- 최신 게시글 -->
    <?include_once("new_board.php")?>

    <!-- 최근 댓글 -->
    <?include_once("new_board_reply.php");?>

    <!-- 메인 표시 여부  -->
    <?include_once("to_do_list.php");?>

  </div>




</div>

        <!-- /page content -->





























<?php
include_once ('./admin.tail.php');
?>
