<?php 
session_start(); 
include "config.php";

if (isset($_POST['username']) && isset($_POST['password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$username = validate($_POST['username']);
	$password = validate($_POST['password']);

	#global $loggedin_username;
	#global $loggedin_password;

	#$loggedin_username = $username;
	#$loggedin_password = $password;

	if (empty($username)) {
		header("Location: ../index.php?error=User Name is required");
	    exit();
	}else if(empty($password)){
        header("Location: ../index.php?error=Password is required");
	    exit();
	}else{
		$sql = "SELECT * FROM login_info WHERE username='$username' AND password='$password'";

		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['username'] === $username && $row['password'] === $password) {
            	$_SESSION['username'] = $row['username'];
            	$_SESSION['profile_type'] = $row['profile_type'];
            	if ($row['profile_type']=='admin'){
            		$sql = "UPDATE login_sessions SET login_time = now() WHERE username='$username';";
            		mysqli_query($conn, $sql);
            		header("Location: admin.php");
		        	exit();	
            	}elseif ($row['profile_type']=='director') {
            		$sql = "UPDATE login_sessions SET login_time = now() WHERE username='$username';";
            		mysqli_query($conn, $sql);
            		header("Location: director.php");
		        	exit();	
            	}elseif ($row['profile_type']=='dean_fa') {
            		$sql = "UPDATE login_sessions SET login_time = now() WHERE username='$username';";
            		mysqli_query($conn, $sql);
            		header("Location: dean.php");
		        	exit();	
            	}elseif ($row['profile_type']=='hod_cse' || $row['profile_type']=='hod_ee' || $row['profile_type']=='hod_me') {
            		$sql = "UPDATE login_sessions SET login_time = now() WHERE username='$username';";
            		mysqli_query($conn, $sql);
            		header("Location: hod.php");
		        	exit();	
            	}else {
            		$sql = "UPDATE login_sessions SET login_time = now() WHERE username='$username';";
            		mysqli_query($conn, $sql);
            		header("Location: faculty.php");
		        	exit();	
            	}
            	
            }else{
				header("Location: ../index.php?error=Incorect User name or password");
		        exit();
			}
		}else{
			header("Location: ../index.php?error=Incorect User name or password");
	        exit();
		}
	}
	
}else{
	header("Location: ../index.php");
	exit();
}