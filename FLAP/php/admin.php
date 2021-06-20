<?php
session_start();

if (isset($_SESSION['username'])) {

?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Webpage</title>
	<link rel="stylesheet" type="text/css" href="../css/admin.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="../js/admin.js"></script>
	
</head>
<body>
	<div>
	<div class="cd-tabs">
	<nav>
		<ul class="cd-tabs-navigation" style="width: 100%;">
			<li><a data-content="profile" class="selected" href="#0">Profile</a></li>
			<li><a data-content="create_user" href="#0">Create User</a></li>
			<li><a data-content="delete_user" href="#0">Delete User</a></li>
			<li><a data-content="update_credentials" href="#0">Update Credentials</a></li>
			<li><a data-content="accounts_info" href="#0">All accounts</a></li>
			<li><a data-content="login_sessions" href="#0">Login Sessions</a></li>
			<li><a data-content="logout" href="#" onclick="window.location.href = 'logout.php'">Logout</a></li>
		</ul> <!-- cd-tabs-navigation -->
	</nav>

	<ul class="cd-tabs-content" style="color: black;">
		<li data-content="profile" class="selected">

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
							</tr>";
						}
					}
								
					
			    ?>


			</table>


		<li data-content="create_user">
			<form action="create_user.php" method="post">
				<fieldset style="width:50vw;padding-left: 30px;">
					<legend><b>New user's information: </b></legend> <br />
					<label>Department:<br /></label>
					<select name="department">
						<option selected>CSE</option>
						<option>EE</option>
						<option>ME</option>
					</select><br><br>
					<label>Username:<br /></label>
					<input type="text" name="username"><br /><br />
					<label>Password:<br />
					<input type="text" name="password"></label><br /> <br />
					<!-- <label>Admin Password:<br />
					<input type="password" name="password"></label><br /> <br /> -->
					<input type="submit" name="submit" value="Create Account" style="color: white; border:none; background-color: #0066cc; border-color: #0066cc; margin-top: 10px; padding: 10px;">
				</fieldset>	
			</form>
			
		</li>

		<li data-content="delete_user">
			<form action="delete_user.php" method="post">
				<fieldset style="width:50vw;padding-left: 30px;">
					<legend><b>Delete user's information: </b></legend> <br />
					<label>Username:<br /></label>
					<input type="text" name="username"><br /><br />
					<input type="submit" name="submit" value="Delete Account" style="color: white; border:none; background-color: #0066cc; border-color: #0066cc; margin-top: 10px; padding: 10px;">
				</fieldset>
			</form>
		</li>


		<li data-content="update_credentials">
			<form action="update_credentials.php" method="post">
			<fieldset style="width:50vw;padding-left: 30px;">
				<legend><b>Update user's credentials: </b></legend> <br />
				<label>Username:<br /></label>
				<input type="text" name="username"><br /><br />
				<label>New Password:<br />
				<input type="text" name="password"></label><br /> <br />
				<input type="submit" name="submit" value="Update Password" style="color: white; border:none; background-color: #0066cc; border-color: #0066cc; margin-top: 10px; padding: 10px;">
			</fieldset>
			</form>
		</li>

		<li data-content="accounts_info">
			
			<table class='table_style'>
				
				<tr>
					<th>Profile Type</th>
					<th>Username</th>
					<th>Password</th>
					<th>Name</th>
					<th>Designation</th>
					<th>Department</th>
					<th>Email ID</th>
					<th>Address</th>
					<th>Joining Year</th>
					<th>Leaves Left</th>
					
				</tr>

				<?php
					require_once "config.php";
					$sql = "SELECT * FROM login_info li, emp_info ei,leaves_count lc WHERE li.username = ei.username AND lc.username = li.username;";
					$result = mysqli_query($conn, $sql);
					while ($row = mysqli_fetch_assoc($result)) {
						echo "<tr>";
							echo "<td>" . $row['profile_type'] . "</td>";
							echo "<td>" . $row['username'] . "</td>";
							echo "<td>" . $row['password'] . "</td>";
							echo "<td>" . $row['name'] . "</td>";
							echo "<td>" . $row['designation'] . "</td>";
							echo "<td>" . $row['department'] . "</td>";
							echo "<td>" . $row['email_id'] . "</td>";
							echo "<td>" . $row['address'] . "</td>";
							echo "<td>" . $row['joining_year'] . "</td>";
							$rem = 12 - $row['used_leaves'];
							echo "<td>" . $rem . "</td>";
						echo "</tr>";		
					    #echo $row['id'] . " " . $row['name'] . " " . $row['dept'];
					    #echo "<br>";
					}
					
			    ?>

			</table>
		</li>

		<li data-content="login_sessions">
			<table class='table_style'>
				<?php

					echo "<tr>
						<th> Username </th>
						<th> Last Login</th>
						<th> Last Logout</th>
					</tr>";
				    

					require_once "config.php";
					$sql = "SELECT * FROM login_sessions";
					$result = mysqli_query($conn, $sql);
					while ($row = mysqli_fetch_assoc($result)) {	
						echo "<tr>";

				    	echo "<td>" . $row['username'] . "</td>";
				    	echo "<td>" . $row['login_time'] . "</td>";
				    	echo "<td>" . $row['logout_time'] . "</td>";
					
						echo "</tr>";
					}
				?>
			</table>
		</li>


		<li data-content="logout">
			<!-- <button style='color: white; border:none; background-color: #0066cc; border-color: #0066cc; margin-top: 10px; padding: 10px;'>Logout</button>
			-->
		</li>

	</ul> <!-- cd-tabs-content -->
</div> <!-- cd-tabs -->
</div>

<?php 
}
else {
	header("Location: .../index.php");
	exit();
}
?>
</body>
</html>