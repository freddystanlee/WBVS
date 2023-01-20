<?php

if(isset($_POST["vote"])){
    require_once "dbconnection.php";
    require_once "function.php";
    $candidateid = $_POST["candidateid"];
    $sessionid = $_POST["sessionid"];
    $userid = $_POST["userid"];
    
    //TAKING THE AMOUNT GF VOTES FOR THE SELECTED CANDIDATES
    $candidatesql = "SELECT votes FROM candidates WHERE candidateid = ?";
    $stmt = mysqli_stmt_init($dbConn);
    $votecount;
    if(!mysqli_stmt_prepare($stmt, $candidatesql)){
        header("Location: ../users/userssession.php?cannotvote");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "i", $candidateid);
        mysqli_stmt_execute($stmt);
        $datareceived = mysqli_stmt_get_result($stmt);
        while($row = mysqli_fetch_assoc($datareceived)){
            $votecount = $row["votes"];
        }
        mysqli_stmt_close($stmt);
    }

    //ADDING 1 VOTE COUNT TO THE CANDIDATE
    $addedvote = $votecount + 1;
    $addedsql = "UPDATE candidates SET votes = ? WHERE candidateid = ?;";
    $stmt2 = mysqli_stmt_init($dbConn);
    if(!mysqli_stmt_prepare($stmt2, $addedsql)){
        header("Location: ../users/userssession.php?cannotvote");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt2, "ii", $addedvote, $candidateid);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);
    }

    //RETRIEVE WHICH PARTICIPANT THAT VOTE
    $statussql = "SELECT participantid FROM participants WHERE userid = ? AND sessionid = ?;";
    $stmt3 = mysqli_stmt_init($dbConn);
    $participantid;
    if(!mysqli_stmt_prepare($stmt3, $statussql)){
        header("Location: ../users/userssession.php?cannotvote");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt3, "ii", $userid, $sessionid);
        mysqli_stmt_execute($stmt3);
        $datareceived = mysqli_stmt_get_result($stmt3);
        while($row = mysqli_fetch_assoc($datareceived)){
            $participantid = $row["participantid"];
        }
        mysqli_stmt_close($stmt3);
    }

    //UPDATE PARTICIPANT STATUS
    $updatestatus = 1;
    $updatesql = "UPDATE participants SET votecasted = ? WHERE participantid = ?;";
    $stmt4 = mysqli_stmt_init($dbConn);
    if(!mysqli_stmt_prepare($stmt4, $updatesql)){
        header("Location: ../users/userssession.php?cannotvote");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt4, "ii", $updatestatus, $participantid);
        mysqli_stmt_execute($stmt4);
        mysqli_stmt_close($stmt4);
    }
    echo "
        <script>
            alert('You have submitted your vote, thank you!');
            window.location.href = '../users/viewresult.php?session=".$sessionid."';
        </script>
    ";

    

} else {

}
    