<?php

define('G5_IS_ADMIN', true);

include_once ('../../common.php');

include_once(G5_ADMIN_PATH.'/admin.lib.php');

// 커뮤니티 사용여부
if(G5_COMMUNITY_USE === false) {
echo "커뮤니티 사용하지 않음설정";
}
?>