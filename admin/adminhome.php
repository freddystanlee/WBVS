<?php
    require_once "../action/dbconnection.php";
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
        <title>ADMIN</title>
        <style>
            body{
                background-color: #DFDFDF;
            }
        </style>
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
        
        <h1 style="text-align: center; margin-top: 10px;">WELCOME ADMIN</h1>

        <div style="display: flex; justify-content: space-evenly; margin-top: 50px;">
            <div style="background-color: orange; color: black; margin: 0 25px; border-radius: 4px; height: auto; width: 400px; box-shadow: 10px 10px 5px grey;">
                <h5 style="background-color: black; color: orange; border-radius: 4px; text-align:center; font-size: 30px;">Voting Session</h5>
                <?php
                    $sessionsql = "SELECT * FROM votingsession;";
                    $stmt = mysqli_stmt_init($dbConn);
                    if(!mysqli_stmt_prepare($stmt, $sessionsql)){
                        header("Location: ../admin/adminhome.php?error=stmtfailed");
                        exit();
                    } else {
                        mysqli_stmt_execute($stmt);
                        $datareceived = mysqli_stmt_get_result($stmt);
                        $checkresult = mysqli_num_rows($datareceived);
                        if($checkresult > 0){
                            echo "<p style='text-align:center; font-size: 20px;'>Number of voting sessions: ".$checkresult."</p>";

                        } else {
                            echo "<p style='text-align:center; font-size: 20px;'>There are no existing session currently</p>";
                        }
                        mysqli_stmt_close($stmt);
                    }
                ?>
                <div style="text-align:center; margin-bottom: 20px;">
                    <a href="managesession.php" class="btn btn-dark">Manage Session</a>
                </div>

            </div>

            <div style="background-color: orange; color: black; margin: 0 25px; border-radius: 4px; height: auto; width: 400px; box-shadow: 10px 10px 5px grey;">
                <h5 style="background-color: black; color: orange; border-radius: 4px; text-align:center; font-size: 30px;">Users</h5>
                <?php
                    $usersql = "SELECT * FROM users;";
                    $stmt2 = mysqli_stmt_init($dbConn);
                    if(!mysqli_stmt_prepare($stmt2, $usersql)){
                        header("Location: ../admin/adminhome.php?error=stmtfailed");
                        exit();
                    } else {
                        mysqli_stmt_execute($stmt2);
                        $datareceived = mysqli_stmt_get_result($stmt2);
                        $checkresult = mysqli_num_rows($datareceived);
                        if($checkresult > 0){
                            echo "<p style='text-align:center; font-size: 20px;'>Number of users: ".$checkresult."</p>";

                        } else {
                            echo "<p style='text-align:center; font-size: 20px;'>There are no existing users currently</p>";
                        }
                        mysqli_stmt_close($stmt2);
                    }
                ?>
                <div style="text-align:center; margin-bottom: 20px;">
                    <a href="manageusers.php" class="btn btn-dark">Manage Users</a>
                </div>
            </div>

            <div style="background-color: orange; color: black; margin: 0 25px; border-radius: 4px; height: auto; width: 400px; box-shadow: 10px 10px 5px grey;">
                <h5 style="background-color: black; color: orange; border-radius: 4px; text-align:center; font-size: 30px;">User Requests</h5>
                <?php
                    $requestsql = "SELECT * FROM request;";
                    $stmt3 = mysqli_stmt_init($dbConn);
                    if(!mysqli_stmt_prepare($stmt3, $requestsql)){
                        header("Location: ../admin/adminhome.php?error=stmtfailed");
                        exit();
                    } else {
                        mysqli_stmt_execute($stmt3);
                        $datareceived = mysqli_stmt_get_result($stmt3);
                        $checkresult = mysqli_num_rows($datareceived);
                        if($checkresult > 0){
                            echo "<p style='text-align:center; font-size: 20px;'>Number of requests: ".$checkresult."</p>";

                        } else {
                            echo "<p style='text-align:center; font-size: 20px;'>There are no requests from users currently</p>";
                        }
                        mysqli_stmt_close($stmt3);
                    }
                ?>
                <div style="text-align:center; margin-bottom: 20px;">
                    <a href="adminrequest.php" class="btn btn-dark">User Requests</a>
                </div>
            </div>
        </div>

        

        

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>