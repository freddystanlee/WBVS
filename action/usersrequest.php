<?php

if(isset($_POST["submitrequest"])) {
    require_once "dbconnection.php";
    require_once "function.php";
    $requestname = mysqli_real_escape_string($dbConn, $_POST["requestname"]);
    $requestdesc = mysqli_real_escape_string($dbConn, $_POST["requestdesc"]);
    $candidates = mysqli_real_escape_string($dbConn, $_POST["candidates"]);
    $userid = mysqli_real_escape_string($dbConn, $_POST["userid"]);

    $sql = "INSERT INTO request (requestname, requestdesc, candidates, userid) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($dbConn);
    //CHECK PREPARED STATEMENT STATUS
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../users/usersrequest.php?error=stmtfailed");
        exit();
    } else{
        mysqli_stmt_bind_param($stmt, "sssi", $requestname, $requestdesc, $candidates, $userid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "
            <script>
                alert('Your request has been submitted. Please wait until approval from admin!');
                window.location.href = '../users/usersrequest.php';
            </script>
        ";
        exit(); 
    }
    
    
    

} else {
    header("Location: ../users/usersrequest.php?requesterror");
    exit();
}