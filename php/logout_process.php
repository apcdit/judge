<?php
	session_start();
	
	if(isset($_SESSION['userID'])) {
		session_destroy();
		session_unset();
		unset($_COOKIE['userID']);
		unset($_COOKIE['titleID']);
		unset($_COOKIE['title']);
		unset($_COOKIE['judge_name']);
		setcookie("userID", "", time()-14400,'/');
		setcookie("titleID", "", time()-14400, '/');
        setcookie("title", "", time()-14400, '/');
		setcookie("judge_name", "", time()-14400, '/');
		
		header("Location: ../login.php");
	} else {
		header("Location: ../login.php");
	}
	
?>