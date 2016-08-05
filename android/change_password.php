<?php
require '../includes/initialize.php';

// array for JSON response
$response = array();
if (filter_input(INPUT_POST,"userId") != NULL && filter_input(INPUT_POST,"newPassword") != NULL   ) {

    $user_id=(int) trim(filter_input(INPUT_POST,"userId"));
    $new_password=trim(filter_input(INPUT_POST,"newPassword"));
    
    // update user's password

    $user = User::find_by_id($user_id);
    $user->password=$new_password;

    if ($user->save()) {
        $response["success"] = 1;
        $response["message"] = "Password successfully changed";
        echo json_encode($response);
}
    else {
            $response["success"] = 0;
            $response["message"] = "Failed to update password";
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


























