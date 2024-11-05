<?php
session_start();

if(isset($_SESSION["username"])) {
$logged = true;
}
if(!isset($_SESSION["username"])) {
$logged = false;
}

if(!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
include_once 'DBC.php';
$profileId = DBC::getProfileId($_SESSION["username"]);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="x-icon" href="/assets/icon.ico" />
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
                <a href="quotes.php">Quotes</a>
                <a href="../index.php">Home</a>
                <a href="../index.php" class="logged-profile-icon-cont" style=" background-color: rgba(0, 0, 0, 0.2);">
                  <img src="../profile_pics/pic<?php echo $profileId; ?>.jpg" class="logged-profile-icon">
                </a>
            </div>
        </div>
        <div>
          <h1 class="login-form"> <?php echo $_SESSION['username']; ?></h1>
          <div class="login-form">
            <img src="../profile_pics/pic<?php echo $profileId; ?>.jpg" class="profile" style="width: 240px; height: 240px; border-radius: 50%;object-fit: cover; margin: 20px;">
            <br><br>
            <button class="button" id="openModalButton">Change Profile Picture</button>
            <div id="pictureModal" class="modal">
              <div class="modal-content">
                <h2>Select a Profile Picture</h2>
                <form id="profilePicForm" action="update_profile_pic.php" class="login-form" method="post">
                  <div class="pictures-container">
                  <?php
                  for ($i = 1; $i <= 10; $i++) {
                    echo '<div class="picture-option">';
                    echo '<input type="radio" id="pic' . $i . '" name="selectedPic" value="' . $i . '">';
                    echo '<label for="pic' . $i . '"><img src="../profile_pics/pic' . $i . '.jpg" alt="Profile Picture ' . $i . '"></label>';
                    echo '</div>';
                    }
                  ?>
                  </div>
                  <br><br>
                  <button type="submit" class="button" id="submitSelection">Submit</button>
                </form>
              </div>
            </div>
            <br><br><br><br><br><br><form action="logout.php" method="post" class="login-form">
            <button class="button">Logout</button>
          </div>
      <footer>Petr Taller 2024 ©</footer>
    </div>
    <script src="script.js"></script>
  </body>
</html>
<?php
if (isset($_SESSION["message"])) {
  $message = $_SESSION["message"];
  echo "<script>alert('$message');</script>";
  unset($_SESSION["message"]);
}
?>
