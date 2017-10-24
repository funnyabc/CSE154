<?php
	/*
		Daniel Tran
		CSE 154 AD
		25 May 2016
		Assignment 7
		This file displays the to do list for the user
	*/

	include "common.php";
	session_start();
	if (!isset($_SESSION["username"])) {
		session_destroy();
		header("Location: start.php");
		die();
	} else {
		printTop();
		$username = $_SESSION["username"];
	?>
		<div id="mainarea">
			<h2> <?= $username ?>'s To-Do List</h2>
			<ul id="todolist">
				<!--Produces list of items user has added to their to do list-->
				<?php
						if (file_exists("todo_".$username.".txt")) {
							$toDoList = file("todo_".$username.".txt", FILE_IGNORE_NEW_LINES);
							for ($i = 0; $i < count($toDoList); $i++) {
								$formatted = htmlspecialchars($toDoList[$i]);
								?>
								<li>
									<?= $formatted ?>
									<form action="submit.php" method="post">
										<input type="hidden" name="action" value="delete" />
										<input type="hidden" name="index" value= <?= $i ?> />
										<input type="submit" value="Delete" />
									</form>
								</li>
					<?php 	}
						}
					?>
				<!--Provides option to add to list-->
				<li>
					<form action="submit.php" method="post">
						<input type="hidden" name="action" value="add" />
						<input name="item" type="text" size="25"/>
						<input type="submit" value="Add" />
					</form>
				</li>
			</ul>

			<div>
				<a href="logout.php"><strong>Log Out</strong></a>
				<em>(logged in since <?= $_COOKIE["time"] ?>)</em>
			</div>
		</div>

	<?php
	printBottom();
	}
?>