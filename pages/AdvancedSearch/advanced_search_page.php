<!DOCTYPE html>
	<?php
		include($_SERVER['DOCUMENT_ROOT'] . "/php/database_error.php");
	?>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title>Advanced Search - VGCDB</title>
	<link rel="icon" href="/icons/logo.png">
	
	<link rel="stylesheet" href="/css/font-style.css" type="text/css">
	<link rel="stylesheet" href="/css/colors.css" type="text/css">
	<link rel="stylesheet" href="/css/scroll-bar.css" type="text/css">
	<link rel="stylesheet" href="/css/menu-bar.css" type="text/css">
	<link rel="stylesheet" href="/css/footer.css" type="text/css">
	<link rel="stylesheet" href="/css/commons.css" type="text/css">
	<link rel="stylesheet" href="/css/character-cards.css" type="text/css">
	<link rel="stylesheet" href="/css/page-transition.css" type="text/css">
	<link rel="stylesheet" href="/css/alert-message.css" type="text/css">
	<link rel="stylesheet" href="style.css" type="text/css">
	
	<script type="text/javascript" src='/libraries/jquery/jquery-3.6.0.min.js'></script>
	<script type="text/javascript" src='/js/page-transition.js'></script>
	<script type="text/javascript" src='/js/fit-text.js'></script>
	<script type="text/javascript" src='/js/menu-bar.js'></script>
	<script type="text/javascript" src='/js/commons.js'></script>
	<script type="text/javascript" src='/js/sessionAndLocalStorageManager.js'></script>

	<script type="text/javascript" src="/js/character-search.js"></script>
	<script type="text/javascript" src="card_color_control.js"></script>

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

	<div id="alert">
		<div class="alert-box">
			<span class="close-button">&times;</span>
			<div class="alert-text">WARNING: Invalid inputs found</div>
		</div>
		<div class="block-underneath-content"></div>
	</div>

    <div id="body-wrapper" class="bg-white bg-pattern">

		<div id="page-transition-in"></div>

		<div class="search-info soft-shadow">
			<h2>Advanced Search</h2>
			<h3>Search for characters by their name, universe, year of first appearance, hair color, eye color, role and gender.</h3>
		</div>

		<form action="/pages/ResultsPage/results_page.php" method="POST" onsubmit="return formTransitionTo(this)">
		<div class="grid-top">
			<div class="a">
				<div class="menu-box soft-shadow" id="character_name_box">
					<table class="search-table">
						<tr>
							<td>
								<h2>Name</h2>    
							</td>
						</tr>
						<tr>
							<td class="box-description">
								<h3>Search for a character by its <b>name</b></h3>
							</td>
						</tr>
						<tr> 
							<td>
								<div class="line"></div>
							</td>
						</tr>
						<tr class="left">
							<td class="align-center">
								<h3 class="left">Character name</h3> 
								
								<input type="text" class="character-search-input" id="character_name" maxlength="30" placeholder="Name" autocomplete="off" name="character_name" spellcheck="false">
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="b">
				<div class="menu-box soft-shadow" id="universe_box">
					<table class="search-table">
						<tr>
							<td>
								<h2>Universe</h2>    
							</td>
						</tr>
						<tr>
							<td class="box-description">
								<h3>Search for characters in a specific <b>video game universe</b></h3>    
							</td>
						</tr>
						<tr> 
							<td>
								<div class="line"></div>
							</td>
						</tr>
						<tr class="left">
							<td class="align-center">
								<h3 class="left">Universe name</h3> 

								<div class="dropdown left">
									<div id="myDropdown" class="dropdown-content">
										<?php
											$dbconn = pg_connect("host = localhost port = 5432 dbname = postgres 
											user = postgres password = vgcdb") or database_error('Could not connect : ' . pg_last_error());

											$query = "SELECT DISTINCT formatted_universe, banner FROM characters";
											$results = pg_query($query) or database_error('Query failed : '. pg_last_error());

											while ($row = pg_fetch_row($results)) {
												echo "<div>
													<div class='image-cropper'>
														<img src='/Images/banners/$row[1]'>
													</div>
													<span>$row[0]</span>
												</div>";
											}
											pg_free_result($results);
										?>
										
									</div>
								</div>
								<input type="text" class="universe-search-input show-shadow-border" id="universe_name" maxlength="30" placeholder="Universe" name="universe" spellcheck="false" autocomplete="off" onkeyup="filterFunction()">  
								
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="c">
				<div class="menu-box soft-shadow" id="year_box">
					<table class="search-table">
						<tr>
							<td colspan="4">
							<h2>Year of first appearance</h2>
							</td>
						</tr>
						<tr>
							<td class="box-description" colspan="4">
								<h3>Search for characters' <b>year of first appearance</b> in a video game</h3>    
							</td>
						</tr>
						<tr> 
							<td colspan="4">
							<div class="line"></div>
							</td>
						</tr>
						<tr class="left">
							<td colspan="4">
								<h3>Year of first appearance</h3> 
							</td>
						</tr>
						<tr>
							<td class="year-input-text">
								<h3>From</h3>
							</td>
							<td>
								<input type="text" class="year-search-input" id="year_1" minlength="4" maxlength="4"  placeholder="1970" name="year1" spellcheck="false" autocomplete="off">  
							</td>
							<td class="year-input-text">
								<h3>to</h3>
							</td>
							<td>
								<input type="text" class="year-search-input" id="year_2" minlength="4" maxlength="4" placeholder="today" name="year2" spellcheck="false" autocomplete="off">  
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="grid-bottom">
			<div class="d">
				<div class="menu-box soft-shadow" id="eye_box">
					<table class="search-table">
						<tr>
							<td>
								<h2>Eye Color</h2>    
							</td>
						</tr>
						<tr>
							<td class="box-description">
								<h3>Search for characters with a specific <b>eye color</b></h3>    
							</td>
						</tr>
						<tr> 
							<td>
							<div class="line"></div>
							</td>
						</tr>
						<tr class="left">
							<td>
								<h3>Eye Colors</h3> 
								<table class="checkbox-table">
									<tr>
										<td>
											<label class="container">
												Black
												<input type="checkbox" id="eye_black" value="Black" name="eye_color[]">
												<span class="checkmark"></span>
											</label>	
										</td>
										<td>
											<label class="container">
												Blue
												<input type="checkbox" id="eye_blue" value="Blue" name="eye_color[]">
												<span class="checkmark"></span>
											</label>	
										</td>
									</tr>
									<tr>
										<td> 
											<label class="container">
												Brown
												<input type="checkbox" id="eye_brown" value="Brown" name="eye_color[]">
												<span class="checkmark"></span>
											</label>       	
										</td>
										<td>
											<label class="container">
												Green
												<input type="checkbox" id="eye_green" value="Green" name="eye_color[]">
												<span class="checkmark"></span>
											</label>	
										</td>
									</tr>
									<tr>
										<td>
											<label class="container">
												Gray
												<input type="checkbox" id="eye_gray" value="Gray" name="eye_color[]">
												<span class="checkmark"></span>
											</label>	
										</td>
										<td>
											<label class="container">
												Orange
												<input type="checkbox" id="eye_orange" value="Orange" name="eye_color[]">
												<span class="checkmark"></span>
											</label>       	
										</td>
									</tr>
									<tr>
										<td>
											<label class="container">
												Purple
												<input type="checkbox" id="eye_purple" value="Purple" name="eye_color[]">
												<span class="checkmark"></span>
											</label>	
										</td>
										<td>
											<label class="container">
												Red
												<input type="checkbox" id="eye_red" value="Red" name="eye_color[]">
												<span class="checkmark"></span>
											</label>	
										</td>
									</tr>
									<tr>
										<td>
											<label class="container">
												White
												<input type="checkbox" id="eye_white" value="White" name="eye_color[]">
												<span class="checkmark"></span>
											</label>	
										</td>
										<td>
											<label class="container">
												Yellow
												<input type="checkbox" id="eye_yellow" value="Yellow" name="eye_color[]">
												<span class="checkmark"></span>
											</label>	
										</td>
									</tr>
									<tr>
										<td>
											<label class="container">
												Pink
												<input type="checkbox" id="eye_pink" value="Pink" name="eye_color[]">
												<span class="checkmark"></span>
											</label>	
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<label class="container">
												None/Undefined
												<input type="checkbox" id="eye_none" value="None / Undefined" name="eye_color[]">
												<span class="checkmark"></span>
											</label>	
										</td>
									</tr>
								</table>   
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="e">
				<div class="menu-box soft-shadow" id="hair_box">
					<table class="search-table">
						<tr>
							<td>
								<h2>Hair Color</h2>    
							</td>
						</tr>
						<tr>
							<td class="box-description">
								<h3>Search for characters with a specific <b>hair color</b></h3>    
							</td>
						</tr>
						<tr> 
							<td>
								<div class="line"></div>
							</td>
						</tr>
						<tr class="left">
							<td>
								<h3>Hair Colors</h3> 
								<table class="checkbox-table">
									<tr>
										<td>
											<label class="container">
												Black
												<input type="checkbox" id="hair_black" value="Black" name="hair_color[]">
												<span class="checkmark"></span>
											</label>	
										</td>
										<td>
											<label class="container">
												Blue
												<input type="checkbox" id="hair_blue" value="Blue" name="hair_color[]">
												<span class="checkmark"></span>
											</label>	
											</td>
										</tr>
										<tr>
											<td>
												<label class="container">
													Brown
													<input type="checkbox" id="hair_brown" value="Brown" name="hair_color[]">
													<span class="checkmark"></span>
												</label>
											</td>
										<td>
											<label class="container">
												Green
												<input type="checkbox" id="hair_green" value="Green" name="hair_color[]">
												<span class="checkmark"></span>
											</label>	
										</td>
									</tr>
									<tr>
										<td>
											<label class="container">
												Gray
												<input type="checkbox" id="hair_gray" value="Gray" name="hair_color[]">
												<span class="checkmark"></span>
											</label>	
										</td>
										<td>
											<label class="container">
												Orange
												<input type="checkbox" id="hair_orange" value="Orange" name="hair_color[]">
												<span class="checkmark"></span>
											</label>	
										</td>
									</tr>
									<tr>
										<td>        
											<label class="container">
												Purple
												<input type="checkbox" id="hair_purple" value="Purple" name="hair_color[]">
												<span class="checkmark"></span>
											</label>	
										</td>
										<td>
											<label class="container">
												Red
												<input type="checkbox" id="hair_red" value="Red" name="hair_color[]">
												<span class="checkmark"></span>
											</label>	
										</td>
									</tr>
									<tr>
										<td>  
											<label class="container">
												White
												<input type="checkbox" id="hair_white" value="White" name="hair_color[]">
												<span class="checkmark"></span>
											</label>      	
										</td>
										<td>
											<label class="container">
												Yellow
												<input type="checkbox" id="hair_yellow" value="Yellow" name="hair_color[]">
												<span class="checkmark"></span>
											</label>	
										</td>
									</tr>
									<tr>
										<td>
											<label class="container">
												Pink
												<input type="checkbox" id="hair_pink" value="Pink" name="hair_color[]">
												<span class="checkmark"></span>
											</label>	
										</td>
										<td>
											<label class="container">
												Sky Blue
												<input type="checkbox" id="hair_sky_blue" value="Sky Blue" name="hair_color[]">
												<span class="checkmark"></span>
											</label>	
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<label class="container">
												None/Undefined
												<input type="checkbox" id="hair_none" value="None / Undefined" name="hair_color[]">
												<span class="checkmark"></span>
											</label>	
										</td>
									</tr>
								</table>   
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="f">
				<div class="menu-box soft-shadow" id="role_box">
					<table class="search-table">
						<tr>
							<td>
								<h2>Role</h2>    
							</td>
						</tr>
						<tr>
							<td class="box-description">
								<h3>Search for characters with specific <b>roles</b> in their universe</h3>
							</td>
						</tr>
						<tr> 
							<td>
							<div class="line"></div>
							</td>
						</tr>
						<tr class="left">
							<td>
								<h3>Roles</h3> 
								<table class="checkbox-table">
									<tr>
										<td>
											<label class="container">
												Protagonist
												<input type="checkbox" id="protagonist" value="Protagonist" name='role[]'>
												<span class="checkmark"></span>
											</label>	
										</td>
										<td>
											<label class="container">
												Antagonist
												<input type="checkbox" id="antagonist" value="Antagonist" name='role[]'>
												<span class="checkmark"></span>
											</label>	
										</td>
									</tr>
									<tr>
										<td>
											<label class="container">
												Secondary
												<input type="checkbox" id="secondary" value="Secondary" name='role[]'>
												<span class="checkmark"></span>
											</label>	
										</td>
										<td>
											<label class="container">
												Enemy
												<input type="checkbox" id="enemy" value="Enemy" name='role[]'>
												<span class="checkmark"></span>
											</label>	
										</td>
									</tr>
									<tr>
										<td>
											<label class="container">
												Neutral
												<input type="checkbox" id="neutral" value="Neutral" name='role[]'>
												<span class="checkmark"></span>
											</label>	
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="g">
				<div class="menu-box soft-shadow" id="gender_box">
					<table class="search-table">
						<tr>
							<td>
								<h2>Gender</h2>
							</td>
						</tr>
						<tr>
							<td class="box-description">
								<h3>Search for characters by their <b>gender</b></h3>
							</td>
						</tr>
						<tr> 
							<td>
								<div class="line"></div>
							</td>
						</tr>
						<tr class="left">
							<td>
								<h3>Genders</h3>
								<table class="checkbox-table">
									<tr>
										<td>
											<label class="container">
												Male
												<input type="checkbox" id="male" value="Male" name="gender[]">
												<span class="checkmark"></span>
											</label>	
										</td>
										<td>
											<label class="container">
												Female
												<input type="checkbox" id="female" value="Female" name="gender[]">
												<span class="checkmark"></span>
											</label>	
										</td>
									</tr>
									<tr>
										<td>
											<label class="container">
												Other
												<input type="checkbox" id="other" value="Other" name="gender[]">
												<span class="checkmark"></span>
											</label>
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<!-- Riga vuota per allineare le 2 righe sovrastanti -->
											<div></div>
										</td>
									</tr>
								</table> 
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="h">
				<div class="reset-button soft-shadow">
					<input class="button" type="reset" id="reset_button" value="Reset">
				</div>
			</div>
			<div class="i">
				<div class="search-button soft-shadow">
					<button type="submit" id="submit_button">Search</button>
				</div>
			</div>

		</div>
		</form>

		<?php
			require($_SERVER['DOCUMENT_ROOT'] . "/php/footer.php");
		?>

    </div>

</body>
</html>