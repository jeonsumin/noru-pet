<?php
include_once('./_common.php');

$link = _BB_ADMIN_LOGIN_URL_PATH;

$url = str_replace("&amp;", "&", $link);

if (!headers_sent())
    header('Location: ' . $url);
else {
    echo '<script>';
    echo 'location.href = "' . $url . '";';
    echo '</script>';
    echo '<noscript>';
    echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
    echo '</noscript>';
}
exit;

