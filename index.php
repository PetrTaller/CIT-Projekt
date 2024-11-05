<?php
session_start();
if(isset($_SESSION["username"])) {
$logged = true;
}
if(!isset($_SESSION["username"])) {
$logged = false;
}
include_once 'source/DBC.php';
$profileId = DBC::getProfileId($_SESSION["username"]);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="x-icon" href="/assets/icon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="source/style.css">
    <title>Kvout</title>
  </head>
  <body>
    <div class="site">
      <div class="topnav">
        <a class="icon" href="index.php">&nbsp;Kvout</a>
        <div class="topnav2">
          <a href="source/about_us.php">About us</a>
          <a href="source/quotes.php">Quotes</a>
          <a href="" style=" background-color: rgba(0, 0, 0, 0.2);">Home</a>
            <a href="<?php if($logged) {echo "source/profile.php";}else{ echo "source/login.php";}?>" class="<?php if($logged) {echo "logged-profile-icon-cont";}else{ echo "profile-icon";}?>">
            <?php if($logged) {
              echo '<img src="../profile_pics/pic' . $profileId . '.jpg" class="logged-profile-icon">';
          } else {
             echo '';
          }?>
            </a>
          </div>
        </div>
        <div class="home">
    <h2>Get Started</h2>
    <p>Kvout makes it easy to explore and discover amazing quotes. Sign up today and start your journey into the world of wisdom, inspiration, and timeless words.</p>

    <h2>Where our inspiration comes from:</h2>
    <div class="originate">
        <img src="assets/location.png" alt="Location" class="originate-image" style="width:750px; border: 5px solid rgba(0, 0, 0, 0.2); border-radius:50px;">
        <div class="originate-overlay">
            <div class="originate-text" style="color: #838383;">17.7117147N, 9.8986503E</div>
        </div>
    </div>

    <h2>Discover Inspiring Quotes</h2>
    <p>At Kvout, we believe that words have the power to inspire, motivate, and bring people together.<br>
       Join us today and become part of a community that celebrates the wisdom of words, connecting people through shared thoughts and reflections from around the world.</p>
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
