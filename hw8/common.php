<?php
	/*
		Daniel Tran
		CSE 154 AD
		2 June 2016
		Homework 8
		This page gives common functions that are shared by the different pages in the MyMDB page
	*/

	#Outputs top banner of page
	function topBanner() {?> 
		<!DOCTYPE html>
		<html>
			<head>
				<title>My Movie Database (MyMDb)</title>
				<meta charset="utf-8" />
				<link href="https://webster.cs.washington.edu/images/kevinbacon/favicon.png" type="image/png" rel="shortcut icon" />

				<!-- Link to your CSS file that you should edit -->
				<link href="bacon.css" type="text/css" rel="stylesheet" />
			</head>

			<body>
				<div id="frame">
					<div id="banner">
						<a href="mymdb.php"><img src="https://webster.cs.washington.edu/images/kevinbacon/mymdb.png" alt="banner logo" /></a>
						My Movie Database
					</div>

					<div id="main">
	<?php }

	#Outputs out bottom banner of page, including the search new actor area
	function bottomBanner() {?>
		<form action="search-all.php" method="get">
					<fieldset>
						<legend>All movies</legend>
						<div>
							<input name="firstname" type="text" size="12" placeholder="first name" autofocus="autofocus" /> 
							<input name="lastname" type="text" size="12" placeholder="last name" /> 
							<input type="submit" value="go" />
						</div>
					</fieldset>
				</form>
		<form action="search-kevin.php" method="get">
					<fieldset>
						<legend>Movies with Kevin Bacon</legend>
						<div>
							<input name="firstname" type="text" size="12" placeholder="first name" /> 
							<input name="lastname" type="text" size="12" placeholder="last name" /> 
							<input type="submit" value="go" />
						</div>
					</fieldset>
				</form>
			</div> <!-- end of #main div -->
		
			<div id="w3c">
				<a href="https://webster.cs.washington.edu/validate-html.php"><img src="https://webster.cs.washington.edu/images/w3c-html.png" alt="Valid HTML5" /></a>
				<a href="https://webster.cs.washington.edu/validate-css.php"><img src="https://webster.cs.washington.edu/images/w3c-css.png" alt="Valid CSS" /></a>
			</div>
		</div> <!-- end of #frame div -->
	</body>
</html>
	<?php }

	#Creates table of movies the actor has starred in. Movies is the list of movies, first and last
	#are the first and last names of the actor and bacon is whether or not the table is including 
	#movies where the actor/actress has starred alongside Kevin Bacon
	function createTable($movies, $first, $last, $bacon) { ?>
			<table>
				<?php
					#Changes caption based on searching for movies exclusively including the
					#actor/actress or ones where they have starred together with Kevin Bacon
					if ($bacon) { ?>
						<caption>Films with <?=$first?> <?=$last?> and Kevin Bacon</caption>
						<?php
					} else { ?>
						<caption>All Films</caption>
					<?php }
				?>
				<tr><th>#</th><th>Title</th><th>Year</th></tr>
				<?php
				$count = 0;
				#Produces table rows for each movie found
				foreach($movies as $movie) {
					$count++;
					$title = $movie["name"];
					$year = $movie["year"];
					?>
					<tr><td><?=$count?></td><td><?=$title?></td><td><?=$year?></td></tr>
					<?php
				} ?>
			</table> 
		<?php
	}
?>