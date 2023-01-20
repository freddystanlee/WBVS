<?php
    session_start();
    if(isset($_SESSION["id"], $_SESSION["uname"])) {
        header("Location: users/usershome.php");
        exit();
    } elseif(isset($_SESSION["admin"])) {
        header("Location: admin/adminhome.php");
        exit();
    }
    
    require_once "header.php";
?>
        
        <div class="loginform"> 
            <form action="action/login.php" method="POST">
                <h2 class="title">Login</h2>
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
                <div class="shortcut">
                    <p>Haven't had an account? <a href="registerform.php">Click here to register</a></p>
                    <a href="forgotpass.php">Forgot Password?</a>     
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