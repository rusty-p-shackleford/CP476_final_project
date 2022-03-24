<?php 
    
    // start session
    session_start();

    // set header
    header ("location: roster.php");	

    // make sure connection is added
    include("../DBConfig.php");
    
    // set id and playername variables
    $id = $_SESSION['id'];
    $player_name = $_GET['Player_Name'];
    $groupName = $_SESSION['groupname']; //Is the name of the column in the groupsport's table.
    $sportTableName = $_SESSION['groupsport'];
   
    // update roster to add player to the users team
    mysqli_query($conn, "UPDATE ".$sportTableName." SET ".$groupName." = ".$id." WHERE Player_Name = '".$player_name."'");

    // refresh the page
    echo '<meta http-equiv="refresh">';

?>
