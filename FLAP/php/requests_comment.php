<?php
session_start();

require_once "config.php";

$username = $_SESSION['username']; # HoD username
$decision = $_POST['decision'];
$comment = $_POST['comment'];
$uid = $_POST['uid'];

#echo $uid; applicant's username for action for selected row's form input

#$requester_username = $_SESSION['leave_req_username'];

$sql1 = "SELECT * FROM login_info WHERE username='$username';";
$result = mysqli_query($conn, $sql1);
$row = mysqli_fetch_assoc($result);
$profile_type = $row['profile_type'];
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
#echo $edited_comment;

$sql = "SELECT * FROM applied_leaves WHERE username='$uid' and result = 'Pending';";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$previous_comments = $row['comments'];
$comments = $previous_comments . '<br>' . $edited_comment;
#echo $comments;
if (!empty($comment))
{
	$sql = "UPDATE applied_leaves SET comments='$comments' WHERE username='$uid' and result = 'Pending';";
	mysqli_query($conn, $sql);
}

if ($decision=='decline')
{
	$sql = "UPDATE applied_leaves SET result='Declined' WHERE username='$uid' and result = 'Pending';";
	mysqli_query($conn, $sql);	
}
elseif ($decision=='approve')
{	
	$sql1 = "UPDATE applied_leaves SET approved_by='$profile_type';";
	mysqli_query($conn, $sql1);
	# currently approved_by = dean_fa

	$sql = "SELECT * FROM login_info li, emp_info ei, applied_leaves al WHERE (li.username = ei.username AND ei.username = al.username) AND li.username='$uid' AND result = 'Pending';";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);


	if ($row['leave_type']=='NL' && ($row['approved_by']=='hod_cse' || $row['approved_by']=='hod_ee' || $row['approved_by']=='hod_me')) 
	{
		echo 'first';
		$sql = "UPDATE applied_leaves SET result='Pending' WHERE username='$uid';";
		mysqli_query($conn, $sql);	
	}
	elseif ($row['leave_type']=='RL' && ($row['approved_by']=='hod_cse' || $row['approved_by']=='hod_ee' || $row['approved_by']=='hod_me'))
	{	echo 'second';
		$sql = "UPDATE applied_leaves SET result='Pending' WHERE username='$uid';";
		mysqli_query($conn, $sql);	
	}	
	elseif ($row['leave_type']=='NL' && $row['approved_by']=='dean_fa')
	{	echo 'third';
		$sql = "UPDATE applied_leaves SET result='Approved' WHERE username='$uid';";
		mysqli_query($conn, $sql);

	}
	elseif ($row['leave_type']=='RL' && $row['approved_by']=='dean_fa')
	{	echo 'fourth';
		$sql = "UPDATE applied_leaves SET result='Pending' WHERE username='$uid';";
		mysqli_query($conn, $sql);	
	}
	elseif ($row['leave_type']=='RL' && $row['approved_by']=='director')
	{	echo 'fifth';
		$sql = "UPDATE applied_leaves SET result='Approved' WHERE username='$uid';";
		mysqli_query($conn, $sql);
			
	}
	elseif ($row['leave_type']=='NL' && $row['approved_by']=='director')
	{	echo 'sixth';
		$sql = "UPDATE applied_leaves SET result='Approved' WHERE username='$uid';";
		mysqli_query($conn, $sql);
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