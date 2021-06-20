<?php
session_start();
require_once "config.php";

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$reason = $_POST['reason'];
$username = $_SESSION['username'];

if ($end_date < $start_date)
{

	echo '<script type="text/javascript">';
	echo 'alert("Select start date and end date in correct order.")';
	echo '</script>';
	
}
else 
{
	$date1 = date("Y-m-d"); #today
	$date2 = $start_date;

	$today = strtotime($date1);
	$expiration_date = strtotime($date2);

	if ($expiration_date >= $today) {
	     $leave_type = "NL";
	} else {
	     $leave_type = "RL";
	}
	$first_date = new DateTime($start_date);
	$second_date = new DateTime($end_date);
	$days = date_diff($first_date,$second_date)->format("%a"); # Number of days
	

	$sql = "SELECT COUNT(*) AS used_leaves FROM applied_leaves WHERE username = '$username' AND result = 'Approved';";
	$result = mysqli_query($conn, $sql);
	$data = mysqli_fetch_assoc($result);
	$max_leaves = 12;
	$leaves_left = $max_leaves - $data['used_leaves'];

	$sql = "SELECT COUNT(*) AS pending_approvals FROM applied_leaves WHERE username = '$username' AND result = 'Pending';";
	$result = mysqli_query($conn, $sql);
	$data = mysqli_fetch_assoc($result);
	$pending_approvals = $data['pending_approvals'];

	if ($leaves_left == 0)
	{
		echo '<script type="text/javascript">';
		echo 'alert("Rejected by the system. You have already used maximum allowed leaves.")';
		echo '</script>';
	}
	else
	{	# Condition for 'cannot apply two leaves at a time for approval'
		if ($pending_approvals==1)
		{
			echo '<script type="text/javascript">';
			echo 'alert("Rejected by the system! You can not apply for more than one application for approval.")';
			echo '</script>';
		}
		else
		{
			if ($days <= $leaves_left)
			{
				$adjusted_second_date = date('Y-m-d', strtotime($start_date. ' + '. $days . 'days'));
				#echo $adjusted_second_date;
				$sql = "INSERT INTO applied_leaves (username,start_date,end_date,leave_type,reason,comments,approved_by,result) VALUES ('$username', '$start_date','$adjusted_second_date','$leave_type','$reason',NULL,NULL,'Pending');";
				mysqli_query($conn, $sql);
				echo '<script type="text/javascript">';
				echo ' alert("Successully applied! Check your Applied Leaves section. ")';
				echo '</script>';
			}
			elseif ($days > $leaves_left) 
			{
				$adjusted_second_date = date('Y-m-d', strtotime($start_date. ' + '. $leaves_left . 'days'));
				#echo $adjusted_second_date;
				#insert leave data in applied_leaves
				$sql = "INSERT INTO applied_leaves (username,start_date,end_date,leave_type,reason,comments,approved_by,result) VALUES ('$username', '$start_date','$adjusted_second_date','$leave_type','$reason',NULL,NULL,'Pending');";
				mysqli_query($conn, $sql);
				echo '<script type="text/javascript">';
				echo 'alert("Successful! You do not have enough leaves left. Applied for available leaves")';
				echo '</script>';	
			}
		}
	}

}




/*

#insert leave data in applied_leaves
$sql = "INSERT INTO applied_leaves (username,start_date,end_date,leave_type,reason,rl_reason,comments,approved_by,result) VALUES ('$username', '$start_date','$end_date','$leave_type','$reason',NULL,NULL,NULL,'Pending');";
mysqli_query($conn, $sql);

$sql1 = "SELECT * FROM login_info WHERE username='$username';";
$result = mysqli_query($conn, $sql1);
$row = mysqli_fetch_assoc($result);

if ($row['username'] === $username) {
	
	if ($row['profile_type']=='dean_fa') {
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

*/

?>