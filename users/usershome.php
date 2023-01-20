<?php
    require_once "../action/dbconnection.php";
    require_once "../action/function.php";
    session_start();
    if(!isset($_SESSION["id"], $_SESSION["uname"])) {
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
        <link rel="stylesheet" href="../css/usersnavbar.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>Home</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Pacifico&display=swap');
            @import url('https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap');
        </style>
    </head>
    <body>
        <header>
            <a class="logo" href="usershome.php">WBVS</a>
            <nav>
                <ul class="navlinks">
                    <li><a href="usershome.php">Home</a></li>
                    <li><a href="userssession.php">Voting Session</a></li>
                    <li><a href="usersprofile.php">Profile</a></li>
                    <li><a href="usersrequest.php">Request Admin</a></li>
                </ul>
            </nav>
            <div class="logout-btn">
                <a href="../action/logout.php"><button>LOGOUT</button></a>
            </div>
        </header>

        <?php
        
            $sql = "SELECT * FROM users WHERE userid = ?;";
            $stmt = mysqli_stmt_init($dbConn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../admin/adminhome.php?error=stmtfailed");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $_SESSION["id"]);
                mysqli_stmt_execute($stmt);
                $datareceived = mysqli_stmt_get_result($stmt);
                while($row = mysqli_fetch_assoc($datareceived)){
                    echo "<h1 style='text-align: center; margin-top: 30px;'>Welcome ".$row["username"]. "!</h1>";
                }
                mysqli_stmt_close($stmt);
            }
        ?>
        <div style="display: flex; justify-content: space-evenly; margin-top: 100px;">
            <div style="text-align: center; width: 500px; height: 500px;">
                <img src="../pic/usershome.jpg" alt="picture">
            </div>
            <div style="width: auto; height: 500px;">
                <h4 style="font-family: 'Pacifico', cursive; font-size: 80px; margin-bottom: 30px;">Vote Yours Now</h4>

                <p style="font-family: 'Kaushan Script', cursive; font-size: 50px">Your Vote is Your Decision</p>
                
            </div>
        </div>


        <footer style="bottom: 0; background-color: black; width: 100%; height: auto; position: fixed; display: flex; justify-content: space-evenly; align-items:center;">
            <!-- WEBSITE -->
            <div style="text-align: center;">
                <h1 style="font-family: 'Qwigley', cursive; color: orange;">WBVS</h1>
                <p style="color: orange;">© Web Based Voting System (WBVS)</p>
            </div>
            <!-- CONTACT -->
            <div>
                <p style="font-size: 20px; font-weight: bold; color: white;">Contact Us</p>
                <p style="font-size: 15px; color:white; margin-bottom: 0;">Email: freddystanlee987@gmail.com</p>
            </div>
        </footer>
    </body>
</html>

    