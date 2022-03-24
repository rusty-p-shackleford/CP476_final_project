<?php

// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../authenticate/log_in.php');
	exit;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
		<meta charset="utf-8">
		<title>Team</title>
		<link rel="stylesheet" href="team.css" type="text/css">
		<!-- Add Icon to Tab -->
		<link rel="icon" sizes="any" href="../images/sportsball.png" />
		
	</head>
	<body class="loggedin">
		<nav class="navtop">
		
			<div>
				<img src="../images/OrangeBallLogo.png" alt="orangeBallLogo" class="orangeBallLogo"> 
				<h1>SportsBall</h1>
				<a href="../home/main_page.php"></i>Home</a>
				<a href="../group/group.php"></i>Group</a>
				<a href="../team/team.php"></i>Team</a>
				<a href="../roster/roster.php"></i>Roster</a>
				<a href="../authenticate/logout.php"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Team Page</h2>

			<h3><?=$_SESSION['name']?>'s Team</h3>
				<table>
						<tr>
							<th>Name</th>
							<th>Team</th>
							<th>Position</th>
							<th>Release</th>
						</tr>
						<?php 
							// connect to database
							include("../DBConfig.php");

							// set id variable from session var
							$id = $_SESSION['id'];
							
							//Need to get current user's group_id
							$result = mysqli_query($conn, "SELECT `group_id` FROM `users` WHERE `user_id` = '".$id."'");
							$groupID = ($result->fetch_assoc())['group_id'];
							
							//Need to get groupname from user's group groupname field
							$result = mysqli_query($conn, "SELECT `group_name`, `group_sport` FROM `groups` WHERE `group_id` = '".$groupID."'");
							$row = $result->fetch_assoc();

							//Set local variables
							$groupName = $row['group_name'];
							$groupSport = $row['group_sport'];//Use groupsport as name of group column in table 

							// set session variables
							$_SESSION['groupsport'] = $groupSport; 
							$_SESSION['groupname'] = $groupName; 
			
						//Only show players who are on this users team
						$result = mysqli_query($conn, "SELECT `Player_Name`,`Team`,`Pos` FROM ".$groupSport." WHERE ".$groupName." = '$id'"); 
						
							while($row = mysqli_fetch_array($result)) {?>
						
						<tr>
							
							<td><?php echo $row['Player_Name'];?></td>
							<td><?php echo $row['Team'];?></td>
							<td><?php echo $row['Pos'];?></td>
							<td><?php echo "<a href='remove.php?Player_Name=".$row['Player_Name']."'><input type='button' class='releasebtn' value ='Release'></a>"?></td>

						</tr>
						<?php } ?>
				</table>

			
		</div>
	</body>
</html>
