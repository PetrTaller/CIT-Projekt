<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selectedPic'])) {
    $selectedPicId = $_POST['selectedPic'];
    include_once 'DBC.php';
    $username = $_SESSION['username'];
    DBC::updateUserProfileId($username, $selectedPicId);
    header("Location: profile.php");
    exit();
} else {
    header("Location: profile.php");
    exit();
}
?>