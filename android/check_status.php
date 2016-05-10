<?php

include('includes/db_connection.php');
require_once ('includes/functions.php');
// array for JSON response
$response = array();
$command = filter_input(INPUT_POST, 'command');
if ($command !== NULL && $command !== "") {
    // get the event
    $event_id = 1;
    $event = find_event($event_id);
    // get the door status
    $current_action =($event["event_status"]) ? $event["action"]: "error";
    // return Json response
    $response["success"] = 1;
    $response["message"] = $current_action;
    echo json_encode($response);
} else {
    $response["success"] = 0;
    $response["message"] = "Unable to find";
    echo json_encode($response);
}

