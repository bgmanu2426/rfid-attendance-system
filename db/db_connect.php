<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "rfidattendance";

$connection = mysqli_connect(
    hostname: $server,
    username: $username,
    password: $password,
    database: $database
);
if (!$connection) {
    die("Error" . mysqli_connect_error());
}