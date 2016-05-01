<?php

include('includes/db_connection.php');
require_once ('includes/functions.php');
// array for JSON response
$response = array();
$email = filter_input(INPUT_POST, 'email_reset', FILTER_SANITIZE_EMAIL);
if ($email !== NULL && $email !== "") {
    $random_pin = random_pin(100,999);
    $subject = "Password Recovery";
    $message = "Hello User,nnYour Password is sucessfully changed. Your new Password is $random_pin . Login with your new Password and change it in the User Panel.nnRegards,nLearn2Crack Team.";
    $from = "mclemy@techxlab.comli.com";
    $headers = "From:" . $from;
    $user = find_user_by_email($email);
    if ($user !== NULL) {
        if (forgotPassword($email, $random_pin)) {
            $response["success"] = 1;
            // mail($email, $subject, $message, $headers);
            send_mail($to, $from, $subject, $message);
            echo json_encode($response);
        } else {
            $response["success"] = 0;
            $response["message"] = "Database error";
            echo json_encode($response);
        }

        // user is already existed - error response
    } else {

        $response["success"] = 0;
        $response["message"] = "User does not exist";
        echo json_encode($response);
    }
} else {
    $response["success"] = 0;
    $response["message"] = "No Email was provided!";
    echo json_encode($response);
}

if (isset($connection)) {
    mysqli_close($connection);
}
