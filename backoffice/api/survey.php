<?php
    include_once('./_common.php');

    if($zx == 'y'){
        $data = array("Q1" => "A", "Q2" => "A", "Q3" => "D", "Q4" => "C", "ChannelType" => "WEB", "Result" => "");
    } else {
        $data = json_decode(file_get_contents('php://input'), true) ?: array();
    }

    $id = (int)($data["ID"] ?? 0);

    $set_sql = "";
    foreach (array("Q1", "Q2", "Q3", "Q4", "ChannelType", "Result") as $key) {
        $set_sql .= ($set_sql ? ", " : "") . $key . " = '" . ESC($data[$key] ?? "", $DB) . "'";
    }

    if ($id > 0) {
        rf_mysql_query("UPDATE surveyList SET " . $set_sql . " WHERE ID = " . $id, $DB);
    } else {
        rf_mysql_query("INSERT INTO surveyList SET " . $set_sql, $DB);
        $id = mysqli_insert_id($DB);
    }

    header("Content-Type: application/json");
    echo json_encode(array("ID" => $id));
