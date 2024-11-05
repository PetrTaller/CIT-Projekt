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
          <a href="../index.php" style=" background-color: rgba(0, 0, 0, 0.2);">About us</a>
          <a href="quotes.php">Quotes</a>
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
        <div class="about_us">
    <h1>About Us</h1>
    <p>Welcome to <strong>Kvout</strong>!</p>
    <p>At Kvout, we celebrate the power of words. Our platform is dedicated to sharing, discovering, and reflecting on inspiring quotes from all walks of life.</p>
    
    <h2>Our Mission</h2>
    <p>Our mission is to curate a diverse collection of quotes that resonate with people from all over the world.<br>
       We aim to provide a space where ideas, wisdom, and experiences are shared through timeless quotes.</p>
    
    <h2>Why Kvout?</h2>
    <ul>
        <li style="text-align:left;"><strong>Diverse Collection:</strong> Explore a vast array of quotes on various topics such as love, life, wisdom, and motivation, all in one place.</li>
        <li style="text-align:left;"><strong>Global Voices:</strong> Discover quotes from different cultures and time periods, offering a global perspective on shared human experiences.</li>
        <li style="text-align:left;"><strong>Search and Share:</strong> Easily search for your favorite quotes and share them with your friends, family, or social media followers.</li>
        <li style="text-align:left;"><strong>User Contributions:</strong> Submit your own favorite quotes and become a part of our growing community of word lovers.</li>
    </ul>
    
    <h2>Join Us</h2>
    <p>Be a part of our growing community at Kvout! Whether you're looking for daily inspiration, seeking wisdom, or just love reading quotes, you’ll find something here that speaks to you.</p>
    <p>Thank you for choosing Kvout. Let’s inspire and be inspired together!</p>
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
