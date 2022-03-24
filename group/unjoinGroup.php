<?php 
    
    // start session
    session_start();	

    //Return to group page
    header("location: group.php");

    // make sure connection is added
    include("../DBConfig.php");
    
    // get id and playername variables
    $id = $_SESSION['id'];
    $groupID = $_GET['groupid'];

    //Get groupname and groupsport
    $groupName = $_GET['groupname'];
    $sportTableName = $_GET['groupsport'];

    //Need release all players on a users team when they leave a group
    if(mysqli_query($conn, "UPDATE `".$sportTableName."` SET `".$groupName."` = 0 WHERE `".$groupName."` = '$id'")){ 
    
	// update roster to remove user from the group
	mysqli_query($conn, "UPDATE `users` SET `group_id` = NULL WHERE `user_id` = '$id'");

    }else{
	echo ("<script LANGUAGE='JavaScript'> window.alert('Unable to unjoin group at this time. Please try again later.');window.location.href='group.php';</script>");
    }
    // refresh the page
    echo '<meta http-equiv="refresh">';

?>
