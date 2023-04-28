<?php
session_start();
if (!isset($_SESSION['userUid'])) {
    header("location: login.php");
    exit();
}

//Connect to the database
require "./db/db_connect.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery CSS  -->
    <link rel="stylesheet" href="./css/jquery-ui.css">
    <link rel="stylesheet" href="./css/dataTables.jqueryui.min.css">
    <link rel="stylesheet" href="./css/buttons.jqueryui.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <!-- Bootstrap CSS  -->
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <style>
        th.sorting.ui-state-default,
        table.dataTable th,
        table.dataTable td {
            text-align: center;
        }
    </style>

    <!-- jQuery JS -->
    <script src="./js/jquery-3.5.1.js"></script>
    <!-- jQuery datatables JS  -->
    <script src="./js/jquery.dataTables.min.js"></script>
    <!-- jQuery UI JS  -->
    <script src="./js/dataTables.jqueryui.min.js"></script>
    <!-- jQuery buttons JS  -->
    <script src="./js/dataTables.buttons.min.js"></script>
    <script src="./js/buttons.jqueryui.min.js"></script>
    <script src="./js/jszip.min.js"></script>
    <script src="./js/pdfmake.min.js"></script>
    <script src="./js/vfs_fonts.js"></script>
    <script src="./js/buttons.html5.min.js"></script>
    <script src="./js/buttons.print.min.js"></script>
    <script src="./js/buttons.colVis.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script for the jQuerys plug-in DataTables
        $(document).ready(function() {
            var table = $('#example').DataTable({
                lengthChange: false,
                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    ['5 rows', '10 rows', '25 rows', '50 rows', 'Show all']
                ],
                buttons: [
                    'pageLength', 'print',
                    // you can also include colvis(colum-visiblity)
                    {
                        extend: 'spacer',
                        style: 'bar',
                        text: '<b>Export files to :- </b>'
                    },
                    'excel', 'pdf',
                ],
            });
            table.buttons().container().insertBefore('#example_filter');
        });
    </script>
    <title>Logs</title>
</head>

<body>
    <!-- Navigation bar -->
    <?php require "./apps/navbar.php"; ?>
    <h3 class="py-2 mt-5 text-center"> Students Daily Log</h3>
    <!-- jQuery table to display users log -->
    <div class="mx-2 table-responsive" style="min-height: 80vh;">
        <table class="table" id="example">
            <thead>
                <tr>
                    <th scope="col">Sl.no</th>
                    <th scope="col">Student Name</th>
                    <th scope="col">Reg.no</th>
                    <th scope="col">Student UID</th>
                    <th scope="col">LogIn</th>
                    <th scope="col">LogOut</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $user_number = $_SESSION['userUid'];
                if ($_SESSION['admin'] == true) {
                    $sql = "SELECT * FROM `users-logs`";
                } else {
                    $sql = "SELECT * FROM `users-logs` WHERE `user_number` = '$user_number'";
                }
                $result = mysqli_query($connection, $sql);
                $num = 1;
                while ($fetch_rows = mysqli_fetch_assoc($result)) {
                    echo '
                        <tr>
                            <td>' . $fetch_rows['date'] . '</td>
                            <td>' . $fetch_rows['user_name'] . '</td>
                            <td>' . $fetch_rows['user_reg_no'] . '</td>
                            <td>' . $fetch_rows['user_id'] . '</td>
                            <td>' . $fetch_rows['user_login'] . '</td>
                            <td>' . $fetch_rows['user_logout'] . '</td>
                        </tr>';
                    $num = $num + 1;
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Footer -->
    <?php require "./apps/footer.php"; ?>
</body>
<script>
    // To add active class to the navbar
    const addClassActive = document.getElementById('logs-tab');
    addClassActive.classList.add('active');
</script>

</html>