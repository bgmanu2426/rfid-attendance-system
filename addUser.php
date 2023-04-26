<?php
session_start();
if ($_SESSION['admin'] == false) {
    header("location: logs.php");
    exit();
}

//Connect to the database
require "./db/db_connect.php";

// Flags to show Alerts
$exists = false;
$showError = false;
$passError = false;
$showSuccess = false;

if (isset($_POST['user_name'])) {
    // Fetch all the details in the POST request
    $user_name = $_POST['user_name'];
    $user_Fname = $_POST['user_Fname'];
    $user_reg_no = $_POST['user_reg_no'];
    $user_number = $_POST['user_number'];
    $user_address = $_POST['user_address'];
    $user_pass = $_POST['user_pass'];
    $user_cpass = $_POST['user_cpass'];

    $existsSql = "SELECT * FROM `users` WHERE `user_number` = '$user_number' AND `user_reg_no` = '$user_reg_no'";
    $existsResult = mysqli_query($connection, $existsSql);
    $numExistRow = mysqli_num_rows($existsResult);
    if ($numExistRow > 0) {
        // If the user with the provided mobile number and register number exists throw error
        $exists = true;
    } else {
        //Store the student details in users database
        if ($user_pass === $user_cpass) {
            $user_pass_hash = password_hash($user_cpass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users`(`user_name`, `user_fname`, `user_reg_no`, `user_number`, `user_address`) VALUES (?,?,?,?,?)";
            $stmt = mysqli_stmt_init($connection);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                $showError = true;  // Show error if the database fails to store user details
            } else {
                $showSuccess = true;  // Show success on storing the user details in the database
                mysqli_stmt_bind_param($stmt, "sssss", $user_name, $user_Fname, $user_reg_no, $user_number, $user_address);
                mysqli_stmt_execute($stmt);
            }

            $sql1 = "INSERT INTO `users-login`(`user_uid`, `user_pass`) VALUES (?,?)";
            $stmt1 = mysqli_stmt_init($connection);
            if (!mysqli_stmt_prepare($stmt1, $sql1)) {
                $showError = true;  // Show error if the database fails to store user login details
            } else {
                $showSuccess = true;  // Show success on storing the user login details in the database
                mysqli_stmt_bind_param($stmt1, "ss", $user_number, $user_pass_hash);
                mysqli_stmt_execute($stmt1);
            }
        } else {
            $passError = true; //Password didnt match
        }
    }
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
    <!-- jQuery JS -->
    <script src="./js/jquery-3.5.1.js"></script>
    <title>Add User</title>
</head>

<body>
    <!-- Navigation bar -->
    <?php require "./apps/navbar.php"; ?>
    <!-- Alerts -->
    <?php
    if ($exists) {
        echo '
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
            <path
                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
        </svg>
        <div class="alert alert-danger d-flex align-items-center" role="alert" style="height: 48px; margin-bottom: 0; position: absolute; left: 41%; top:59px;">
            <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:" style="width: 18px">
                <use xlink:href="#exclamation-triangle-fill" />
            </svg>
            <div>
                Student already exists!
            </div>
        </div>';
    } elseif ($showError) {
        echo '
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
            <path
                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
        </svg>
        <div class="alert alert-danger d-flex align-items-center" role="alert" style="height: 48px; margin-bottom: 0; position: absolute; left: 38%; top:59px;">
            <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:" style="width: 18px">
                <use xlink:href="#exclamation-triangle-fill" />
            </svg>
            <div>
                Couldn\'t store in Database
            </div>
        </div>';
    } elseif ($passError) {
        echo '
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
            <path
                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
        </svg>
        <div class="alert alert-danger d-flex align-items-center" role="alert" style="height: 48px; margin-bottom: 0; position: absolute; left: 40%; top:59px;">
            <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:" style="width: 18px">
                <use xlink:href="#exclamation-triangle-fill" />
            </svg>
            <div>
                Passwords do not match
            </div>
        </div>';
    } elseif ($showSuccess) {
        echo '
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="info-fill" viewBox="0 0 16 16">
                <path
                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
            </symbol>
        </svg>
        <div class="alert alert-primary d-flex align-items-center" role="alert" style="height: 48px; margin-bottom: 0; position: absolute; left: 38.2%; top:59px;">
            <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Info:" style="width: 18px">
                <use xlink:href="#info-fill" />
            </svg>
            <div>
                Scan RFID Card to register the user
            </div>
        </div>';
    }
    ?>

    <h3 class="py-2 mt-5 text-center">Register Student Details</h3>
    <div style="min-height:82vh;">
        <div style="width:70%" class="m-auto px-4">
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
                <center>
                    <button type="submit" class="btn btn-primary bg-gradient my-3">Add User</button>
                </center>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <?php require "./apps/footer.php"; ?>
    <script>
        // To add active class to the navbar
        const addClassActive = document.getElementById('add-users-tab');
        addClassActive.classList.add('active');

        // To fix the re-submission error on reloading the webpage
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        // To make the alert auto dismissable
        $(document).ready(function() {
            $(".alert").fadeTo(2500, 400).slideUp(400, function() {
                $(this).alert('close');
            })
        })
    </script>

</body>

</html>