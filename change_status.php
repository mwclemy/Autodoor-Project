<?php

include('includes/db_connection.php');
require_once ('includes/functions.php');
// array for JSON response
$response = array();
$status = filter_input(INPUT_GET, 'status');
if ($status !== NULL && $status !== "") {
    $event_id = 1;
    // change the event_status = 1
    // Meaning the command has been successfully completed.
    if (change_status($event_id,$status)) {
        $response["success"] = 1;
        $response["message"] = "success";
        echo json_encode($response);
    } else {
        $response["success"] = 0;
        $response["message"] = "failed";
        echo json_encode($response);
    }
} else {
    $response["success"] = 0;
    $response["message"] = "Unable to find";
    echo json_encode($response);
}

