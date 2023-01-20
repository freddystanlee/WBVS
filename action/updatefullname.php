<?php

if(isset($_POST["updatefullname"])){
    require_once "dbconnection.php";
    require_once "function.php";
    $fullname = $_POST["fullname"];

    if(invalidfullname($fullname) !== false){
        echo "
            <script>
                alert('Please enter a valid fullname with alphabets only!');
                window.location.href = '../users/usersprofile.php';
            </script>
        ";
        exit();
    }

    session_start();
    $loggedinuser = $_SESSION["id"];
    $sql = "UPDATE users SET fullname = ? WHERE userid = ?;";
    $stmt = mysqli_stmt_init($dbConn);
                
    //CHECK PREPARED STATEMENT STATUS
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../users/usersprofile.php?error=stmtfailed");
        exit();
    }
                       
    mysqli_stmt_bind_param($stmt, "ss", $fullname, $loggedinuser);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    echo "
        <script>
            alert('Full Name updated!');
            window.location.href = '../users/usersprofile.php';
        </script> 
    ";
    exit();

} else {
    header("Location: ../users/usersprofile.php?error");
    exit();
}