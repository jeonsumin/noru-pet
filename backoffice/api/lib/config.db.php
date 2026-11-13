<?php
$db_addr = '211.43.14.162';
$db_id   = 'noroowapet';
$db_pass = 'brightbb!@';
$db_sel  = 'noroowapet_db';
$db_port = 3306;

$DB = mysqli_connect($db_addr, $db_id, $db_pass, $db_sel, $db_port) or die("Fail connect DataBase Server 2");
mysqli_query($DB, 'SET NAMES utf8mb4') or die("Error Setting db 1");
