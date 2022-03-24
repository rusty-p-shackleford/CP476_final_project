<?php

// start session
session_start();

// if not logged in redirect to login page
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../authenticate/log_in.php');
	exit;
}

//Global Constants
define("MIN_PSWD_LEN", 6);

// Create connection
include("../DBConfig.php");

// set header
header("Location: group.php");

// check if data was submitted
if (!isset($_POST['groupname'], $_POST['sport'], $_POST['maxGroupSize'])) {
	
	echo ("<script LANGUAGE='JavaScript'> window.alert('All fields are Required!');window.location.href='createNewGroup.php';</script>");

}else if (empty($_POST['groupname']) || empty($_POST['sport']) || empty($_POST['maxGroupSize'])) {// Check the values are not empty.
	
	echo ("<script LANGUAGE='JavaScript'> window.alert('All fields are Required!');window.location.href='createNewGroup.php';</script>");

}else if ($_POST['maxGroupSize'] < 2) {// Ensure the group number is at least 2
	
	echo ("<script LANGUAGE='JavaScript'> window.alert('A group must have space for at least 2 members!');window.location.href='createNewGroup.php';</script>");

}else if ($stmt = $conn->prepare('SELECT `group_name` FROM `groups` WHERE `group_name` = ?')) {// check if the group exists.

	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('s', $_POST['groupname']);
	$stmt->execute();
	$stmt->store_result();

	if ($stmt->num_rows > 0) {// If group name is already taken
		
		echo ("<script LANGUAGE='JavaScript'> window.alert('Group name already exists. Please choose another name and try again.'); window.location.href = 'createNewGroup.php';</script>");

	} else {//Create new group
		
		if ($stmt = $conn->prepare('INSERT INTO `groups` (`group_name`, `group_sport`, `max_members`) VALUES (?, ?, ?)')) {
			
			$stmt->bind_param('sss', $_POST['groupname'], $_POST['sport'], $_POST['maxGroupSize']);
			$stmt->execute();

		        //Check if user already in a group, if so then delete user's players in old group 
		        if(isset($_SESSION['groupid'])){ 
			
			    //Need to get user's current groupname from user's group groupname field
			    $result = mysqli_query($conn, "SELECT `group_name`, `group_sport` FROM `groups` WHERE `group_id` = ".$_SESSION['groupid']);
			    $row = $result->fetch_assoc();

			    //release all players on a users team when they leave a group
			    if(mysqli_query($conn, "UPDATE `".$row['group_sport']."` SET `".$row['group_name']."` = 0 WHERE `".$row['group_name']."` = ".$_SESSION['id'])){ 
		    
				// update roster to remove user from their old group
				mysqli_query($conn, "UPDATE `users` SET `group_id` = NULL WHERE `user_id` = '$id'");

			    }
		        }

			//Get user's new group id from groups table
			$stmt = $conn->prepare('SELECT `group_id` FROM `groups` WHERE `group_name` = ?');
			$stmt->bind_param('s', $_POST['groupname']);
			$stmt->execute();
			$result = $stmt->get_result();
			$groupID = ($result->fetch_assoc())['group_id'];

			//Add user who created the group as member of the group
			$result = mysqli_query($conn, "UPDATE `users` SET `group_id` = ".$groupID." WHERE `user_id` = ".$_SESSION['id']."");
			//$stmt = $conn->prepare('UPDATE users SET groupid = ? WHERE id = ?');
			//$stmt->bind_param('ss', $groupID, $_SESSION['id']);
			//$stmt->execute()

			// set sports table name = to whatever sport user choose
			$sportTableName = $_POST['sport'];
		
			//Add column to relavant sport database
			$result = mysqli_query($conn, "ALTER TABLE ".$sportTableName." ADD `".$_POST['groupname']."` INT NOT NULL");
			//$stmt = $conn->prepare("ALTER TABLE hockeyPlayers ADD ? INT NOT NULL");
			//$stmt->bind_param('s', $_POST['groupname']);
			//$stmt->execute();
			
			
			echo ("<script LANGUAGE='JavaScript'> window.alert('Group has been successfully created.');window.location.href='group.php';</script>");
		} else {
			
			echo ("<script LANGUAGE='JavaScript'> window.alert('Group creation was not successful.');window.location.href='createNewGroup.php';</script>");
		}
	}
	//Housekeeping
	$stmt->close();
} else {
	
	echo ("<script LANGUAGE='JavaScript'> window.alert('Group unable to be created at this time.');window.location.href='createNewGroup.php';</script>");
}
//Housekeeping
$conn->close();

?>
