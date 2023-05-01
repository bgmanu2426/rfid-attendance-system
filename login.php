<?php
//Start the session
session_start();
if (isset($_SESSION['userUid'])) {
    header("location: index.php");
    exit();
}

$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Connecting to the databse
    require "./db/db_connect.php";

    //Variables to store and match the details from login form
    $user_number = $_POST["user_number"];
    $user_password = $_POST["user_pass"];

    if (isset($_POST['admin_user'])) {
        //Check the email and password entered by user is correct or not
        $sql = "SELECT * FROM `admin-login` WHERE admin_uid='$user_number'";
        $result = mysqli_query($connection, $sql);
        $num = mysqli_num_rows($result);
        $fetch_rows = mysqli_fetch_assoc($result);
        if (($num == 1) && password_verify($user_password, $fetch_rows['admin_pass'])) {
            $_SESSION['userUid'] = $user_number;
            $_SESSION['user'] = true;
            $_SESSION['admin'] = true;
            header("location: manageUsers.php");
        } else {
            $showError = true;
        }
    } else {
        //Check the email and password entered by user is correct or not
        $sql = "SELECT * FROM `users-login` WHERE user_uid='$user_number'";
        $result = mysqli_query($connection, $sql);
        $num = mysqli_num_rows($result);
        $fetch_rows = mysqli_fetch_assoc($result);
        if (($num == 1) && password_verify($user_password, $fetch_rows['user_pass'])) {
            $_SESSION['userUid'] = $user_number;
            $_SESSION['user'] = true;
            $_SESSION['admin'] = false;
            header("location: index.php");
        } else {
            $showError = true;
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="shortcut icon" href="./images/favicon.ico" type="image/x-icon">
    <!-- Bootstrap CSS  -->
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- Bootstrap JS -->
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery JS -->
    <script src="./js/jquery-3.5.1.js"></script>
    <title>Login</title>
</head>

<body>
    <!-- Navbar included -->
    <?php include './apps/navbar.php'; ?>

    <!-- Alerts -->
    <?php
    if ($showError) {
        echo '
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </symbol>
        </svg>
        <div class="alert alert-danger d-flex align-items-center" role="alert" style="height: 48px; margin-bottom: 0; position: absolute; left: 42.5%; top:69px;">
            <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:" style="width: 18px;">
                <use xlink:href="#exclamation-triangle-fill"></use>
            </svg>
            <div>
                Invalid Credentials
            </div>
        </div>
      ';
    }
    ?>

    <!-- Login form -->
    <div class="container col-md-6 my-5" style="min-height: 66.5vh;">
        <h3 class="text-center my-4 pt-2">Login to Attendance System </h3>
        <form action="./login.php" method="POST">
            <div class="form-floating mb-3">
                <input type="text" class="form-control my-4" id="user_number" name="user_number" placeholder="name@example.com">
                <label for="user_number">Enter Number</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control my-4" id="user_pass" name="user_pass" placeholder="Password">
                <label for="user_pass">Enter Password</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" name="admin_user" id="admin_user">
                <label class="form-check-label" for="admin_user">
                    Admin Login
                </label>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" id='sub' class="btn btn-primary my-3">Login</button>
            </div>
        </form>
    </div>

    <?php
    include './apps/footer.php';
    ?>
    <script>
        // To add active class to the navbar
        const addClassActive = document.getElementById('login-users-tab');
        addClassActive.classList.add('active');

        // To fix the re-submission error on reloading the webpage
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        // To make the alert auto dismissable
        $(document).ready(function() {
            $(".alert").fadeTo(3000, 1).slideUp(300, function() {
                $(this).alert('close');
            })
        })
    </script>
</body>

</html>