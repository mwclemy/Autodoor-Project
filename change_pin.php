<?php

include('includes/db_connection.php');
require_once ('includes/functions.php');
// array for JSON response
$response = array();
$current_pin = filter_input(INPUT_POST, 'current_pin');
$new_pin = filter_input(INPUT_POST, 'new_pin');

if (($current_pin !== NULL && $current_pin !== "") && ($new_pin !== NULL && $new_pin !== "")) {
    $user = find_user_by_pin($current_pin);
    if ($user !== NULL) {
        // change the current pin to the new pin
        if (change_pin($new_pin, $user["email"])) {
            $response["success"] = 1;
            $response["message"] = "Pin successfully changed";
            echo json_encode($response);
        } else {
            $response["success"] = 0;
            $response["message"] = "Database error";
            echo json_encode($response);
        }
    } else {
        $response["success"] = 0;
        $response["message"] = "Your Pin is invalid ";
        echo json_encode($response);
    }
} else {
    $response["success"] = 0;
    $response["message"] = "Missing input(s) ";
    echo json_encode($response);
}

if (isset($connection)) {
    mysqli_close($connection);
}