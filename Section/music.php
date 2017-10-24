<!DOCTYPE html>
<html>
	<!--
	Web Programming Step by Step
	Lab #3, PHP
	-->

	<head>
		<title>Music Viewer</title>
		<meta charset="utf-8" />
		<link href="https://www.cs.washington.edu/education/courses/cse190m/12sp/labs/3/viewer.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
		
		<h1>My Music Page</h1>
		
		<!-- Number of Songs (Variables) -->
		<?php 
			$numSongs = 1234;
		?>
			<p>
				I love music.
				I have <?=$numSongs; ?> total songs,
				which is over <?=$numSongs / 10 ?> hours of music!
			</p>
			   

		<!-- Music Results Pages (Loops) -->
		<div class="section">
			<h2>Google's Music Results</h2>
		
			<ol>
			<?php 
				for ($i = 0; $i < 5; $i++) { ?>
					<li><a href="https://www.google.com/search?tbm=nws&amp;q=Music&amp;start=<?=$i * 10?>">Page <?=$i + 1 ?></a></li>
			<?php
				}?>
<!-- 				<li><a href="https://www.google.com/search?tbm=nws&amp;q=Music&amp;start=0">Page 1</a></li>
				<li><a href="https://www.google.com/search?tbm=nws&amp;q=Music&amp;start=10">Page 2</a></li>
				<li><a href="https://www.google.com/search?tbm=nws&amp;q=Music&amp;start=20">Page 3</a></li>
				<li><a href="https://www.google.com/search?tbm=nws&amp;q=Music&amp;start=30">Page 4</a></li>
				<li><a href="https://www.google.com/search?tbm=nws&amp;q=Music&amp;start=40">Page 5</a></li> -->
			</ol>
		</div>

		<!-- Favorite Artists (Arrays) -->
		<!-- Favorite Artists from a File (Files) -->
		<div class="section">
			<h2>My Favorite Artists</h2>
		
			<ol>
			<?php
				$artists = array("Britney Spears", "Christina Aguilera", "Justin Bieber", "Lady Gaga", "Cœur de pirate");
				foreach ($artists as $singer) { ?>
					<li><?=$singer ?></li>
			<?php
				}?>	
				<!-- <li>Britney Spears</li>
				<li>Christina Aguilera</li>
				<li>Justin Bieber</li> -->
			</ol>
		</div>
		
		<!-- Music (Multiple Files) -->
		<!-- MP3 Formatting -->
		<div class="section">
			<h2>My Music and Playlists</h2>

			<ul id="musiclist">
				<li class="mp3item">
					<a href="http://webster.cs.washington.edu/cse154/songs/Be More.mp3">Be More.mp3</a>
				</li>
				
				<li class="mp3item">
					<a href="http://webster.cs.washington.edu/cse154/songs/Just Because.mp3">Just Because.mp3</a>
				</li>

				<li class="mp3item">
					<a href="http://webster.cs.washington.edu/cse154/songs/Drift Away.mp3">Drift Away.mp3</a>
				</li>

				<!-- Exercise 8: Playlists (Files) -->
				<li class="playlistitem">154-mix.m3u:
					<ul>
						<li>Hello.mp3</li>
						<li>Be More.mp3</li>
						<li>Drift Away.mp3</li>
						<li>Panda Sneeze.mp3</li>
					</ul>
				</li>
			</ul>
		</div>

		<div>
			<a href="https://webster.cs.washington.edu/validate-html.php">
				<img src="http://webster.cs.washington.edu/w3c-html.png" alt="Valid HTML5" />
			</a>
			<a href="https://webster.cs.washington.edu/validate-css.php">
				<img src="http://webster.cs.washington.edu/w3c-css.png" alt="Valid CSS" />
			</a>
		</div>
	</body>
</html>
