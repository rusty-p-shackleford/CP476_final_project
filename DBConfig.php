<?php
//This is the file you call when you want access to the 'sportsball' database
//After calling include(../DBConfig.php); in a file you can then access $conn in that file

// local sql variables
$servername = "localhost";
$username = "root";
$serverpassword = "Put-Password-Here";
$dbname = "Put-Database-Name-Here";

// create a connection to database
$conn = new mysqli($servername, $username, $serverpassword, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>
