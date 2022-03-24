
<!DOCTYPE html>

<?php

//start the session
session_start();

// create connection to database
include("../DBConfig.php");

// check if login data was submitted
if ( !isset($_POST['usrname'], $_POST['pswd']) ) {
	
	exit('Both username and password fields are required!');
}

if ($stmt = $conn->prepare("SELECT user_id, password FROM users WHERE username = ?")) {
	
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bind_param('s', $_POST['usrname']);
	$stmt->execute();
	$stmt->store_result();

	if ($stmt->num_rows > 0) {
		$stmt->bind_result($id, $password);
		$stmt->fetch();
		
		// verify the password.
		if (password_verify($_POST['pswd'], $password)) {

			// Create a session so we know the user is logged in
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['name'] = $_POST['usrname'];
			$_SESSION['id'] = $id;

			//Rdiredt to user homepage
			header('Location: ../home/main_page.php');

		} else {
			// password incorrect
		echo ("<script LANGUAGE='JavaScript'> window.alert('Password is incorrect.');window.location.href='log_in.php';</script>");

		}
	} else {
		// username incorrect
		echo ("<script LANGUAGE='JavaScript'> window.alert('Username is incorrect or user does not exist.');window.location.href='log_in.php';</script>");

	}
	//Housekeeping
	$stmt->close();
}
//Housekeeping
$conn->close();

?> 
