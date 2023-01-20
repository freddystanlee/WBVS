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
        <title>Voting Poll</title>
        <style>
            body{
                background-color: #EFEFEF;
            }
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
            $statussql = "SELECT votecasted FROM participants WHERE userid = ? AND sessionid = ?;";
            $stmt3 = mysqli_stmt_init($dbConn);
            $votecasted;
            if(!mysqli_stmt_prepare($stmt3, $statussql)){
                header("Location: ../users/userssession.php?cannotvote");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt3, "ii", $_SESSION["id"], $_GET["session"]);
                mysqli_stmt_execute($stmt3);
                $datareceived = mysqli_stmt_get_result($stmt3);
                while($row = mysqli_fetch_assoc($datareceived)){
                    $votecasted = $row["votecasted"];
                }
                mysqli_stmt_close($stmt3);
            }
            if($votecasted === 0){
                $sessionsql = "SELECT * FROM votingsession WHERE sessionid = ?;";
                $stmt = mysqli_stmt_init($dbConn);
                if(!mysqli_stmt_prepare($stmt, $sessionsql)){
                    header("Location: userspoll.php?session=". $_GET["session"]."cannotdiaplaysession");
                    echo "statement error";
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "i", $_GET["session"]);
                    mysqli_stmt_execute($stmt);
                    $datareceived = mysqli_stmt_get_result($stmt);
                    while ($row = mysqli_fetch_assoc($datareceived)){
                        echo "<h1 style='text-align: center; margin-top: 40px;'>".$row["sessionname"]."</h1>";
                        echo "<p style='margin: 0 50px 0 50px; font-size: 23px; font-weight: bold'>About: </p>";
                        echo "<p style='margin: 0 50px 0 50px; font-size: 18px;'>".$row["sessiondesc"]."</p>";
                        echo "<p style='margin: 0 50px 20px 50px; font-size: 15px;'>*Please vote one of these candidates below by clicking on the circle button</p>";
                    }
                    mysqli_stmt_close($stmt);
                } 
        ?>
                <form action="../action/submitvote.php" method="POST">
                    <div style="margin: 0 500px; justify-content: space-between">

                    <?php
                        $candidatesql = "SELECT * FROM candidates WHERE sessionid = ?";
                        $stmt2 = mysqli_stmt_init($dbConn);
                        if(!mysqli_stmt_prepare($stmt2, $candidatesql)){
                            header("Location: userspoll.php?session=". $_GET["session"]."cannotdiaplaycandidates");
                            echo "statement error";
                            exit();
                        } else {
                            mysqli_stmt_bind_param($stmt2, "i", $_GET["session"]);
                            mysqli_stmt_execute($stmt2);
                            $datareceived2 = mysqli_stmt_get_result($stmt2);
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($datareceived2)):
                    ?>

                                <div class="form-check" style="margin-bottom: 40px; height: auto; width: auto; box-shadow: 10px 10px 5px grey; background-color: #6A6A6A;">
                                    <h5 style="font-weight: bolder; text-align: center; font-size: 25px; color: orange;">Candidate <?= $no ?></h5>
                                    <div style="text-align:center;">
                                        <img src="../candidates/<?= $row["candidateimage"] ?>" style="height: 210px; width: auto;">
                                    </div>
                                    <div style="margin-left: 40px">
                                        <input type="hidden" name="sessionid" value="<?= $_GET["session"] ?>">
                                        <input type="hidden" name="userid" value="<?= $_SESSION["id"] ?>">
                                        <input class="form-check-input" type="radio" name="candidateid" value="<?= $row["candidateid"] ?>" style="font-size: 20px; border: 2px solid white; background-color: #6A6A6A" required>
                                        <label class="form-check-label" style="font-weight: bold; font-size: 20px; color: orange;"><?= $row["candidatename"] ?></label>
                                    </div>
                                    <br>
                                    <p style="font-weight: bold; margin-left: 10px; margin-bottom: 0; color: white;">Description:</p>
                                    <p style="margin-left: 10px; margin-bottom: 20px; color: white;"><?= $row["candidatedesc"] ?></p><br><br>
                                </div>

                    <?php 
                                $no++;
                            endwhile;
                            mysqli_stmt_close($stmt2);         
                        }
                    ?>

                    </div>

                    <!-- Button trigger modal -->
                    <div style="text-align: center; margin-bottom: 120px;">
                        <a href="#top" class="btn btn-outline-dark" style="margin-right: 20px;">Back to the top</a>
                        <button type="button" class="btn btn-warning" style="margin-left: 20px;" data-bs-toggle="modal" data-bs-target="#exampleModal">Submit Vote</button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to vote for this candidate?</p>
                                <p style="color: red;">Note: You will not be able to vote more than one time, make sure you have selected the candidate properly</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-success" name="vote">Vote</button>
                            </div>
                            </div>
                        </div>
                    </div>

                </form>

        <?php 
            } elseif ($votecasted === 1){
                $sessionsql = "SELECT * FROM votingsession WHERE sessionid = ?;";
                $stmt = mysqli_stmt_init($dbConn);
                if(!mysqli_stmt_prepare($stmt, $sessionsql)){
                    header("Location: userspoll.php?session=". $_GET["session"]."cannotdiaplaysession");
                    echo "statement error";
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "i", $_GET["session"]);
                    mysqli_stmt_execute($stmt);
                    $datareceived = mysqli_stmt_get_result($stmt);
                    while ($row = mysqli_fetch_assoc($datareceived)){
                        echo "<h1 style='text-align: center; margin-top: 40px;'>".$row["sessionname"]."</h1>";
                        echo "<p style='margin: 0 50px 0 50px; font-size: 23px; color: red'>*You have voted for this session, you can not vote more than one time</p>";
                        echo "<a href='viewresult.php?session=".$_GET["session"]."' class='btn btn-warning' style='margin: 0 50px;'>View Result</a>";
                        echo "<p style='margin: 0 50px 0 50px; font-size: 23px; font-weight: bold'>About: </p>";
                        echo "<p style='margin: 0 50px 0 50px; font-size: 18px;'>".$row["sessiondesc"]."</p>";
                    }
                    mysqli_stmt_close($stmt);
                }      
        ?>

                <div style="margin: 0 500px; justify-content: space-between">

                <?php
                    $candidatesql = "SELECT * FROM candidates WHERE sessionid = ?";
                    $stmt2 = mysqli_stmt_init($dbConn);
                    if(!mysqli_stmt_prepare($stmt2, $candidatesql)){
                        header("Location: userspoll.php?session=". $_GET["session"]."cannotdiaplaycandidates");
                        echo "statement error";
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt2, "i", $_GET["session"]);
                        mysqli_stmt_execute($stmt2);
                        $datareceived2 = mysqli_stmt_get_result($stmt2);
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($datareceived2)):
                ?>

                            <div class="form-check" style="margin-bottom: 40px; height: auto; width: auto; box-shadow: 10px 10px 5px grey; background-color: #6A6A6A;">
                                <h5 style="font-weight: bolder; text-align: center; font-size: 25px; color: orange;">Candidate <?= $no ?>: <?= $row["candidatename"]?></h5>
                                <div style="text-align:center;">
                                    <img src="../candidates/<?= $row["candidateimage"] ?>" style="height: 210px; width: auto;">
                                </div>
                                <br>
                                <p style="font-weight: bold; margin-left: 10px; margin-bottom: 0; color: white;">Description:</p>
                                <p style="margin-left: 10px; margin-bottom: 20px; color: white;"><?= $row["candidatedesc"] ?></p><br><br>
                            </div>

                <?php 
                            $no++;
                        endwhile;
                        mysqli_stmt_close($stmt2);         
                    }
                ?>

                </div>
                
        <?php
            }
        ?>

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
