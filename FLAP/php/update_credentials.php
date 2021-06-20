<?php

require_once "config.php";

$username = $_POST['username'];
$password = $_POST['password'];
$sql = "UPDATE login_info SET password='$password' WHERE username='$username';";
mysqli_query($conn, $sql);

header("Location: admin.php");

?>