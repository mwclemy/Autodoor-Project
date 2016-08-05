<?php
require '../includes/initialize.php';

// array for JSON response
$response = array();

$roles = Role::find_all();
$offices = Office::find_all();

if ($roles && $offices) {
        
         //Create Json response
         $response["success"] = 1;
         $response["roles"] =$roles;
         $response["offices"]=$offices;

        // echoing JSON response

         echo json_encode($response);

         }
    else {

       // No role found
        $response["success"] = 0;
        $response["message"] = "No data";

        // echoing JSON response
         echo json_encode($response);
    }
    
 
 ?>