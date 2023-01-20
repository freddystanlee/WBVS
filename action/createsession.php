<?php

if(isset($_POST["create"])) {
    require_once "dbconnection.php";
    require_once "function.php";
    $sessionname = mysqli_real_escape_string($dbConn, $_POST["sessionname"]);
    $sessiondesc = mysqli_real_escape_string($dbConn, $_POST["sessiondesc"]);

    //CANDIDATES DATA
    $candidatename = $_POST["candidatename"];
    $candidatedesc = $_POST["candidatedesc"];
    $filename = $_FILES["candidateimage"]["name"];
    $fileerror = $_FILES["candidateimage"]["error"];
    $filetmpname = $_FILES["candidateimage"]["tmp_name"];
    $votecount = 0;

    if(sessionnameexist($dbConn, $sessionname) !== false){
        echo "
            <script>
                alert('Session name already exist, please try another session name!');
                window.location.href = '../admin/adminsession.php';
            </script>
        "; 
        exit();
    }
    if(checkifunique($candidatename) !== true){
        echo "
            <script>
                alert('Please enter different for each candidate name, so that they are unique to each other!');
                window.location.href = '../admin/adminsession.php';
            </script>
        ";
        exit();
    }

    createsession($dbConn, $sessionname, $sessiondesc);


    //RETRIEVING SESSION ID TO BE ASSIGNED TO CANDIDATES
    $sql = "SELECT sessionid FROM votingsession WHERE sessionname = ?;";
    $stmt = mysqli_stmt_init($dbConn);
                    
    //CHECK PREPARED STATEMENT STATUS
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../admin/adminsession.php?error=stmtfailed");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $sessionname);
        mysqli_stmt_execute($stmt);
                        
        $datareceived = mysqli_stmt_get_result($stmt);
        while ($gotsessionid = mysqli_fetch_assoc($datareceived)) {
            $sessionid = $gotsessionid['sessionid'];
        }
        mysqli_stmt_close($stmt);
    }
    
    //LOOPING EACH CANDIDATES DATA
    foreach($candidatename as $key => $value){
        $fileext = explode('.', $filename[$key]);
        $fileactualext = strtolower(end($fileext));
        $allowedext = array('jpg', 'jpeg', 'png', 'gif');

        // CHECK ALLOWED FILE EXTENSION
        if(in_array($fileactualext, $allowedext)) {
            // CHECK IF UPLOADED FILES HAS AN ERROR
            if($fileerror[$key] === 0) {

                    $newfilename = uniqid("$candidatename[$key]").".".$fileactualext;
                    $sql = "INSERT INTO candidates(candidatename, candidatedesc, candidateimage, votes, sessionid) VALUES(?, ?, ?, ?, ?);";
                    $stmt = mysqli_stmt_init($dbConn);
                    
                    //CHECK PREPARED STATEMENT STATUS
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        header("Location: ../admin/adminsession.php?error=candidatestmtfailed");
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "sssii", $candidatename[$key], $candidatedesc[$key], $newfilename, $votecount, $sessionid);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_close($stmt);

                        //SET UPLOAD LOCATION
                        $fileuploadlocation = "../candidates/".$newfilename;
                        move_uploaded_file($filetmpname[$key], $fileuploadlocation);
                    }

            } else {
                echo "
                    <script>
                        alert('There was an error uploading your file');
                        window.location.href = '../admin/adminsession.php';
                    </script>
                ";
                exit();
            }

        } else {
            echo "
                <script>
                    alert('Please keep the file extension in jpg, jpeg, png, gif');
                    window.location.href = '../admin/adminsession.php';
                </script>
            ";
            exit();
        }
    }
    
    echo "
        <script>
            alert('Voting Session has been created!');
            window.location.href = '../admin/viewsession.php';
        </script>
    ";
    exit();

}else{
    header("Location: ../admin/adminsession.php?error=failedtocreate");
    exit();
}