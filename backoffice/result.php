<?php
include_once('./_common.php');

if($zx == 'y'){
    $user_cd = 'abc01234';
} else {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);
    $user_cd = $data['userCd'];
}

if($user_cd == ''){
    error_json(array('status' => 400, 'message' => 'Bad Request'));
}

$result['status'] = 200;


$today = _BB_TIME_YMD;

$select = "SELECT * FROM surveyList ";
$select .= "WHERE DATE(REG_DT) = '" . $today. "' ";
$select .= "AND USER_CD = '". $user_cd ."' ";

debug($select);
$select_data = rf_mysql_row($select, $DB);
debug($select_data);


if( $select_data ) {
    $result['data'] = $select_data['RESULT'];
} else {
    error_json(array('status' => 404, 'message' => 'Not Found User'));
}

echo json_encode($result);