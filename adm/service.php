<?php
$sub_menu = '100400';
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$g5['title'] = '부가서비스';
include_once('./admin.head.php');
?>


<style>

.productbox {
    background-color:#ffffff;
	padding:10px;
	margin-bottom:10px;
	-webkit-box-shadow: 0 8px 6px -6px  #999;
	   -moz-box-shadow: 0 8px 6px -6px  #999;
	        box-shadow: 0 8px 6px -6px #999;
}

.producttitle {
    font-weight:bold;
	padding:5px 0 5px 0;
}

.productprice {
	border-top:1px solid #dadada;
	padding-top:5px;
}

.pricetext {
	font-weight:bold;
	font-size:1.4em;
}

</style>




<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
            <h3>부가서비스</h3>
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

                        <p class='bg-info' style='padding:15px;'>아래의 서비스들은 그누보드에서 이미 지원하는 기능으로 별도의 개발이 필요 없으며 서비스 신청후 바로 사용 할수 있습니다.</p>



                        
                            <div class="col-md-4 column productbox">
                                <img src="<?php echo G5_ADMIN_URL ?>/img/service_img1.jpg" class="img-responsive">
                                <div class="producttitle">휴대폰 본인확인 서비스</div>
                                <div class="productprice"><div class="pull-right"></div><div class="pricetext">정보통신망법 23조 2항(주민등록번호의 사용제한)에 따라 기존 주민등록번호 기반의 인증서비스 이용이 불가합니다. 주민등록번호 대체수단으로 최소한의 정보(생년월일, 휴대폰번호, 성별)를 입력받아 본인임을 확인하는 인증수단 입니다</div></div>
                                
                                <div class="productprice"><a href="http://sir.kr/main/service/p_cert.php" target="_blank"><img src="<?php echo G5_ADMIN_URL ?>/img/svc_btn_01.jpg" alt="KCP 휴대폰 본인확인 신청하기"></a></div>
                                <div class="productprice"><a href="http://sir.kr/main/service/lg_cert.php" target="_blank"><img src="<?php echo G5_ADMIN_URL ?>/img/svc_btn_02.jpg" alt="LG유플러스 휴대폰대체인증 신청하기"></a></div>
                                <div class="productprice"><a href="http://sir.kr/main/service/b_cert.php" target="_blank"><img src="<?php echo G5_ADMIN_URL ?>/img/svc_btn_03.jpg" alt="OKname 휴대폰 본인확인 신청하기"></a></div>
                            </div>


                            <div class="col-md-4 column productbox">
                                <img src="<?php echo G5_ADMIN_URL ?>/img/service_img2.jpg" class="img-responsive">
                                <div class="producttitle">아이핀 본인확인 서비스</div>
                                <div class="productprice"><div class="pull-right"></div><div class="pricetext">정부가 주관하는 주민등록번호 대체 수단으로 본인의 개인정보를 아이핀 사이트에 한번만 발급해 놓고, 이후부터는 아이디와 패스워드 만으로
                                                            본인임을 확인하는 인증수단 입니다.</div></div>
                                <div class="productprice"><a href="http://sir.kr/main/service/b_ipin.php" target="_blank"><img src="<?php echo G5_ADMIN_URL ?>/img/svc_btn_04.jpg" alt="OKname 아이핀 본인확인 신청하기"></a></div>

                            </div>


                            <div class="col-md-4 column productbox">
                                <img src="<?php echo G5_ADMIN_URL ?>/img/svc_btn_05.jpg" class="img-responsive">
                                <div class="producttitle">아이핀 본인확인 서비스</div>
                                <div class="productprice"><div class="pull-right"></div><div class="pricetext">사이트 관리자 또는 회원이 다른 회원의 <br>휴대폰으로 단문메세지(최대 한글 40자, 영문 80자)를 발송할 수 있습니다.</div></div>
                                <div class="productprice"><a href="http://icodekorea.com/res/join_company_fix_a.php?sellid=sir2" target="_blank"><img src="<?php echo G5_ADMIN_URL ?>/img/svc_btn_05.jpg" alt="아이코드 SMS 서비스 신청하기"></a></div>
                            </div>

     
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



































<?php
include_once('./admin.tail.php');
?>
