<?php 

if(isset($_POST["updateusername"])){
    require_once "dbconnection.php";
    require_once "function.php";
    $username = $_POST["usrname"];

    if(invalidusername($username) !== false){
        echo "
            <script>
                alert('Please enter a valid username with alphabets or numbers only!');
                window.location.href = '../users/usersprofile.php';
            </script>
        ";
        exit();
    }
    if(usernameexist ($dbConn, $username) !== false){
        echo "
            <script>
                alert('Username has already been taken, please enter a different username!');
                window.location.href = '../users/usersprofile.php';
            </script>
        ";
        exit();

    }
    
    session_start();
    $loggedinuser = $_SESSION["id"];
    $sql = "UPDATE users SET username = ? WHERE userid = ?;";
    $stmt = mysqli_stmt_init($dbConn);
                
    //CHECK PREPARED STATEMENT STATUS
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../users/usersprofile.php?error=stmtfailed");
        exit();
    }
                       
    mysqli_stmt_bind_param($stmt, "ss", $username, $loggedinuser);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    echo "
        <script>
            alert('Username updated!');
            window.location.href = '../users/usersprofile.php';
        </script> 
    ";
    exit();

    

} else {
    header("Location: ../users/usersprofile.php?error");
    exit();
}