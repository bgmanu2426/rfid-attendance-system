<?php
session_start();
if ($_SESSION['admin'] == false) {
    header("location: logs.php");
    exit();
}
//Connect to the database
require "./db/db_connect.php";

if (isset($_GET['uid'])) {
    $slno = $_GET['uid'];
    echo $slno;
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
            <form action="/addUser.php" method="post">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control my-4" id="user_name" name="user_name" placeholder="Username">
                    <label for="user_name">Student name</label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control my-4" id="user_Fname" name="user_Fname" placeholder="UserFname">
                    <label for="user_Fname">Student father name</label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control my-4" id="user_pass" name="user_pass" placeholder="Password">
                    <label for="user_pass">Enter Password</label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control my-4" id="user_pass" name="user_pass" placeholder="Password">
                    <label for="user_pass">Enter Password</label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control my-4" id="user_pass" name="user_pass" placeholder="Password">
                    <label for="user_pass">Enter Password</label>
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