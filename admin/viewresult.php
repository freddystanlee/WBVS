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
        <link rel="stylesheet" href="../css/usersnavbar.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>View Result</title>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            // Load google charts
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            // Draw the chart and set the chart values
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Candidates Name', 'Votes'],
                    <?php 
                        $candidatesql = "SELECT candidatename, votes FROM candidates WHERE sessionid = ?;";
                        $stmt = mysqli_stmt_init($dbConn);
                        if(!mysqli_stmt_prepare($stmt, $candidatesql)){
                            header("Location: userspoll.php?session=". $_GET["session"]."cannotdisplaycandidates");
                            echo "statement error";
                            exit();
                        } else {
                            mysqli_stmt_bind_param($stmt, "i", $_GET["session"]);
                            mysqli_stmt_execute($stmt);
                            $datareceived = mysqli_stmt_get_result($stmt);
                            while ($row = mysqli_fetch_assoc($datareceived)){
                                echo "['".$row["candidatename"]."', ".$row["votes"]."],";
                            }
                            mysqli_stmt_close($stmt);  
                        } 
                    ?>
                ]);

                // Optional; add a title and set the width and height of the chart
                var options = {'title':'Voting Result', 'width':'auto', 'height':500};

                // Display the chart inside the <div> element with id="piechart"
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(data, options);
            }
        </script>
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
        
        <?php 
            $sessionsql = "SELECT * FROM votingsession WHERE sessionid = ?;";
            $stmt2 = mysqli_stmt_init($dbConn);
            if(!mysqli_stmt_prepare($stmt2, $sessionsql)){
                header("Location: userspoll.php?session=". $_GET["session"]."cannotdiaplaysession");
                echo "statement error";
                exit();
            } else {
                mysqli_stmt_bind_param($stmt2, "i", $_GET["session"]);
                mysqli_stmt_execute($stmt2);
                $datareceived = mysqli_stmt_get_result($stmt2);
                while ($row = mysqli_fetch_assoc($datareceived)) :?>
                    <h1 style="text-align: center; margin-top: 40px;"><?= $row["sessionname"]; ?></h1>
                    <p style="margin: 0 50px 0 50px; font-size: 23px; font-weight: bold">About: </p>
                    <p style="margin: 0 50px 0 50px; font-size: 18px;"><?=$row["sessiondesc"]; ?></p><br>   
        <?php 
                    
                endwhile;
                mysqli_stmt_close($stmt2);         
            }
        ?>
        <div style="margin-left: 50px;">
            <a href="viewsession.php" class="btn btn-warning">Go Back To Voting Session</a>
        </div>

        <div id="piechart" style="width: auto; height: auto;"></div>
        
        

        <div style="margin: 0 500px; justify-content: space-between">
            <?php
                $candidatesql = "SELECT * FROM candidates WHERE sessionid = ?";
                $stmt3 = mysqli_stmt_init($dbConn);
                if(!mysqli_stmt_prepare($stmt3, $candidatesql)){
                    header("Location: userspoll.php?session=". $_GET["session"]."cannotdiaplaycandidates");
                    echo "statement error";
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt3, "i", $_GET["session"]);
                    mysqli_stmt_execute($stmt3);
                    $datareceived2 = mysqli_stmt_get_result($stmt3);
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($datareceived2)) :?>
                        <div class="form-check" style="margin-bottom: 40px; height: auto; width: auto; box-shadow: 10px 10px 5px grey; background-color: #424242;">
                            <h5 style="font-weight: bolder; text-align: center; font-size: 25px; color: orange;">Candidate <?= $no. ": ". $row["candidatename"] ?></h5>
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
                    mysqli_stmt_close($stmt3);         
                }
            ?>
        </div>

        <div style="text-align: center;">
                <a href="#top" class="btn btn-outline-dark">Back to the top</a>
        </div>
            
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>