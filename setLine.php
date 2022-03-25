<?php 

    // start session
    session_start();

    // set header
    header ("location: team.php");	
			
    // connect to database
    include("../DBConfig.php");	
	
    // get session variables
    $id = $_SESSION['id'];
	$id = $id + 5000;

	$leftwing = $_POST['leftwing'];
	$rightwing = $_POST['rightwing'];
	$centre = $_POST['centre'];
	$leftdefense = $_POST['leftdefense'];
	$rightdefense = $_POST['rightdefense'];
	$goalie = $_POST['goalie'];
	
    $groupName = $_SESSION['groupname']; //Is the name of the column in the groupsport's table.
    $sportTableName = $_SESSION['groupsport'];
	
    mysqli_query($conn, "UPDATE $sportTableName SET $groupName = $id - 5000 WHERE $groupName = $id");
    mysqli_query($conn, "UPDATE $sportTableName SET $groupName = $id WHERE Player_Name = '$leftwing'");
    mysqli_query($conn, "UPDATE $sportTableName SET $groupName = $id WHERE Player_Name = '$rightwing'");
    mysqli_query($conn, "UPDATE $sportTableName SET $groupName = $id WHERE Player_Name = '$centre'");
    mysqli_query($conn, "UPDATE $sportTableName SET $groupName = $id WHERE Player_Name = '$leftdefense'");
    mysqli_query($conn, "UPDATE $sportTableName SET $groupName = $id WHERE Player_Name = '$rightdefense'");
    mysqli_query($conn, "UPDATE $sportTableName SET $groupName = $id WHERE Player_Name = '$goalie'");

    
    //Refresh page
    echo '<meta http-equiv="refresh">';

?>