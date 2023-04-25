<?php
//Connect to the database
require "./db/db_connect.php";
$exits = false;

if (isset($_GET['uid'])) {
    $student_uid = $_GET['uid'];

    //Store the new users data to users table in th databse
    $existsSql = "SELECT * FROM `users` WHERE `user_id` = '$student_uid'";
    $existsResult = mysqli_query($connection, $existsSql);
    $numExistRow = mysqli_num_rows($existsResult);
    if ($numExistRow > 0) {
        $exists = true;
        //vguvyggvgbuvk
        //vguv
    } else {
        $sql = "INSERT INTO `users` (`user_id`) VALUES ($student_uid)";
        $result = mysqli_query($connection, $sql);
        if (!$result) {
            echo "error";
        } else {
            echo "sucessfully registered";
        }
    }
}
