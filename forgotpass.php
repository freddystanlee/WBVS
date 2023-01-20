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


        <div style="margin-top: 5%; width:50%; margin-left: 25%; margin-right: 25%; font-family: 'Montserrat', sans-serif;"> 
            <form action="action/forgotpass.php" method="POST">
                <h2 class="title">Forgot Password</h2>
                <div style="margin: 5px 40px 20px 40px;">
                    <label style="font-size: 20px; color: black;" for="usrname">Enter Your Email to Reset Your Password</label><br>
                    <input style="height: 40px; font-size: medium; padding: 0 20px; width: 100%; border-radius: 5px; border: 1px solid rgb(177, 177, 177); box-sizing: border-box;" type="email" name="email" id="usrname" placeholder="Enter your email here..." required>
                </div>
                <div style="margin: 5px 40px 20px 40px; text-align: center">
                    <button style="background-color: red; color: white; border-radius: 5px; border: none; padding: 10px 15px; margin-bottom: 20px;"type="reset">Reset</button>
                    <button style="background-color: rgb(0, 173, 0); color: white; border-radius: 5px; border: none; padding: 10px 15px; margin-bottom: 20px;" type="submit" name="submit">Submit</button>
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