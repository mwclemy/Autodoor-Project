<?php
require '../includes/initialize.php';

// array for JSON response
$response = array();
if (filter_input(INPUT_GET,"device_id") != NULL) {
    $device_id=(int) trim(filter_input(INPUT_GET,"device_id"));
    
    $office= Office::find_office_by_device($device_id);
    $user_office = UserOffice::find_user_office_by_office_id($office->office_id);
    $event = Event::find_event_by_user_office_id($user_office->user_office_id);
     
    $event_command = $event->command;

    // return Json response
    $response["message"] = $event_command;
    echo json_encode($response);

}

else {
// Missing input(s)
    $response["success"] = 0;
    $response["message"] = "Missing input(s)";

    // echoing JSON response
    echo json_encode($response); 
 
}

?>













