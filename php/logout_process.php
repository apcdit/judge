<?php
	session_start([
    'cookie_lifetime' => 7200,
]);
	
	if(isset($_SESSION['userID'])) {
		session_destroy();
		session_unset();
		header("Location: ../login.php");
	} else {
		header("Location: ../login.php");
	}
	
?>