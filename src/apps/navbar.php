<?php
if (isset($_SESSION['user']) && $_SESSION['user'] == true) {
    $loggedin = true;
} else {
    $loggedin = false;
}

if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
    $adminlogin = true;
} else {
    $adminlogin = false;
}

echo '<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="./index.php">
            <img src="../public/images/logo.png" style="width: 42px; height: 40px;" alt="Logo" width="30" height="24">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">';
if ($loggedin) {
    echo '
                <li class="nav-item">
                    <a class="nav-link" id="logs-tab" href="./index.php">Logs</a>
                </li>';
}
if ($adminlogin) {
    echo '
                <li class="nav-item">
                    <a class="nav-link" id="manage-users-tab" href="./manageUsers.php">Manage users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="add-users-tab" href="./addUser.php">Add Users</a>
                </li>';
}
if (!$loggedin) {
    echo '
                <li class="nav-item">
                    <a class="nav-link" id="login-users-tab" href="./login.php">LogIn</a>
                </li>';
}
echo ' </ul>';
if ($loggedin) {
    echo '
            <button class="btn btn-danger"><a href="./apps/logout.php" style="text-decoration: none; color:white;">Logout</a></button>';
}
echo '</div>
    </div>
</nav>';
