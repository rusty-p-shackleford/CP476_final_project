<?php 
    
    // start session
    session_start();	

    // make sure connection is added
    include("../DBConfig.php");
    
    // get id and playername variables
    $id = $_SESSION['id'];
    $newGroupID = $_GET['groupid'];

    //Get maximum number of group members in new group
    $result = mysqli_query($conn, "SELECT `max_members` FROM `groups` WHERE `group_id`=".$newGroupID);
    $groupMax = ($result->fetch_assoc())["max_members"];

    //Find number of current members in new group
    $groupCount = mysqli_num_rows(mysqli_query($conn, "SELECT `user_id` FROM `users` WHERE `group_id`=".$newGroupID));

    //Check that group membership isn't already full
    if($groupCount < $groupMax){	

	    /*Check if user already in a group, the delete user's players in old group */

	    // Get users old group id
	    //$result = mysqli_query($conn, "SELECT `group_id` FROM `users` WHERE `user_id`=".$id);
	    //$oldGroupID = ($result->fetch_assoc())["group_id"];

	    if(isset($_SESSION['groupid'])){ //If groupid is not null, then user is currently in a group
		
		    //Need to get user's current groupname from user's group groupname field
		    $result = mysqli_query($conn, "SELECT `group_name`, `group_sport` FROM `groups` WHERE `group_id` = ".$_SESSION['groupid']);
		    $row = $result->fetch_assoc();

		    //Set local variables
		    $groupName = $row['group_name'];
		    $sportTableName = $row['group_sport'];

		    //release all players on a users team when they leave a group
		    if(mysqli_query($conn, "UPDATE `".$sportTableName."` SET `".$groupName."` = 0 WHERE `".$groupName."` = ".$id)){ 
	    
			// update roster to remove user from their old group
			mysqli_query($conn, "UPDATE `users` SET `group_id` = NULL WHERE `user_id` = '$id'");

		    }
	    }		
	    /*		*/
	
	    // update roster to add user to the new group
	    mysqli_query($conn, "UPDATE `users` SET `group_id` = '$newGroupID' WHERE `user_id` = '$id'");

	    //Update session variables
	    $_SESSION['groupid'] = $newGroupID;

	    // set header
	    header("Location: group.php");
	
    }else{

	echo ("<script LANGUAGE='JavaScript'> window.alert('Group is already at capacity. Please try joining another group.');window.location.href='group.php';</script>");
    }

    // refresh the page
    echo '<meta http-equiv="refresh">';

 

?>
