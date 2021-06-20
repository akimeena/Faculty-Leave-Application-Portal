<?php 
session_start();
require_once "config.php";

$username = $_SESSION['username'];
$sql = "UPDATE login_sessions SET logout_time = now() WHERE username = '$username';";
mysqli_query($conn, $sql);

session_unset();
session_destroy();

header("Location: ../index.php");


?>