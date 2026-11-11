<?php

if (PHP_VERSION >= '5.1.0') {
    //if (function_exists("date_default_timezone_set")) date_default_timezone_set("Asia/Seoul");
    date_default_timezone_set('Europe/Berlin');
}

$http = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? 's' : '') . '://';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
if(isset($_SERVER['HTTP_HOST']) && preg_match('/:[0-9]+$/', $host))	$host = preg_replace('/:[0-9]+$/', '', $host);


$port = $_SERVER['SERVER_PORT'] != 80 ? ':'.$_SERVER['SERVER_PORT'] : '';
define('_BB_HTTPS_DOMAIN',				$http.$host.$port."");
define('_BB_DEV_MODE',					false);
define('_BB_CONNECT_PATH',				_BB_DEV_MODE ? "/" : "" );
define('_BB_ADMIN_DIR',					'admin');

define('_BB_URL_PATH',					_BB_HTTPS_DOMAIN._BB_CONNECT_PATH);
define('_BB_ADMIN_URL_PATH',			_BB_HTTPS_DOMAIN._BB_CONNECT_PATH."/"._BB_ADMIN_DIR);
define('_BB_ADMIN_LOGIN_URL_PATH',		_BB_URL_PATH."/"._BB_ADMIN_DIR.'/login.php');
define('_BB_ADMIN_DASHBOARD_PATH',		_BB_URL_PATH."/"._BB_ADMIN_DIR.'/dashboard.php');

define('_BB_SERVER_TIME',    time());

define('_BB_TIME_YMDHIS',    date('Y-m-d H:i:s', _BB_SERVER_TIME));
define('_BB_TIME_YMD',       substr(_BB_TIME_YMDHIS, 0, 10));
define('_BB_TIME_HIS',       substr(_BB_TIME_YMDHIS, 11, 8));

define('_BB_FILE_DIR',       'data');
define('_BB_FILE_UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'].'/'._BB_FILE_DIR);



$BB_DATE = date('YmdHis');

$today = date('Y-m-d');
$BB_IPADDR = $_SERVER['REMOTE_ADDR'];
$zx = '';

if( isset($zx) ){ define("IS_DEBUG", true); }else{ define("IS_DEBUG", false); }
?>
