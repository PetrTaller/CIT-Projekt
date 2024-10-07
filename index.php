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
include_once 'source/DBC.php';
$profileId = DBC::getProfileId($_SESSION["username"]);

// chat generovany api ->

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents('php://input'), true);
  if (isset($data['content']) && isset($data['author'])) {
      $content = mysqli_real_escape_string($connection, $data['content']);
      $author = mysqli_real_escape_string($connection, $data['author']);

      $query = "INSERT INTO blog_posts (content, author) VALUES ('$content', '$author')";
      if (mysqli_query($connection, $query)) {
          $id = mysqli_insert_id($connection);
          echo json_encode(['id' => $id]);
      } else {
          http_response_code(500);
          echo json_encode(['error' => 'Failed to create blog post']);
      }
  } else {
      http_response_code(400);
      echo json_encode(['error' => 'Invalid data']);
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['blogId'])) {
  $result = mysqli_query($connection, "SELECT * FROM blog_posts");
  $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
  echo json_encode($posts);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['blogId'])) {
  $blogId = intval($_GET['blogId']);
  $query = "SELECT * FROM blog_posts WHERE id = $blogId";
  $result = mysqli_query($connection, $query);
  if ($post = mysqli_fetch_assoc($result)) {
      echo json_encode($post);
  } else {
      http_response_code(404);
      echo json_encode(['error' => 'Post not found']);
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['blogId'])) {
  $blogId = intval($_GET['blogId']);
  $query = "DELETE FROM blog_posts WHERE id = $blogId";
  if (mysqli_query($connection, $query)) {
      echo json_encode(['message' => 'Post deleted']);
  } else {
      http_response_code(404);
      echo json_encode(['error' => 'Post not found']);
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'PATCH' && isset($_GET['blogId'])) {
  $blogId = intval($_GET['blogId']);
  $data = json_decode(file_get_contents('php://input'), true);

  $updateFields = [];
  if (isset($data['content'])) {
      $content = mysqli_real_escape_string($connection, $data['content']);
      $updateFields[] = "content = '$content'";
  }
  if (isset($data['author'])) {
      $author = mysqli_real_escape_string($connection, $data['author']);
      $updateFields[] = "author = '$author'";
  }

  if (count($updateFields) > 0) {
      $query = "UPDATE blog_posts SET " . implode(', ', $updateFields) . " WHERE id = $blogId";
      if (mysqli_query($connection, $query)) {
          echo json_encode(['message' => 'Post updated']);
      } else {
          http_response_code(404);
          echo json_encode(['error' => 'Post not found']);
      }
  } else {
      http_response_code(400);
      echo json_encode(['error' => 'No fields to update']);
  }
}

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
        <div class="blog-posts">
  <?php
  $response = file_get_contents('http://your-server/api/blog');
  $posts = json_decode($response, true);
  foreach ($posts as $post) {
      echo "<div class='post'>";
      echo "<h2>Author: " . htmlspecialchars($post['author']) . "</h2>";
      echo "<p>" . htmlspecialchars($post['content']) . "</p>";
      echo "<small>Created on: " . htmlspecialchars($post['created_at']) . "</small>";
      echo "</div>";
  }
  ?>
</div>
          </div>
        </div>
      <footer>Petr Taller 2024 ©</footer>
    </div>
  </body>
</html>
