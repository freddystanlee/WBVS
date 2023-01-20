<?php 
    session_start();
    if(!isset($_SESSION["resetpass"], $_SESSION["resettoken"])){
        header("Location: index.php");
        exit();
    } elseif ($_SESSION["resettoken"] !== $_GET["reset"]) {
        header("Location: index.php");
        exit();
    }
    require_once "header.php";

?>
        <div style="margin-top: 5%; width:50%; margin-left: 25%; margin-right: 25%; font-family: 'Montserrat', sans-serif;"> 
            <form action="action/resetpass.php" method="POST">
                <input name="resettoken" type="hidden" value="<?= $_SESSION["resettoken"] ?>">
                <input name="email" type="hidden" value="<?= $_SESSION["resetpass"] ?>">
                <h2 style="background-color: orange; text-align: center; font-size: 25px;">Reset Password for <?= $_SESSION["resetpass"] ?></h2>
                <div style="margin: 5px 40px 20px 40px;">
                    <label style="font-size: 20px; color: black;" for="password">New Password</label><br>
                    <input style="height: 40px; font-size: medium; padding: 0 20px; width: 100%; border-radius: 5px; border: 1px solid rgb(177, 177, 177); box-sizing: border-box;" type="password" name="password" id="password" placeholder="Enter your new password..." required>
                </div>
                <div style="margin: 5px 40px 20px 40px;">
                    <label style="font-size: 20px; color: black;" for="password">Confirm Password</label><br>
                    <input style="height: 40px; font-size: medium; padding: 0 20px; width: 100%; border-radius: 5px; border: 1px solid rgb(177, 177, 177); box-sizing: border-box;" type="password" name="passwordrpt" id="passwordrpt" placeholder="Confirm password..." required>
                </div>
                <div style="margin: 5px 40px 20px 40px; text-align: center">
                    <button style="background-color: red; color: white; border-radius: 5px; border: none; padding: 10px 15px; margin-bottom: 20px;"type="reset">Reset</button>
                    <button style="background-color: rgb(0, 173, 0); color: white; border-radius: 5px; border: none; padding: 10px 15px; margin-bottom: 20px;" type="submit" name="submit">Submit</button>
                </div>
            </form>
        </div>

    </body>
</html>