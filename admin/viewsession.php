<?php
    require_once "../action/dbconnection.php";
    session_start();
    if(!isset($_SESSION["admin"])) {
        header("Location: ../index.php");
        exit();
    }
    
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/adminnavbar.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>View Session</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

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

        <h1 style="text-align: center; margin-top: 40px;">All Voting Sessions</h1>

        <div style="margin: 0 50px">
            <table class="table table-hover" style="margin-right: 20px;">
                <thead>
                    <tr class="table-dark">
                        <th scope="col">Session ID</th>
                        <th scope="col">Session Name</th>
                        <th scope="col">Session Description</th>
                        <th scope="col">Candidates</th>
                        <th scope="col">Action</>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sessionsql = "SELECT * FROM votingsession;";
                        $stmt = mysqli_stmt_init($dbConn);
                        if(!mysqli_stmt_prepare($stmt, $sessionsql)){
                            header("Location: ../admin/viewsession.php?error=stmtfailed");
                            exit();
                        } else {
                            mysqli_stmt_execute($stmt);
                            $datareceived = mysqli_stmt_get_result($stmt);
                            $checkresult = mysqli_num_rows($datareceived);
                            if($checkresult > 0){
                                while ($row = mysqli_fetch_assoc($datareceived)) :?>
                    
                                    <tr>
                                        <td><?= $row["sessionid"] ?></td>
                                        <td><?= $row["sessionname"] ?></td>
                                        <td><?= $row["sessiondesc"] ?></td>
                                        <td>
                                            <ul>
                                                <?php 
                                                    $candidatesession = $row["sessionid"];
                                                    $candidatesql = "SELECT candidatename FROM candidates WHERE sessionid = '$candidatesession';";
                                                    $execute = mysqli_query($dbConn, $candidatesql);
                                                    while ($candidaterow = mysqli_fetch_assoc($execute)){
                                                        echo "<li>".$candidaterow["candidatename"]."</li>";
                                                    } 
                                                ?>
                                            </ul>
                                        </td>
                                        <td>
                                            <a href="addparticipant.php?session=<?= $row["sessionid"] ?>" class="btn btn-dark">Add Participants</a>
                                            <a href="viewresult.php?session=<?= $row["sessionid"] ?>" class="btn btn-warning">View Result</a>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete Session</button>
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">Are you sure you want to delete this session?</div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                                <a href="crud.php?deletesession=<?= $row["sessionid"] ?>" class="btn btn-danger">Delete</a>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                    <?php 
                                endwhile;
                                mysqli_stmt_close($stmt);
                            } else {
                                echo "<p style='color: red; font-size:20px;'>There are no sessions that exist currently</p>";
                            }
                        
                        }
                    ?>    

                    
                </tbody>
            </table>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>