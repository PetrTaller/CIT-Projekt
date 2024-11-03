<?php
class DBC {
public const SERVER_IP = "aws-web-database.cv4q64qmg5uo.eu-central-1.rds.amazonaws.com";
public const USER = "admin";
public const PASSWORD = "123Pindicek888*";
public const DATABASE = "Databs";
public const PORT = "3306";
private static $connection = null;

protected function __construct()
{
}

public static function getInstance()
{
    if (!self::$connection) {
        self::$connection = new DBC();
    }

    return self::$connection;
}

public static function getConnection()
{
    if (!self::$connection) {
        self::$connection = mysqli_connect(
            self::SERVER_IP,
            self::USER,
            self::PASSWORD,
            self::DATABASE,
            self::PORT
        );
        if (!self::$connection) {
            die('Could not connect to DB');
        }
    }
    return self::$connection;
}

public static function closeConnection()
{
    if (self::$connection) {
        mysqli_close(self::$connection);
        self::$connection = null;
    }
}

public static function insertUser($username, $password)
{
    $connection = self::getConnection();
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $profile_id = 1;
    $is_admin = 0;
    $query = "INSERT INTO users (username, password,profile_id,is_admin) VALUES ('$username','$hashedPassword','$profile_id','$is_admin')";
    return mysqli_query($connection, $query);
}

public static function getUser($username)
{
    $connection = self::getConnection();
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($connection, $query);
    return mysqli_fetch_assoc($result);
}

public static function updateUserProfileId($username, $profile_id)
{
    $connection = self::getConnection();
    $username = mysqli_real_escape_string($connection, $username);
    $pictureTitle = mysqli_real_escape_string($connection, $profile_id);
    $query = "UPDATE users SET profile_id = '$profile_id' WHERE username = '$username'";
    return mysqli_query($connection, $query);
}

public static function getProfileId($username)
{
    $connection = self::getConnection();
    $query = "SELECT profile_id FROM users WHERE username='$username'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['profile_id'];
}

public static function insertBlogPost($content,$author,$visibility)
{
    $connection = self::getConnection();
    $query = "INSERT INTO blog_posts (content, author, visibility) VALUES ('$content','$author','$visibility')";
    return mysqli_query($connection, $query);
}

public static function getBlogPost($id)
{
    $connection = self::getConnection();
    $query = "SELECT * FROM blog_posts WHERE id='$id'";
    $result = mysqli_query($connection, $query);
    return mysqli_fetch_assoc($result);
}

public static function getBlogPosts($username = null) {
    $connection = self::getConnection();
    if ($username) {
        if (self::isAdmin($username)) {
            $query = "SELECT * FROM blog_posts";
        } else {
            $query = "SELECT * FROM blog_posts WHERE author='$username' OR visibility='public'";
        }
    } else {
        $query = "SELECT * FROM blog_posts WHERE visibility='public'";
    }
    $result = mysqli_query($connection, $query);
    return $result;
}

public static function deleteBlogPost($id) {
    $connection = self::getConnection();
    $query = "DELETE FROM blog_posts WHERE id='$id'";
    return mysqli_query($connection, $query);
}

public static function updateBlogPost($id, $data) {
    $connection = self::getConnection();
    $updates = [];
    if (isset($data['content'])) {
        $content = mysqli_real_escape_string($connection, $data['content']);
        $updates[] = "content='$content'";
    }
    if (isset($data['visibility'])) {
        $visibility = mysqli_real_escape_string($connection, $data['visibility']);
        $updates[] = "visibility='$visibility'";
    }
    if (!empty($updates)) {
        $query = "UPDATE blog_posts SET " . implode(", ", $updates) . " WHERE id='$id'";
        return mysqli_query($connection, $query);
    }
    return false;
}

public static function isAdmin($username) {
    $connection = self::getConnection();
    $username = mysqli_real_escape_string($connection, $username);
    $query = "SELECT is_admin FROM users WHERE username='$username'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    if($result){
    return $row['is_admin'] == 1;
    }else{
    return FALSE;
    }
}

}
?>
