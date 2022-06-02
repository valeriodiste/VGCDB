<!DOCTYPE html>

<?php

	include($_SERVER['DOCUMENT_ROOT'] . "/php/database_error.php");

	$colors = array(
		"Dark Gray" => "--dark-gray",
		"Blue" => "--blue",
		"Brown" => "--brown",
		"Green" => "--green",
		"Gray" => "--gray",
		"Orange" => "--orange",
		"Purple" => "--purple",
		"Red" => "--red",
		"Light Gray" => "--light-gray",
		"Yellow" => "--yellow",
		"Pink" => "--pink",
		"Sky Blue" => "--sky-blue",
	);
	

?>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>VGCDB</title>
	<link rel="icon" href="/icons/logo.png">

	<link rel="stylesheet" href="/css/font-style.css" type="text/css">
	<link rel="stylesheet" href="/css/colors.css" type="text/css">
	<link rel="stylesheet" href="/css/scroll-bar.css" type="text/css">
	<link rel="stylesheet" href="/css/menu-bar.css" type="text/css">
	<link rel="stylesheet" href="/css/footer.css" type="text/css">
	<link rel="stylesheet" href="/css/commons.css" type="text/css">
	<link rel="stylesheet" href="/css/character-cards.css" type="text/css">
	<link rel="stylesheet" href="/css/page-transition.css" type="text/css">
	<link rel="stylesheet" href="style.css" type="text/css">
	<link rel="stylesheet" href="loader.css" type="text/css">

	<script type="text/javascript" src='/libraries/jquery/jquery-3.6.0.min.js'></script>
	<script type="text/javascript" src='/js/page-transition.js'></script>
	<script type="text/javascript" src='/js/fit-text.js'></script>
	<script type="text/javascript" src='/js/menu-bar.js'></script>
	<script type="text/javascript" src='/js/commons.js'></script>
	<script type="text/javascript" src='/js/sessionAndLocalStorageManager.js'></script>

	
	<style>
		:root {
			--dark-mode: 0;				
			--primary: var(--red);
			--secondary: var(--blue);
			--tertiary: none;
		}
	</style>

</head>
<body>

<?php
    require($_SERVER['DOCUMENT_ROOT'] . "/php/navbar.php");
?>

	<div id="body-wrapper">

		<!-- Loader -->
		<div id="loader-animation" class="soft-shadow">
			<div class="loader-wrapper">
				<div class="loader-circle"></div>
				<div class="loader-circle"></div>
				<div class="loader-circle"></div>
				<div class="loader-shadow"></div>
				<div class="loader-shadow"></div>
				<div class="loader-shadow"></div>
				<span><b>VGCDB</b> is loading</span>
			</div>
		</div>

		<div id="page-transition-in"></div>
		
		<div id="homepage" class="bg-white bg-pattern">
			
			<div class="wrapper soft-shadow">
				<!-- Visualizza la scena 3D -->
				<canvas id="render-canvas"></canvas>
			</div>
			
			<div class="top">
				<div>
					<div class="wave">
						<svg viewBox="0 0 1920 1000" width="100vw" height="100vh" x="0" y="0" preserveAspectRatio="xMidYMin slice">
							<path class="bg-primary soft-shadow"
								d="M1639.5,146.5c-126.82,41.84-194.41,117.93-255,172-79.3,70.76-131,
								90.89-147.76,99.13C1092.67,488.37,1008.46,448.69,835,486c-112.58,
								24.22-188.59,64.92-284,116C361.91,703.24,292.66,794.2,126,819A548.38,
								548.38,0,0,1,0,823V0H1920V128.34C1852,117.13,1749.88,110.08,1639.5,146.5Z">
							</path>
						</svg>
					</div>
		
					<div class="heading">
						<div class="title-style extra-soft-shadow">VGCDB</div>
						<div class="subtitle-style extra-soft-shadow">video game characters database</div>
						<form action="/pages/ResultsPage/results_page.php" method="POST" onsubmit="return formTransitionTo(this)">
							<div class="search-section soft-shadow">
								<input type="text" class="character-search-input" id="character_name" maxlength="30" placeholder="Search for a character" autocomplete="off" name="character_name" spellcheck="false">
								<div class="my-button">
									<button type="submit">Search</button>
								</div>
							</div>
						</form>
						<div class="advanced-search-section soft-shadow">
							<div class="info">
								<h3>Advanced Search</h3>
								<p>
									Search for characters by video game series, year, hair color, eye color, and more				
								</p>
							</div>
							<div class="my-button soft-shadow">
								<button type="button" onclick="javascript:transitionTo('/pages/AdvancedSearch/advanced_search_page.php')">Advanced Search</button>
							</div>
						</div>
					</div>
				</div>
			
				<div class="website-info">
					<div class="description-card soft-shadow bg-primary">
						<div>
							<h3>What is VGCDB?</h3>
						</div>
						<div class="line"></div>
						<div>
							<p>
								<a href="#body-wrapper"><b>VGCDB</b></a> is an online database of characters from various video game series. 
								<br>
								<br>
								Here you can find information about countless characters from the most popular video game series, universes and franchises.
								<br>
								<br>
								The 
								<a href="javascript:transitionTo('/pages/AdvancedSearch/advanced_search_page.php')"><b>Advanced Search page</b></a>
								allows you to search for characters by:
								<ul>
									<li>name</li>
									<li>video game series (universe)</li>
									<li>year of first appearance</li>
									<li>hair color</li>
									<li>eye color</li>
									<li>role</li>
									<li>gender</li>
								</ul>
							</p>
						</div>
					</div>
				</div>
			</div>

			<div class="featured-characters inset-soft-shadow-up">

				<div class="related-characters">
					<h2>Random characters</h2>
					<div>

                    <?php

						$dbconn = pg_connect("host = localhost port = 5432 dbname = postgres 
						user = postgres password = vgcdb")
						or database_error('Could not connect : ' . pg_last_error());

						$q1 = "SELECT name FROM characters";
						$result = pg_query($dbconn, $q1) or database_error('Query failed : ' . pg_last_error());

						$character_list = [];

						while ($line = pg_fetch_array($result, null, PGSQL_NUM)) {
							array_push($character_list, strval($line[0]));
						}
						
						$begin=0;
						$end = count($character_list) - 1;
						$limit=4;
						
						//find 4 non-repeating values
						$rand_array=range($begin,$end); 
						shuffle($rand_array);
						$rand_array=array_slice($rand_array,0,$limit); 

						$first = $character_list[$rand_array[0]];
						$second = $character_list[$rand_array[1]];
						$third = $character_list[$rand_array[2]];
						$fourth = $character_list[$rand_array[3]];

                        $q1 = "(SELECT * FROM characters WHERE name='$first' LIMIT 1) UNION 
							(SELECT * FROM characters WHERE name='$second' LIMIT 1) UNION 
							(SELECT * FROM characters WHERE name='$third' LIMIT 1) UNION
							(SELECT * FROM characters WHERE name='$fourth' LIMIT 1)";

                        $result = pg_query($dbconn, $q1) or database_error('Query failed : ' . pg_last_error());

                        while ($line = pg_fetch_array($result, null, PGSQL_NUM)) {

							$formatted_name = 		$line[0];
        					$formatted_universe = 	$line[1];
        					$image = 				$line[10];
							$name = 				$line[12];
        					$universe = 			$line[13]; 
                            
                        
							echo "<div class='vertical-character-card soft-shadow'>
							<div>
								<div class='character-image-container soft-shadow'>";
								if (file_exists($_SERVER['DOCUMENT_ROOT'].'/Images/characters/'.$image)) {
									echo "<img class='character-image' src='/Images/characters/$image' alt='Character Image'>";
								} else {
									echo "<img class='character-image icon-dark-mode-responsive' src='/Images/character_image_not_found.png' alt='Character Image'>";
								}

								$url = urlencode('/pages/characterpage/character_page.php?character='.$name.'&universe='.$universe);
								
								echo "</div>
								<div>

									<a href=\"javascript:transitionTo('$url')\">$formatted_name</a>

								</div>
								<div>
									<p>$formatted_universe</p>
								</div>
							</div>
						</div>";
						}

						pg_free_result($result);
                    	pg_close($dbconn);
                    ?>   

					</div>
				</div>
			</div>

		</div>

		<?php
			require($_SERVER['DOCUMENT_ROOT'] . '/php/footer.php');
		?>

		
	</div>

	<script type="text/javascript" src='/libraries/three/three.min.js'></script>
	<script type="text/javascript" src='/libraries/three/GLTFLoader.js'></script>
	<script type="text/javascript" src='3dmodel-handler.js'></script>

</body>

</html>