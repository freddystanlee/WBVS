<?php
    session_start();
    if(isset($_SESSION["id"], $_SESSION["uname"])) {
        header("Location: ../users/usershome.php");
        exit();
    } elseif(isset($_SESSION["admin"])) {
        header("Location: adminhome.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/adminloginform.css">
        <title>Admin</title>
    </head>
    <body>
        <div class="adminlogin"> 
            <form action="../action/loginadmin.php" method="POST">
                <h2 class="title">Admin Login</h2>
                <div>
                    <label for="usrname">Username</label><br>
                    <input type="text" name="usrname" id="usrname" placeholder="Enter your username here..." required>
                </div>
                <div>
                    <label for="pass">Password</label><br>
                    <input type="password" name="pass" id="pass" placeholder="Enter your password here..." required>
                </div>
                <div>
                    <button type="reset" class="resetbtn">Reset</button>
                    <button type="submit" class="loginbtn" name="login">Login</button>
                </div>
            </form>
        </div>
    </body>
</html> 
        
        
        
        
        
        
        