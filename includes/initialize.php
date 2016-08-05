<?php
// Define the core paths
// Define them as absolute paths to make sure that require_one
// works as expected

 defined('DS') ? null : define('DS',DIRECTORY_SEPARATOR) ;
defined('SITE_ROOT') ? null : define('SITE_ROOT',DS.'home'.DS.'a2008479'.DS.'public_html');
// defined('SITE_ROOT') ? null : define('SITE_ROOT','C:'.DS.'xampp'.DS.'htdocs'.DS.'autodoor');

defined('LIB_PATH') ? null : define('LIB_PATH',SITE_ROOT.DS.'includes') ;
// load config file first
require_once (LIB_PATH.DS.'config.php');
// load basic functions next so that everything after can use them
require_once (LIB_PATH.DS.'functions.php');
// load core objects
require_once (LIB_PATH.DS.'session.php');
require_once (LIB_PATH.DS.'database.php');
require_once (LIB_PATH.DS.'database_object.php');

// load database_related classes
require_once (LIB_PATH.DS.'user.php');
require_once (LIB_PATH.DS.'office.php');
require_once (LIB_PATH.DS.'role.php');

