<?php
session_start();
if(isset($_SESSION["username"])) {
$logged = true;
}
if(!isset($_SESSION["username"])) {
$logged = false;
}
if (isset($_SESSION["message"])) {
  $message = $_SESSION["message"];
  echo "<script>alert('$message');</script>";
  unset($_SESSION["message"]);
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
            <p>At Kvout, we believe in the power of connection and communication.Our platform is designed to bring people from all <br>
                corners of the world together in one virtual space where you can share ideas, build friendships,and engage in meaningful conversations.</p>
            <h2>Our Mission</h2>
            <p>Our mission is to create a vibrant and inclusive community where everyone has a voice.<br>
                 We aim to foster an environment that encourages open dialogue, cultural exchange, and mutual respect among all our users.</p>
            <h2>Why Kvout?</h2>
            <ul>
                <li style="text-align:left;"><strong>Global Reach:</strong> Connect with users from different countries and cultures, broadening your horizons and enriching your understanding of the world.</li>
                <li style="text-align:left;"><strong>Real-Time Communication:</strong> Enjoy seamless, real-time chat experiences that make you feel closer to others, no matter the distance.</li>
                <li style="text-align:left;"><strong>Safe and Secure:</strong> Your safety is our priority. We have implemented robust security measures and moderation tools to ensure a positive and respectful environment for all users.</li>
                <li style="text-align:left;"><strong>User-Friendly Interface:</strong> Our intuitive design makes it easy to navigate and engage in conversations, whether you're a tech-savvy user or just getting started.</li>
            </ul>
            <h2>Join Us</h2>
            <p>Be a part of our growing community at Kvout Whether you're looking to make new friends,<br>
                 learn about different cultures, or just have a casual chat, you'll find a welcoming space here. Together,<br>
                  let's build bridges across continents and create lasting connections.</p>
            <p>Thank you for choosing Kvout. We look forward to chatting with you!</p>
        </div>
      <footer>Petr Taller 2024 ©</footer>
    </div>
  </body>
</html>
