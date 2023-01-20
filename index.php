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
        <div style="justify-content: space-evenly; border-bottom: 3px solid grey; margin: 0 30px;">
            <div style="text-align: center;">
                <p style="font-size: 50px; margin-top: 40px;">Welcome to WBVS</h1>
                <p style="font-size: 20px;">The place where you can vote easily</p>
                <p style="font-size: 20px;">Register your very own account now to be able to use the voting system</p>
            </div>

            <div style="text-align: center;">
                <img src="pic/voting.jpg" alt="voting">
            </div>
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


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
 
