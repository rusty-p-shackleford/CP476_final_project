<?php

// start session
session_start();

// if not logged in redirect to the login page

if (!isset($_SESSION['loggedin'])) {
	header('Location: ../authenticate/log_in.php');
	exit;
}
?>

<!DOCTYPE html>

<html>
	
	<head>
		
		<!-- link references -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
		<meta charset="utf-8">
		<title>Group</title>
		<link rel="stylesheet" href="group.css">
		<!-- Add Icon to Tab -->
		<link rel="icon" sizes="any" href="../images/sportsball.png" />
		
	</head>
	<body class="loggedin">
		
		<!-- create navtop -->
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
			<h2>Group Page</h2>

			<h3><?=$_SESSION['name']?>'s Group</h3>
				
				<!-- Create group button-->
				<?php echo "<a href='createNewGroup.php'><button class='button createGroup'>Create New Group</button></a>" ?>
				
				<!-- Join group table -->
				<table>
						<tr>
							<th>Group Name</th>
							<th>Group Sport</th>
							<th>Members</th>
							<th>Join Group</th>
						</tr>
						<!--<?php echo 'try this' ?>-->
						<?php 
						// connnect to database
						include("../DBConfig.php");

						// set id variable from session var
						$id = $_SESSION['id'];
						
						$result = mysqli_query($conn, "SELECT `group_id`,`group_name`,`group_sport`,`max_members` FROM `groups`"); 

						while($row = mysqli_fetch_array($result)) {

						// Count number of people currently in each group	
						$groupCount = mysqli_query($conn, "SELECT user_id FROM `users` WHERE `group_id` = ".$row['group_id']);
						
						//Get 2d array of sql results
						$arr = $groupCount->fetch_all();

						//Set default value for variable
						$isMemberOfGroup = false;

						//Loop through 2d array of user ids of group members
						foreach ($arr as $key => $value) {

							//If user id is in array, then user is member of that group
							if($value[0] == $_SESSION['id']){
								$isMemberOfGroup = true;
								break;
							}
						} 
						// get the number of members in the current group
						$numGroupMembers =  mysqli_num_rows($groupCount);

						if($numGroupMembers == 0){// Group has zero members, delete the group
							
							// delete group from groups table where groups have no members
							mysqli_query($conn, "DELETE FROM `groups` WHERE `group_id` = ".$row['group_id']."");

							// delete group column from sports table
							mysqli_query($conn, "ALTER TABLE `".$row['group_sport']."` DROP `".$row['group_name']."`");
						}else{
						?>
						
						<tr>
							<td><?php echo $row['group_name'];?></td>
							<td><?php echo $row['group_sport'];?></td>
							<td><?php echo $numGroupMembers . " / " . $row['max_members'];?></td>

							<!-- Checks users id against ids in result to see if user is in that group-->
							<?php if($isMemberOfGroup){ ?>

							<td><?php echo "<a href='unjoinGroup.php?groupid=".$row['group_id']."&groupname=".$row['group_name']."&groupsport=".$row['group_sport']."'><input type='button' value ='Unjoin'></a>"?></td>
							<?php }else{ ?>
							<td><?php echo "<a href='joinGroup.php?groupid=".$row['group_id']."'><input type='button' value ='Join'></a>"?></td>
							<?php } ?>
						</tr>
						<?php } ?>
					<?php } //To close while loop ?>
				</table>
					
		</div>
	</body>
</html>
