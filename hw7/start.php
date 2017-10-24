<?php
	/*
		Daniel Tran
		CSE 154 AD
		25 May 2016
		Assignment 7
		This provides the first page the user sees when they have not logged in.
	*/
	include "common.php";
	if (isset($_SESSION["username"])) {
		header("Location: todolist.php");
		die();
	} else {
		printTop(); ?> 
			<div id="mainarea">
				<p>
					The best way to manage your tasks. <br />
					Never forget the cow (or anything else) again!
				</p>

				<p>
					Log in now to manage your to-do list. <br />
					If you do not have an account, one will be created for you.
				</p>
				<!-- Prints out login area for user -->
				<form action="login.php" method="post">
					<div id="loginarea">
						<input type="text" name="username" size="8" /> User Name<br />
						<input type="text" name="password" size="8" /> Password<br />
						<input type="submit" value="Log In"/>
					</div>
				</form>
				<p>
						<em>(last login from this computer was <?= $_COOKIE["time"] ?>)</em>
				</p>
			</div>
	<?php printBottom();
	}?>