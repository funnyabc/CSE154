<?php
	/*
		Daniel Tran
		CSE 154 AD
		25 May 2016
		Assignment 7
		This file provides the skeleton of the page, mainly the blue regions on the top and bottom
		of the page
	*/

//Produces top bar display of the cow and name of the site
function printTop() {?>
<!DOCTYPE HTML>
<html>
	<head>
	    <title>Remember the Cow</title>
	    <link rel="stylesheet" href="cow.css">
	</head>
	<body>
	    <div class="bluebar">
	    	<img src="https://webster.cs.washington.edu/images/todolist/logo.gif" alt="cowlogo">
	    	<h1>Remember <br /> the Cow</h1>
	    </div>
<?php }

//Produces bottom bar display of the verifiers
function printBottom() {
?>
		<div class="bluebar">
			<p>
				<q>Remember The Cow is nice, but it's a total copy of another site.</q> - PCWorld<br>
				All pages and content © Copyright CowPie Inc.
			</p>
			<div id="w3c">
				<a href="https://webster.cs.washington.edu/validate-html.php">
					<img src="https://webster.cs.washington.edu/images/w3c-html.png" alt="Valid HTML"></a>
				<a href="https://webster.cs.washington.edu/validate-css.php">
					<img src="https://webster.cs.washington.edu/images/w3c-css.png" alt="Valid CSS"></a>
			</div>
		</div>
	</body>
</html>

<?php }
?>