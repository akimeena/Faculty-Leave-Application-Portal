<?php
session_start();
require_once "config.php";
$username = $_SESSION['username'];
$comment = $_POST['comment'];

$sql1 = "SELECT * FROM login_info WHERE username='$username';";
$result = mysqli_query($conn, $sql1);
$row = mysqli_fetch_assoc($result);

if ($row['username'] === $username) {
	if ($row['profile_type']=='director') {
		$commenter = 'Director: ';	
    }elseif ($row['profile_type']=='dean_fa') {
		$commenter = 'Dean FA: ';
	}elseif ($row['profile_type']=='hod_cse' || $row['profile_type']=='hod_ee' || $row['profile_type']=='hod_me') {
		$commenter = 'HoD: ';
	}else {
		$commenter = 'Faculty: ';
	}
	
}

$edited_comment = $commenter . $comment;
echo $edited_comment;

$sql = "SELECT * FROM applied_leaves WHERE username='$username' and result = 'Pending';";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$previous_comments = $row['comments'];
$comments = $previous_comments . '<br>' . $edited_comment;

if (!empty($comment))
{
	$sql = "UPDATE applied_leaves SET comments='$comments' WHERE username='$username' and result = 'Pending';";
	mysqli_query($conn, $sql);
}


$sql1 = "SELECT * FROM login_info WHERE username='$username';";
$result = mysqli_query($conn, $sql1);
$row = mysqli_fetch_assoc($result);

if ($row['username'] === $username) {
	if ($row['profile_type']=='director') {
		header("Location: director.php");
    	exit();	
    }elseif ($row['profile_type']=='dean_fa') {
		header("Location: dean.php");
    	exit();	
	}elseif ($row['profile_type']=='hod_cse' || $row['profile_type']=='hod_ee' || $row['profile_type']=='hod_me') {
		header("Location: hod.php");
    	exit();	
	}else {
		header("Location: faculty.php");
    	exit();	
	}
	
}

?>