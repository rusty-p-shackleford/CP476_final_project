<?php

session_start();

// destroy session
session_destroy();

// redirect to the login page:
header('Location: log_in.php');

?>
