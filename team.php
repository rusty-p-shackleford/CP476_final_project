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
			<h3><?=$_SESSION['name']?>'s LineUp</h3>
				
			<div class="lineup">
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
				//[NOTE: Groupsport can be: (Hockey, Baseball, Football, Soccer, Basketball)]

				// set session variables
				$_SESSION['groupsport'] = $groupSport; 
				$_SESSION['groupname'] = $groupName; 

				$id = $_SESSION['id'];			
				$lineup_id = $id + 5000;
				//Need to get current user's group_id

				$leftwings = mysqli_query($conn, "SELECT `Player_Name` FROM ".$groupSport." WHERE ".$groupName." = '$id' AND `pos` = 'LW' OR ".$groupName." = '$lineup_id' AND `pos` = 'LW'");
				$rightwings = mysqli_query($conn, "SELECT `Player_Name` FROM ".$groupSport." WHERE ".$groupName." = '$id' AND `pos` = 'RW' OR ".$groupName." = '$lineup_id' AND `pos` = 'RW'");
				$centres = mysqli_query($conn, "SELECT `Player_Name` FROM ".$groupSport." WHERE ".$groupName." = '$id' AND `pos` = 'C' OR ".$groupName." = '$lineup_id' AND `pos` = 'C'");
				$leftdefenses = mysqli_query($conn, "SELECT `Player_Name` FROM ".$groupSport." WHERE ".$groupName." = '$id' AND `pos` = 'D' OR ".$groupName." = '$lineup_id' AND `pos` = 'D'");
				$rightdefenses = mysqli_query($conn, "SELECT `Player_Name` FROM ".$groupSport." WHERE ".$groupName." = '$id' AND `pos` = 'D' OR ".$groupName." = '$lineup_id' AND `pos` = 'D'");
				$goalies = mysqli_query($conn, "SELECT `Player_Name` FROM ".$groupSport." WHERE ".$groupName." = '$id' AND `pos` = 'G' OR ".$groupName." = '$lineup_id' AND `pos` = 'G'");?>
				<form method ="POST" action="setLine.php">
				<table class="front">
					<tr>
						<th>Leftwing</th>
						<th>Centre</th>
						<th>Rightwing</th>
					</tr>
					<tr>
						<td><select name="leftwing"><?php while ($row = mysqli_fetch_array($leftwings)) {echo '<option>'.$row['Player_Name'].'</option>';}?></select></td>
						<td><select name="centre"><?php while ($row = mysqli_fetch_array($centres)) {echo '<option>'.$row['Player_Name'].'</option>';}?></select></td>
						<td><select name="rightwing"><?php while ($row = mysqli_fetch_array($rightwings)) {echo '<option>'.$row['Player_Name'].'</option>';}?></select></td>
					</tr>
				</table>
				<table class="defense">
					<tr>
						<th>Defense</th>
						<th>Defense</th>
					</tr>
					<tr>
						<td><select name="leftdefense"><?php while ($row = mysqli_fetch_array($leftdefenses)) {echo '<option>'.$row['Player_Name'].'</option>';}?></select></td>
						<td><select name="rightdefense"><?php $count = 0; while($row = mysqli_fetch_array($rightdefenses)) {if($count == 1){echo '<option selected>'.$row['Player_Name'].'</option>';}else{echo '<option>'.$row['Player_Name'].'</option>';}$count += 1;}?></select></td>
					</tr>
				</table>
				<table class="goalies">
					<tr>
						<th>Goalie</th>
					</tr>
					<tr>
						<td><select name="goalie"><?php while ($row = mysqli_fetch_array($goalies)) {echo '<option>'.$row['Player_Name'].'</option>';}?></select></td>
					</tr>
				</table>
				<input type='submit' name='submit' class='setlinebtn' value ='Set Line Up'>
				</form>
			</div>
			
			<h3><?=$_SESSION['name']?>'s Team</h3>
				<table>
						<tr>
							<th>Name</th>
							<th>Team</th>
							<th>Position</th>
							<th>Release</th>
						</tr>
						<?php 
							
			
						//Only show players who are on this users team
						$result = mysqli_query($conn, "SELECT `Player_Name`,`Team`,`Pos` FROM ".$groupSport." WHERE ".$groupName." = '$id' OR ".$groupName." = '$lineup_id'"); 
						
							while($row = mysqli_fetch_array($result)) {?>
						
						<tr>
							
							<td><?php echo $row['Player_Name'];?> potato</td>
							<td><?php echo $row['Team'];?></td>
							<td><?php echo $row['Pos'];?></td>
							<td><?php echo "<a href='remove.php?Player_Name=".$row['Player_Name']."'><input type='button' class='releasebtn' value ='Release'></a>"?></td>

						</tr>
						<?php } ?>
				</table>

			
		</div>
	</body>
</html>
