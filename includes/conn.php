<?php

define( 'DB_HOST', 'localhost' );          // Set database host
define( 'DB_USER', 'root' );             // Set database user
define( 'DB_PASS', '' );             // Set database password
define( 'DB_NAME', 'oswa_inv' ); 

$mysqli = new mysqli("localhost", "root", "", "oswa_inv");
if($mysqli->error){
    die($mysqli->error);
}
?>