<?php

// Set sessions
if(!isset($_SESSION)) {
    session_start();
}

$hostname = "localhost";
$username = "root";
$password = "root";
$dbname = "php_user_authentication";

$connection = mysqli_connect($hostname, $username, $password, $dbname) or die("Database connection not established.")

?>