<?php
	/*
		Daniel Tran
		CSE 154 AD
		2 June 2016
		Homework 8
		This program takes in an actor/actress and searches all the movies they have appeared in
		together with Kevin Bacon. This data gets displayed, if it is found, onto a table
	*/

	include "common.php";
	$first = htmlspecialchars($_GET["firstname"]);
	$last = htmlspecialchars($_GET["lastname"]);
	topBanner();
	//Initiates call to imdb database
	$db = new PDO("mysql:dbname=imdb;host=localhost;charset=utf8", "danc88", "wPeYLwZbUB");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$firstQuery = $db->quote($first."%");
	$lastQuery = $db->quote($last);
	//Retrieves celebrity from imdb database.
	$celeb = $db->query("SELECT id FROM actors WHERE last_name = $lastQuery AND first_name LIKE 
							$firstQuery ORDER BY film_count DESC, id LIMIT 1");
	//Retrieves Kevin Bacon from imdb database
	$kevinBacon = $db->query("SELECT id FROM actors WHERE last_name = 'Bacon' AND first_name LIKE 
							'Kevin' ORDER BY film_count DESC, id LIMIT 1");
	if ($celeb->rowCount() == 0) {?>
		<p>Actor/Actress <?=$first?> <?=$last?> not found</p> <?php 
	} else {
		$celebId = "";
		$kevinBaconId = ""; 
		foreach ($celeb as $data) {
			$celebId = $data["id"];
		}
		foreach ($kevinBacon as $data) {
			$kevinBaconId = $data["id"];
		}
		//Combines the list of movies that given actor and Kevin Bacon have starred in together
		$movies = $db->query("SELECT name, year FROM movies m JOIN roles r1 ON r1.movie_id = m.id
							 JOIN roles r2 ON r2.movie_id = m.id JOIN actors a ON a.id = 
							 r1.actor_id JOIN actors a2 ON a2.id = r2.actor_id WHERE r1.actor_id = 
							 $celebId AND r2.actor_id = $kevinBaconId ORDER BY year DESC, name");
		if ($movies->rowCount() == 0) { ?>
			<p><?=$first?> <?=$last?> has not been in a movie with Kevin Bacon</p>
		<?php } else {?>
			<h1>Results for <?=$first?> <?=$last?></h1>
			<?php
			createTable($movies, $first, $last, true); 
	 	}
	}
	bottomBanner();
?>