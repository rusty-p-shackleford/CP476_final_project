<?php

//Module Constants
$ALLOWED_FILE_EXT = array("jpg", "jpeg", "png");
$MAX_FILE_SIZE = 500000; //Half a megabyte

// Connect to database
include("../DBConfig.php");

// Set header	
header("Location: main_page.php");


if(isset($_POST['submit']) && isset($_FILES['file'])){

	//Get reference to file
	$file = $_FILES['file'];

	//Get references to file attributes
	$fileName = $_FILES['file']['name'];
	$fileTmpName = $_FILES['file']['tmp_name'];//Is the temporary location of the file
	$fileSize = $_FILES['file']['size'];
	$fileError = $_FILES['file']['error'];
	$fileType = $_FILES['file']['type'];

	//If there was an error uploading the file
	if($fileError !== 0){
		echo ("<script LANGUAGE='JavaScript'> window.alert('Error uploading file.');window.location.href='main_page.php';</script>");
	}
	//If the file is too large
	if($fileSize > $MAX_FILE_SIZE){
		echo ("<script LANGUAGE='JavaScript'> window.alert('File too large.');window.location.href='main_page.php';</script>");
	}

	//Get the file extension (ie. split the string) : Returns an array
	$fileNameSplit = explode('.', $fileName);
	$fileExt = strtolower(end($fileNameSplit));

	//If user submitted file has permitted extension
	if(in_array($fileExt, $ALLOWED_FILE_EXT)){
		
		//Create new file name for storing on server
		$newFileName = uniqid('', true) .".". $fileExt;

		//Set new file path to destition folder on server
		$fileDestination = "../images/".$newFileName;

		//Move file from temporary location to new perminant destination
		move_uploaded_file($fileTmpName, $fileDestination);		

		//Add new filename and filepath to user's sql row !!!


	}else{
		echo ("<script LANGUAGE='JavaScript'> window.alert('File type not allowed. Please choose another photo.');window.location.href='main_page.php';</script>");
	}
	
	// refresh the page
    	echo '<meta http-equiv="refresh">';
}

?>
