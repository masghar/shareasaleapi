<?php

define('DB_SERVER', 'shareddb-y.hosting.stackcp.net');
define('DB_USERNAME', 'sasapi-3135391c30');
define('DB_PASSWORD', 'zvhync2day');
define('DB_NAME', 'sasapi-3135391c30');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>