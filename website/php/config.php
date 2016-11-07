<?php
	define('dbserver','24.99.201.43');
	define('dbusername','techsavvyadmin');
	define('dbpassword','magnificentseven2016');
	define('dbdatabase','techsavvyadmin');
	
	//Creates a connection the the database that can be used in any other php file
	$database = new mysqli(dbserver, dbusername, dbpassword, dbdatabase);
?>