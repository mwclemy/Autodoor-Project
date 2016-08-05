<?php
require_once (LIB_PATH.DS.'config.php');
class MySQLDatabase {
 private $connection;
 private $magic_quotes_active;
 private $real_escape_string_exists;
 function __construct() {
     $this->open_connection();
     $this->magic_quotes_active = get_magic_quotes_gpc();
     $this->real_escape_string_exists = function_exists("mysqli_real_escape_string"); 
     
     // i.e PHP >= v4.3.0
 }
 
 public function open_connection () {
     $this->connection =mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME); 
     if (!$this->connection) {
      die( "Database connection failed: ". mysqli_connect_error() ." (" .mysqli_connect_errno().")" ); 
     }
 }
 public function query($sql) {
 $result = mysqli_query($this->connection, $sql);
 $this->confirm_query($result);
 return $result;
 }
 
private function confirm_query($result)
{
if(!$result)
{
die("database querry failed  ". mysqli_error($this->connection));
}
}
public function escape_value($value) {
    if ($this->real_escape_string_exists) { // PHP v4.3.0 or higher
       // undo any magic quote effects  so mysqli_real_escape_string can do the work
        if ($this->magic_quotes_active) {
         $value=  stripslashes($value);  
        }
        $value = mysqli_real_escape_string($this->connection,$value);
    }
    else { // befor PHP v4.3.0
    //if magic quotes aren't already on then add slashes manually 
    if (!$this->magic_quotes_active) {
        $value = addslashes($value);
    }
      // if magic quotes are active, then the slashes already exist  
    }
    return $value;
}

public function datetime_to_text($datetime) {
$unixdatetime = strtotime($datetime);
return strftime("%B %d, %Y at %I:%M %p ", $unixdatetime);
}
public function fetch_array($result_set) {
 return mysqli_fetch_array($result_set);   
}
public function num_rows($result){
    return mysqli_num_rows($result);
}
public function insert_id() {
   return mysqli_insert_id($this->connection);
}
public function affected_rows() {
    return mysqli_affected_rows($this->connection);
}
 public function close_connection () {
     if (isset($this->connection)) {
      mysqli_close($this->connection);
      unset($this->connection);
     }
 }
 
}
$database= new MySQLDatabase();
$db = & $database;