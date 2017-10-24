<?php
	/*
		Daniel Tran
		CSE 154 AD
		25 May 2016
		Assignment 7
		This file logs the user into the page with their personal list
	*/

	#Evaluates given username and password to check if it's valid and/or if it exists
	session_start();
	if (isset($_SESSION["username"])) {
		redirect("todolist");
	} elseif (!preg_match("/^[a-z]([a-z0-9]){1,7}$/", $_POST["username"]) || 
				!preg_match("/^[0-9].{4,10}[^a-z0-9A-Z]$/", $_POST["password"])) {
		redirect("start");
	} elseif ($_POST["username"] == "" || $_POST["password"] == "") {
		die("username and/or password are blank.");
	} else {
		$username = $_POST["username"];
		$password = $_POST["password"];
		$inFile = false;
		foreach (file("users.txt", FILE_IGNORE_NEW_LINES) as $credentials) {
			list($u, $p) = explode(":", $credentials);
			#Checks if input matches logged credential data
			if ($u == $username) {
				if ($p == $password) {
					logIn($username);
					session_regenerate_id(TRUE);
					$inFile = true;
				} else {
					redirect("start");
				}
			}
		}
		#If username does not exist, but valid input is given, appends to end of list of all credentials
		if (!$inFile) {
			$newUser = $username.":".$password;
			file_put_contents("users.txt", $newUser."\n", FILE_APPEND);
			chmod("users.txt", 0777);
			logIn($username);
		}
	}

	#Logs the user into their current session with their list
	function logIn($username) {
		setcookie("time", date("D y M d, g:i:s a"), time() + 60*60*24*7);
		$_SESSION["username"] = $username;
		redirect("todolist");
	}

	#Redirects user back to start page if no input given or wrong password is given
	function redirect($filename) {
		header("Location: ".$filename.".php");
		die();
	}
?>