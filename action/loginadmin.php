<?php

if(isset($_POST["login"])) {
    require_once "dbconnection.php";
    require_once "function.php";
    $adminuname = mysqli_real_escape_string($dbConn, $_POST["usrname"]);
    $adminpassword = mysqli_real_escape_string($dbConn, $_POST["pass"]);

    loginadmin($dbConn, $adminuname, $adminpassword);
    
    exit(); 

} else {
    header("Location: ../loginform.php?login=error");
    exit();
}