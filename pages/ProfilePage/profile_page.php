<!DOCTYPE html>
	<?php
		include($_SERVER['DOCUMENT_ROOT'] . "/php/database_error.php");

	?>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Profile - VGCDB</title>
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

		<div id="page-transition-in"></div>
		
		<div class="profile-page-info soft-shadow">
			<h2>Profile page</h2>
			<h3>This is your profile page, here you can see your profile information, stats and favourite characters.</h3>
		</div>
			
		<?php

			$username = $_SESSION['username']; 
			
			$dbconn = pg_connect("host = localhost port =5432 dbname = postgres user = postgres password = vgcdb") 
			or database_error('Could not connect : ' . pg_last_error());
			
			$q1 = "SELECT * FROM users WHERE username=$1";
			$result1 = pg_query_params($dbconn, $q1, array($username)) or database_error('Query failed : '.pg_last_error());
			if ($line1 = pg_fetch_array($result1, null, PGSQL_NUM)) {
				$icon = $line1[2];
			}

			$q_num_favourites = "SELECT count(*) FROM favourites WHERE username=$1";
			$result1 = pg_query_params($dbconn, $q_num_favourites, array($username)) or database_error('Query failed : '.pg_last_error());
			if ($line1 = pg_fetch_array($result1, null, PGSQL_NUM)) {
				$num_of_favourites = $line1[0];
			}
			
			$q_num_suggested = "SELECT count(*) FROM suggestions WHERE username=$1";
			$result1 = pg_query_params($dbconn, $q_num_suggested, array($username)) or database_error('Query failed : '.pg_last_error());
			if ($line1 = pg_fetch_array($result1, null, PGSQL_NUM)) {
				$num_of_suggested = $line1[0];
			}

		?>

		<div class="page-content bg-pattern">
			
			<div class="bg-secondary user-info soft-shadow">
				<div>
					<div class="profile-info">
						<h3>Your profile</h3>
					</div>
				</div>
				<div class="line"></div>
				<div class="profile-main">
					<div class="bg-gray profile-name-icon soft-shadow">
						<div class="icon-container">
							<?php
								echo "<img class='profile-image icon-dark-mode-responsive' src='/Icons/profile-icons/$icon' alt='Profile Icon'>";
							?>
						</div>
						<div class="username-text">
							<?php
								echo"$username";
							?>
						</div>
					</div>
					<div class="profile-logout">
						<div id="logout" class="login-option">
							<a href="javascript:transitionTo('/pages/Sign_Out/index.php')">Logout</a>
							<div class="icon">
								<img class="icon-dark-mode-responsive" src="/icons/logout-icon.png">
							</div>
						</div>
					</div>
				</div>
				<div class="bg-gray user-stats soft-shadow">
					<div>
						<div>
							Number of characters added to favourites:
						</div>
						<div>
							<?php
								echo "$num_of_favourites characters";
							?>
						</div>
					</div>
					<div>
						<div>
							Number of characters suggested for VGCDB:
						</div>
						<div>
							<?php
								echo "$num_of_suggested characters";
							?>
						</div>
					</div>
				</div>
			</div>

			<div class="favourites">

				<?php

					$q2 = "SELECT * FROM favourites WHERE username=$1";
					$result2 = pg_query_params($dbconn, $q2, array($username)) or database_error('Query failed : '.pg_last_error());

					echo'<div class="bg-primary favourites-info extra-soft-shadow">
						Your favourite characters
					</div>
					<div class="favourites-section soft-shadow">';


					if (pg_fetch_array($result2, null, PGSQL_NUM)) { 

						// Resetto il puntatore interno per l'array dei risultati
						pg_result_seek($result2,0);
				
						while($line2 = pg_fetch_array($result2, null, PGSQL_NUM)) {

							$character_name = $line2[1];
							$universe = $line2[2];


							$q3 = "SELECT * FROM characters WHERE name = $1 AND universe = $2";
							$result3 = pg_query_params($dbconn, $q3, array($character_name, $universe)) or database_error('Query failed : '.pg_last_error());

							if ($line3 = pg_fetch_row($result3)) {

								$formatted_name = 		$line3[0];
								$formatted_universe = 	$line3[1];
								$image = 				$line3[10];
								$name = 				$line3[12];
								$universe = 			$line3[13];
							
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

							pg_free_result($result3);
						}
				
					} else {
						echo '
							<div class="no-favourites">
								<div>
									<h3>
										You didn\'t add any character in your favourites
									</h3>
									<p>
										To add one, simply visit the page of a character and click on the "Add to favourite" under the character\'s info.
									</p>
								</div>
							</div>
						';
					}

					pg_free_result($result2);

					pg_free_result($result1);
					
					pg_close($dbconn);

					echo'</div>';

				?>

			</div>
		</div>

		
		<?php
			require($_SERVER['DOCUMENT_ROOT'] . "/php/footer.php");
		?>

	</div>

	<script>
		// Script per assegnare le funzionalità al bottone di logout
		$(document).ready(function() {
			document.querySelector(".profile-logout > #logout").addEventListener("click", (e) => {
				if (e.target.querySelector("a")) {
					let url = e.target.querySelector("a").href;
					if (url.length > 0) {
						if (url[0] == 'j') {
							let real_url = url.slice(25, -2);
							window["transitionTo"](real_url);
						} else {
							window.location.href = url;
						}
					} else {
						console.log("Element has no url");
					}
				}
			});
		});
	</script>
	
</body>
</html>