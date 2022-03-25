<?php 

    // start session
    session_start();

    // set header
    header ("location: team.php");	
			
    // connect to database
    include("../DBConfig.php");	
	
    // get session variables
    $id = $_SESSION['id'];
    $player_name = $_GET['Player_Name'];
    $groupName = $_SESSION['groupname']; //Is the name of the column in the groupsport's table.
    $sportTableName = $_SESSION['groupsport'];

    // remove appropriate player from current users team
    
    mysqli_query($conn, "UPDATE $sportTableName SET $groupName = 0 WHERE Player_Name = '$player_name'");
    
    //Refreash page
    echo '<meta http-equiv="refresh">';

?>
