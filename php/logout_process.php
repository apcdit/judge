<?php
	session_start([
    'cookie_lifetime' => 7200,
]);
	
	if(isset($_SESSION['userID'])) {
		session_destroy();
		session_unset();
		unset($_COOKIE['userID']);
		unset($_COOKIE['titleID']);
		unset($_COOKIE['title']);
		setcookie("userID", "", time()-14400,'/');
		setcookie("titleID", "", time()-14400, '/');
        setcookie("title", "", time()-14400, '/');
		
		header("Location: ../login.php");
	} else {
		header("Location: ../login.php");
	}
	
?>