<?php
    require_once "../action/dbconnection.php";
    require_once "../action/function.php";
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
        <title>Manage Users</title>
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

        <h1 style="text-align: center; margin-top: 40px;">All Users</h1>

        <div style="margin: 0 50px">
            <table class="table table-hover" style="margin-right: 20px;">
                <thead>
                    <tr class="table-dark">
                        <th scope="col">User ID</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM users;";
                        $stmt = mysqli_stmt_init($dbConn);
                        if(!mysqli_stmt_prepare($stmt, $sql)){
                            header("Location: ../admin/manageusers.php?error=stmtfailed");
                            echo "Statement error, cannot display users";
                            exit();
                        } else {
                            mysqli_stmt_execute($stmt);
                            $datareceived = mysqli_stmt_get_result($stmt);
                            $checkresult = mysqli_num_rows($datareceived);
                            if($checkresult > 0){
                                while ($row = mysqli_fetch_assoc($datareceived)) :?>
                    
                                    <tr>
                                        <td><?= $row["userid"] ?></td>
                                        <td><?= $row["fullname"] ?></td>
                                        <td><?= $row["username"] ?></td>
                                        <td><?= $row["email"] ?></td>
                                        <td><?= $row["gender"] ?></td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete User</button>
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
                                            <div class="modal-body">Are you sure you want to delete this user?</div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                                <a href="crud.php?deleteuser=<?= $row["userid"] ?>" class="btn btn-outline-danger">Delete</a>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                    <?php 
                                endwhile;
                                mysqli_stmt_close($stmt);
                            } else {
                                echo "<p style='color: red; font-size:20px;'>There are no users that exist currently</p>";
                            }
                        
                        }
                    ?>    

                    
                </tbody>
            </table>
        </div>

        

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>