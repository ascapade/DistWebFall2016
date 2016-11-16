<?php
	session_start();
	
	$message = true;
	
	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
		$_SESSION['loggedin'] = false;
		if(isset($_SESSION['username']))
		{
			$_SESSION['username'] = "";
		}
		echo $_SESSION['loggedin'];
	}
	else {
		echo "error";
	}
?>