<?php

if(isset($_POST["login"])) {
    require_once "dbconnection.php";
    require_once "function.php";
    $username = mysqli_real_escape_string($dbConn, $_POST["usrname"]);
    $password = mysqli_real_escape_string($dbConn, $_POST["pass"]);

    loginacc($dbConn, $username, $password);
    
    exit(); 

} else {
    header("Location: ../loginform.php?login=error");
    exit();
}


