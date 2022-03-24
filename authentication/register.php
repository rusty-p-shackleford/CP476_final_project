<?php

//Global Constants
define("MIN_PSWD_LEN", 6);

// Create connection
include("../DBConfig.php");

// check if data was submitted
if (!isset($_POST['usrname'], $_POST['pswd'], $_POST['email'])) {
	
	echo ("<script LANGUAGE='JavaScript'> window.alert('All fields are required!');window.location.href='registration.php';</script>");

}else if (empty($_POST['usrname']) || empty($_POST['pswd']) || empty($_POST['email'])) {// Check the values are not empty.
	
	echo ("<script LANGUAGE='JavaScript'> window.alert('All fields are required!');window.location.href='registration.php';</script>");

}else if (strlen($_POST['pswd']) < MIN_PSWD_LEN) { //Checks for password 
	
	echo ("<script LANGUAGE='JavaScript'> window.alert('Minimum Required Password Length is " . MIN_PSWD_LEN . " Characters!');window.location.href='registration.php';</script>");
}else if (! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){// Checks for e-mail

	echo ("<script LANGUAGE='JavaScript'> window.alert('Email address is not valid!');window.location.href='registration.php';</script>");

}else if ($stmt = $conn->prepare('SELECT user_id, password FROM users WHERE username = ?')) {// Check if the account exists.

	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('s', $_POST['usrname']);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) { // Account with that user name already exists
		
		echo ("<script LANGUAGE='JavaScript'> window.alert('Username already exists, try again.');window.location.href='registration.php';</script>");
	
	} else { // Create new account
		
		if ($stmt = $conn->prepare('INSERT INTO users (username, password, email) VALUES (?, ?, ?)')) {
			
			$password = password_hash($_POST['pswd'], PASSWORD_DEFAULT);
			$stmt->bind_param('sss', $_POST['usrname'], $password, $_POST['email']);
			$stmt->execute();
			
			echo ("<script LANGUAGE='JavaScript'> window.alert('Account created successfully.');window.location.href='log_in.php';</script>");
		} else {
			echo ("<script LANGUAGE='JavaScript'> window.alert('Unable to create account. Please try again later.');window.location.href='registration.php';</script>");	
		}
	}
	//Housekeeping
	$stmt->close();
} else {
	
	echo ("<script LANGUAGE='JavaScript'> window.alert('Unable to create account please try again later.');window.location.href='registration.php';</script>");
}
//Housekeeping
$conn->close();

?>
