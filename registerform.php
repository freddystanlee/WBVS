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
        
        <div class="registrationform"> 
            <form action="action/register.php" method="POST">
                <h2 class="title">Registration</h2>
                <div>
                    <label for="fullname">Full Name</label><br>
                    <input type="text" name="fullname" id="fullname" placeholder="Enter your full name here..." required>
                </div>
                <div>
                    <label for="usrname">Username</label><br>
                    <input type="text" name="usrname" id="usrname" placeholder="Enter your username here..." required>
                </div>
                <div>
                    <label for="email">Email</label><br>
                    <input type="email" name="email" id="email" placeholder="Enter your email here..." required>
                </div>
                <div>
                    <label for="pass">Password</label><br>
                    <input type="password" name="pass" id="pass" placeholder="Enter your password here..." required>
                </div>
                <div>
                    <label for="passrpt">Confirm Password</label><br>
                    <input type="password" name="passrpt" id="passrpt" placeholder="Repeat your password here..." required>
                </div>
                <div>
                    <label for="gender">Gender</label><br>
                    <select name="gender" id="gender">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div>
                    <button type="reset" class="resetbtn">Reset</button>
                    <button type="submit" class="submitbtn" name="submit">Submit</button>
                </div>
                <div class="shortcut">
                    <p>Already have account?<a href="loginform.php">Click here to login</a></p>      
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