<?php
    include_once('./_common.php');

    if($zx == 'y'){ // 테스트 일때
        $Q1 = "A";
        $Q2 = "A";
        $Q3 = "D";
        $Q4 = "C";
    } else { // 테스트 아닐때
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        $Q1 = $data["Q1"];
        $Q2 = $data["Q2"];
        $Q3 = $data["Q3"];
        $Q4 = $data["Q4"];

    }


$insert_sql = "INSERT INTO surveyList SET ";
$insert_sql .= "Q1 = '". $Q1 . "' ";
$insert_sql .= ", Q2 = '". $Q2. "' ";
$insert_sql .= ", Q3 = '". $Q3. "' ";
$insert_sql .= ", Q4 = '". $Q4. "' ";


debug($insert_sql);

rf_mysql_query($insert_sql , $DB);

echo "ok";

