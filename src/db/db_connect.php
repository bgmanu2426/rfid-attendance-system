<?php
$env = parse_ini_file('.env');

$server = "localhost";
$username = $env['DB_SERVER_USERNAME'];
$password = $env['DB_SERVER_PASSWORD'];
$database = $env['DB_SERVER_DATABASE'];

$connection = mysqli_connect(
    hostname: $server,
    username: $username,
    password: $password,
    database: $database
);
if (!$connection) {
    die("Error" . mysqli_connect_error());
}