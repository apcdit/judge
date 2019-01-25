
<?php

	require('config.php');
	$servername = DB_HOST;
	$username = DB_USERNAME;
	$password = DB_PASSWORD;
	

	try {
		//Creating connection for mysql
		$conn = new PDO("mysql:host=$servername;dbname=apchinese", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e){
		echo "Connection failed: " . $e->getMessage();
	}
?>