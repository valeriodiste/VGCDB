<!DOCTYPE html>

<?php

	$username = "";
	if(isset($_SESSION['username']) && $_SESSION['username'] != "") {
		$username = $_SESSION['username'];
	}

	include($_SERVER['DOCUMENT_ROOT'] . "/php/database_error.php");

    $name = $_GET['character'];
    $universe = $_GET['universe'];
	
    $dbconn = pg_connect("host = localhost port = 5432 dbname = postgres 
    user = postgres password = vgcdb")
    or database_error('Could not connect : ' . pg_last_error());

    $q1 = "SELECT * FROM characters WHERE name=$1 AND universe=$2";
    $result = pg_query_params($dbconn, $q1, array($name, $universe)) 
		or database_error('Query failed : ' . pg_last_error());
    if($line = pg_fetch_array($result, null, PGSQL_NUM)) {
		
        $formatted_name = 		$line[0];
        $formatted_universe = 	$line[1];
        $year = 				$line[2];
        $role = 				$line[3];
        $gender = 				$line[4];
        $eye = 					$line[5];
        $hair = 				$line[6];
        $color1 = 				$line[7];
        $color2 = 				$line[8];
        $description = 			preg_replace('/([^D.][^rSs])[.] ([a-zA-Z])/i', '${1}.<br/>${2}',$line[9]);
        $image = 				$line[10];
        $banner = 				$line[11];

    }
    pg_free_result($result);

	// Calcola il numero di preferiti
	$q1 = "SELECT COUNT(*) FROM favourites WHERE character=$1 AND universe=$2";
    $result = pg_query_params($dbconn, $q1, array($name, $universe)) or database_error('Query failed : ' . pg_last_error());
	$num_favourites = 0;
	if ($line = pg_fetch_array($result, null, PGSQL_NUM)) {
		$num_favourites = $line[0];
	}
	$favourites_at_start = (strlen($name) * 967) + (strlen($universe) * 997);
	$num_favourites = $favourites_at_start + $num_favourites;

	// Aggiusta il formato da mostrare del numero di preferiti (aggiunge un punto ogni 3 caratteri del numero)
	$favourite_text_array = str_split(strrev(strval($num_favourites)));
	$favourite_text = array();
	foreach ($favourite_text_array as $i=>$char) {
		if ($i != 0 && $i % 3 == 0) {
			array_push($favourite_text,'.');
		}
		array_push($favourite_text, $char);
	}
	$num_favourites = implode(array_reverse($favourite_text));

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
	<?php
    	echo"<title>$formatted_name - VGCDB</title>";
	?>
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

	<script type="text/javascript" src='/libraries/jquery/jquery-3.6.0.min.js'></script>
	<script type="text/javascript" src='/js/page-transition.js'></script>
	<script type="text/javascript" src='/js/fit-text.js'></script>
	<script type="text/javascript" src='/js/menu-bar.js'></script>
	<script type="text/javascript" src='/js/commons.js'></script>
	<script type="text/javascript" src='/js/sessionAndLocalStorageManager.js'></script>

	<script type="text/javascript" src="script.js"></script>

	<?php
		echo"<style>
			:root {
				--dark-mode: 0;						
				--primary: var($colors[$color1]);
				--secondary: var($colors[$color2]);
			}
		</style>";
	?>

</head>
<body>
	<?php
		require($_SERVER['DOCUMENT_ROOT'] . "/php/navbar.php");
	?>

	<div id='body-wrapper'>

		<div id='page-transition-in'></div>

		<div id='main'>

			<div class='banner'>

				<?php
					if (file_exists($_SERVER['DOCUMENT_ROOT'].'/Images/banners/'.$banner)) {
						echo"<img src='/Images/banners/$banner' alt='Character series banner'>";
					} else {
						echo"<img src='/Images/banner_image_not_found.png' alt='Banner Image'>";
					}
				?>
			</div>

			<div class='back'>
				<div class='front soft-shadow'>
					<div class='character-card soft-shadow'>
						<div class='character-image-container soft-shadow'>
						<?php
						if (file_exists($_SERVER['DOCUMENT_ROOT'].'/Images/characters/'.$image)) {
							echo"<img class='character-image' src='/Images/characters/$image' alt='Character Image'>";
						} else {
							echo"<img class='character-image' src='/Images/character_image_not_found.png' alt='Character Image'>";
						}
						?>
						</div>
					</div>
					<div class='character-description'>
						<div class='character-name'>
							<?php
							echo "<h2>$formatted_name</h2>";
							?>
						</div>
						<div class='character-series'>
							<p>
								<?php
									$url = urlencode('/pages/resultspage/results_page.php?universe='.$universe);
									echo "<a href=\"javascript:SameUniverseSearch()\">
										from: <b>$formatted_universe ></b>
									</a>
									<form id='hidden-form' action='/pages/ResultsPage/results_page.php' method='POST' onsubmit='return formTransitionTo(this)'>
										<input type='hidden' name='universe' value=\"" . $formatted_universe . "\">
									</form>";
								?>
							</p>
						</div>
						<?php
							$q1 = "SELECT * FROM favourites WHERE username=$1 AND character=$2 AND universe=$3";
							$result = pg_query_params($dbconn, $q1, array($username, $name, $universe)) or database_error('Query failed : ' . pg_last_error());
							if(pg_fetch_array($result, null, PGSQL_NUM)) {
								echo"<div id='in-favourites' class='favourite'>";
							} else {
								echo"<div class='favourite'>";
							}
							// Form per AJAX (aggiorna il database, aggiunge/rimuove il personaggio ai/dai favourites)
							echo"<form id='hidden-favourite-form' method='POST' action='javascript:void(0)' >
								<input type='hidden' name='username' value='" . $username . "'>
								<input type='hidden' name='character' value='" . $name . "'>
								<input type='hidden' name='universe' value='" . $universe . "'>
								<input type='hidden' id='form-add' name='add'>
							</form>";
							pg_free_result($result);
					
						?>
							<img id='star-empty' alt='ADD' class='star-icon is-button icon-dark-mode-responsive'></img>
							<div>
								<h5 class='disable-text-select'></h5>
								<?php
								echo "<h6 class='disable-text-select'>$num_favourites favourites</h6>";
								?>
							</div>
						</div>
					</div>
				</div>

				<div class='table-card soft-shadow'>
					<table class='character-table'>
						<tr>
							<?php
							echo "<td class='table-attribute'>Role</td>
							<td class='table-value'>$role</td>";
							?>
						</tr>
						<tr>
							<td colspan='2'><div class='line'></div></td>
						</tr>
						<tr>
							<?php
							echo "<td class='table-attribute'>First Appearance</td>
							<td class='table-value'>$year</td>";
							?>
						</tr>
						<tr>
							<td colspan='2'><div class='line'></div></td>
						</tr>
						<tr>
							<?php
							echo "<td class='table-attribute'>Gender</td>
							<td class='table-value'>$gender</td>";
							?>
						</tr>
						<tr>
							<td colspan='2'><div class='line'></div></td>
						</tr>
						<tr>
							<?php
							echo "<td class='table-attribute'>Hair Color</td>
							<td class='table-value'>$hair</td>";
							?>
						</tr>
						<tr>
							<td colspan='2'><div class='line'></div></td>
						</tr>
						<tr>
							<?php
							echo "<td class='table-attribute'>Eye Color</td>
							<td class='table-value'>$eye</td>";
							?>
						</tr>
					</table>
				</div>
			
			</div>
			
			<div class='bg-white bg-pattern description soft-shadow'>
				<div class='description-card soft-shadow bg-primary'>
					<div>
						<?php
						echo "<h3>About $formatted_name</h3>";
						?>
					</div>
					<div class='line'></div>
					<div>
						<p>
							<?php
							echo $description;
							?>
						</p>
					</div>
				</div>

			</div>

			<div class="related-characters">
				<h2>Related characters</h2>
				<div>

				<?php
					$q2 = "SELECT * FROM characters WHERE name!=$1 AND universe=$2 ORDER BY LENGTH(role) DESC LIMIT 4";
					$result = pg_query_params($dbconn, $q2, array($name, $universe)) or database_error('Query failed : ' . pg_last_error());

					while($line = pg_fetch_array($result, null, PGSQL_NUM)) {

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

				<!-- Funziona grazie al form "nascosto" sotto alla sezione "from: universe" dei dati del personaggio di questa pagina -->
				<a href="javascript:SameUniverseSearch()"><b>Other related characters ></b></a>
				
			</div>

		</div>

		<?php
			require($_SERVER['DOCUMENT_ROOT'] . '/php/footer.php');
		?>

		
	</div>
</body>


</html>