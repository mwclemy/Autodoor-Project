<?php
require '../includes/initialize.php';

// array for JSON response
$response = array();
if (filter_input(INPUT_POST,"userId") != NULL && filter_input(INPUT_POST,"officeStatus") != NULL  && filter_input(INPUT_POST,"officeName") != NULL ) {

    $user_id=(int) trim(filter_input(INPUT_POST,"userId"));
    $office_status=trim(filter_input(INPUT_POST,"officeStatus"));
    $office_name=trim(filter_input(INPUT_POST,"officeName"));

    $new_office_status = Office::reverse_status($office_status);

     $office = Office::find_office_by_name($office_name);
    
    // get user office

    $user_office = UserOffice::find_user_office($user_id, $office->office_id);

    // insert a new event in the event table

    $event = new Event();
    $event->command= $new_office_status;
    $event->created_at = strftime("%Y-%m-%d %H:%M:%S",time());
    $event->user_office_id =$user_office->user_office_id;

    if ($event->save()) {

    // First Solution
     // wait for 8 seconds for arduino to respond
     //    sleep(8);
     //     //Get the saved event 
     // $saved_event = Event::find_event_by_user_office_id($user_office->user_office_id);
     
     // if ($saved_event->event_status == 1) {
     //         // update the office status

     //      $office->office_status=$new_office_status;
     //      $office->save();

     //            $response["success"] = 1;
     //            $response["newofficestatus"] = $new_office_status;
     //            $response["message"] ="Success";
     //            echo json_encode($response);


     //    }

     //    else {
     //            $response["success"] = 0;
     //            $response["message"] = "Some error occured.";
     //            echo json_encode($response);
     //    }

    // Second Solution
    //Get the saved event 
     $saved_event = Event::find_event_by_user_office_id($user_office->user_office_id);
    while ($saved_event->event_status == 0) {
     //Get the saved event 
     $saved_event = Event::find_event_by_user_office_id($user_office->user_office_id);
    }
     if ($saved_event->event_status == 1) {
             // update the office status

          $office->office_status=$new_office_status;
          $office->save();

                $response["success"] = 1;
                $response["newofficestatus"] = $new_office_status;
                $response["message"] ="Success";
                echo json_encode($response);


        }

        else {
                $response["success"] = 0;
                $response["message"] = "Some error occured.";
                echo json_encode($response);
        }

    }


    else {
            $response["success"] = 0;
            $response["message"] = "failed to save command.";
            echo json_encode($response);
    }

    
 }
 else {
    // Missing input(s)
    $response["success"] = 0;
    $response["message"] = "Missing input(s)";

    // echoing JSON response
    echo json_encode($response); 
 }
?>



















<?php

// include('includes/db_connection.php');
// require_once ('includes/functions.php');
// // array for JSON response
// $response = array();
// $command = filter_input(INPUT_POST, 'command');
// if ($command !== NULL && $command !== "") {
//     $event_id = 1;
//     $event = find_event($event_id);
//     if ($event['action'] !== $command) {
//         // send the command
//         if (save_command($command)) {
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

//             sleep(5);
//             if ($event["event_status"] == 1) {
//                 //change the event status back to 0
//                 change_status($event_id, 0);
//                 $response["success"] = 1;
//                 $response["command"] = $command;
//                 $response["time"] = $event["event_date"];
//                 echo json_encode($response);
//             } else if ($event["event_status"] == 0){
//                 $response["success"] = 0;
//                 $response["command"] = "command failed. ";
//                 $response["hint"] = $command;
//                 echo json_encode($response);
//             }
//             else {
                
//             }
//         } else {
//             $response["success"] = 0;
//             $response["command"] = "failed to save command.";
//             $response["hint"] = $command;
//             echo json_encode($response);
//         }
//     } else {
//         $response["success"] = 0;
//         $response["command"] = "wrong command.";
//         $response["hint"] = $command;
//         echo json_encode($response);
//     }
// } else {
//     $response["success"] = 0;
//     $response["command"] = "empty command.";
//     $response["hint"] = $command;
//     echo json_encode($response);
// }