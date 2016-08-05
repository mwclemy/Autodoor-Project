<?php
require '../includes/initialize.php';

// array for JSON response
$response = array();
if (filter_input(INPUT_GET,"username") != NULL && filter_input(INPUT_GET,"password") != NULL) {
    $username=trim(filter_input(INPUT_GET,"username"));
    $password=trim(filter_input(INPUT_GET,"password"));

    $found_user = User::authenticate($username, $password);

   
    if ($found_user) {
        
       // Get the user's roleid
        $role_id = $found_user->role_id;
         // Find the user's role
        $role = Role::find_by_id($role_id);
        // Find the user office in the joining table
        $user_office=UserOffice::find_user_offices($found_user->user_id);

        $offices = Office::find_user_offices($user_office);
        
         //Create Json response
         $response["success"] = 1;
         $response["user"] = get_object_vars($found_user);
         $response["useroffice"]= $user_office;
         $response["office"] = $offices;
         $response["role"] = get_object_vars($role);

        // echoing JSON response

         echo json_encode($response);

}
    else {

       // No user found
        $response["success"] = 0;
        $response["message"] = "Incorrect Username or Password";

        // echoing JSON response
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


