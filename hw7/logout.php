<?php
	/*
		Daniel Tran
		CSE 154 AD
		25 May 2016
		Assignment 7
		This file logs the user out of the current session. If the page is accessed without being
		logged in, it will redirect to the start page.
	*/
	session_start();
	if (isset($_SESSION["username"])) {
		session_destroy();
	}
	header("Location: start.php");
	die();
?>