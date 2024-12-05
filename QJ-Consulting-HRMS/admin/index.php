<?php
    session_start();
    if(isset($_SESSION['admin'])) {
        header("Location: dashboard.php");
    }
    if(isset($_REQUEST['submit'])) {

        if(isset($_REQUEST['username']) && isset($_REQUEST['password'])) {

            $username = $_REQUEST['username'];
            $password = md5($_REQUEST['password']);

            include("./../connection/connection.php");
            $query = "SELECT `admin_id`, `username`, `password` FROM `admin_master`";
            $data = mysqli_query($connection, $query);

            while($ar = mysqli_fetch_array($data)) {

                if($ar['username'] == $username && $ar['password'] == $password) {
                    
                    $_SESSION['admin'] = $ar['admin_id'];
                    header("Location: ./dashboard.php");
                    exit();
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php include("./../title.php"); ?>
        <link rel="stylesheet" href="./../css/style.css">
    </head>
    <body>
        <div class="flex justify-center align-center h100-vh">
            <form class="base-form flex flex-column gap-16" action="">
                <div class="text-center font-28">Admin Login</div>
                <br>
                <div class="flex flex-column gap-8 font-18">
                    Username
                    <input class="input-field font-16" type="text" placeholder="Enter your username" name="username">
                </div>
                <div class="flex flex-column gap-8 font-18">
                    Password
                    <input class="input-field font-16" type="password" placeholder="Enter your password" name="password">
                </div>
                <div class="flex flex-column gap-8">
                    <input class="button-1 font-16" type="submit" name="submit">
                </div>
            </form>
        </div>
    </body>
</html>