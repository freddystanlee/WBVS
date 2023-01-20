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
        <title>Session List</title>
        
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
        <h1 style="font-family: 'Montserrat', sans-serif; text-align: center; margin-top: 40px;">Voting Session Participated</h1>

        <div style="margin: 0 50px 120px 50px">
            <table class="table table-hover" style="margin-right: 20px;">
                <thead>
                    <tr class="table-dark">
                        <th scope="col">#</th>
                        <th scope="col">Session Name</th>
                        <th scope="col">Session Description</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sessionsql = "SELECT participants.sessionid, votingsession.sessionname, votingsession.sessiondesc FROM participants INNER JOIN votingsession ON participants.sessionid = votingsession.sessionid WHERE participants.userid = ?;";
                        $stmt = mysqli_stmt_init($dbConn);
                        if(!mysqli_stmt_prepare($stmt, $sessionsql)){
                            header("Location: ../users/userssession.php?error=stmtfailed");

                            exit();
                        } else {
                            mysqli_stmt_bind_param($stmt, "i", $_SESSION["id"]);
                            mysqli_stmt_execute($stmt);
                            $datareceived = mysqli_stmt_get_result($stmt);
                            $checkresult = mysqli_num_rows($datareceived);
                            if($checkresult > 0){
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($datareceived)) :?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $row["sessionname"]?></td>
                                        <td><?= $row["sessiondesc"]?></td>
                                        <td>
                                            <a href="userspoll.php?session=<?= $row["sessionid"] ?>" class="btn btn-dark">Open This Session</a>
                                            <a href="viewresult.php?session=<?= $row["sessionid"] ?>" class="btn btn-warning">View Result</a>
                                        </td>
                                    </tr>
                                    
                    <?php 
                                    $no++;
                                endwhile;
                                mysqli_stmt_close($stmt);
                            } else {
                                echo "<p style='color: red; font-size:20px;'>You are not in any voting session currently</p>";
                            }
                        }
                    ?>    

                    
                </tbody>
            </table>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>