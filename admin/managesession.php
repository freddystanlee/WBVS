<?php
session_start();
    if(!isset($_SESSION["admin"])) {
        header("Location: ../index.php");
        exit();
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/adminnavbar.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>Manage Session</title>
    </head>
    <body>
        <header class="navcontainer">
            <a class="logo" href="adminhome.php">WBVS</a>
            <nav>
                <ul class="navlinks">
                    <li><a href="adminhome.php">Dashboard</a></li>
                    <li><a href="managesession.php">Manage Session</a></li>
                    <li><a href="manageusers.php">Manage Users</a></li>
                    <li><a href="adminrequest.php">User Requests</a></li>
                </ul>
            </nav>
            <div class="logout-btn">
                <a href="../action/logout.php"><button>LOGOUT</button></a>
            </div>
        </header>
        <div style="border: 2px solid grey; margin: 5% 25% 0 25%; box-shadow: 10px 10px 5px grey; ">        
            <h1 style="text-align: center;">What do you want to do?</h1>
            <div class="managesession-btn" style="margin-top: 30px; margin-bottom: 30px; text-align:center;">
                <a href="adminsession.php" class="btn btn-dark" style="margin: 0 20px;">Create A Voting Session</a>
                <a href="viewsession.php" class="btn btn-warning" style="margin: 0 20px;">View All Voting Session</a>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>