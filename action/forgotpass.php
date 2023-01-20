<?php

require_once "dbconnection.php";
require_once "function.php";

if(isset($_POST["submit"])){
    $email = mysqli_real_escape_string($dbConn, $_POST["email"]);

    $sql = "SELECT email FROM users WHERE email = ?;";
    $stmt = mysqli_stmt_init($dbConn);
    //CHECK PREPARED STATEMENT STATUS
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../forgotpass.php?error=stmtfailed");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $datareceived = mysqli_stmt_get_result($stmt);
        $checkresult = mysqli_num_rows($datareceived);
        if($checkresult === 1){
            $resettoken = "";
            while($row = mysqli_fetch_assoc($datareceived)){
                session_start();
                $resettoken = uniqid();
                $_SESSION["resetpass"] = $row["email"];
                $_SESSION["resettoken"] = $resettoken;
            }
            header("Location: ../resetpass.php?reset=".$resettoken."");
        } else {
            echo "
                <script>
                    alert('Email does not exist, please enter a valid email to reset');
                    window.location.href = '../forgotpass.php';
                </script>
            ";
            exit();
        }
    }
} 
