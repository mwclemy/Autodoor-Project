<?php

include('includes/db_connection.php');
require_once ('includes/functions.php');
// array for JSON response
$response = array();
// get the event
$event_id = 1;
$event = find_event($event_id);
// get the android's command
$event_action = $event["action"];
// return Json response
$response["message"] = $event_action;
echo json_encode($response);


