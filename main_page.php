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
			<h3><?=$_SESSION['name']?>'s Lineup</h3>
				
			<div class="lineup">
				<?php
				// connect to database
				include("../DBConfig.php");

				// set id variable from session var
				$id = $_SESSION['id'];
				
				//Need to get current user's group_id
				$result = mysqli_query($conn, "SELECT `group_id` FROM `users` WHERE `user_id` = '".$id."'");
				$groupID = ($result->fetch_assoc())['group_id'];
				if($groupID != NULL){
				
				//Need to get groupname from user's group groupname field
				$result = mysqli_query($conn, "SELECT `group_name`, `group_sport` FROM `groups` WHERE `group_id` = '".$groupID."'");
				$row = $result->fetch_assoc();

				//Set local variables
				$groupName = $row['group_name'];
				$groupSport = $row['group_sport'];//Use groupsport as name of group column in table 
				//[NOTE: Groupsport can be: (Hockey, Baseball, Football, Soccer, Basketball)]

				// set session variables
				$_SESSION['groupsport'] = $groupSport; 
				$_SESSION['groupname'] = $groupName; 

				$id = $_SESSION['id'];			
				$lineup_id = $id + 5000;
				//Need to get current user's group_id

				$result = mysqli_query($conn, "SELECT `Player_Name` FROM $groupSport WHERE $groupName = $lineup_id AND `pos` = 'LW'");
				$row = mysqli_fetch_assoc($result);
				$leftwinger = $row['Player_Name'];
				$result = mysqli_query($conn, "SELECT `Player_Name` FROM $groupSport WHERE $groupName = $lineup_id AND `pos` = 'RW'");
				$row = mysqli_fetch_assoc($result);
				$rightwinger = $row['Player_Name'];
				$result = mysqli_query($conn, "SELECT `Player_Name` FROM $groupSport WHERE $groupName = $lineup_id AND `pos` = 'C'");
				$row = mysqli_fetch_assoc($result);
				$centrer = $row['Player_Name'];
				$result= mysqli_query($conn, "SELECT `Player_Name` FROM $groupSport WHERE $groupName = $lineup_id AND `pos` = 'D'");
				$row = mysqli_fetch_assoc($result);
				$leftdefenser = $row['Player_Name'];
				$leftdefenserest = strval($leftdefenser);
				$result = mysqli_query($conn, "SELECT `Player_Name` FROM $groupSport WHERE $groupName = $lineup_id AND `pos` = 'D' AND `Player_Name` != '$leftdefenserest'");
				$row = mysqli_fetch_assoc($result);
				$rightdefenser = $row['Player_Name'];
				$result = mysqli_query($conn, "SELECT `Player_Name` FROM $groupSport WHERE $groupName = $lineup_id AND `pos` = 'G'");
				$row = mysqli_fetch_assoc($result);
				//$goalier = $row['Player_Name'];
				?>
				
				<table class="front">
					<tr>
						<th>Leftwing</th>
						<th>Centre</th>
						<th>Rightwing</th>
					</tr>
					<tr>
						<td><?php echo $leftwinger; ?></td>
						<td><?php echo $centrer; ?></td>
						<td><?php echo $rightwinger; ?></td>
					</tr>
				</table>
				<table class="defense">
					<tr>
						<th>Defense</th>
						<th>Defense</th>
					</tr>
					<tr>
						<td><?php echo $leftdefenser; ?></td>
						<td><?php echo $rightdefenser; ?></td>
					</tr>
				</table>
				<table class="goalies">
					<tr>
						<th>Goalie</th>
					</tr>
					<tr>
						<td><!--<?php echo $goalier;  ?>--></td>
					</tr>
				</table>
			</div>
			<?php }?>
			
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
