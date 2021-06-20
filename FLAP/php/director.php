<?php
session_start();

if (isset($_SESSION['username'])) {

?>
<!DOCTYPE html>
<html>
<head>
	<title>Director Webpage</title>
	<link rel="stylesheet" type="text/css" href="../css/faculty.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="../js/faculty.js"></script>
	
</head>
<body>
	<div>
	<div class="cd-tabs">
	<nav>
		<ul class="cd-tabs-navigation" style="width: 100%">
			<li><a data-content="profile" class="selected" href="#profile">Profile</a></li>
			<li><a data-content="leave_requests" href="#0">Leave Requests</a></li>
			<li><a data-content="others_leaves" href="#0">Others' Leave History</a></li>
			<li><a data-content="appoint" href="#0">Appoint</a></li>
			<li><a data-content="logout" href="#" onclick="window.location.href = 'logout.php'">Logout</a></li>
		</ul> <!-- cd-tabs-navigation -->
	</nav>

<ul class="cd-tabs-content" style="color: black;">
		<li data-content="profile" class="selected" id="profile">

			<table>
				<?php
					require_once "config.php";
					$sql = "SELECT * FROM login_info li, emp_info ei WHERE li.username = ei.username;";
					$result = mysqli_query($conn, $sql);
					while ($row = mysqli_fetch_assoc($result))
					{
						if ($row['username'] == $_SESSION['username'])
						{
							echo "<tr>
								<td><b>Employee Name:</b></td>
								<td class='profile_table_right';>" . $row['name'] . "</td>
							</tr>
							<tr>
								<td><b> Designation:</b></td>
								<td class='profile_table_right';>" . $row['designation'] . "</td>
							</tr>
							<tr>
								<td><b>Department:</b></td>
								<td class='profile_table_right';>" . $row['department'] . "</td>
							</tr>
							<tr>
								<td><b>Email address:</b></td>
								<td class='profile_table_right';>" . $row['email_id'] . "</td>
							</tr>
							<tr>
								<td><b>Office address:</b></td>
								<td class='profile_table_right';>" . $row['address'] . "</td>
							</tr>
							<tr>
								<td><b>Joining Year:</b></td>
								<td class='profile_table_right';>" . $row['joining_year'] . "</td>
							</tr>";
						}
					}
								
					
			    ?>


			</table>


			<button style='color: #7E7D7D; border:none; margin-top: 30px; padding: 10px;' onclick="toggle_visibility('updateprofile')">Update Profile</button>
			<div style=" width: 50vw; height: 100vh; display: none;" id="updateprofile">
				<form action="update_profile.php" method="post">
					<fieldset style="width:50vw;padding-left: 30px; margin-top: 30px;">
					<legend><b>Update information: </b></legend> <br />
					<label>Name:<br /></label>
					<input type="text" name="name"><br /><br />
					<label>Designation:<br /></label>
					<input type="text" name="designation"><br /><br />
					<label>Department:<br /></label>
					<select name="department">
						<option></option>
						<option>CSE</option>
						<option>EE</option>
						<option>ME</option>
					</select><br><br>
					<label>Email Address:<br /></label>
					<input type="email" name="email_id"><br /><br />
					<label>Office Address:<br /></label>
					<input type="text" name="address"><br /><br />
					<label>Joining Year:<br /></label>
					<input type="number" name="joining_year"><br /><br />
					<label>New Password:<br />
					<input type="password" name="password"></label><br /> <br />
					<input type="submit" name="submit" value="Update" style='color: white; border:none; background-color: #0066cc; border-color: #0066cc; margin-top: 10px; padding: 10px;' onclick="toggle_visibility('updateprofile')">
				</fieldset>
				</form>
				
			</div>
			<script type="text/javascript">
			<!--
			    function toggle_visibility(id) {
			       var e = document.getElementById(id);
			       if(e.style.display == 'block')
			          e.style.display = 'none';
			       else
			          e.style.display = 'block';
			    }
			//-->
			</script>

		

		

		<li data-content="leave_requests">
			<span style="position: absolute; top: 65%;left: 0px;"><b>NL:</b> Normal leave, <b>RL:</b> Retrospective leave
			<table class='applied_leaves_table' style="position: relative; top: 10px;">
				<?php 
				echo "<tr>
					<th>Name</th>
					<th>Designation</th>
					<th>Department</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>Leave type</th>
					<th>Reason</th>
					<th>Comments</th>
					<th>Decision</th>
				</tr>";
				$profile_type = $_SESSION['profile_type'];
				$username = $_SESSION['username'];


				$sql = "SELECT * FROM login_info li, emp_info ei, applied_leaves al WHERE (li.username = ei.username AND ei.username = al.username) AND ((al.approved_by = 'dean_fa' AND al.result = 'Pending' AND al.leave_type='RL') OR (  (li.profile_type='hod_cse' OR li.profile_type='hod_ee' OR li.profile_type='hod_me' OR li.profile_type='dean_fa') AND result='Pending' ));";

				$result = mysqli_query($conn, $sql);
				while ($row = mysqli_fetch_assoc($result))
				{	$uid = $row['username'];
					#$_SESSION['leave_req_username'] = $row['username'];
					echo "<tr>
				    	<td>" . $row['name'] . "</td>
						<td>" . $row['designation'] ."</td>
						<td>" . $row['department'] . "</td>
						<td>" . $row['start_date'] . "</td>
						<td>" . $row['end_date'] . "</td>
						<td>" . $row['leave_type'] . "</td>
						<td>" . $row['reason'] . "</td>
						<td>" . $row['comments'] . "</td>";
						if ($row['approved_by']=='director')
						{
							echo "<td>" . $row['result'] . "</td>";
						}
						else
						{
						echo "<td><form action='requests_comment.php' method='post'>
							<input type='radio' name='decision' value='approve'>
				    		<label for='approve'>Approve</label>
				    		<input type='radio' name='decision' value='decline'>
				    		<label for='decline'>Decline</label>
				    		<input type='text' name='comment' value='' placeholder='Add comment ...' style='width: 100px;'>
				    		<input type='text' name = 'uid' value = '". $uid ."' hidden>
				    		<input type='submit' name='submit' value='Done'>
						</form>
						</td>";
						}

					echo "</tr>";

				}

				
				?>			    

			</table>
			
		</li>

		<li data-content="others_leaves">
			<span style="position: absolute; top: 65%;left: 0px;"><b>NL:</b> Normal leave, <b>RL:</b> Retrospective leave
			<table class='applied_leaves_table' style="position: relative; top: 10px;">

				<?php 
				echo "<tr>
					<th>Name</th>
					<th>Designation</th>
					<th>Department</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>Leave type</th>
					<th>Reason</th>
					<th>Comments</th>
					<th>Decision</th>
				</tr>";
				$profile_type = $_SESSION['profile_type'];
				$username = $_SESSION['username'];

				$sql = "SELECT * FROM login_info li, emp_info ei, applied_leaves al WHERE (li.username = ei.username AND ei.username = al.username) AND  ((al.approved_by='director' AND al.result='Approved') OR (al.approved_by='dean_fa' AND result='Declined') OR ((li.profile_type = 'hod_cse' OR li.profile_type = 'hod_ee' OR li.profile_type = 'hod_me') AND result='Declined') );";
				$result = mysqli_query($conn, $sql);
				while ($row = mysqli_fetch_assoc($result))
				{
					
					echo "<tr>
				    	<td>" . $row['name'] . "</td>
						<td>" . $row['designation'] ."</td>
						<td>" . $row['department'] . "</td>
						<td>" . $row['start_date'] . "</td>
						<td>" . $row['end_date'] . "</td>
						<td>" . $row['leave_type'] . "</td>
						<td>" . $row['reason'] . "</td>
						<td>" . $row['comments'] . "</td>
						<td>" . $row['result'] . "</td>
					</tr>";

				}

				?>

			</table>
		</li>

		
		<li data-content="appoint">
			<form action="appoint.php" method="post">
			<fieldset style="width:100vh; padding-left: 30px;">
				<div></div>
				<br>
				<label>Username:<br /></label>
				<input type="text" name="username"><br /><br />
				<label>Position:<br /></label>
				<select name="profile_type">
					<option>dean_fa</option>
					<option>hod_cse</option>
					<option>hod_ee</option>
					<option>hod_me</option>
				</select>
				<legend><b>New Appointment Information: </b></legend> <br />
				<label>Start Date:<br /></label>
				<input type="date" name="start_date"><br /><br />
				<label>End Date:<br />
				<input type="date" name="end_date"></label><br /> <br />
				<input type="submit" value="Apply" style='color: white; border:none; background-color: #0066cc; border-color: #0066cc; margin-top: 10px; padding: 10px;'>
			</fieldset>
			</form>
		</li>
		<li data-content="logout">
			
		</li>
	</ul> <!-- cd-tabs-content -->
</div> <!-- cd-tabs -->
</div>
<?php 
}
else {
	header("Location: ../index.php");
	exit();
}
?>
</body>
</html>