<?php
	/*
		Daniel Tran
		CSE 154 AD
		2 June 2016
		Homework 8
		This program takes in an actor/actress and outputs all the movies they have starred in. If
		they are in the database, their casted roles get outputted into a table format.
	*/

	include "common.php";
	$first = htmlspecialchars($_GET["firstname"]);
	$last = htmlspecialchars($_GET["lastname"]);
	topBanner();
	#Initiates database call to imdb
	$db = new PDO("mysql:dbname=imdb;host=localhost;charset=utf8", "danc88", "wPeYLwZbUB");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$firstQuery = $db->quote($first."%");
	$lastQuery = $db->quote($last);
	#Retrieves actor id from the imdb database
	$celeb = $db->query("SELECT id FROM actors WHERE last_name = $lastQuery AND first_name LIKE 
							$firstQuery ORDER BY film_count DESC, id LIMIT 1");
	if ($celeb->rowCount() == 0) { ?>
		<p>Actor/Actress <?=$first?> <?=$last?> not found</p>
	<?php } else { 
		$celebId = "";
		foreach ($celeb as $data) {
			$celebId = $data["id"];
		}
		#Searches for all movies the actor/actress has been in
		$movies = $db->query("SELECT name, year FROM movies m JOIN roles r ON r.movie_id = m.id 
			JOIN actors a ON a.id = r.actor_id WHERE a.id = $celebId ORDER BY year DESC, name"); ?>
		<h1>Results for <?=$first?> <?=$last?></h1> <?php
		createTable($movies, $first, $last, false);  
	}
	bottomBanner();
?>