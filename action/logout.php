<?php

require_once "dbconnection.php";
session_start();
session_unset();
session_destroy();
mysqli_close($dbConn);
header("Location: ../index.php");
exit();
