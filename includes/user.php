<?php
require_once (LIB_PATH.DS.'database.php');
class User  extends DatabaseObject {
    protected static $table_name="users";
    protected static $db_fields = array('user_id', 'username', 'password', 'f_name','l_name', 'email','tel','user_status','role_id');
    public $user_id;
    public $username;
    public $password;
    public $f_name;
    public $l_name;
    public $email;
    public $tel;
    public $role_id;
    public $user_status;
   
public function full_name() {
     if (isset($this->f_name) && isset($this->l_name)) {
         return $this->f_name . " ". $this->l_name;
     }
     else {
         return "";
     }
 }

 public static function authenticate($username, $password) {
     global $database;
     $escaped_username = $database->escape_value($username);
     $escaped_password= $database->escape_value($password);
     $sql="SELECT * FROM  ". self::$table_name ;
     $sql.=" WHERE username= '{$escaped_username}' AND password='{$escaped_password}' ";
     $sql.=" LIMIT 1 ";

     $result_array= User::find_by_sql($sql);
     return !empty($result_array) ? array_shift($result_array) : false;
 }
  

  // Common Database Methods
public static function find_all() {
     $sql="SELECT * FROM  ".self::$table_name;
     return self::find_by_sql($sql);
     }
public static function find_by_id($id) {
     $primary_key=self::$db_fields[0];
     $sql="SELECT * FROM ".self::$table_name." WHERE {$primary_key} = {$id} LIMIT 1";
     $result_array=  self::find_by_sql($sql);
     return !empty($result_array) ? array_shift($result_array) : false;
 }
 
public static function find_by_sql($sql) {
     global $database;
     $object_array =array();
     $result_set=$database->query($sql);
     while ($row= $database->fetch_array($result_set)) {
         $object_array[] = self::instantiate($row);
     }
     return $object_array;
 }
 
 private static function instantiate($record) {
    $object= new User();
     foreach ($record as $attribute=> $value) {
       if ($object->has_attribute($attribute)) {
           $object->$attribute=$value;
       }  
     }
     return $object;
 }
 private function has_attribute($attribute) {
     // get_object_vars returns an associative array with all attributes
     // (incl. private ones!) as the keys and their current values as the value
     $object_vars = $this->attributes();
     // we don't care about the value, we just want to know if the key exists
     // we will return true or false
     return array_key_exists($attribute,$object_vars);
 }

// Methodes for CRUD operations on the Database

protected function attributes() {
    // return an array of attribute keys and values
    $attributes = array();
    foreach(self::$db_fields as $field) {
       if (property_exists($this, $field)) {
        $attributes[$field]= $this->$field;
       }
    }
return $attributes;
}

protected function sanitized_attributes() {
    global $database;
    $clean_attributes= array();
    // Sanitize the values before submitting
    // Note: does not alter the actual value of each attribute
    foreach ($this->attributes() as $key => $value) {
    $clean_attributes[$key] = $database->escape_value($value);
    }
    return $clean_attributes;
}
public function save () {
    $primary_key=self::$db_fields[0];
    $attributes= $this->attributes();
    return isset($this->$primary_key) ? $this->update() : $this->create() ;
}

public function create () {
    global $database;
    $attributes = $this->sanitized_attributes();
    $sql = "INSERT INTO ".self::$table_name." ( ";
    $sql.=join(", ", array_keys($attributes));
    $sql.=") VALUES ('";
    $sql.= join("' ,'",array_values($attributes));
    $sql.= "')";
    if ($database->query($sql)) {
    $this->user_id = $database->insert_id();
    return true;
}
else {
return false;
}
echo $sql;
}  

public function update () {
    global $database;
    $primary_key=self::$db_fields[0];
    $attributes = $this->sanitized_attributes();
    $attribute_pairs= array();

    foreach($attributes as $key => $value) {
    $attribute_pairs[]="{$key}='{$value}'";
    }

    $sql=" UPDATE ".self::$table_name." SET ";
    $sql.= join(", ",$attribute_pairs);
    $sql.=" WHERE ".$primary_key. " = ".$attributes[$primary_key];

    $database->query($sql);
    if ($database->affected_rows() == 1) {
    return true;
    }
    else {
    return false;
    }
}

public function delete()  {
    global $database;
    $primary_key=self::$db_fields[0];
    $attributes = $this->sanitized_attributes();
    $sql="DELETE FROM ".self::$table_name;
    $sql.=" WHERE ".$primary_key. "= ".$attributes[$primary_key];
    $sql.=" LIMIT 1";
    $database->query($sql);
    if ($database->affected_rows() == 1) {
    return true;
    }
    else {
    return false;
    }
}

public function count_all() {
    global $database;
    $sql= "SELECT COUNT(*) FROM " .self::$table_name;
    $result_set=$database->query($sql);
    $row= $database->fetch_array($result_set);
    return array_shift($row);
}
 
}
?>

