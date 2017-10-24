<?php
	/*
		Daniel Tran
		CSE 154 AD
		25 May 2016
		Assignment 7
		This file performs the actions that allow the user to append or remove items from their to
		do list
	*/

	//Checks whether or not in a current session
	session_start();
	$username = $_SESSION["username"];
	if (!isset($username)) {
		header("Location: start.php");
	} else {
		$action = $_POST["action"];
		//Appends new item to list
		if ($action == "add") {
			$item = $_POST["item"];
			if (file_exists("todo_".$username.".txt")) {
				file_put_contents("todo_".$username.".txt", $item."\n", FILE_APPEND);
			} else {
				file_put_contents("todo_".$username.".txt", $item."\n");
				print "new file made";
			}
		} elseif ($action == "delete") {
			//Removes selected item from list
			$i = $_POST["index"];
			$list = file("todo_".$username.".txt", FILE_IGNORE_NEW_LINES);
			if (is_nan($i) || count($list) <= $i) {
				die("invalid index/value.");
			} else {
				unset($list[$i]);
				file_put_contents("todo_".$username.".txt", "");
				foreach ($list as $remaining) {
					file_put_contents("todo_".$username.".txt", $remaining."\n", FILE_APPEND);
				}
			}
		}
		header("Location: todolist.php");
	}
	die();
?>