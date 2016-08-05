<?php

function confirm_query($result_set) {
    global $connection;
    if (!$result_set) {
        die("database querry failed " . mysqli_error($connection));
    }
}

function find_user_by_email($email) {
    global $connection;

    $query = "SELECT *   ";
    $query.="FROM users  ";
    $query.="WHERE email='{$email}'  ";
    $query.="LIMIT 1 ";
    $user_set = mysqli_query($connection, $query);
    confirm_query($user_set);
    $user = mysqli_fetch_assoc($user_set);
    if ($user !== null) {
        return $user;
    } else {
        return null;
    }
}

function user_check($email, $pin) {
    $user = find_user_by_email($email);
    if ($user !== null) {
// user found 
        if ($email === $user["email"] && $pin === $user["pin"]) {
// the email and pin are correct
            return true;
        } else {
// email and pin  do not match
            return false;
        }
    } else {
// No email found
        return null;
    }
}

function random_string() {
    $character_set_array = array();
    $character_set_array[] = array('count' => 7, 'characters' => 'abcdefghijklmnopqrstuvwxyz');
    $character_set_array[] = array('count' => 1, 'characters' => '0123456789');
    $temp_array = array();
    foreach ($character_set_array as $character_set) {
        for ($i = 0; $i < $character_set['count']; $i++) {
            $temp_array[] = $character_set['characters'][rand(0, strlen($character_set['characters']) - 1)];
        }
    }
    shuffle($temp_array);
    return implode('', $temp_array);
}

function random_pin($min, $max) {
    $integer = rand($min, $max);
    return "$integer";
}

function forgotPassword($email, $newpin) {
    global $connection;
    $query = "UPDATE users SET pin = '$newpin' WHERE email = '$email' ";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return true;
}

function find_user_by_pin($pin) {
    global $connection;
    $query = "SELECT *   ";
    $query.="FROM users  ";
    $query.="WHERE pin='{$pin}'  ";
    $query.="LIMIT 1 ";
    $user_set = mysqli_query($connection, $query);
    confirm_query($user_set);
    $user = mysqli_fetch_assoc($user_set);
    if ($user !== null) {
        return $user;
    } else {
        return null;
    }
}

function change_pin($new_pin, $email) {
    global $connection;
    $query = "UPDATE users SET pin='{$new_pin}' WHERE email ='{$email}' ";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return true;
}

function send_mail($to, $from, $subject, $msg) {

    $headers = "MIME-Version: 1.0 \r\n";
    $headers.="from: $from  $subject  \r\n";
    $headers.="Content-type: text/html;charset=utf-8 \r\n";
    $headers.="X-Priority: 3\r\n";
    $headers.="X-Mailer: smail-PHP " . phpversion() . "\r\n";
    $msg = ' 
    <div style="text-align:left"> 
    <h2>' . $subject . '</h2> 
    ' . $msg . ' 
    </div> 
    ';

    if (mail($to, $subject, $msg, $headers)) {
        return true;
    } else {
        return false;
    }
}

function save_command($command) {
    global $connection;
    $query = "UPDATE Event SET action= '{$command}' ";
    if ($command === "open") {
        $query.="WHERE action = 'closed' ";
    } else {
        $query.="WHERE action = 'open' ";
    }
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return true;
}

function find_event($event_id) {
    global $connection;
    $query = "SELECT * FROM Event WHERE event_id={$event_id} ";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    $event = mysqli_fetch_assoc($result);
    if ($event !== null) {
        return $event;
    } else {
        return null;
    }
}

function change_status($event_id,$event_status) {
    global $connection;
    $query = "UPDATE Event SET event_status = {$event_status}  WHERE event_id={$event_id} ";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return true;
}

function log_action ($action, $message = "") {
$logfile= SITE_ROOT.DS.'logs'.DS.'logs.txt';
$new = file_exists($logfile) ? false : true;
if ($handle = fopen($logfile, 'a')) { // append 
$timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
$contents= "{$timestamp}  |  {$action}:  {$message}\n";
fwrite($handle, $contents);
fclose($handle);
}
else {
    echo "Could not open log file for writing.";
}

}

function __autoload($class_name) {
 $path =LIB_PATH.DS.strtolower($class_name).".php";
 if (file_exists($path)) {
     require_once ($path);
 } else {
    die("The file {$class_name}.php could not be found. ");
         
     }
 }
 function include_layout_template($template="") {
include(SITE_ROOT.DS.'public'.DS.'layouts'.DS.$template);
}

 function strip_zeros_from_date($marked_string="") {
    // first remove the marked zeros
    $no_zeros = str_replace('*0','',$marked_string);
    // then remove any remaining marks
    $cleaned_string= string_replace('*','',$no_zeros);
    return $cleaned_string;
}

function output_message($message=""){
if(!empty($message)){
return "<p class=\"message\">{$message}</p>";
}
else {
return "";
}
}
