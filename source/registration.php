<?php
session_start();
require_once "./DBC.php";
if(isset($_SESSION["username"])) {
    header("Location: ../index.php");
    exit();
}
if(isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if(DBC::getUser($username)) {
            $_SESSION["message"] = "User already exists.";
            header("Location: registration.php"); 
            exit();
    } else {
        if(DBC::insertUser($username, $password)) {
            $_SESSION["message"] = "Registration successful. You can now log in.";
            header("Location: login.php"); 
            exit();
        } else {
            $_SESSION["message"] = "Registration unsuccessful. Try again.";
            header("Location: registration.php"); 
            exit();
        }
    }
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
                <br><br><br><br><h1 class="login-form">Registration</h1><br>
                <form method="post" action="registration.php" class="login-form">
                    <label for="username" class="login-form">Username:</label><br>
                    <input type="text" id="username" name="username" required class="button" style="background-color:white; color:black;"><br>
                    <label for="password" class="login-form">Password:</label><br>
                    <input type="password" id="password" name="password" required class="button" style="background-color:white; color:black;"><br><br><br>
                    <input type="submit" name="register" value="Register" class="button"><br><br><br><br><br><br><br><br><br><br><br>
                </form>
                <form action="../index.php" method="post" class="login-form">
                    <button class="button">Contine without registering</button>
                </form>
                <br><form action="login.php" method="post" class="login-form">
                    <button class="button">Back to Login</button>
                </form>
                <br><br>
                <footer>Petr Taller 2024 ©</footer>
            </div>
        </div>
    </body>
</html>