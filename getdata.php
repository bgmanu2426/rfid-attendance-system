<?php
//Connect to the database
require "./db/db_connect.php";

// Date and time 
date_default_timezone_set("Asia/Kolkata");
$time = date("h:i:sa");
$date = date("d-m-Y");

// Scan the RFID card and get the rfid uid from Arduino UNO
if (isset($_GET['uid'])) {
    $user_id_get = $_GET['uid'];
    // Check that the user exists in database or not 
    $existsSql = "SELECT * FROM `users` WHERE `user_id` = '$user_id_get'";
    $existsResult = mysqli_query($connection, $existsSql);
    $numExistRow = mysqli_num_rows($existsResult);
    // If user exists
    if ($numExistRow > 0) {
        // Fetch user data from our database 
        $fetch_rows = mysqli_fetch_assoc($existsResult);
        $user_name = $fetch_rows['user_name'];
        $user_reg_no = $fetch_rows['user_reg_no'];
        $user_id = $fetch_rows['user_id'];
        $user_number = $fetch_rows['user_number'];

        // Find if the user has logged in today or not
        $sql0 = "SELECT * FROM `users-logs` WHERE `user_id` = '$user_id_get' AND `date` = '$date'";
        $result0 = mysqli_query($connection, $sql0);
        if (!$result0) {
            echo "Error finding userId and date in users-logs";
        }
        $num_rows = mysqli_num_rows($result0);
        $fetch_rows0 = mysqli_fetch_assoc($result0);
        // LogIn the user if he is not loggedIn
        if ($num_rows == 0) {
            $sql1 = "INSERT INTO `users-logs`(`date`, `user_name`, `user_reg_no`, `user_id`, `user_number`, `user_login`, `user_logout`) VALUES (?,?,?,?,?,?,?)";
            $stmt1 = mysqli_stmt_init($connection);
            if (!mysqli_stmt_prepare($stmt1, $sql1)) {
                echo "Error logging in";
            } else {
                $timeout = "0";
                mysqli_stmt_bind_param($stmt1, "sssssss", $date, $user_name, $user_reg_no, $user_id, $user_number, $time, $timeout);
                mysqli_stmt_execute($stmt1);
                echo "Welcome " . $user_name . "! You are loggedin";
                http_response_code(200);
                exit;
            }
        } elseif ($num_rows == 1 && $fetch_rows0['user_logout'] == "0") {
            // Logout the user if he is loggedIn
            $sql2 = "UPDATE `users-logs` SET `user_logout`= ? WHERE `user_id` = ? AND `date` = ?";
            $stmt2 = mysqli_stmt_init($connection);
            if (!mysqli_stmt_prepare($stmt2, $sql2)) {
                echo "Error logging out";
            } else {
                mysqli_stmt_bind_param($stmt2, "sss", $time, $user_id_get, $date);
                mysqli_stmt_execute($stmt2);
                echo "Good bye " . $user_name . "!You are loggedout";
                http_response_code(200);
                exit;
            }
        } else {
            // If the user has checked in & out today tell him to comeback tommorow
            echo "You are registerd today comeback tommorow";
            http_response_code(404);
            exit;
        }
    } else {
        // If user dosen't exists
        $sql = "SELECT * FROM `users` WHERE `add_card` = 1";
        $result = mysqli_query($connection, $sql);
        $num_rows = mysqli_num_rows($result);
        // Add the user with the uid if admin gave permission
        if ($num_rows == 1) {
            $sql1 = "UPDATE `users` SET `user_id`='$user_id_get',`add_card`='0' WHERE `add_card` = '1'";
            $result1 = mysqli_query($connection, $sql1);
            if (!$result1) {
                echo "Error registering your account";
            } else {
                echo "Successfully Registered User";
                http_response_code(201);
                exit;
            }
        } elseif ($num_rows > 1) {
            echo "Multiple users detected";
            http_response_code(404);
            exit;
        } else {
            echo "Your card is invalid";
            http_response_code(404);
            exit;
        }
    }
}
