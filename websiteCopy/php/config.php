<?php
	define('dbserver','localhost');
	define('dbusername','pma');
	define('dbpassword','testingtesting123');
	define('dbdatabase','techsavvyadmin');

	//Creates a connection the the database that can be used in any other php file
	$database = new mysqli(dbserver, dbusername, dbpassword, dbdatabase);

class DBController {
    private $host = dbserver;
    private $user = dbusername;
    private $password = dbpassword;
    private $database = dbdatabase;

    function __construct() {
        $conn = $this->connectDB();
        if(!empty($conn)) {
            $this->selectDB($conn);
        }
    }

    function connectDB() {
        $conn = mysql_connect($this->host,$this->user,$this->password);
        return $conn;
    }

    function selectDB($conn) {
        mysql_select_db($this->database,$conn);
    }

    function runQuery($query) {
        $result = mysql_query($query);
        while($row=mysql_fetch_assoc($result)) {
            $resultset[] = $row;
        }
        if(!empty($resultset))
            return $resultset;
    }

    function numRows($query) {
        $result  = mysql_query($query);
        $rowcount = mysql_num_rows($result);
        return $rowcount;
    }
}
?>