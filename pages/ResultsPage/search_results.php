<?php

	echo'<div class="bg-primary results-info extra-soft-shadow">
		Search Results
	</div>
	<div id="main-results" class="search-results soft-shadow">';

	$dbconn = pg_connect("host = localhost port =5432 dbname = postgres 
	user = postgres password = vgcdb")
	or database_error('Could not connect : ' . pg_last_error());

	$character_name_query = '';
	$universe_query = '';
	$year1_query = '';
	$year2_query = '';
	$role_query = '';
	$gender_query = '';
	$eye_query = '';
	$hair_query = '';
	$character_name_query = '';
	$universe_query = '';

	if(!empty($_POST['character_name'])) {
		$character_name = $_POST['character_name'];
		$character_name = str_replace("'","",str_replace("-","",strtolower($character_name)));
		$character_name_query = " AND name ~ '$character_name'";
	}
	if(!empty($_POST['universe'])) {
		$universe = $_POST['universe'];
		$universe = str_replace("'","",str_replace("-","",strtolower($universe)));
		$universe_query = " AND universe ~ '$universe'";
	}
	if(!empty($_POST['year1'])) {
		$value = $_POST['year1'];
		$year1_query = "AND year >= $value";
	}
	if(!empty($_POST['year2'])) {
		$value = $_POST['year2'];
		$year2_query = "AND year < $value";
	}
	if(!empty($_POST['role'])) {
		$value = $_POST['role'];
		$array = implode('\',\'',$value);
		$role_query = "AND role IN ('$array')";
	}
	if(!empty($_POST['gender'])) {
		$value = $_POST['gender'];
		$array = implode('\',\'',$value);
		$gender_query = "AND gender IN ('$array')";
	}
	if(!empty($_POST['eye_color'])) {
		$value = $_POST['eye_color'];
		$array = implode('\',\'',$value);
		$eye_query = "AND eye IN ('$array')";	
	}
	if(!empty($_POST['hair_color'])) {
		$value = $_POST['hair_color'];
		$array = implode('\',\'',$value);
		$hair_query = "AND hair IN ('$array')";
	}

	$query = 
		"SELECT * FROM characters 
			WHERE true " . "$year1_query" . "$year2_query" . "$role_query" . "$gender_query" . "$eye_query" . "$hair_query" . $character_name_query . $universe_query . " 
			ORDER BY LENGTH(role) DESC, universe";

	$result = pg_query($query) or database_error('Query failed : '.pg_last_error());
	
	if (pg_fetch_array($result, null, PGSQL_NUM)) { 

		// Resetto il puntatore interno per l'array dei risultati
		pg_result_seek($result,0);

		// Array dei main results (usato per evitare di mostrare dulicati nella sezione "Other results")
		$main_results_array = array();
		
		while($line = pg_fetch_array($result, null, PGSQL_NUM)) {
		
			$formatted_name = 		$line[0];
			$formatted_universe = 	$line[1];
			$image = 				$line[10];
			$name = 				$line[12];
			$universe = 			$line[13];
		
			echo "<div class='horizontal-character-card soft-shadow'>
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
							<div>
								<a href=\"javascript:transitionTo('$url')\">$formatted_name</a>
							</div>
							<div>
								<p>$formatted_universe</p>
							</div>
						</div>
					</div>
				</div>";

			// Aggiorno l'array dei risultati per evitare di mostrare duplicati nella sezione "Other Results"
			array_push($main_results_array, [$name, $universe]);

		}

		pg_free_result($result);
	} else {
		echo '
			<div class="no-results">
				<div>
					<h3>
						No exact results found for your search...
					</h3>
					<p>
						Please try again with a more generic filter
					</p>
				</div>
				<div class="line"></div>
				<div>
					<div>
						<h3>
							Suggest a character
						</h3>
						<p>
							If you can\'t find the character you are looking for, you can suggest a character for VGCDB
						</p>
					</div>
					<div class="my-button soft-shadow">
						<button type="button" onclick="transitionTo(\'/pages/SuggestionPage/suggestion_page.php\')">Suggest a character</button>
					</div>
				</div>
				
			</div>
		';
	}

	/* ====================================================================================================================================== */
	/* -------------------------------------------------- Sezione OHTER RESULTS ------------------------------------------------------------- */
	/* ====================================================================================================================================== */

	$query = 
		"WITH 
		mainresults AS (
			SELECT * FROM characters 
			WHERE true " . "$year1_query" . "$year2_query" . "$role_query" . "$gender_query" . "$eye_query" . "$hair_query" . $character_name_query . $universe_query . 
		"),
		nameoruniverse AS (" . 
			(
				empty($_POST['character_name']) && empty($_POST['universe']) ? 
					"SELECT * FROM characters WHERE false" 
				: ( 
					empty($_POST['character_name']) ? 
						"SELECT * FROM characters
							WHERE (true " . $universe_query . ") 
							ORDER BY LENGTH(role) DESC, universe" 
					: ( 
						empty($_POST['universe']) ?
							"SELECT * FROM characters
								WHERE (true " . $character_name_query . ") 
								ORDER BY LENGTH(role) DESC, universe"
							:
							"SELECT * FROM characters
								WHERE (true " . $universe_query . ") OR (true" . $character_name_query . ")
								ORDER BY LENGTH(role) DESC, universe" 
						)
				)
			) . 
		")" . 
		"SELECT *
			FROM (
				SELECT * FROM nameoruniverse
				EXCEPT
				SELECT * FROM mainresults
			) t1" . 
		" ORDER BY 
		-- showorder, 
		LENGTH(role) DESC, universe;
		";

	$result = pg_query($query) or database_error('Query failed : '.pg_last_error());

	if(pg_fetch_array($result, null, PGSQL_NUM)) { 

		pg_result_seek($result,0);

		echo'</div>
			<div class="bg-primary results-info extra-soft-shadow">
				Other Results
			</div>
			<div id="other-results" class="search-results soft-shadow">';

		while($line = pg_fetch_array($result, null, PGSQL_NUM)) {
			

			$formatted_name = 		$line[0];
			$formatted_universe = 	$line[1];
			$image = 				$line[10];
			$name = 				$line[12];
			$universe = 			$line[13];

			echo "<div class='horizontal-character-card soft-shadow'>
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
						<div>
							<a href=\"javascript:transitionTo('$url')\">$formatted_name</a>
						</div>
						<div>
							<p>$formatted_universe</p>
						</div>
					</div>
				</div>
			</div>";
					
		}
	} 

	pg_free_result($result);
	pg_close($dbconn);

	echo'</div>';

?>