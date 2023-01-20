<?php

if(isset($_POST["updateprofpic"])) {
    // UPLOADED FILES DETAILS
    require_once "dbconnection.php";
    require_once "function.php";
    $filename = $_FILES['file']['name'];
    $filesize = $_FILES['file']['size'];
    $fileerror = $_FILES['file']['error'];
    $filetmpname = $_FILES['file']['tmp_name'];

    updateprofpic($dbConn, $filename, $filesize, $fileerror, $filetmpname);
    
    echo "
        <script>
            alert('Profile Picture Updated');
            window.location.href = '../users/usersprofile.php';
        </script>
    ";
    
    exit();
} else {
    header("Location: ../users/usersprofile.php?error");
    exit();
}