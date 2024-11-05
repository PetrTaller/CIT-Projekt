<?php
session_start();
if(isset($_SESSION["username"])) {
$logged = true;
}
if(!isset($_SESSION["username"])) {
$logged = false;
}
include_once 'DBC.php';
$profileId = DBC::getProfileId($_SESSION["username"]);


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
      <div class="topnav">
        <a class="icon" href="../index.php">&nbsp;Kvout</a>
        <div class="topnav2">
          <a href="about_us.php">About us</a>
          <a href="../index.php" style=" background-color: rgba(0, 0, 0, 0.2);">Quotes</a>
          <a href="../index.php">Home</a>
            <a href="<?php if($logged) {echo "profile.php";}else{ echo "login.php";}?>" class="<?php if($logged) {echo "logged-profile-icon-cont";}else{ echo "profile-icon";}?>">
            <?php if($logged) {
              echo '<img src="../profile_pics/pic' . $profileId . '.jpg" class="logged-profile-icon">';
          } else {
             echo '';
          }?>
            </a>
          </div>
        </div>
        </div>
      <footer>Petr Taller 2024 ©</footer>
    </div>
  </body>
</html>
<?php
if (isset($_SESSION["message"])) {
  $message = $_SESSION["message"];
  echo "<script>alert('$message');</script>";
  unset($_SESSION["message"]);
}
?>
