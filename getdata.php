<?php
//Connect to the database
require "./db/db_connect.php";
$userError = false;
$date = date("d-m-Y");
$time = date("h:i:sa");

if (isset($_GET['uid'])) {
    $user_id_get = $_GET['uid'];
    $existsSql = "SELECT * FROM `users` WHERE `user_id` = '$user_id_get'";
    $existsResult = mysqli_query($connection, $existsSql);
    $numExistRow = mysqli_num_rows($existsResult);
    if ($numExistRow > 0) {
        $fetch_rows = mysqli_fetch_assoc($existsResult);
        $user_name = $fetch_rows['user_name'];
        $user_reg_no = $fetch_rows['user_reg_no'];
        $user_id = $fetch_rows['user_id'];
        $user_number = $fetch_rows['user_number'];

        $sql0 = "SELECT * FROM `users-logs` WHERE `user_id` = '$user_id_get' AND `date` = '$date'";
        $result0 = mysqli_query($connection, $sql0);
        if (!$result0) {
            echo "error finding userId and date in user-logs";
        }
        $num_rows = mysqli_num_rows($result0);
        $fetch_rows0 = mysqli_fetch_assoc($result0);
        if ($num_rows == 0) {
            $timeout = "0";
            $sql1 = "INSERT INTO `users-logs`(`date`, `user_name`, `user_reg_no`, `user_id`, `user_number`, `user_login`, `user_logout`) VALUES ('$date','$user_name','$user_reg_no','$user_id','$user_number','$time',$timeout)";
            $result1 = mysqli_query($connection, $sql1);
            if (!$result1) {
                echo "Error logging in";
            } else {
                echo "Welcome! you have been loggedin successfully";
            }
        } elseif ($num_rows == 1 && $fetch_rows0['user_logout'] == "0") {
            $sql2 = "UPDATE `users-logs` SET `user_logout`= '$time' WHERE `user_id` = '$user_id_get' AND `date` = '$date'";
            $result2 = mysqli_query($connection, $sql2);
            if (!$result2) {
                echo "Error logging out";
            } else {
                echo "Have a good day you have been loggedout successfully";
            }
        } else {
            echo "you have been logged today come tommorow";
        }
    } else {
        //Store the new users data to users table in th databse
        $sql = "SELECT * FROM `users` WHERE `add_card` = 1";
        $result = mysqli_query($connection, $sql);
        $num_rows = mysqli_num_rows($result);
        if ($num_rows == 1) {
            $sql1 = "UPDATE `users` SET `user_id`='$user_id_get',`add_card`='0' WHERE `add_card` = '1'";
            $result1 = mysqli_query($connection, $sql1);
            if (!$result1) {
                echo "error";
            } else {
                echo "sucessfully registered";
            }
        } elseif ($num_rows > 1) {
            $userError = true; //Multiple user detected
        } else {
            echo "your card is invalid";
            http_response_code(404);
            exit;
        }
    }
}
