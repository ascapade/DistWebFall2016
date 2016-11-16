<?php
	define('dbserver','localhost');
	define('dbusername','pma');
	define('dbpassword','testingtesting123');
	define('dbdatabase','techsavvyadmin');
	
	//Creates a connection the the database that can be used in any other php file
	$database = new mysqli(dbserver, dbusername, dbpassword, dbdatabase);
?>