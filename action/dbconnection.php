<?php 

$serverName = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "wbvs";

$dbConn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

if (!$dbConn){
    die("Database Connection Failed: " . mysqli_connect_error());
}