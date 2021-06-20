<?php
session_start();
require_once "config.php";
$username = $_POST['username'];
$profile_type = $_POST['profile_type'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

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
		$sql ="SELECT * FROM login_info li, emp_info ei WHERE  li.username = ei.username AND li.profile_type='$profile_type';";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		$old_user = $row['username'];

	    $sql = "SELECT * FROM login_info li, emp_info ei WHERE li.username = ei.username AND li.username = '$username';";
	    $result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		if ($row['profile_type']<>$profile_type)
		{
			$sql1 = "INSERT INTO appoint_info VALUES ('$username','$start_date','$end_date');";
			mysqli_query($conn, $sql1);
			if (strtotime($start_date)>=$today && $today <= strtotime($end_date))
			{
				$sql2 = "UPDATE login_info SET profile_type='$profile_type' WHERE username='$username';";
				mysqli_query($conn, $sql2);

				$sql = "UPDATE login_info SET profile_type='faculty' WHERE username='$old_user';";
				mysqli_query($conn, $sql);

				$sql = "UPDATE applied_leaves SET username='$username' WHERE username='$old_user';";
				mysqli_query($conn, $sql);
								
				echo '<script type="text/javascript">';
				echo 'alert("Successfully assigned the position.")';
				echo '</script>';
			}
		}

	} else {
	    echo '<script type="text/javascript">';
		echo 'alert("Past date is not allowed in end date option.")';
		echo '</script>';
	}
}

?>