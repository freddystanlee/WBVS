<?php
require_once "../action/dbconnection.php";
require_once "../action/function.php";
if(isset($_GET["deletesession"])){
    
    $sessionid = $_GET["deletesession"];
    //Retrieve candidates file name first
    $sql ="SELECT candidateimage FROM candidates WHERE sessionid = ?;";
    $stmt = mysqli_stmt_init($dbConn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../admin/viewsession.php?error=candidateimagefailed");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "i", $sessionid);
        mysqli_stmt_execute($stmt);
        $datareceived = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($datareceived)){
            $deletepath = "../candidates/".$row["candidateimage"];
            if(!unlink($deletepath)){
                echo "
                    <script>
                        alert('Candidate images failed to delete');
                        window.location.href = 'viewsession.php';
                    </script>
                ";
            } 
        }
        mysqli_stmt_close($stmt);
    }

    $sql2 = "DELETE FROM votingsession WHERE sessionid = ?;";
    $stmt2 = mysqli_stmt_init($dbConn);
    if(!mysqli_stmt_prepare($stmt2, $sql2)){
        header("Location: ../admin/viewsession.php?error=deletefailed");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt2, "i", $sessionid);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);

        echo "
            <script>
                alert('Voting session has been deleted including its candidates and participants');
                window.location.href = 'viewsession.php';
            </script>
        ";
    }
}

if(isset($_GET["deleterequest"])){
    $requestid = $_GET["deleterequest"];
    
    $sql = "DELETE FROM request WHERE requestid = ?;";
    $stmt = mysqli_stmt_init($dbConn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../admin/viewsession.php?error=deletefailed");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "i", $requestid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        echo "
            <script>
                alert('Request has been deleted!');
                window.location.href = 'adminrequest.php';
            </script>
        ";
    }

}

if(isset($_POST["adduser"])){
    $userid = $_POST["userid"];
    $sessionid = $_POST["sessionid"];
    $votecasted = 0;

    //FIRST CHECK IF USER IS ALREADY IN THE VOTING SESSION 
    if(checkparticipant($dbConn, $userid, $sessionid) !== false){
        echo "
            <script>
                alert('Users has already been added as a participant for this session, please add a different user!');
                window.location.href = 'addparticipant.php?session=".$sessionid."';
            </script>
        ";
        exit();
    }
    
    $sql = "INSERT INTO participants (votecasted, sessionid, userid) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($dbConn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: addparticipant.php?session=".$sessionid."");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "iii", $votecasted, $sessionid, $userid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "
            <script>
                alert('Users has been added as a participant');
                window.location.href = 'addparticipant.php?session=".$sessionid."';
            </script>
        ";
    }

}

if(isset($_POST["deleteparticipant"])){
    $participantid = $_POST["participantid"];
    $sessionid = $_POST["sessionid"];
    $sql = "DELETE FROM participants WHERE participantid = ?;";
    $stmt = mysqli_stmt_init($dbConn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../admin/viewsession.php?error=deletefailed");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "i", $participantid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        echo "
            <script>
                alert('Participant has been deleted!');
                window.location.href = 'addparticipant.php?session=".$sessionid."';
            </script>
        ";
    }
}

if(isset($_GET["deleteuser"])){

    //Deleting users image first
    $userid = $_GET["deleteuser"];

    $deletejpg = "../users/uploads/".$userid.".jpg";
    $deletejpeg = "../users/uploads/".$userid.".jpeg";
    $deletepng = "../users/uploads/".$userid.".png";
    $deletegif = "../users/uploads/".$userid.".gif";
    unlink($deletejpg);
    unlink($deletejpeg);
    unlink($deletepng);
    unlink($deletegif);

    //DELETING USERS DATA
    $sql = "DELETE FROM users WHERE userid = ?;";
    $stmt = mysqli_stmt_init($dbConn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../admin/manageusers.php?error=deletefailed");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "i", $userid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        echo "
            <script>
                alert('User has been deleted');
                window.location.href = 'manageusers.php';
            </script>
        ";
    }
    
}