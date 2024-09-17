<?php
session_start();

if(isset($_SESSION["username"])) {
    header("Location: ../index.php");
    exit();
}
if (isset($_SESSION["message"])) {
    $message = $_SESSION["message"];
    echo "<script>alert('$message');</script>";
    unset($_SESSION["message"]);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <link rel="icon" type="x-icon" href="../assets/icon.ico" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="style.css">
        <title>Kvout</title>
    </head>
    <body>
        <div class="site">
            <div class="login-form">
                <br><br><br><br><h1 class="login-form">Login</h1><br>
                <form action="DSlogin.php" class="login-form" method="post">
                    <label for="username" class="login-form">Username:</label><br>
                    <input type="text" name="username" required id="username" class="button" style="background-color:white; color:black;"><br>
                    <label for="password" class="login-form">Password:</label><br>
                    <input type="password" name="password" required id="password" class="button" style="background-color:white; color:black;"><br><br><br>
                    <input type="submit" value="Login" class="button" ><br><br><br><br><br><br><br><br><br><br><br>
                </form>
                <form action="../index.php" method="post" class="login-form">
                    <button class="button">Contine without logging in</button>
                </form>
                    <br><form action="registration.php" method="post" class="login-form">
                    <button class="button">Register</button>
                </form>
                <br><br>
                <footer>Petr Taller 2024 ©</footer>
            </div>
        </div>
    </body>
    </html>