<?php

if(isset($_POST["submit"])) {
    require_once "dbconnection.php";
    require_once "function.php";
    $fullname = mysqli_real_escape_string($dbConn, $_POST["fullname"]);
    $username = mysqli_real_escape_string($dbConn, $_POST["usrname"]);
    $email = mysqli_real_escape_string($dbConn, $_POST["email"]);
    $password = mysqli_real_escape_string($dbConn, $_POST["pass"]);
    $passwordrpt = mysqli_real_escape_string($dbConn, $_POST["passrpt"]);
    $gender = mysqli_real_escape_string($dbConn, $_POST["gender"]);
    $avatar = "Default";

    if(invalidfullname($fullname) !== false){
        echo "
            <script>
                alert('Please enter a valid fullname with alphabets only!');
                window.location.href = '../registerform.php';
            </script>
        ";
        exit();
    }
    if(invalidusername($username) !== false){
        echo "
            <script>
                alert('Please enter a valid username with alphabets or numbers only!');
                window.location.href = '../registerform.php';
            </script>
        ";
        exit();
    }

    if(passmatch($password, $passwordrpt) !== false){
        echo "
            <script>
                alert('Password does not match, please match the password entered!');
                window.location.href = '../registerform.php';
            </script>
        ";
        exit();
    }

    if(usernameexist($dbConn, $username) !== false){
        echo "
            <script>
                alert('Username has already been taken, please enter a different username!');
                window.location.href = '../registerform.php';
            </script>
        ";
        exit();
    }

    if(emailexist($dbConn, $email) !== false){
        echo "
            <script>
                alert('Email has already been taken, please enter a different email!');
                window.location.href = '../registerform.php';
            </script>
        ";
        exit();
    }

    createacc($dbConn, $fullname, $username, $email, $password, $gender, $avatar);
    
    exit();

}else{
    header("Location: ../registerform.php?signup=error");
    exit();
}