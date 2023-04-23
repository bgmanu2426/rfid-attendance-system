<?php
//Start the session
session_start();

// Connect to the database
require "./db/db_connect.php";
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
    <title>Home</title>
</head>

<body>
    <!-- Navigation bar -->
    <?php require "./apps/navbar.php"; ?>



    <!-- Footer -->
    <?php require "./apps/footer.php"; ?>
    <script>
        // To add active class to the navbar
        const addClassActive = document.getElementById('add-users-tab');
        addClassActive.classList.add('active');
    </script>

</body>

</html>