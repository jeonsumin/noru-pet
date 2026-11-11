<?php
include_once('./_common.php');

$password = $_POST['accessCode'];

$code = "1234";

if( $password != $code) {
    php_alert("비밀번호가 일치하지 않습니다.", "back");
}

$link = _BB_ADMIN_DASHBOARD_PATH;

set_session('ss_auth', 'ss_auth');
goto_url($link);

exit;
