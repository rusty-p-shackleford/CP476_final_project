<?php

// start session
session_start();

// if not logged in redirect to login page
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../authenticate/log_in.php');
	exit;
}

// Connect to database
include("../DBConfig.php");

// get account info from database
$stmt = $conn->prepare('SELECT password, email, group_id FROM users WHERE user_id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();

//Bind result of query
$stmt->bind_result($password, $email, $groupID);
$stmt->fetch();
$stmt->close();

//Set session variables
$_SESSION['groupid'] = $groupID;

?>

<!DOCTYPE html>

<html>
	
	<head>
		
		<!--  link references -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
		<meta charset="utf-8">
		<title>Home</title>
		<link rel="stylesheet" href="main_page.css">
		<!-- Add Icon to Tab -->
		<link rel="icon" sizes="any" href="../images/sportsball.png" />
		
	</head>
	
	<body class="loggedin">
		
		<!--  create nav bar -->
		<nav class="navtop">

			<div>
				<img src="../images/OrangeBallLogo.png" alt="orangeBallLogo" class="orangeBallLogo"> 
				<h1>SportsBall</h1>
				<a href="./main_page.php"></i>Home</a>
				<a href="../group/group.php"></i>Group</a>
				<a href="../team/team.php"></i>Team</a>
				<a href="../roster/roster.php"></i>Roster</a>
				<a href="../authenticate/logout.php"></i>Logout</a>
			
			</div>

		</nav>

		<!--  fill in homepage content -->
		<div class="content">
			
			<h2>Home Page</h2>
			<p>Welcome back, <?=$_SESSION['name']?>!</p>
			
			<div class="profile">
			<h2>Profile</h2>
			<div>
				<table>
					<tr>
						<td>Username:</td>
						<td><?=$_SESSION['name']?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?=$email?></td>
					</tr>
					<tr>
						<td>Photo:</td>
						<td>
							<form action="uploadProfilePicture.php" method="POST" endtype="multipart/form-data">
							<img src="../images/defaultProfilePic.png" alt="defaultProfilePic" class="defaultProfilePic">
							<br>
							<input class="browse" type="file" name="file">
							<br>
							<input class="upload" type="submit" name="submit" value="Upload Photo">
							</form>
						</td>
					</tr>
				</table>
			</div>
			
		</div>

	</body>

</html>
