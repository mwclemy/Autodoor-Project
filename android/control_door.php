<?php

include('includes/db_connection.php');
require_once ('includes/functions.php');
// array for JSON response
$response = array();
$command = filter_input(INPUT_POST, 'command');
if ($command !== NULL && $command !== "") {
    $event_id = 1;
    $event = find_event($event_id);
    if ($event['action'] !== $command) {
        // send the command
        if (save_command($command)) {
            // waits for the arduino to receive and process the command
            // By constantly reading the event status until it has changed to 1.
//            while ($event["event_status"] != 1) {
//                $response["success"] = 0;
//                $response["command"] = "command failed. ";
//                 $response["hint"] = $command;
//                echo json_encode($response);
//            }
//            //change the event status back to 0
//            change_status($event_id, 0);
//            $response["success"] = 1;
//            $response["command"] = $command;
//            $response["time"] = $event["event_date"];
//           echo json_encode($response);

            sleep(5);
            if ($event["event_status"] == 1) {
                //change the event status back to 0
                change_status($event_id, 0);
                $response["success"] = 1;
                $response["command"] = $command;
                $response["time"] = $event["event_date"];
                echo json_encode($response);
            } else if ($event["event_status"] == 0){
                $response["success"] = 0;
                $response["command"] = "command failed. ";
                $response["hint"] = $command;
                echo json_encode($response);
            }
            else {
                
            }
        } else {
            $response["success"] = 0;
            $response["command"] = "failed to save command.";
            $response["hint"] = $command;
            echo json_encode($response);
        }
    } else {
        $response["success"] = 0;
        $response["command"] = "wrong command.";
        $response["hint"] = $command;
        echo json_encode($response);
    }
} else {
    $response["success"] = 0;
    $response["command"] = "empty command.";
    $response["hint"] = $command;
    echo json_encode($response);
}