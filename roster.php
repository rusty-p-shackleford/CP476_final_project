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
		<title>Roster</title>
		<link rel="stylesheet" href="roster.css" type="text/css">
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
			<h2>Roster Page</h2>

				<form action = "roster.php" method="POST">

					<div class="input">

						<input type="text" name="search" placeholder="Search" value="<?php if(isset($_GET['search'])){echo $_GET['search'];}?>" class="search-field">
						<button type="submit" name="searchbtn" class="search-button">Search</button>

					</div>

				</form>

			<h3>Available players</h3>
				<table>
						<tr>
							<th>Name </th>
							<th>Team</th>
							<th>Position</th>
							<th>Acquisitions</th>
						</tr>
						<?php 
							// connect to database
							include("../DBConfig.php");

							// set id variable from session var
							$id = $_SESSION['id'];
							
							//Need to get current user's group_id
							$result = mysqli_query($conn, "SELECT `group_id` FROM `users` WHERE `user_id` = ".$id."");
							$groupID = ($result->fetch_assoc())['group_id'];
							
							if (!isset($groupID)){
								echo ("<script LANGUAGE='JavaScript'> window.alert('Please Join A Group To See Roster!');window.location.href='../group/group.php';</script>");
							}
							
							//Need to get groupname from user's group groupname field
							$result = mysqli_query($conn, "SELECT `group_name`, `group_sport` FROM `groups` WHERE `group_id` = ".$groupID."");
							$row = $result->fetch_assoc();

							//Set local variables
							$groupName = $row['group_name'];
							$groupSport = $row['group_sport'];//Use groupsport as name of group column in table 
							//[NOTE: Groupsport can be: (Hockey, Baseball, Football, Soccer, Basketball)]

							// set session variables
							$_SESSION['groupsport'] = $groupSport; //Table 
							$_SESSION['groupname'] = $groupName; //Column in table

							if (isset($_POST['searchbtn'])){

								$search = $_POST['search'];
								$result = mysqli_query($conn, "SELECT * FROM $groupSport WHERE `Player_Name` LIKE '%$search%' AND `".$groupName."` = 0 or `Team` LIKE '%$search%' AND `".$groupName."` = 0 OR `Pos` LIKE '%$search%' AND `".$groupName."` = 0");
	
								}
							else{
	
								$result = mysqli_query($conn, "SELECT `Player_Name`,`Team`,`Pos` FROM $groupSport WHERE `".$groupName."` = 0"); 
	
								}
						
							while($row = mysqli_fetch_array($result)) { ?>
						
							<tr>
								<td><?php echo $row['Player_Name'];?></td>
								<td><?php echo $row['Team'];?></td>
								<td><?php echo $row['Pos'];?></td>
								<td><?php echo "<a href='acquire.php?Player_Name=".$row['Player_Name']."'><input type='button' class='acquirebtn' value='Acquire'></a>"?></td>					
							</tr>
						<?php } ?>
				</table>
		</div>
	</body>
	
</html>
