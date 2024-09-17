<?php
session_start();
session_unset();
session_destroy();
header("Location: ../index.php");
header("Cache-Control: no-cache, must-revalidate");
exit();
?>