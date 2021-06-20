<?php

require_once "config.php";

$username = $_POST['username'];

$sql = "DELETE FROM login_info WHERE username='$username';";
mysqli_query($conn, $sql);
$sql1 = "DELETE FROM emp_info WHERE username='$username';";
mysqli_query($conn, $sql1);
$sql2 = "DELETE FROM leaves_count WHERE username='$username';";
mysqli_query($conn, $sql2);

header("Location: admin.php");

?>