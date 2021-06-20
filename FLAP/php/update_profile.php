<?php
session_start();

require_once "config.php";
$username = $_SESSION['username'];
$name = $_POST['name'];
$designation = $_POST['designation']; 
$department = $_POST['department'];
$email_id = $_POST['email_id'];
$address = $_POST['address'];
$joining_year = $_POST['joining_year'];
$password = $_POST['password'];

$sql = "SELECT * FROM login_info li, emp_info ei WHERE li.username = ei.username;";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result))
{
	if ($row['username'] == $_SESSION['username'])
	{
		if (!empty($name))
		{
			$sql1 = "UPDATE emp_info SET name='$name' WHERE username='$username';";
			mysqli_query($conn, $sql1);
		}

		if (!empty($designation))
		{
			$sql1 = "UPDATE emp_info SET designation='$designation' WHERE username='$username';";
			mysqli_query($conn, $sql1);
		}

		if (!empty($department))
		{
			$sql1 = "UPDATE emp_info SET department='$department' WHERE username='$username';";
			mysqli_query($conn, $sql1);
		}

		if (!empty($email_id))
		{
			$sql1 = "UPDATE emp_info SET email_id='$email_id' WHERE username='$username';";
			mysqli_query($conn, $sql1);
		}

		if (!empty($address))
		{
			$sql1 = "UPDATE emp_info SET address='$address' WHERE username='$username';";
			mysqli_query($conn, $sql1);
		}

		if (!empty($joining_year))
		{
			$sql1 = "UPDATE emp_info SET joining_year='$joining_year' WHERE username='$username';";
			mysqli_query($conn, $sql1);
		}

		if (!empty($joindate))
		{
			$sql1 = "UPDATE emp_info SET password='$password' WHERE username='$username';";
			mysqli_query($conn, $sql1);
		}
	}
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