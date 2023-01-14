<?php
error_reporting(E_ALL);
$server = "localhost";
$username = "root";
$password = "";
$database = "users";

$conn = mysqli_connect($server, $username, $password, $database);

if (!$conn) {
    die(mysqli_error($conn)) ;
}
?>




