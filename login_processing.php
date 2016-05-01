<?php

include('includes/db_connection.php');
require_once ('includes/functions.php');
// array for JSON response
$response = array();
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$pin = filter_input(INPUT_POST, 'pin', FILTER_SANITIZE_STRING);
if (($pin !== NULL && $pin !== "" )&&  ($email !== NULL && $email !== "")) { 
    // check if the enterred email and pin are the same as the ones saved in DB
    $result = user_check($email, $pin);
    if ($result === TRUE) {
        // Valid email and pin 
        $response["success"] = 1;
        $response["message"] = "";
// echoing JSON response
        echo json_encode($response);
    } else if ($result === NULL) {
        // No user found
        $response["success"] = 0;
        $response["message"] = "No user found";

        // echoing JSON response
        echo json_encode($response);
    } else {
        // Email and pin do not match
        $response["success"] = 0;
        $response["message"] = "Email and Pin do not match";

        // echoing JSON response
        echo json_encode($response);
    }
} else {
    // Missing input(s)
    $response["success"] = 0;
    $response["message"] = "Missing input(s)";

    // echoing JSON response
    echo json_encode($response);
}


if (isset($connection)) {
    mysqli_close($connection);
}
