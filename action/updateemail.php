<?php 

if(isset($_POST["updateemail"])){
    require_once "dbconnection.php";
    require_once "function.php";
    $email = $_POST["email"];

    if(emailexist ($dbConn, $email) !== false){
        echo "
            <script>
                alert('Email has already been taken, please enter a different email!');
                window.location.href = '../users/usersprofile.php';
            </script>
        ";
        exit();
    }

    session_start();
    $loggedinuser = $_SESSION["id"];
    $sql = "UPDATE users SET email = ? WHERE userid = ?;";
    $stmt = mysqli_stmt_init($dbConn);
                
    //CHECK PREPARED STATEMENT STATUS
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../users/usersprofile.php?error=stmtfailed");
        exit();
    }
                       
    mysqli_stmt_bind_param($stmt, "ss", $email, $loggedinuser);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    echo "
        <script>
            alert('Email updated!');
            window.location.href = '../users/usersprofile.php';
        </script> 
    ";
    exit();

    

} else {
    header("Location: ../users/usersprofile.php?error");
    exit();
}