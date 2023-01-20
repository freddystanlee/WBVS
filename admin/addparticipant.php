<?php
    require_once "../action/dbconnection.php";
    session_start();
    if(!isset($_SESSION["admin"])) {
        header("Location: ../index.php");
        exit();
    } elseif (!isset($_GET["session"])) {
        header("Location: viewsession.php");
        exit();    
    }
    $_SESSION["sessionnum"] = $_GET["session"];
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/adminnavbar.css">
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>Add Participant</title>
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
        <div style="margin: 30px 40px 120px 40px;">
            <h3 style="text-align: center;">Add Participant For Session <?= $_SESSION["sessionnum"] ?></h3>
            
            <!-- USERS LIST TABLE -->
            <h4>Users List</h4>
            <table class="table table-hover">
                
                <thead>
                    <tr class="table-dark">
                        <th scope="col">User ID</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $usersql = "SELECT * FROM users;";
                        $stmt1 = mysqli_stmt_init($dbConn);
                        if(!mysqli_stmt_prepare($stmt1, $usersql)){
                            header("Location: addparticipant.php?session=".$_SESSION["sessionnum"]."cannotdisplayusertable");
                            exit();
                        } else {
                            mysqli_stmt_execute($stmt1);
                            $datareceived = mysqli_stmt_get_result($stmt1);
                            $checkresult = mysqli_num_rows($datareceived);
                            if($checkresult > 0){
                            while ($row = mysqli_fetch_assoc($datareceived)) : 
                    ?>

                                <tr>
                                    <td><?= $row["userid"] ?></td>
                                    <td><?= $row["fullname"] ?></td>
                                    <td><?= $row["username"] ?></td>
                                    <td><?= $row["gender"] ?></td>
                                    <td>
                                        <form action="crud.php" method="POST">
                                            <input type="hidden" name="userid" value="<?= $row["userid"] ?>">
                                            <input type="hidden" name="sessionid" value="<?= $_SESSION["sessionnum"]?>">
                                            <button type="submit" name="adduser" class="btn btn-dark">Add This User</button>
                                        </form>
                                    </td>
                                </tr>
                    <?php
                            endwhile;
                            mysqli_stmt_close($stmt1);
                            } else {
                                echo "<p style='color: red; font-size:20px;'>There are no registered users currently</p>";
                            }
                        }      
                        
                    ?>
                </tbody>
            </table>


            <!-- PARTICIPANTS LIST TABLE FOR THE SESSION SELECTED -->
            <h4 style="margin-top: 50px;">Added Participants to Session <?= $_SESSION["sessionnum"] ?></h4>
            <table class="table table-hover">
                <thead>
                    <tr class="table-dark">
                        <th scope="col">Participant ID</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Session ID</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $participantsql = "SELECT participants.participantid, users.fullname, users.gender, participants.sessionid FROM participants INNER JOIN users ON participants.userid = users.userid WHERE participants.sessionid = ?;";
                        $stmt2 = mysqli_stmt_init($dbConn);
                        if(!mysqli_stmt_prepare($stmt2, $participantsql)){
                            header("Location: addparticipant.php?session=".$_SESSION["sessionnum"]."cannotdisplayparticipantstable");
                            exit();
                        } else {
                            mysqli_stmt_bind_param($stmt2, "i", $_SESSION["sessionnum"]);
                            mysqli_stmt_execute($stmt2);
                            $datareceived = mysqli_stmt_get_result($stmt2);
                            $checkresult = mysqli_num_rows($datareceived);
                            if($checkresult > 0){
                                while ($row = mysqli_fetch_assoc($datareceived)) : 
                    ?>              
                                <tr>
                                    <td><?= $row["participantid"] ?></td>
                                    <td><?= $row["fullname"] ?></td>
                                    <td><?= $row["gender"] ?></td>
                                    <td><?= $row["sessionid"] ?></td>
                                    <td>
                                        <form action="crud.php" method="POST">
                                            <input type="hidden" name="participantid" value="<?= $row["participantid"] ?>">
                                            <input type="hidden" name="sessionid" value="<?= $_SESSION["sessionnum"] ?>">
                                            <button type="submit" name="deleteparticipant" class="btn btn-danger">Remove Participant</button>
                                        </form>
                                    </td>
                                </tr>
                            

                    <?php
                                endwhile;
                                mysqli_stmt_close($stmt2);    
                            } else {
                                echo "<p style='color: red; font-size:20px;'>There are no participants in this session currently</p>";
                            }
                            
                        }
                    ?>
                </tbody>
            </table>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>