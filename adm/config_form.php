<?php
$sub_menu = "100100";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

if (!isset($config['cf_add_script'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_add_script` TEXT NOT NULL AFTER `cf_admin_email_name` ", true);
}

if (!isset($config['cf_mobile_new_skin'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_mobile_new_skin` VARCHAR(255) NOT NULL AFTER `cf_memo_send_point`,
                    ADD `cf_mobile_search_skin` VARCHAR(255) NOT NULL AFTER `cf_mobile_new_skin`,
                    ADD `cf_mobile_connect_skin` VARCHAR(255) NOT NULL AFTER `cf_mobile_search_skin`,
                    ADD `cf_mobile_member_skin` VARCHAR(255) NOT NULL AFTER `cf_mobile_connect_skin` ", true);
}

if (isset($config['cf_gcaptcha_mp3'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    CHANGE `cf_gcaptcha_mp3` `cf_captcha_mp3` VARCHAR(255) NOT NULL DEFAULT '' ", true);
} else if (!isset($config['cf_captcha_mp3'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_captcha_mp3` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_mobile_member_skin` ", true);
}

if(!isset($config['cf_editor'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_editor` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_captcha_mp3` ", true);
}

if(!isset($config['cf_googl_shorturl_apikey'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_googl_shorturl_apikey` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_captcha_mp3` ", true);
}

if(!isset($config['cf_mobile_pages'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_mobile_pages` INT(11) NOT NULL DEFAULT '0' AFTER `cf_write_pages` ", true);
    sql_query(" UPDATE `{$g5['config_table']}` SET cf_mobile_pages = '5' ", true);
}

if(!isset($config['cf_facebook_appid'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_facebook_appid` VARCHAR(255) NOT NULL AFTER `cf_googl_shorturl_apikey`,
                    ADD `cf_facebook_secret` VARCHAR(255) NOT NULL AFTER `cf_facebook_appid`,
                    ADD `cf_twitter_key` VARCHAR(255) NOT NULL AFTER `cf_facebook_secret`,
                    ADD `cf_twitter_secret` VARCHAR(255) NOT NULL AFTER `cf_twitter_key` ", true);
}

// uniqid 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['uniqid_table']} ", false)) {
    sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['uniqid_table']}` (
                  `uq_id` bigint(20) unsigned NOT NULL,
                  `uq_ip` varchar(255) NOT NULL,
                  PRIMARY KEY (`uq_id`)
                ) ", false);
}

if(!sql_query(" SELECT uq_ip from {$g5['uniqid_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE {$g5['uniqid_table']} ADD `uq_ip` VARCHAR(255) NOT NULL ");
}

// 임시저장 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['autosave_table']} ", false)) {
    sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['autosave_table']}` (
                  `as_id` int(11) NOT NULL AUTO_INCREMENT,
                  `mb_id` varchar(20) NOT NULL,
                  `as_uid` bigint(20) unsigned NOT NULL,
                  `as_subject` varchar(255) NOT NULL,
                  `as_content` text NOT NULL,
                  `as_datetime` datetime NOT NULL,
                  PRIMARY KEY (`as_id`),
                  UNIQUE KEY `as_uid` (`as_uid`),
                  KEY `mb_id` (`mb_id`)
                ) ", false);
}

if(!isset($config['cf_admin_email'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_admin_email` VARCHAR(255) NOT NULL AFTER `cf_admin` ", true);
}

if(!isset($config['cf_admin_email_name'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_admin_email_name` VARCHAR(255) NOT NULL AFTER `cf_admin_email` ", true);
}

if(!isset($config['cf_cert_use'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_cert_use` TINYINT(4) NOT NULL DEFAULT '0' AFTER `cf_editor`,
                    ADD `cf_cert_ipin` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_cert_use`,
                    ADD `cf_cert_hp` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_cert_ipin`,
                    ADD `cf_cert_kcb_cd` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_cert_hp`,
                    ADD `cf_cert_kcp_cd` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_cert_kcb_cd`,
                    ADD `cf_cert_limit` INT(11) NOT NULL DEFAULT '0' AFTER `cf_cert_kcp_cd` ", true);
    sql_query(" ALTER TABLE `{$g5['member_table']}`
                    CHANGE `mb_hp_certify` `mb_certify` VARCHAR(20) NOT NULL DEFAULT '' ", true);
    sql_query(" update {$g5['member_table']} set mb_certify = 'hp' where mb_certify = '1' ");
    sql_query(" update {$g5['member_table']} set mb_certify = '' where mb_certify = '0' ");
    sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['cert_history_table']}` (
                  `cr_id` int(11) NOT NULL auto_increment,
                  `mb_id` varchar(255) NOT NULL DEFAULT '',
                  `cr_company` varchar(255) NOT NULL DEFAULT '',
                  `cr_method` varchar(255) NOT NULL DEFAULT '',
                  `cr_ip` varchar(255) NOT NULL DEFAULT '',
                  `cr_date` date NOT NULL DEFAULT '0000-00-00',
                  `cr_time` time NOT NULL DEFAULT '00:00:00',
                  PRIMARY KEY (`cr_id`),
                  KEY `mb_id` (`mb_id`)
                )", true);
}

if(!isset($config['cf_analytics'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_analytics` TEXT NOT NULL AFTER `cf_intercept_ip` ", true);
}

if(!isset($config['cf_add_meta'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_add_meta` TEXT NOT NULL AFTER `cf_analytics` ", true);
}

if (!isset($config['cf_syndi_token'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_syndi_token` VARCHAR(255) NOT NULL AFTER `cf_add_meta` ", true);
}

if (!isset($config['cf_syndi_except'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_syndi_except` TEXT NOT NULL AFTER `cf_syndi_token` ", true);
}

if(!isset($config['cf_sms_use'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_sms_use` varchar(255) NOT NULL DEFAULT '' AFTER `cf_cert_limit`,
                    ADD `cf_icode_id` varchar(255) NOT NULL DEFAULT '' AFTER `cf_sms_use`,
                    ADD `cf_icode_pw` varchar(255) NOT NULL DEFAULT '' AFTER `cf_icode_id`,
                    ADD `cf_icode_server_ip` varchar(255) NOT NULL DEFAULT '' AFTER `cf_icode_pw`,
                    ADD `cf_icode_server_port` varchar(255) NOT NULL DEFAULT '' AFTER `cf_icode_server_ip` ", true);
}

if(!isset($config['cf_mobile_page_rows'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_mobile_page_rows` int(11) NOT NULL DEFAULT '0' AFTER `cf_page_rows` ", true);
}

if(!isset($config['cf_cert_req'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_cert_req` tinyint(4) NOT NULL DEFAULT '0' AFTER `cf_cert_limit` ", true);
}

if(!isset($config['cf_faq_skin'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_faq_skin` varchar(255) NOT NULL DEFAULT '' AFTER `cf_connect_skin`,
                    ADD `cf_mobile_faq_skin` varchar(255) NOT NULL DEFAULT '' AFTER `cf_mobile_connect_skin` ", true);
}

// LG유플러스 본인확인 필드 추가
if(!isset($config['cf_lg_mid'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_lg_mid` varchar(255) NOT NULL DEFAULT '' AFTER `cf_cert_kcp_cd`,
                    ADD `cf_lg_mert_key` varchar(255) NOT NULL DEFAULT '' AFTER `cf_lg_mid` ", true);
}

if(!isset($config['cf_optimize_date'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_optimize_date` date NOT NULL default '0000-00-00' AFTER `cf_popular_del` ", true);
}

// 카카오톡링크 api 키
if(!isset($config['cf_kakao_js_apikey'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_kakao_js_apikey` varchar(255) NOT NULL DEFAULT '' AFTER `cf_googl_shorturl_apikey` ", true);
}

// SMS 전송유형 필드 추가
if(!isset($config['cf_sms_type'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_sms_type` varchar(10) NOT NULL DEFAULT '' AFTER `cf_sms_use` ", true);
}

// 접속자 정보 필드 추가
if(!sql_query(" select vi_browser from {$g5['visit_table']} limit 1 ")) {
    sql_query(" ALTER TABLE `{$g5['visit_table']}`
                    ADD `vi_browser` varchar(255) NOT NULL DEFAULT '' AFTER `vi_agent`,
                    ADD `vi_os` varchar(255) NOT NULL DEFAULT '' AFTER `vi_browser`,
                    ADD `vi_device` varchar(255) NOT NULL DEFAULT '' AFTER `vi_os` ", true);
}

if(!$config['cf_faq_skin']) $config['cf_faq_skin'] = "basic";
if(!$config['cf_mobile_faq_skin']) $config['cf_mobile_faq_skin'] = "basic";

$g5['title'] = '환경설정';
include_once ('./admin.head.php');

$pg_anchor = '<ul class="anchor">
    <li><a href="#anc_cf_basic">기본환경</a></li>
    <li><a href="#anc_cf_board">게시판기본</a></li>
    <li><a href="#anc_cf_join">회원가입</a></li>
    <li><a href="#anc_cf_cert">본인확인</a></li>
    <li><a href="#anc_cf_mail">기본메일환경</a></li>
    <li><a href="#anc_cf_article_mail">글작성메일</a></li>
    <li><a href="#anc_cf_join_mail">가입메일</a></li>
    <li><a href="#anc_cf_vote_mail">투표메일</a></li>
    <li><a href="#anc_cf_sns">SNS</a></li>
    <li><a href="#anc_cf_lay">레이아웃 추가설정</a></li>
    <li><a href="#anc_cf_sms">SMS</a></li>
    <li><a href="#anc_cf_extra">여분필드</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
    <a href="'.G5_URL.'/">메인으로</a>
</div>';

if (!$config['cf_icode_server_ip'])   $config['cf_icode_server_ip'] = '211.172.232.124';
if (!$config['cf_icode_server_port']) $config['cf_icode_server_port'] = '7295';

if ($config['cf_sms_use'] && $config['cf_icode_id'] && $config['cf_icode_pw']) {
    $userinfo = get_icode_userinfo($config['cf_icode_id'], $config['cf_icode_pw']);
}
?>

<style>
/* .x_content{
    display:none;
} */

.cf_cert_hide {
    display:none;
}

.panel_toolbox{
    min-width:0;
}
</style>

<form class='form-horizontal' name="fconfigform" id="fconfigform" method="post" onsubmit="return fconfigform_submit(this);">
<input type="hidden" name="token" value="" id="token">


<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>기본환경설정</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class='row' >

            <!-- form input mask -->
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel" >
                  <div class="x_title">
                    <h2>홈페이지 기본환경 설정</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
            

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">홈페이지 제목 <span class="required red">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <input class="form-control"  type="text" name="cf_title" value="<?php echo $config['cf_title'] ?>"   required="required">
                        </div>
                      </div>
                      <br>



                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">최고관리자 <span class="required red">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo get_member_id_select('cf_admin', 10, $config['cf_admin'], 'required') ?>
                        </div>
                      </div>
                      <br>



                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">관리자 메일 주소 <span class="required red">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <?php echo help('관리자가 보내고 받는 용도로 사용하는 메일 주소를 입력합니다. (회원가입, 인증메일, 테스트, 회원메일발송 등에서 사용)') ?>
                          <input type="text" class="form-control" name="cf_admin_email" value="<?php echo $config['cf_admin_email'] ?>" id="cf_admin_email" required="required" >
                        </div>
                      </div>
                      <br>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">관리자 메일 발송이름 <span class="required red">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <?php echo help('관리자가 보내고 받는 용도로 사용하는 메일의 발송이름을 입력합니다. (회원가입, 인증메일, 테스트, 회원메일발송 등에서 사용)') ?>
                          <input type="text" class="form-control" name="cf_admin_email_name" value="<?php echo $config['cf_admin_email_name'] ?>" id="cf_admin_email_name" required="required" >
                        </div>
                      </div>
                      <br>
                      
           
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">포인트 사용 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <input type="checkbox" class="flat" name="cf_use_point" value="1" id="cf_use_point" <?php echo $config['cf_use_point']?'checked':''; ?> > 사용 </p>
                        </div>
                      </div>
                      <br>

                      


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">로그인시 포인트 <span class="required red">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <?php echo help('회원이 로그인시 하루에 한번만 적립') ?>
                          <input type="number" class="form-control" name="cf_login_point" value="<?php echo $config['cf_login_point'] ?>" id="cf_login_point" required="required" >
                        </div>
                      </div>
                      <br>



                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">쪽지보낼시 차감 포인트 <span class="required red">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <?php echo help('양수로 입력하십시오. 0점은 쪽지 보낼시 포인트를 차감하지 않습니다.') ?>
                          <input type="number" class="form-control" name="cf_memo_send_point" value="<?php echo $config['cf_memo_send_point'] ?>" id="cf_memo_send_point" required="required" >
                        </div>
                      </div>
                      <br>


                       

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">이름(닉네임) 표시 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <?php echo help('입력 숫자의 자릿수 만큼 표시.') ?>
                          <input type="number" class="form-control" name="cf_cut_name" value="<?php echo $config['cf_cut_name'] ?>" id="cf_cut_name">
                        </div>
                      </div>
                      <br>



                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">닉네임 수정 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <?php echo help('수정하면 입력 숫자 동안 바꿀 수 없음') ?>
                          <input type="number" class="form-control" name="cf_nick_modify" value="<?php echo $config['cf_nick_modify'] ?>" id="cf_nick_modify" >
                        </div>
                      </div>
                      <br>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">정보공개 수정 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <?php echo help('수정하면 입력 숫자일 동안 바꿀 수 없음') ?>
                          <input type="number" class="form-control" name="cf_open_modify" value="<?php echo $config['cf_open_modify'] ?>" id="cf_open_modify" >
                        </div>
                      </div>
                      <br>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">최근게시물 삭제 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('설정일이 지난 최근게시물 자동 삭제') ?>
                            <input type="number" class="form-control" name="cf_new_del" value="<?php echo $config['cf_new_del'] ?>" id="cf_new_del" >
                         </div>
                      </div>
                      <br>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">쪽지 삭제 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('설정일이 지난 쪽지 자동 삭제') ?>
                            <input type="number" class="form-control" name="cf_memo_del" value="<?php echo $config['cf_memo_del'] ?>" id="cf_memo_del" >
                         </div>
                      </div>
                      <br>               





                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">접속자로그 삭제 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('설정일이 지난 접속자 로그 자동 삭제') ?>
                            <input type="number" class="form-control" name="cf_visit_del" value="<?php echo $config['cf_visit_del'] ?>" id="cf_visit_del" >
                         </div>
                      </div>
                      <br> 


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">인기검색어 삭제 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('설정일이 지난 인기검색어 자동 삭제') ?>
                            <input type="number" class="form-control" name="cf_popular_del" value="<?php echo $config['cf_popular_del'] ?>" id="cf_popular_del" >
                         </div>
                      </div>
                      <br> 


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">현재 접속자 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('설정값 이내의 접속자를 현재 접속자로 인정') ?>
                            <input type="number" class="form-control" name="cf_login_minutes" value="<?php echo $config['cf_login_minutes'] ?>" id="cf_login_minutes" >
                         </div>
                      </div>
                      <br> 


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">최근게시물 라인수 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('목록 한페이지당 라인수') ?>
                            <input type="number" class="form-control" name="cf_new_rows" value="<?php echo $config['cf_new_rows'] ?>" id="cf_new_rows" >
                         </div>
                      </div>
                      <br> 


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">한페이지당 라인수 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('목록(리스트) 한페이지당 라인수') ?>
                            <input type="number" class="form-control" name="cf_page_rows" value="<?php echo $config['cf_page_rows'] ?>" id="cf_page_rows" >
                         </div>
                      </div>
                      <br> 


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">모바일 한페이지당 라인수 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('모바일 목록 한페이지당 라인수') ?>
                            <input type="number" class="form-control" name="cf_mobile_page_rows" value="<?php echo $config['cf_mobile_page_rows'] ?>" id="cf_mobile_page_rows" >
                         </div>
                      </div>
                      <br> 


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">페이지 표시 수 <span class="required red">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('입력 숫자만큼의 페이지씩 표시') ?>
                            <input type="number" class="form-control" name="cf_write_pages" value="<?php echo $config['cf_write_pages'] ?>" id="cf_write_pages" required >
                         </div>
                      </div>
                      <br> 


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">모바일 페이지 표시 수 <span class="required red">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('입력 숫자만큼의 페이지씩 표시') ?>
                            <input type="number" class="form-control" name="cf_mobile_pages" value="<?php echo $config['cf_mobile_pages'] ?>" id="cf_mobile_pages" required >
                         </div>
                      </div>
                      <br> 

                        

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">최근게시물 스킨 <span class="required red">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo get_skin_select('new', 'cf_new_skin', 'cf_new_skin', $config['cf_new_skin'], 'required'); ?>
                         </div>
                      </div>
                      <br> 

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">모바일 최근게시물 스킨 <span class="required red">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo get_mobile_skin_select('new', 'cf_mobile_new_skin', 'cf_mobile_new_skin', $config['cf_mobile_new_skin'], 'required'); ?>
                         </div>
                      </div>
                      <br> 


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">검색 스킨 <span class="required red">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo get_skin_select('search', 'cf_search_skin', 'cf_search_skin', $config['cf_search_skin'], 'required'); ?>
                         </div>
                      </div>
                      <br> 


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">모바일 검색 스킨 <span class="required red">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo get_mobile_skin_select('search', 'cf_mobile_search_skin', 'cf_mobile_search_skin', $config['cf_mobile_search_skin'], 'required'); ?>
                         </div>
                      </div>
                      <br> 



                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">접속자 스킨 <span class="required red">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo get_skin_select('connect', 'cf_connect_skin', 'cf_connect_skin', $config['cf_connect_skin'], 'required'); ?>
                         </div>
                      </div>
                      <br> 


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">모바일 접속자 스킨 <span class="required red">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo get_mobile_skin_select('connect', 'cf_mobile_connect_skin', 'cf_mobile_connect_skin', $config['cf_mobile_connect_skin'], 'required'); ?>
                         </div>
                      </div>
                      <br> 


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">FAQ 스킨 <span class="required red">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo get_skin_select('faq', 'cf_faq_skin', 'cf_faq_skin', $config['cf_faq_skin'], 'required'); ?>
                         </div>
                      </div>
                      <br> 



                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">모바일 FAQ 스킨 <span class="required red">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo get_mobile_skin_select('faq', 'cf_mobile_faq_skin', 'cf_mobile_faq_skin', $config['cf_mobile_faq_skin'], 'required'); ?>
                         </div>
                      </div>
                      <br> 

                        

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">에디터 선택 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help(G5_EDITOR_URL.' 밑의 DHTML 에디터 폴더를 선택합니다.') ?>
                            <select class='form-control' name="cf_editor" id="cf_editor">
                            <?php
                            $arr = get_skin_dir('', G5_EDITOR_PATH);
                            for ($i=0; $i<count($arr); $i++) {
                                if ($i == 0) echo "<option value=\"\">사용안함</option>";
                                echo "<option value=\"".$arr[$i]."\"".get_selected($config['cf_editor'], $arr[$i]).">".$arr[$i]."</option>\n";
                            }
                            ?>
                            </select>
                         </div>
                      </div>
                      <br> 


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">음성캡챠 선택 <span class="required red">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help(G5_CAPTCHA_URL.'/mp3 밑의 음성 폴더를 선택합니다.') ?>
                            <select class='form-control' name="cf_captcha_mp3" id="cf_captcha_mp3" required class="required">
                            <?php
                            $arr = get_skin_dir('mp3', G5_CAPTCHA_PATH);
                            for ($i=0; $i<count($arr); $i++) {
                                if ($i == 0) echo "<option value=\"\">선택</option>";
                                echo "<option value=\"".$arr[$i]."\"".get_selected($config['cf_captcha_mp3'], $arr[$i]).">".$arr[$i]."</option>\n";
                            }
                            ?>
                            </select>
                         </div>
                      </div>
                      <br> 

                        



                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">복사, 이동시 로그 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <?php echo help('게시물 아래에 누구로 부터 복사, 이동됨 표시') ?><br>
                          <input type="checkbox" class="flat" name="cf_use_copy_log" value="1" id="cf_use_copy_log" <?php echo $config['cf_use_copy_log']?'checked':''; ?>> 남김          
                        </div>
                      </div>
                      <br>

                           


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">포인트 유효기간 <span class="required red">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('기간을 0으로 설정시 포인트 유효기간이 적용되지 않습니다.') ?>
                            <input type="number" class="form-control" name="cf_point_term" value="<?php echo $config['cf_point_term']; ?>" id="cf_point_term" required >
                         </div>
                      </div>
                      <br> 


 
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">접근가능 IP </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('입력된 IP의 컴퓨터만 접근할 수 있습니다. 123.123.+ 도 입력 가능. (엔터로 구분)') ?>
                            <textarea  class="form-control" name="cf_possible_ip" id="cf_possible_ip"><?php echo $config['cf_possible_ip'] ?></textarea>
                         </div>
                      </div>
                      <br>
                      


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">접근차단 IP </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('입력된 IP의 컴퓨터는 접근할 수 없음. 123.123.+ 도 입력 가능. (엔터로 구분)') ?>
                            <textarea  class="form-control" name="cf_intercept_ip" id="cf_intercept_ip"><?php echo $config['cf_intercept_ip'] ?></textarea>
                         </div>
                      </div>
                      <br>



                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">방문자분석 스크립트 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('방문자분석 스크립트 코드를 입력합니다. 예) 구글 애널리틱스') ?>
                            <textarea  class="form-control" name="cf_analytics" id="cf_analytics"><?php echo $config['cf_analytics']; ?></textarea>
                         </div>
                      </div>
                      <br>



                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">추가 메타태그 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('추가로 사용하실 meta 태그를 입력합니다.') ?>
                            <textarea  class="form-control" name="cf_add_meta" id="cf_add_meta"><?php echo $config['cf_add_meta']; ?></textarea>
                         </div>
                      </div>
                      <br>



                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">네이버 신디케이션 연동키 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('네이버 신디케이션 연동키(token)을 입력하면 네이버 신디케이션을 사용할 수 있습니다.<br>연동키는 <a href="http://webmastertool.naver.com/" target="_blank"><u>네이버 웹마스터도구</u></a> -> 네이버 신디케이션에서 발급할 수 있습니다.') ?>
                            <input type='text'  class="form-control" name="cf_syndi_token" value="<?php echo $config['cf_syndi_token'] ?>" id="cf_syndi_token" >
                         </div>
                      </div>
                      <br>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">네이버 신디케이션 제외게시판 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('네이버 신디케이션 수집에서 제외할 게시판 아이디를 | 로 구분하여 입력하십시오. 예) notice|adult<br>참고로 그룹접근사용 게시판, 글읽기 권한 2 이상 게시판, 비밀글은 신디케이션 수집에서 제외됩니다.') ?>
                            <input type='text'  class="form-control" name="cf_syndi_except" value="<?php echo $config['cf_syndi_except'] ?>" id="cf_syndi_except" >
                         </div>
                      </div>



                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                          <input type="submit" class="btn btn-success btn_submit" value='확인' accesskey="s" >
                          <a href='/adm' class="btn btn-primary">취소</a>
                        </div>
                      </div>

                  </div>
                </div>
              </div>
              <!-- 홈페이지 기본환경 설정 끝! 첫라인 첫번째  -->




              <!-- 홈페이지 기본환경 설정 끝! 두번째 첫번째  -->                  
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>게시판 기본 설정</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
            

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">글쓰기 간격 <span class="required red">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <?php echo help('입력숫자(초) 지난후 가능') ?>
                          <input class="form-control"  type="number"name="cf_delay_sec" value="<?php echo $config['cf_delay_sec'] ?>" id="cf_delay_sec" required >
                        </div>
                      </div>
                      <br>



                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">	새창 링크 </span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('글내용중 자동 링크되는 타켓을 지정합니다.') ?><br>
                            <select class='form-control' name="cf_link_target" id="cf_link_target">
                                <option value="_blank"<?php echo get_selected($config['cf_link_target'], '_blank') ?>>_blank</option>
                                <option value="_self"<?php echo get_selected($config['cf_link_target'], '_self') ?>>_self</option>
                                <option value="_top"<?php echo get_selected($config['cf_link_target'], '_top') ?>>_top</option>
                                <option value="_new"<?php echo get_selected($config['cf_link_target'], '_new') ?>>_new</option>
                            </select>
                        </div>
                      </div>
                      <br>



                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">글읽기 포인트 <span class="required red">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <input type="number" class="form-control" name="cf_read_point" value="<?php echo $config['cf_read_point'] ?>" id="cf_read_point" required >
                        </div>
                      </div>
                      <br>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">글쓰기 포인트 <span class="required red">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <input type="number" class="form-control" name="cf_write_point" value="<?php echo $config['cf_write_point'] ?>" id="cf_write_point" required >
                        </div>
                      </div>
                      <br>
                      
           
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">댓글쓰기 포인트 <span class="required red">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <input type="number" class="form-control" name="cf_comment_point" value="<?php echo $config['cf_comment_point'] ?>" id="cf_comment_point" required >
                        </div>
                      </div>
                      <br>

                      


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">다운로드 포인트 <span class="required red">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <input type="number" class="form-control" name="cf_download_point" value="<?php echo $config['cf_download_point'] ?>" id="cf_download_point" required >
                        </div>
                      </div>
                      <br>



                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">검색 단위 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <?php echo help('입력숫자(건) 단위로 검색') ?>
                          <input type="number" class="form-control" name="cf_search_part" value="<?php echo $config['cf_search_part'] ?>" id="cf_search_part" >
                        </div>
                      </div>
                      <br>


                       

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">이미지 업로드 확장자 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <?php echo help('게시판 글작성시 이미지 파일 업로드 가능 확장자. | 로 구분') ?>
                          <input type="text" class="form-control" name="cf_image_extension" value="<?php echo $config['cf_image_extension'] ?>" id="cf_image_extension" >
                        </div>
                      </div>
                      <br>



                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">플래쉬 업로드 확장자 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <?php echo help('게시판 글작성시 플래쉬 파일 업로드 가능 확장자. | 로 구분') ?>
                          <input type="text" class="form-control" name="cf_flash_extension" value="<?php echo $config['cf_flash_extension'] ?>" id="cf_flash_extension" >
                        </div>
                      </div>
                      <br>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">동영상 업로드 확장자 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <?php echo help('게시판 글작성시 동영상 파일 업로드 가능 확장자. | 로 구분') ?>
                          <input type="text" class="form-control" name="cf_movie_extension" value="<?php echo $config['cf_movie_extension'] ?>" id="cf_movie_extension" >
                        </div>
                      </div>
                      <br>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">단어 필터링 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('입력된 단어가 포함된 내용은 게시할 수 없습니다. 단어와 단어 사이는 ,로 구분합니다.') ?>
                            <textarea class="form-control" name="cf_filter" id="cf_filter" rows="7"><?php echo $config['cf_filter'] ?></textarea>
                         </div>
                      </div>
                      <br>



                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                          <input type="submit" class="btn btn-success btn_submit" value='확인' accesskey="s" >
                          <a href='/adm' class="btn btn-primary">취소</a>
                        </div>
                      </div>

                  </div>
                </div>
              </div>
              <!-- /홈페이지 기본환경 설정 끝! 두번째 첫번째 -->




              <!-- 홈페이지 기본환경 설정 끝! 두번째 첫번째         2017-09-22에는 여기서부터 하면됩니다!!           -->
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>회원가입 설정</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
            

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">회원 스킨 <span class="required red">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo get_skin_select('member', 'cf_member_skin', 'cf_member_skin', $config['cf_member_skin'], 'required'); ?>
                        </div>
                      </div>
                      <br>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">모바일 회원 스킨 <span class="required red">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo get_skin_select('member', 'cf_mobile_member_skin', 'cf_mobile_member_skin', $config['cf_mobile_member_skin'], 'required'); ?>
                        </div>
                      </div>
                      <br>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">홈페이지 입력 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <input type="checkbox" class="flat" name="cf_use_homepage" value="1" id="cf_use_homepage" <?php echo $config['cf_use_homepage']?'checked':''; ?>> <label for="cf_use_homepage">보이기</label>
                            <input type="checkbox" class="flat" name="cf_req_homepage" value="1" id="cf_req_homepage" <?php echo $config['cf_req_homepage']?'checked':''; ?>> <label for="cf_req_homepage">필수입력</label>
                        </div>
                      </div>
                      <br>



                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">주소 입력 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <input type="checkbox" class="flat" name="cf_use_addr" value="1" id="cf_use_addr" <?php echo $config['cf_use_addr']?'checked':''; ?>> <label for="cf_use_homepage">보이기</label>
                            <input type="checkbox" class="flat" name="cf_req_addr" value="1" id="cf_req_addr" <?php echo $config['cf_req_addr']?'checked':''; ?>> <label for="cf_req_homepage">필수입력</label>
                        </div>
                      </div>
                      <br>



                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">전화번호 입력 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <input type="checkbox" class="flat" name="cf_use_tel" value="1" id="cf_use_tel" <?php echo $config['cf_use_tel']?'checked':''; ?>> <label for="cf_use_homepage">보이기</label>
                            <input type="checkbox" class="flat" name="cf_req_tel" value="1" id="cf_req_tel" <?php echo $config['cf_req_tel']?'checked':''; ?>> <label for="cf_req_homepage">필수입력</label>
                        </div>
                      </div>
                      <br>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">휴대폰번호 입력 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <input type="checkbox" class="flat" name="cf_use_hp" value="1" id="cf_use_hp" <?php echo $config['cf_use_hp']?'checked':''; ?>> <label for="cf_use_homepage">보이기</label>
                            <input type="checkbox" class="flat" name="cf_req_hp" value="1" id="cf_req_hp" <?php echo $config['cf_req_hp']?'checked':''; ?>> <label for="cf_req_homepage">필수입력</label>
                        </div>
                      </div>
                      <br>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">서명 입력 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <input type="checkbox" class="flat" name="cf_use_signature" value="1" id="cf_use_signature" <?php echo $config['cf_use_signature']?'checked':''; ?>> <label for="cf_use_homepage">보이기</label>
                            <input type="checkbox" class="flat" name="cf_req_signature" value="1" id="cf_req_signature" <?php echo $config['cf_req_signature']?'checked':''; ?>> <label for="cf_req_homepage">필수입력</label>
                        </div>
                      </div>
                      <br>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">자기소개 입력 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <input type="checkbox" class="flat" name="cf_use_profile" value="1" id="cf_use_profile" <?php echo $config['cf_use_profile']?'checked':''; ?>> <label for="cf_use_homepage">보이기</label>
                            <input type="checkbox" class="flat" name="cf_req_profile" value="1" id="cf_req_profile" <?php echo $config['cf_req_profile']?'checked':''; ?>> <label for="cf_req_homepage">필수입력</label>
                        </div>
                      </div>
                      <br>




                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">회원가입시 권한 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo get_member_level_select('cf_register_level', 1, 9, $config['cf_register_level']) ?>
                        </div>
                      </div>
                      <br>



                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">회원가입시 포인트 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('* 1점 단위') ?>
                            <input type="number" class="form-control" name="cf_register_point" value="<?php echo $config['cf_register_point'] ?>" id="cf_register_point" >
                        </div>
                      </div>
                      <br>



                        <!-- 여기서부터하자!!!!!!!!!!!!!!!!!!!!!! -->


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">회원탈퇴후 삭제일 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('* 1일 단위') ?>
                            <input type="number" class="form-control" name="cf_leave_day" value="<?php echo $config['cf_leave_day'] ?>" id="cf_leave_day" >
                        </div>
                      </div>
                      <br>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">회원아이콘 사용 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('게시물에 게시자 닉네임 대신 아이콘 사용') ?>
                            <select class='form-control' name="cf_use_member_icon" id="cf_use_member_icon">
                                <option value="0"<?php echo get_selected($config['cf_use_member_icon'], '0') ?>>미사용
                                <option value="1"<?php echo get_selected($config['cf_use_member_icon'], '1') ?>>아이콘만 표시
                                <option value="2"<?php echo get_selected($config['cf_use_member_icon'], '2') ?>>아이콘+이름 표시
                            </select>
                        </div>
                      </div>
                      <br>



                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">아이콘 업로드 권한 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help("* 입력값 이상") ?>
                            <?php echo get_member_level_select('cf_icon_level', 1, 9, $config['cf_icon_level']) ?>
                        </div>
                      </div>
                      <br>



                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">회원아이콘 용량 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('* 입력값(바이트) 이하') ?>
                            <input type="number" class="form-control" name="cf_member_icon_size" value="<?php echo $config['cf_member_icon_size'] ?>" id="cf_member_icon_size" >
                        </div>
                      </div>
                      <br>



                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">회원아이콘 사이즈(가로) </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('* 입력값(픽셀) 이하') ?>
                            <input type="number" class="form-control" name="cf_member_icon_width" value="<?php echo $config['cf_member_icon_width'] ?>" id="cf_member_icon_width" >
                        </div>
                      </div>
                      <br>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">회원아이콘 사이즈(세로) </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('* 입력값(픽셀) 이하') ?>
                            <input type="number" class="form-control" name="cf_member_icon_height" value="<?php echo $config['cf_member_icon_height'] ?>" id="cf_member_icon_height" >
                        </div>
                      </div>
                      <br>



                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">추천인제도 사용 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <input type="checkbox"class="flat" name="cf_use_recommend" value="1" id="cf_use_recommend" <?php echo $config['cf_use_recommend']?'checked':''; ?>> 사용
                        </div>
                      </div>
                      <br>




                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">추천인 포인트 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <input type="number" class="form-control" name="cf_recommend_point" value="<?php echo $config['cf_recommend_point'] ?>" id="cf_recommend_point" >
                        </div>
                      </div>
                      <br>





                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">아이디,닉네임 금지단어 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('회원아이디, 닉네임으로 사용할 수 없는 단어를 정합니다. 쉼표 (,) 로 구분') ?>
                            <textarea class="form-control" name="cf_prohibit_id" id="cf_prohibit_id" rows="5"><?php echo $config['cf_prohibit_id'] ?></textarea>
                         </div>
                      </div>
                      <br>



                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">입력 금지 메일 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php echo help('입력 받지 않을 도메인을 지정합니다. 엔터로 구분 ex) hotmail.com') ?>
                            <textarea class="form-control" name="cf_prohibit_email" id="cf_prohibit_email" rows="5"><?php echo $config['cf_prohibit_email'] ?></textarea>
                         </div>
                      </div>
                      <br>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">회원가입약관 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <textarea class="form-control" name="cf_stipulation" id="cf_stipulation" rows="10"><?php echo $config['cf_stipulation'] ?></textarea>
                         </div>
                      </div>
                      <br>



                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">개인정보처리방침 </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <textarea class="form-control" id="cf_privacy" name="cf_privacy" rows="10"><?php echo $config['cf_privacy'] ?></textarea>
                         </div>
                      </div>
                      <br>



                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                          <input type="submit" class="btn btn-success btn_submit" value='확인' accesskey="s" >
                          <a href='/adm' class="btn btn-primary">취소</a>
                        </div>
                      </div>

                  </div>
                </div>
              </div>
              <!-- /form input mask -->


              











             <!-- 홈페이지 기본환경 설정 끝! 두번째 첫번째         2017-09-22에는 여기서부터 하면됩니다!!           -->
             <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>본인확인 설정</h2>


                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />


                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">본인확인
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <p>회원가입 시 본인확인 수단을 설정합니다.</p>
                            <p>실명과 휴대폰 번호 그리고 본인확인 당시에 성인인지의 여부를 저장합니다.</p>
                            <p>게시판의 경우 본인확인 또는 성인여부를 따져 게시물 조회 및 쓰기 권한을 줄 수 있습니다.</p>

                            <select class='form-control' name="cf_cert_use" id="cf_cert_use">
                                <?php echo option_selected("0", $config['cf_cert_use'], "사용안함"); ?>
                                <?php echo option_selected("1", $config['cf_cert_use'], "테스트"); ?>
                                <?php echo option_selected("2", $config['cf_cert_use'], "실서비스"); ?>
                            </select>

                        </div>
                      </div>
                      <br>


     

                      <div class="form-group cf_cert_service">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">아이핀 본인확인
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <select class='form-control' name="cf_cert_ipin" id="cf_cert_ipin">
                                <?php echo option_selected("",    $config['cf_cert_ipin'], "사용안함"); ?>
                                <?php echo option_selected("kcb", $config['cf_cert_ipin'], "코리아크레딧뷰로(KCB) 아이핀"); ?>
                            </select>
                        </div>
                      </div>
                      <br>




                      <div class="form-group cf_cert_service">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">휴대폰 본인확인
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <select class='form-control' name="cf_cert_hp" id="cf_cert_hp">
                                <?php echo option_selected("",    $config['cf_cert_hp'], "사용안함"); ?>
                                <?php echo option_selected("kcb", $config['cf_cert_hp'], "코리아크레딧뷰로(KCB) 휴대폰 본인확인"); ?>
                                <?php echo option_selected("kcp", $config['cf_cert_hp'], "NHN KCP 휴대폰 본인확인"); ?>
                                <?php echo option_selected("lg",  $config['cf_cert_hp'], "LG유플러스 휴대폰 본인확인"); ?>
                            </select>
                        </div>
                      </div>
                      <br>




                      <div class="form-group cf_cert_service">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">코리아크레딧뷰로<br>KCB 회원사ID
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <p>KCB 회원사ID를 입력해 주십시오.</p>
                            <p>서비스에 가입되어 있지 않다면, KCB와 계약체결 후 회원사ID를 발급 받으실 수 있습니다.</p>
                            <p>이용하시려는 서비스에 대한 계약을 아이핀, 휴대폰 본인확인 각각 체결해주셔야 합니다.</p>
                            <p>아이핀 본인확인 테스트의 경우에는 KCB 회원사ID가 필요 없으나,</p>
                            <p>휴대폰 본인확인 테스트의 경우 KCB 에서 따로 발급 받으셔야 합니다.</p>

                            <input type="text" class='form-control' name="cf_cert_kcb_cd" value="<?php echo $config['cf_cert_kcb_cd'] ?>" id="cf_cert_kcb_cd" class="frm_input" size="20"> 
                            <br><a class='btn btn-default' href="http://sir.kr/main/service/b_ipin.php" target="_blank" class="btn_frmline">KCB 아이핀 서비스 신청페이지</a>
                            <a class='btn btn-default' href="http://sir.kr/main/service/b_cert.php" target="_blank" class="btn_frmline">KCB 휴대폰 본인확인 서비스 신청페이지</a>

                        </div>
                      </div>
                      <br>




                      <div class="form-group cf_cert_service">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">NHN KCP 사이트코드
                        </label>

                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <p>서비스에 가입되어 있지 않다면, KCB와 계약체결 후 회원사ID를 발급 받으실 수 있습니다.</p>
                            <p>이용하시려는 서비스에 대한 계약을 아이핀, 휴대폰 본인확인 각각 체결해주셔야 합니다.</p>        

                            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                <input type="text" class='form-control has-feedback-left' name="cf_cert_kcp_cd" value="<?php echo $config['cf_cert_kcp_cd'] ?>" id="cf_cert_kcp_cd"> 
                                <span class="form-control-feedback left" aria-hidden="true">SM</span>
                                <br><a href="http://sir.kr/main/service/p_cert.php" target="_blank" class="btn_frmline btn btn-default">NHN KCP 휴대폰 본인확인 서비스 신청페이지</a>
                            </div>
                            

                        </div>
                      </div>
                      <br>



                      <div class="form-group cf_cert_service">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">LG유플러스 상점아이디
                        </label>

                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <p>LG유플러스 상점아이디 중 si_를 제외한 나머지 아이디만 입력해 주십시오.</p>
                            <p>서비스에 가입되어 있지 않다면, 본인확인 서비스 신청페이지에서 서비스 신청 후 상점아이디를 발급 받으실 수 있습니다.</p>  
                            <p>LG유플러스 휴대폰본인확인은 ActiveX 설치가 필요하므로 Internet Explorer 에서만 사용할 수 있습니다.</p>        

                            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                <input type="text" class='form-control has-feedback-left' name="cf_lg_mid" value="<?php echo $config['cf_lg_mid'] ?>" id="cf_lg_mid" > 
                                <span class="form-control-feedback left" aria-hidden="true">si_</span>
                                <br><a href="http://sir.kr/main/service/lg_cert.php" target="_blank" class="btn_frmline btn btn-default">LG유플러스 본인확인 서비스 신청페이지</a>
                            </div>
                            

                        </div>
                      </div>
                      <br>



                      <div class="form-group cf_cert_service">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">LG유플러스 MERT KEY
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <p>LG유플러스 상점MertKey는 상점관리자 -> 계약정보 -> 상점정보관리에서 확인하실 수 있습니다.</p>

                            <input type="text" class='form-control' name="cf_lg_mert_key" value="<?php echo $config['cf_lg_mert_key'] ?>" id="cf_lg_mert_key"> 
                        </div>
                      </div>
                      <br>



                      <div class="form-group cf_cert_service">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">본인확인 이용제한
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <p>하루동안 아이핀과 휴대폰 본인확인 인증 이용회수를 제한할 수 있습니다.</p>
                            <p>회수제한은 실서비스에서 아이핀과 휴대폰 본인확인 인증에 개별 적용됩니다.</p>
                            <p>0 으로 설정하시면 회수제한이 적용되지 않습니다.</p>

                            <input type="number" class='form-control' name="cf_cert_limit" value="<?php echo $config['cf_cert_limit']; ?>" id="cf_cert_limit"> 
                        </div>
                      </div>
                      <br>


                      <div class="form-group cf_cert_service">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">본인확인 필수
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <p>회원가입 때 본인확인을 필수로 할지 설정합니다. 필수로 설정하시면 본인확인을 하지 않은 경우 회원가입이 안됩니다.</p>

                            <input type="checkbox" class='flat' name="cf_cert_req" value="1" id="cf_cert_req"<?php echo get_checked($config['cf_cert_req'], 1); ?>> 예
                        </div>
                      </div>
                      <br>








                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                          <input type="submit" class="btn btn-success btn_submit" value='확인' accesskey="s" >
                          <a href='/adm' class="btn btn-primary">취소</a>
                        </div>
                      </div>

                  </div>
                </div>
              </div>
              <!-- /form input mask -->

















             <!-- 홈페이지 기본환경 설정 끝! 두번째 첫번째         2017-09-22에는 여기서부터 하면됩니다!!           -->
             <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>기본 메일 환경 설정</h2>


                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />





                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">메일발송 사용
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <p>체크하지 않으면 메일발송을 아예 사용하지 않습니다. 메일 테스트도 불가합니다.</p>

                            <input type="checkbox" class='flat' name="cf_email_use" value="1" id="cf_email_use" <?php echo $config['cf_email_use']?'checked':''; ?>> 사용
                        </div>
                      </div>
                      <br>

                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">메일인증 사용
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <p>메일에 배달된 인증 주소를 클릭하여야 회원으로 인정합니다.</p>

                            <input type="checkbox" class='flat' name="cf_use_email_certify" value="1" id="cf_use_email_certify" <?php echo $config['cf_use_email_certify']?'checked':''; ?>> 사용
                        </div>
                      </div>
                      <br>

                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">폼메일 사용 여부
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <p>체크하지 않으면 비회원도 사용 할 수 있습니다.</p>

                            <input type="checkbox" class='flat' name="cf_formmail_is_member" value="1" id="cf_formmail_is_member" <?php echo $config['cf_formmail_is_member']?'checked':''; ?>> 회원만 사용
                        </div>
                      </div>
                      <br>




                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                          <input type="submit" class="btn btn-success btn_submit" value='확인' accesskey="s" >
                          <a href='/adm' class="btn btn-primary">취소</a>
                        </div>
                      </div>

                  </div>
                </div>
              </div>
              <!-- /form input mask -->











             <!-- 홈페이지 기본환경 설정 끝! 두번째 첫번째         2017-09-22에는 여기서부터 하면됩니다!!           -->
             <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>게시판 글 작성 시 메일 설정</h2>


                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />





                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">최고관리자
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <p>최고관리자에게 메일을 발송합니다.</p>

                            <input type="checkbox" class='flat' name="cf_email_wr_super_admin" value="1" id="cf_email_wr_super_admin" <?php echo $config['cf_email_wr_super_admin']?'checked':''; ?>> 사용
                        </div>
                      </div>
                      <br>

                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">그룹관리자
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <p>그룹관리자에게 메일을 발송합니다.</p>

                            <input type="checkbox" class='flat' name="cf_email_wr_group_admin" value="1" id="cf_email_wr_group_admin" <?php echo $config['cf_email_wr_group_admin']?'checked':''; ?>> 사용
                        </div>
                      </div>
                      <br>

                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">게시판관리자
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <p>게시판관리자에게 메일을 발송합니다.</p>

                            <input type="checkbox" class='flat' name="cf_email_wr_board_admin" value="1" id="cf_email_wr_board_admin" <?php echo $config['cf_email_wr_board_admin']?'checked':''; ?>> 사용
                        </div>
                      </div>
                      <br>



                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">원글작성자
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <p>게시자님께 메일을 발송합니다.</p>

                            <input type="checkbox" class='flat' name="cf_email_wr_write" value="1" id="cf_email_wr_write" <?php echo $config['cf_email_wr_write']?'checked':''; ?>> 사용
                        </div>
                      </div>
                      <br>

                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">댓글작성자
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <p>원글에 댓글이 올라오는 경우 댓글 쓴 모든 분들께 메일을 발송합니다.</p>

                            <input type="checkbox" class='flat' name="cf_email_wr_comment_all" value="1" id="cf_email_wr_comment_all" <?php echo $config['cf_email_wr_comment_all']?'checked':''; ?>> 사용
                        </div>
                      </div>
                      <br>


                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                          <input type="submit" class="btn btn-success btn_submit" value='확인' accesskey="s" >
                          <a href='/adm' class="btn btn-primary">취소</a>
                        </div>
                      </div>

                  </div>
                </div>
              </div>
              <!-- /form input mask -->











             <!-- 홈페이지 기본환경 설정 끝! 두번째 첫번째         2017-09-22에는 여기서부터 하면됩니다!!           -->
             <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>회원가입 시 메일 설정</h2>


                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />





                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">최고관리자 메일발송
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <p>최고관리자에게 메일을 발송합니다.</p>

                            <input type="checkbox" class='flat' name="cf_email_mb_super_admin" value="1" id="cf_email_mb_super_admin" <?php echo $config['cf_email_mb_super_admin']?'checked':''; ?>> 사용
                        </div>
                      </div>
                      <br>

                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">회원님께 메일발송
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <p>회원가입한 회원님께 메일을 발송합니다.</p>

                            <input type="checkbox" class='flat' name="cf_email_mb_member" value="1" id="cf_email_mb_member" <?php echo $config['cf_email_mb_member']?'checked':''; ?>> 사용
                        </div>
                      </div>
                      <br>



                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                          <input type="submit" class="btn btn-success btn_submit" value='확인' accesskey="s" >
                          <a href='/adm' class="btn btn-primary">취소</a>
                        </div>
                      </div>

                  </div>
                </div>
              </div>
              <!-- /form input mask -->









             <!-- 홈페이지 기본환경 설정 끝! 두번째 첫번째         2017-09-22에는 여기서부터 하면됩니다!!           -->
             <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>투표 기타의견 작성 시 메일 설정</h2>


                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />





                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">최고관리자 메일발송
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <p>최고관리자에게 메일을 발송합니다.</p>

                            <input type="checkbox" class='flat' name="cf_email_po_super_admin" value="1" id="cf_email_po_super_admin" <?php echo $config['cf_email_po_super_admin']?'checked':''; ?>> 사용
                        </div>
                      </div>
                      <br>





                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                          <input type="submit" class="btn btn-success btn_submit" value='확인' accesskey="s" >
                          <a href='/adm' class="btn btn-primary">취소</a>
                        </div>
                      </div>

                  </div>
                </div>
              </div>
              <!-- /form input mask -->








             <!-- 홈페이지 기본환경 설정 끝! 두번째 첫번째         2017-09-22에는 여기서부터 하면됩니다!!           -->
             <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>소셜네트워크서비스(SNS : Social Network Service)</h2>


                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />





                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">페이스북 앱 ID
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <input type="text" class='form-control' name="cf_facebook_appid" value="<?php echo $config['cf_facebook_appid'] ?>" id="cf_facebook_appid"> 
                            <br>
                            <a href="https://developers.facebook.com/apps" target="_blank" class="btn btn-default">앱 등록하기</a>
                        </div>
                      </div>
                      <br>



                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">페이스북 앱 Secret
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <input type="text" class='form-control' name="cf_facebook_secret" value="<?php echo $config['cf_facebook_secret'] ?>" id="cf_facebook_secret">
                        </div>
                      </div>
                      <br>




                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">트위터 컨슈머 Key
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <input type="text" class='form-control'name="cf_twitter_key" value="<?php echo $config['cf_twitter_key'] ?>" id="cf_twitter_key"> 
                            <br>
                            <a href="https://dev.twitter.com/apps" target="_blank" class="btn btn-default">앱 등록하기</a>
                        </div>
                      </div>
                      <br>



                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">트위터 컨슈머 Secret
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <input type="text" class='form-control' name="cf_twitter_secret" value="<?php echo $config['cf_twitter_secret'] ?>" id="cf_twitter_secret" > 
                        </div>
                      </div>
                      <br>







                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">구글 짧은주소 API Key
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <input type="text" class='form-control' name="cf_googl_shorturl_apikey" value="<?php echo $config['cf_googl_shorturl_apikey'] ?>" id="cf_googl_shorturl_apikey" > 
                            <br>
                            <a href="http://code.google.com/apis/console" target="_blank" class="btn btn-default">앱 등록하기</a>
                        </div>
                      </div>
                      <br>



                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">카카오 Javascript API Key
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <input type="text" class='form-control' name="cf_kakao_js_apikey" value="<?php echo $config['cf_kakao_js_apikey'] ?>" id="cf_kakao_js_apikey" > 
                            <br>
                            <a href="http://developers.kakao.com/" target="_blank" class="btn btn-default">앱 등록하기</a>
                        </div>
                      </div>
                      <br>








                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                          <input type="submit" class="btn btn-success btn_submit" value='확인' accesskey="s" >
                          <a href='/adm' class="btn btn-primary">취소</a>
                        </div>
                      </div>

                  </div>
                </div>
              </div>
              <!-- /form input mask -->














             <!-- 홈페이지 기본환경 설정 끝! 두번째 첫번째         2017-09-22에는 여기서부터 하면됩니다!!           -->
             <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>레이아웃 추가설정</h2>


                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />



                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">추가 script, css
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <p>HTML의 &lt;/HEAD&gt; 태그위로 추가될 JavaScript와 css 코드를 설정합니다.<br>관리자 페이지에서는 이 코드를 사용하지 않습니다.</p>
                            <textarea class='form-control' name="cf_add_script" id="cf_add_script" style='height:150px;'><?php echo get_text($config['cf_add_script']); ?></textarea>
                        </div>
                      </div>
                      <br>



                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                          <input type="submit" class="btn btn-success btn_submit" value='확인' accesskey="s" >
                          <a href='/adm' class="btn btn-primary">취소</a>
                        </div>
                      </div>

                  </div>
                </div>
              </div>
              <!-- /form input mask -->














             <!-- 홈페이지 기본환경 설정 끝! 두번째 첫번째         2017-09-22에는 여기서부터 하면됩니다!!           -->
             <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>SMS</h2>


                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />



                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">SMS 사용
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <select class="form-control"  id="cf_sms_use" name="cf_sms_use">
                                <option value="" <?php echo get_selected($config['cf_sms_use'], ''); ?>>사용안함</option>
                                <option value="icode" <?php echo get_selected($config['cf_sms_use'], 'icode'); ?>>아이코드</option>
                            </select>
                        </div>
                      </div>
                      <br>


                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">SMS 전송유형
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <p>전송유형을 SMS로 선택하시면 최대 80바이트까지 전송하실 수 있으며</p>
                            <p>LMS로 선택하시면 90바이트 이하는 SMS로, 그 이상은 1500바이트까지 LMS로 전송됩니다.</p>
                            <p>요금은 건당 SMS는 16원, LMS는 48원입니다.</p>

                            <select id="cf_sms_type" name="cf_sms_type" class='form-control'>
                                <option value="" <?php echo get_selected($config['cf_sms_type'], ''); ?>>SMS</option>
                                <option value="LMS" <?php echo get_selected($config['cf_sms_type'], 'LMS'); ?>>LMS</option>
                            </select>
                        </div>
                      </div>
                      <br>


                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">아이코드 회원아이디
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <p>아이코드에서 사용하시는 회원아이디를 입력합니다.</p>
                            <input type="text" class='form-control' name="cf_icode_id" value="<?php echo $config['cf_icode_id']; ?>" id="cf_icode_id" > 
                            
                        </div>
                      </div>
                      <br>

                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">아이코드 비밀번호
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <p>	아이코드에서 사용하시는 비밀번호를 입력합니다.</p>
                            <input type="password" class='form-control' name="cf_icode_pw" value="<?php echo $config['cf_icode_pw']; ?>" id="cf_icode_pw"  > 

                            
                        </div>
                      </div>
                      <br>



                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">요금제	
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">

                            <input type="hidden" name="cf_icode_server_ip" value="<?php echo $config['cf_icode_server_ip']; ?>">
                            <?php
                                if ($userinfo['payment'] == 'A') {
                                echo '충전제';
                                    echo '<input type="hidden" name="cf_icode_server_port" value="7295">';
                                } else if ($userinfo['payment'] == 'C') {
                                    echo '정액제';
                                    echo '<input type="hidden" name="cf_icode_server_port" value="7296">';
                                } else {
                                    echo '가입해주세요.';
                                    echo '<input type="hidden" name="cf_icode_server_port" value="7295">';
                                }
                            ?>
                            
                        </div>
                      </div>
                      <br>



                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">아이코드 SMS 신청<br>회원가입
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <a href="http://icodekorea.com/res/join_company_fix_a.php?sellid=sir2" target="_blank" class="btn btn-default">아이코드 회원가입</a>             
                            
                        </div>
                      </div>
                      <br>




                      <?php if ($userinfo['payment'] == 'A') { ?>              
                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">충전 잔액
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <a href="http://www.icodekorea.com/smsbiz/credit_card_amt.php?icode_id=<?php echo $config['cf_icode_id']; ?>&amp;icode_passwd=<?php echo $config['cf_icode_pw']; ?>" target="_blank" class="btn btn-default">충전하기</a>            
                            
                        </div>
                      </div>
                      <br>
                      <?php } ?>



                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                          <input type="submit" class="btn btn-success btn_submit" value='확인' accesskey="s" >
                          <a href='/adm' class="btn btn-primary">취소</a>
                        </div>
                      </div>

                  </div>
                </div>
              </div>
              <!-- /form input mask -->











             <!-- 홈페이지 기본환경 설정 끝! 두번째 첫번째         2017-09-22에는 여기서부터 하면됩니다!!           -->
             <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>여분필드 기본 설정</h2>


                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />



                    <?php for ($i=1; $i<=10; $i++) { ?>
                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">여분필드<?php echo $i ?>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <p>여분필드<?php echo $i ?> 제목</p>
                            <input type="text" class='form-control' name="cf_<?php echo $i ?>_subj" value="<?php echo get_text($config['cf_'.$i.'_subj']) ?>" id="cf_<?php echo $i ?>_subj" > 
                        </div>
                      </div>
                      <br>

                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">여분필드<?php echo $i ?>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <p>여분필드<?php echo $i ?> 값</p>
                            <input type="text" class='form-control' name="cf_<?php echo $i ?>" value="<?php echo $config['cf_'.$i] ?>" id="cf_<?php echo $i ?>" > 
                        </div>
                      </div>
                      <br>


                    <?php } ?>


                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                          <input type="submit" class="btn btn-success btn_submit" value='확인' accesskey="s" >
                          <a href='/adm' class="btn btn-primary">취소</a>
                        </div>
                      </div>

                  </div>
                </div>
              </div>
              <!-- /form input mask -->
















            </div>
          </div>
        </div>

















</form>



<script>
$(function(){
    <?php
    if(!$config['cf_cert_use'])
        echo '$(".cf_cert_service").addClass("cf_cert_hide");';
    ?>
    $("#cf_cert_use").change(function(){
        switch($(this).val()) {
            case "0":
                $(".cf_cert_service").addClass("cf_cert_hide");
                break;
            default:
                $(".cf_cert_service").removeClass("cf_cert_hide");
                break;
        }
    });

    $(".get_theme_confc").on("click", function() {
        var type = $(this).data("type");
        var msg = "기본환경 스킨 설정";
        if(type == "conf_member")
            msg = "기본환경 회원스킨 설정";

        if(!confirm("현재 테마의 "+msg+"을 적용하시겠습니까?"))
            return false;

        $.ajax({
            type: "POST",
            url: "./theme_config_load.php",
            cache: false,
            async: false,
            data: { type: type },
            dataType: "json",
            success: function(data) {
                if(data.error) {
                    alert(data.error);
                    return false;
                }

                var field = Array('cf_member_skin', 'cf_mobile_member_skin', 'cf_new_skin', 'cf_mobile_new_skin', 'cf_search_skin', 'cf_mobile_search_skin', 'cf_connect_skin', 'cf_mobile_connect_skin', 'cf_faq_skin', 'cf_mobile_faq_skin');
                var count = field.length;
                var key;

                for(i=0; i<count; i++) {
                    key = field[i];

                    if(data[key] != undefined && data[key] != "")
                        $("select[name="+key+"]").val(data[key]);
                }
            }
        });
    });
});

function fconfigform_submit(f)
{
    f.action = "./config_form_update.php";
    return true;
}
</script>

<?php
// 본인확인 모듈 실행권한 체크
if($config['cf_cert_use']) {
    // kcb일 때
    if($config['cf_cert_ipin'] == 'kcb' || $config['cf_cert_hp'] == 'kcb') {
        // 실행모듈
        if(strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
            if(PHP_INT_MAX == 2147483647) // 32-bit
                $exe = G5_OKNAME_PATH.'/bin/okname';
            else
                $exe = G5_OKNAME_PATH.'/bin/okname_x64';
        } else {
            if(PHP_INT_MAX == 2147483647) // 32-bit
                $exe = G5_OKNAME_PATH.'/bin/okname.exe';
            else
                $exe = G5_OKNAME_PATH.'/bin/oknamex64.exe';
        }

        echo module_exec_check($exe, 'okname');
    }

    // kcp일 때
    if($config['cf_cert_hp'] == 'kcp') {
        if(PHP_INT_MAX == 2147483647) // 32-bit
            $exe = G5_KCPCERT_PATH . '/bin/ct_cli';
        else
            $exe = G5_KCPCERT_PATH . '/bin/ct_cli_x64';

        echo module_exec_check($exe, 'ct_cli');
    }

    // LG의 경우 log 디렉토리 체크
    if($config['cf_cert_hp'] == 'lg') {
        $log_path = G5_LGXPAY_PATH.'/lgdacom/log';

        if(!is_dir($log_path)) {
            echo '<script>'.PHP_EOL;
            echo 'alert("'.str_replace(G5_PATH.'/', '', G5_LGXPAY_PATH).'/lgdacom 폴더 안에 log 폴더를 생성하신 후 쓰기권한을 부여해 주십시오.\n> mkdir log\n> chmod 707 log");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        } else {
            if(!is_writable($log_path)) {
                echo '<script>'.PHP_EOL;
                echo 'alert("'.str_replace(G5_PATH.'/', '',$log_path).' 폴더에 쓰기권한을 부여해 주십시오.\n> chmod 707 log");'.PHP_EOL;
                echo '</script>'.PHP_EOL;
            }
        }
    }
}

include_once ('./admin.tail.php');
?>
