<?php
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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>Request</title>
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
        
        <div style="justify-content: space-evenly; border-bottom: 3px solid grey; margin: 0 30px;">
            <div style="text-align: left;">
                <p style="font-size: 40px; margin-top: 40px;">Request Admin</h1>
                <p style="font-size: 20px;">This form below is for you to request to the administrator what kind of voting topics you want.</p>
                <p style="font-size: 20px;">If the requested topic is approved, the requested voting session will be created for you and other participants.</p>
                <p style="font-size: 20px;">However, participants for the voting session will be decided by the administrator.</p>
            </div>
        </div>
        
        <div style="margin: 10px 450px 120px 450px;">
            <form action="../action/usersrequest.php" method="POST">
                <input type="hidden" name="userid" value="<?= $_SESSION["id"] ?>">
                <div class="mb-4">
                    <label for="requestname" class="form-label">Voting Name / Title</label>
                    <input type="text" class="form-control" name="requestname" id="requestname" placeholder="Type the voting title/topic that you want to suggest..." required>
                </div>
                <div class="mb-4">
                    <label for="requestdesc" class="form-label">Voting Description</label>
                    <textarea class="form-control" name="requestdesc" id="requestdesc" rows="4" placeholder="Type the description regarding to the voting title..." required></textarea>
                </div>
                <div class="mb-4">
                    <label for="candidates" class="form-label">Candidates</label>
                    <textarea class="form-control" name="candidates" id="candidates" rows="4" placeholder="List all the candidates you want for this voting. For example (Bryan, Josh, Freddy, ...)" required></textarea>
                </div>
                <button type="submit" class="btn btn-success" name="submitrequest">Submit Request</button>
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