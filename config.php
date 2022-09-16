<?php

define('DB_SERVER', 'YOUR DB HOST');
define('DB_USERNAME', 'USERNAME');
define('DB_PASSWORD', 'PASSWORD');
define('DB_NAME', 'DBNAME');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
