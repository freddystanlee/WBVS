<?php

require_once "dbconnection.php";

if(isset($_POST["submit"])){
    $email = mysqli_real_escape_string($dbConn, $_POST["email"]);
    $password = mysqli_real_escape_string($dbConn, $_POST["password"]);
    $passwordrpt = mysqli_real_escape_string($dbConn, $_POST["passwordrpt"]);
    $resettoken = $_POST["resettoken"];
    
    if($password !== $passwordrpt){
        echo "
            <script>
                alert('Password do not match, please match the password entered');
                window.location.href = '../resetpass.php?reset=".$resettoken."';
            </script>
        ";
        exit();
    }

    $passwordhashed = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE users SET password = ? WHERE email = ?;";
    $stmt = mysqli_stmt_init($dbConn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../resetpass.php?reset=".$resettoken."");
        exit();
    }else {
        mysqli_stmt_bind_param($stmt, "ss", $passwordhashed, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        session_start();
        session_unset();
        session_destroy();

        echo "
            <script>
                alert('Password has been reset');
                window.location.href = '../loginform.php';
            </script>
        ";
        exit();
    }
} 
