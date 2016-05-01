<?php

define("DB_SERVER", "mysql7.000webhost.com");
define("DB_USER", "a5716501_mclemy");
define("DB_PASS", "kabazayire2");
define("DB_NAME", "a5716501_Autodoo");
$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if (mysqli_connect_errno()) {
    die("database failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
}


