<?php
require '../includes/initialize.php';

// array for JSON response
$response = array();
if (filter_input(INPUT_POST,"fName") != NULL && filter_input(INPUT_POST,"lName") != NULL && filter_input(INPUT_POST,"email") != NULL && filter_input(INPUT_POST,"phoneNumber") != NULL && filter_input(INPUT_POST,"role") != NULL && filter_input(INPUT_POST,"office") != NULL  ) {

    $fname=trim(filter_input(INPUT_POST,"fName"));
    $lname=trim(filter_input(INPUT_POST,"lName"));
    $email=trim(filter_input(INPUT_POST,"email"));
    $tel=trim(filter_input(INPUT_POST,"phoneNumber"));
    $role=trim(filter_input(INPUT_POST,"role"));
    $office=trim(filter_input(INPUT_POST,"office"));

  

  // Add user to the DB
   
    $user = new User();
    $user->f_name = $fname;
    $user->l_name = $lname;
    $user->email = $email;
    $user->tel = $tel;
    $role_object =Role::find_role_id($role);
    $user->role_id = $role_object->role_id;

if (!$user->save()) {
 // No user found
        $response["success"] = 0;
        $response["message"] = "Some error occured.";

        // echoing JSON response
         echo json_encode($response);
    }

    // get the id of the inserted user
    $user_id= $database->insert_id();
    $office_object = Office::find_office_by_name($office);
    $office_id = $office_object->office_id;

   // Add request to the DB

    $new_request = new Request();
    $new_request->user_id = $user_id;
    $new_request->office_id = $office_id;
    
    if ($new_request->save())  {
        
      //Create Json response
         $response["success"] = 1;
         $response["message"] = "Request sent successfully.";
        // echoing JSON response

         echo json_encode($response);

}
    else {

       // No user found
        $response["success"] = 0;
        $response["message"] = "Some error occured.";

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


