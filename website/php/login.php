<?php
	//Includes the php file that connects to the database.
	//The variable used is $database and is a mysqli object.
	include("config.php");
	session_start();
	
	$email = $database->real_escape_string($_POST['loginEmail']); //Gets user's email from the email field
	$pass = $database->real_escape_string($_POST['loginPassword']); //Get the user's password from the password field
	
	//hashes the password
	$pass = hash('sha256', $pass);
	
	//query statement
	$sql = "SELECT * FROM customers WHERE email='$email'";
	
	//gets the result of the query
	$result = $database->query($sql);
	
	//puts the query result into an associative array
	$row = $result->fetch_array(MYSQLI_ASSOC);
	
	//count the number of rows returned
	$count = $result->num_rows;
	
	//if only one row is returned and the password is correct
	if($count == 1 && $row['password'] == $pass)
	{
		//creates a session variable to indicate that a user is logged in
		$_SESSION['username'] = $email;
		$_SESSION['loggedin'] = true;
		
		//Returns the user to a specified address, in this case it's the index page of the website
		header("Location: ../index.html");
	}
	
	//if a number of rows other than 1 is returned, or if the password is incorrect
	else
	{
		$error = "Incorrect login credentials.";
		header("Location: ../index.html");
	}
?>