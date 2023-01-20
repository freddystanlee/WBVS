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
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/adminnavbar.css">
        <link rel="stylesheet" href="../css/createsession.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>Voting Session</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="../js/addcandidate.js"></script>
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
        <h1 class="page-title" style="text-align: center; margin-top: 30px;">Create Voting Session</h1>
        


        <form method="POST" action="../action/createsession.php" enctype="multipart/form-data" style="margin: 0 50px 120px 50px;">     
            <div class="mb-4">
                <label for="sessionname" class="form-label">Session Name (Title of your voting session)</label>
                <input type="text" class="form-control" name="sessionname" id="sessionname" required>
            </div>
            <div class="mb-4">
                <label for="sessiondesc" class="form-label">Session Description</label>
                <textarea class="form-control" name="sessiondesc" id="sessiondesc" rows="3" required></textarea>
            </div>

            <div class="candidatessection">
                <h4>Add Candidates to the Voting Session</h4>
                <table class="table table-hover">
                    <thead>
                        <tr class="table-dark">
                            <th scope="col">Candidate Name</th>
                            <th scope="col">Candidate Description</th>
                            <th scope="col">Candidate Image</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="candidatefield">
                        <tr>
                            <td>
                                <div class="form-floating mb-3">
                                    <input class="form-control" type="text" name="candidatename[]" id="candidatename" required>
                                    <label for="candidatename">Candidate Name</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" type="text" name="candidatedesc[]" id="candidatedesc" style="height: 200px;" required></textarea>
                                    <label for="candidatedesc">Candidate Description</label>
                                </div>
                            </td>
                            <td>
                                <div class="mb-3">
                                    <p>*Please keep the file extensions in jpg, jpeg, png, gif</p>
                                    <input class="form-control" type="file" name="candidateimage[]" id="candidateimage" required>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-floating mb-3">
                                    <input class="form-control" type="text" name="candidatename[]" id="candidatename" required>
                                    <label for="candidatename">Candidate Name</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" type="text" name="candidatedesc[]" id="candidatedesc" style="height: 200px;" required></textarea>
                                    <label for="candidatedesc">Candidate Description</label>
                                </div>
                            </td>
                            <td>
                                <div class="mb-3">
                                    <input class="form-control" type="file" name="candidateimage[]" id="candidateimage" required>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-dark" type="button" name="addcandidate" id="addcandidate">Add More Candidate</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">Create Session</button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">Are you sure you want to create this session?</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-success" name="create">Create</button>
                    </div>
                    </div>
                </div>
            </div>
        </form>
        
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
