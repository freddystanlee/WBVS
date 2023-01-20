<?php
    require_once "../action/dbconnection.php";
    require_once "../action/function.php";
    session_start();
    if(!isset($_SESSION["id"], $_SESSION["uname"])) {
        header("Location: ../index.php");
        exit();
    }  
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/usersnavbar.css">
        <link rel="stylesheet" href="../css/profilepage.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>Profile</title>
        
    </head>
    <body>
        <header>
            <a class="logo" href="usershome.php">WBVS</a>
            <nav>
                <ul class="navlinks">
                    <li><a href="usershome.php">Home</a></li>
                    <li><a href="userssession.php">Voting Session</a></li>
                    <li><a href="usersprofile.php">Profile</a></li>
                    <li><a href="usersrequest.php">Request Admin</a></li>
                </ul>
            </nav>
            <div class="logout-btn">
                <a href="../action/logout.php"><button>LOGOUT</button></a>
            </div>
        </header>
        <div class="profile"> 
            <div class="profile-title">
                <h2>Profile</h2>
            </div>
            <div class="picture">
                <?php 
                    if(checkdefaultavatar($dbConn) === true){
                        if($_SESSION["gndr"] === "Male") {
                            echo "<img src='defaultavatar/defaultmaleavatar.jpg' alt='defaultmale'>";
                        } elseif($_SESSION["gndr"] === "Female") {
                            echo "<img src='defaultavatar/defaultfemaleavatar.jpg' alt='defaultfemale'>";
                        } 
                    } else {
                        displayprofpic ($dbConn);
                    }      
                ?>
            </div>
            <form action="../action/updateprofpic.php" class="profpic-section" method="POST" enctype="multipart/form-data">
                <div>
                    <input type="file" name="file" required> 
                    <button type="submit" name="updateprofpic">Update</button>
                    <p style="font-size: small;">*Please keep the file extension in jpg, jpeg, png, gif!</p>
                </div>
            </form>
            <form action="../action/updatefullname.php" class="fullname-section" method="POST">
                <div>
                    <label for="fullname">Full Name</label><br>
                    <input type="text" name="fullname" id="fullname" placeholder="<?php displayfullname($dbConn)?>" required> <button type="submit" name="updatefullname">Update</button>
                </div>
            </form>
            <form action="../action/updateusername.php" class="username-section" method="POST">
                <div>
                    <label for="usrname">Username</label><br>
                    <input type="text" name="usrname" id="usrname" placeholder="<?php displayusername($dbConn)?>" required> <button type="submit" name="updateusername">Update</button>
                </div>
            </form>
            <form action="../action/updateemail.php" class="email-section" method="POST">
                <div>
                    <label for="email">Email</label><br>
                    <input type="email" name="email" id="email" placeholder="<?php displayemail($dbConn)?>" required> <button type="submit" name="updateemail">Update</button>
                </div>
            </form>
            
        </div>

        <footer style="bottom: 0; background-color: black; width: 100%; height: auto; position: fixed; display: flex; justify-content: space-evenly; align-items:center;">
            <!-- WEBSITE -->
            <div style="text-align: center;">
                <h1 style="font-family: 'Qwigley', cursive; color: orange;">WBVS</h1>
                <p style="color: orange;">© Web Based Voting System (WBVS)</p>
            </div>
            <!-- CONTACT -->
            <div>
                <p style="font-size: 20px; font-weight: bold; color: white;">Contact Us</p>
                <p style="font-size: 15px; color:white; margin-bottom: 0;">Email: freddystanlee987@gmail.com</p>
            </div>
        </footer>
             
    </body>
</html>