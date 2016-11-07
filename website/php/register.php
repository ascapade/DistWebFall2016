<?php
	//Includes the php file that connects to the database.
	//The variable used is $database and is a mysqli object.
	include("config.php");
	session_start();
	
	$fname = $database->real_escape_string($_POST['fname']); //Get first name field
	$lname = $database->real_escape_string($_POST['lname']); //Get last name field
	$email = $database->real_escape_string($_POST['email']); //Get email field
	$location = $database->real_escape_string($_POST['location']); //Get location/address field
	$pass = $database->real_escape_string($_POST['password']); //Get password field
	
	//name validation
	if(empty($fname) || empty($lname))
	{
		$error = true;
		$nameerror = "Please enter a first and last name.";
	}
	
	//email validation
	$emailquery = "SELECT email FROM customers WHERE email=$email";
	$emailqueryresult = $database->query($emailquery);
	$emailqueryrows = $emailqueryresult->num_rows;
	if($emailqueryrows != 0)
	{
		$error = true;
		$emailerror = "Email is in use.";
	}
	else if(empty($email))
	{
		$error = true;
		$emailerror = "Please enter an email";
	}
	
	//password validation
	if(empty($pass))
	{
		$error = true;
		$passerror = "Please enter a password.";
	}
	
	//location validation
	if(empty($location))
	{
		$error = true;
		$locerror = "Location can not be blank.";
	}
	
	//Hash the password before inserting it into the database
	$pass = hash('sha256', $pass);
	
	//Prepare query statement
	$sql = "INSERT INTO customers (fname, lname, email, location, password) 
	VALUES ('$fname', '$lname', '$email', '$location', '$pass')";
	
	//Get the result of the query
	$result = $database->query($sql);
	
	//If the query is successful
	if($result)
	{
		$error = "success";
		$errorMessage = "You have been registered and may login now.";
		unset($fname);
		unset($lname);
		unset($pass);
		unset($email);
		unset($location);
	}
	
	//If the query fails
	else{
		$error = "Failure";
		$errorMessage = "An unexpected error has occured, try again later.";
	}
?>