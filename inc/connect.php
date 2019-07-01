
<?php

	require('config.php');
	$servername = DB_HOST;
	$dbname = DB_NAME;
	$username = DB_USERNAME;
	$password = DB_PASSWORD;
	

	try {
		//Creating connection for mysql
		$conn = new PDO("mysql:host=$servername;dbname=".$dbname, $username, $password);
		$conn->exec("set names utf8");
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e){
		echo "Connection failed: " . $e->getMessage();
	}
	ini_set('session.cookie_lifetime', 86400);
	ini_set('session.gc_maxlifetime', 86400);
?>