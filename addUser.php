<?php
//Connect to the database
require "./db/db_connect.php";

// Flags to show Alerts
$exists = false;
$showError = false;
$passError = false;
$showSuccess = true;

if (isset($_POST['user_name'])) {
    $user_name = $_POST['user_name'];
    $user_Fname = $_POST['user_Fname'];
    $user_reg_no = $_POST['user_reg_no'];
    $user_number = $_POST['user_number'];
    $user_address = $_POST['user_address'];
    $user_pass = $_POST['user_pass'];
    $user_cpass = $_POST['user_cpass'];
    //Store the new users data to users table in th databse
    $existsSql = "SELECT * FROM `users` WHERE `user_reg_no` = '$user_reg_no'";
    $existsResult = mysqli_query($connection, $existsSql);
    $numExistRow = mysqli_num_rows($existsResult);
    if ($numExistRow > 0) {
        $exists = true;
    } else {
        if ($user_pass == $user_cpass) {
            //Creating to store users login data in users table
            $user_pass_hash = password_hash($user_cpass, PASSWORD_DEFAULT);
            $sql = "UPDATE `users` SET `user_name`=?,`user_fname`=?,`user_reg_no`=?,`user_number`=?,`user_address`=? WHERE `user_reg_no` = 0";
            $stmt = mysqli_stmt_init($connection);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                $showError = true;
            } else {
                $showSuccess = true;
                mysqli_stmt_bind_param($stmt, "sssss", $user_name, $user_Fname, $user_reg_no, $user_number, $user_address);
                mysqli_stmt_execute($stmt);
            }

            $sql1 = "INSERT INTO `users-login`(`user_number`, `user_pass`) VALUES (?,?)";
            $stmt1 = mysqli_stmt_init($connection);
            if (!mysqli_stmt_prepare($stmt1, $sql1)) {
                $showError = true;
            } else {
                $showSuccess = true;
                mysqli_stmt_bind_param($stmt1, "ss", $user_number, $user_pass_hash);
                mysqli_stmt_execute($stmt1);
            }
        } else {
            $passError = true;
        }
    }
}

session_start();
if ($_SESSION['admin'] == false) {
    header("location: logs.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <!-- Bootstrap CSS  -->
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- Bootstrap JS -->
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <title>Add User</title>
</head>

<body>
    <!-- Navigation bar -->
    <?php require "./apps/navbar.php"; ?>

    <div style="min-height:82vh;">
        <h3 class="mt-1 py-3 bg-warning">
            <center>
                **title goes here**
            </center>
        </h3>
        <div style="background-color:cyan; width:70%" class="m-auto p-4">
            <form action="./addUser.php" method="post">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control my-4" id="user_name" name="user_name" placeholder="Username" required>
                    <label for="user_name">Student name</label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control my-4" id="user_Fname" name="user_Fname" placeholder="UserFname">
                    <label for="user_Fname">Student father name</label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control my-4" id="user_reg_no" name="user_reg_no" placeholder="Register Number" required>
                    <label for="user_reg_no">Student Register Number</label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control my-4" id="user_number" name="user_number" placeholder="Mobile Number" required>
                    <label for="user_number">Student Mobile Number</label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control my-4" id="user_address" name="user_address" placeholder="Address">
                    <label for="user_address">Student Address</label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control my-4" id="user_pass" name="user_pass" placeholder="Mobile Number" required>
                    <label for="user_pass">Enter Password</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control my-4" id="user_cpass" name="user_cpass" placeholder="Mobile Number" required>
                    <label for="user_cpass">Confirm Password</label>
                </div>
                <button type="submit" id='sub' class="btn btn-primary bg-gradient my-3">Login</button>
            </form>
        </div>

    </div>
    <!-- Footer -->
    <?php require "./apps/footer.php"; ?>
    <script>
        // To add active class to the navbar
        const addClassActive = document.getElementById('add-users-tab');
        addClassActive.classList.add('active');
    </script>

</body>

</html>