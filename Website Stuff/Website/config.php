<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'na05-sql.pebblehost.com');
define('DB_USERNAME', 'customer_179919_collatzdb');
define('DB_PASSWORD', 's6jYWqX1$iu0HiHgXMDd');
define('DB_NAME', 'customer_179919_collatzdb');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>