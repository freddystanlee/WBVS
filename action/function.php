<?php
function invalidfullname($fullname){
    if(!preg_match("/^[a-zA-Z\s]+$/", $fullname)){
        $result = true;
        return $result;
    } else {
        $result = false;
        return $result;   
    }  
}

function invalidusername($username){
    if(!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
        return $result; 
    } else {
        $result = false;
        return $result;   
    }
}

function passmatch ($password, $passwordrpt) {
    
    if($password !== $passwordrpt) {
        $result = true;
        return $result;  
    } else {
        $result = false;
        return $result;  
    }   
}

function usernameexist ($dbConn, $username) {

    $sql = "SELECT * FROM users WHERE username = ?;";
    $stmt = mysqli_stmt_init($dbConn);

    //CHECK PREPARE STATEMENT STATUS
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../registerform.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $datareceived = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($datareceived)){
        return $row;
        //RETURNS IN BOOLEAN
    }else{
        $result = false;
        return $result;      
    }
    mysqli_stmt_close($stmt);
}

function emailexist ($dbConn, $email) {

    $sql = "SELECT * FROM users WHERE email = ?;";
    $stmt = mysqli_stmt_init($dbConn);

    //CHECK PREPARED STATEMENT STATUS
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../registerform.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $datareceived = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($datareceived)){
        return $row;
        //RETURNS IN BOOLEAN
    }else{
        $result = false;
        return $result;    
    }
    mysqli_stmt_close($stmt);
}

function createacc($dbConn, $fullname, $username, $email, $password, $gender, $avatar){
    $sql = "INSERT INTO users(fullname, username, email, password, gender, avatar) VALUES (?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($dbConn);

    //CHECK PREPARED STATEMENT STATUS
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../registerform.php?error=stmtfailed");
        exit();
    }

    $passwordhashed = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssssss", $fullname, $username, $email, $passwordhashed, $gender, $avatar);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    echo "
        <script>
            alert('Account has been created, you can now login!');
            window.location.href = '../loginform.php';
        </script>
    ";
}

function loginacc($dbConn, $username, $password){
    //CALL USERNAME EXIST FUNCTION FROM REGISTER
    $usermatched = usernameexist ($dbConn, $username);
    if($usermatched === false){
        echo "
            <script>
                alert('Your username or password is wrong, please re-enter the correct one');
                window.location.href = '../loginform.php';
            </script>
        ";
    }

    //CHECK PASSWORD RELATED TO USERNAME ENTERED
    $hashedpass = $usermatched ["password"];
    //CHECK HASHED PASS WITH ENTERED PASS, THE RESULT IS BOOLEAN
    $passcheck = password_verify($password, $hashedpass);

    if($passcheck === false){
        echo "
            <script>
                alert('Your username or password is wrong, please re-enter the correct one');
                window.location.href = '../loginform.php';
            </script>
        ";
    } elseif ($passcheck === true){
        session_start();
        $_SESSION["id"] = $usermatched ["userid"];
        $_SESSION["uname"] = $usermatched ["username"];
        $_SESSION["gndr"] = $usermatched ["gender"];
        echo "
            <script>
                alert('Login successfully, welcome!');
                window.location.href = '../users/usershome.php';
            </script>
        ";       
    } 
}

function displayfullname($dbConn){
    $loggedinuser = $_SESSION["id"];
    $sql = "SELECT fullname FROM users WHERE userid = ?;";
    $stmt = mysqli_stmt_init($dbConn);
                    
    //CHECK PREPARED STATEMENT STATUS
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../users/usersprofile.php?error=stmtfailed");
        exit();
    }
                    
    mysqli_stmt_bind_param($stmt, "s", $loggedinuser);
    mysqli_stmt_execute($stmt);
                    
    $datareceived = mysqli_stmt_get_result($stmt);
    while ($gotfullname = mysqli_fetch_assoc($datareceived)) {
        echo $gotfullname['fullname'];
    }
    mysqli_stmt_close($stmt); 
}

function displayusername($dbConn){
    $loggedinuser = $_SESSION["id"];
    $sql = "SELECT username FROM users WHERE userid = ?;";
    $stmt = mysqli_stmt_init($dbConn);
                    
    //CHECK PREPARED STATEMENT STATUS
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../users/usersprofile.php?error=stmtfailed");
        exit();
    }
                    
    mysqli_stmt_bind_param($stmt, "s", $loggedinuser);
    mysqli_stmt_execute($stmt);
                    
    $datareceived = mysqli_stmt_get_result($stmt);
    while ($gotusername = mysqli_fetch_assoc($datareceived)) {
        echo $gotusername['username'];
    }
    mysqli_stmt_close($stmt); 
}

function displayemail($dbConn){
    $loggedinuser = $_SESSION["id"];
    $sql = "SELECT email FROM users WHERE userid = ?;";
    $stmt = mysqli_stmt_init($dbConn);
                    
    //CHECK PREPARED STATEMENT STATUS
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../users/usersprofile.php?error=stmtfailed");
        exit();
    }
                    
    mysqli_stmt_bind_param($stmt, "s", $loggedinuser);
    mysqli_stmt_execute($stmt);
                    
    $datareceived = mysqli_stmt_get_result($stmt);
    while ($gotemail = mysqli_fetch_assoc($datareceived)) {
        echo $gotemail['email'];
    }
    mysqli_stmt_close($stmt);
}

function checkdefaultavatar($dbConn){

    $loggedinuser = $_SESSION["id"];
    $sql = "SELECT avatar FROM users WHERE userid = ?;";
    $stmt = mysqli_stmt_init($dbConn);
                    
    //CHECK PREPARED STATEMENT STATUS
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../users/usersprofile.php?error=stmtfailed");
        exit();
    }
                    
    mysqli_stmt_bind_param($stmt, "s", $loggedinuser);
    mysqli_stmt_execute($stmt);
                    
    $datareceived = mysqli_stmt_get_result($stmt);
    while ($avatarstatus = mysqli_fetch_assoc($datareceived)) {
        if($avatarstatus['avatar'] === "Default"){
            $result = true;
            return $result;
        }
    }
    mysqli_stmt_close($stmt);
}


//USERS PROFILE PICTURE
function updateprofpic($dbConn, $filename, $filesize, $fileerror, $filetmpname){

    $fileext = explode('.', $filename);
    $fileactualext = strtolower(end($fileext));
    $allowedext = array('jpg', 'jpeg', 'png', 'gif');

    // CHECK ALLOWED FILE EXTENSION
    if(in_array($fileactualext, $allowedext)) {
        // CHECK IF UPLOADED FILES HAS AN ERROR
        if($fileerror === 0) {
            session_start();
            $filenewname = $_SESSION["id"].".".$fileactualext;
            $loggedinuser = $_SESSION["id"];

            $sql = "UPDATE users SET avatar = ? WHERE userid = ?;";
            $stmt = mysqli_stmt_init($dbConn);
            
            //CHECK PREPARED STATEMENT STATUS
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../users/usersprofile.php?error=stmtfailed");
                exit();
            }
                            
            mysqli_stmt_bind_param($stmt, "ss", $filenewname, $loggedinuser);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            //SET UPLOAD LOCATION
            $fileuploadlocation = "../users/uploads/".$filenewname;
            move_uploaded_file($filetmpname, $fileuploadlocation);

        } else {
            echo "
                <script>
                    alert('There was an error uploading your file');
                    window.location.href = '../users/usersprofile.php';
                </script>
            ";
            exit();
        }

    } else {
        echo "
            <script>
                alert('Please choose the correct file extension');
                window.location.href = '../users/usersprofile.php';
            </script>
        ";
        exit();
    }
}

function displayprofpic ($dbConn){
    $loggedinuser = $_SESSION["id"];
    $sql = "SELECT avatar FROM users WHERE userid = ?;";
    $stmt = mysqli_stmt_init($dbConn);
                    
    //CHECK PREPARED STATEMENT STATUS
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../users/usersprofile.php?error=stmtfailed");
        exit();
    }
              
    mysqli_stmt_bind_param($stmt, "s", $loggedinuser);
    mysqli_stmt_execute($stmt);

    $datareceived = mysqli_stmt_get_result($stmt);
    while ($gotavatar = mysqli_fetch_assoc($datareceived)) {
        echo "<img src='uploads/" . $gotavatar['avatar'] . "' alt='avatar'>";
    }
    mysqli_stmt_close($stmt);
}


//ADMIN LOGIN
function adminunameexist ($dbConn, $adminuname) {

    $sql = "SELECT * FROM admin WHERE adminuname = ?;";
    $stmt = mysqli_stmt_init($dbConn);

    //CHECK PREPARE STATEMENT STATUS
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../registerform.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $adminuname);
    mysqli_stmt_execute($stmt);
    $datareceived = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($datareceived)){
        return $row;
        //RETURNS IN BOOLEAN
    }else{
        $result = false;
        return $result;      
    }
    mysqli_stmt_close($stmt);
}

function loginadmin($dbConn, $adminuname, $adminpassword){
    //CALL USERNAME EXIST FUNCTION FROM REGISTER
    $adminmatched = adminunameexist ($dbConn, $adminuname);
    if($adminmatched === false){
        echo "
            <script>
                alert('Your username or password is wrong, please re-enter the correct one');
                window.location.href = '../admin/adminlogin.php';
            </script>
        ";
    }

    //CHECK PASSWORD RELATED TO USERNAME ENTERED
    $hashedpass = $adminmatched ["adminpassword"];
    //CHECK HASHED PASS WITH ENTERED PASS, THE RESULT IS BOOLEAN
    $passcheck = password_verify($adminpassword, $hashedpass);

    if($passcheck === false){
        echo "
            <script>
                alert('Your username or password is wrong, please re-enter the correct one');
                window.location.href = '../admin/adminlogin.php';
            </script>
        ";
    } elseif ($passcheck === true){
        session_start();
        $_SESSION["admin"] = $adminmatched ["adminid"];
        
        echo "
            <script>
                alert('Login successfully, welcome admin!');
                window.location.href = '../admin/adminhome.php';
            </script>
        ";       
    } 
}

//CREATING SESSION PROCESSES
function sessionnameexist($dbConn, $sessionname){
    $sql = "SELECT sessionname FROM votingsession WHERE sessionname = ?;";
    $stmt = mysqli_stmt_init($dbConn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../users/userssession.php?stmtfailed");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $sessioinname);
        mysqli_stmt_execute($stmt);
        $datareceived = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($datareceived)){
            return $row;
            //RETURNS IN BOOLEAN
        }else{
            $result = false;
            return $result;      
        }
        mysqli_stmt_close($stmt);
    }
}

function createsession($dbConn, $sessionname, $sessiondesc){
    
    $sql = "INSERT INTO votingsession (sessionname, sessiondesc) VALUE (?, ?);";
    $stmt = mysqli_stmt_init($dbConn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../users/userssession.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $sessionname, $sessiondesc);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

//CHECK UNIQUE CANDIDATE NAMES
function checkifunique($candidatename){
    if(count(array_unique($candidatename)) == count($candidatename)){
        $result = true;
        return $result;
    } else {
        $result = false;
        return $result;
    }
}


function checkparticipant($dbConn, $userid, $sessionid){
    $sql = "SELECT * FROM participants WHERE userid = ? AND sessionid = ?;";
    $stmt = mysqli_stmt_init($dbConn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: addparticipant.php?session=".$sessionid."");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ii", $userid, $sessionid);
        mysqli_stmt_execute($stmt);
        $datareceived = mysqli_stmt_get_result($stmt);
        $checkresult = mysqli_num_rows($datareceived);
        if($checkresult > 0){
            $result = true;
            return $result;
        } else {
            $result = false;
            return $result;
        }
    }
}