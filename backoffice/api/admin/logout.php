<?php
include_once('./_common.php');

$_SESSION = [];
session_destroy();

goto_url(_BB_ADMIN_LOGIN_URL_PATH);
