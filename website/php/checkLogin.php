<?php
	session_start();
	
	$message = false;
	
	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
		echo $_SESSION['username'];
	}
	else {
		echo $message;
	}
?>