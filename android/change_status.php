<?php
require '../includes/initialize.php';

// array for JSON response
$response = array();
if (filter_input(INPUT_GET,"device_id") != NULL && filter_input(INPUT_GET,"event_status") != NULL) {
    $device_id=(int) trim(filter_input(INPUT_GET,"device_id"));
    $event_status = (int) trim(filter_input(INPUT_GET,"event_status"));
    
    $office= Office::find_office_by_device($device_id);
    $user_office = UserOffice::find_user_office_by_office_id($office->office_id);
    $event = Event::find_event_by_user_office_id($user_office->user_office_id);

    // Change the event status and changed_at
     
    $event->event_status=$event_status;
    $event->changed_at=strftime("%Y-%m-%d %H:%M:%S",time());
    $event->save();

}

else {
 
}

?>
































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

