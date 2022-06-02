<!DOCTYPE html>

<?php
	
	include($_SERVER['DOCUMENT_ROOT'] . "/php/database_error.php");

?>

<html>

<head>

	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Search Results - VGCDB</title>
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

	<style>
		:root {
			--dark-mode: 0;				
			--primary: var(--red);
			--secondary: var(--blue);
			--tertiary: none;
		}
	</style>
</head>
<body id="body">
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
		
	<div id="body-wrapper"></div>

	<div id="page-transition-in"></div>

	<div class="page-content bg-white bg-pattern">
		<div class="search-box soft-shadow">
			<form id="search-form" action="#body">
			<table class="search-table">
				<tr>
					<td>
						<h2>Refine your search</h2>
					</td>
				</tr>
				<tr>
					<td>
						<div class="line"></div>
					</td>
				</tr>
				<tr>
					<td>
						<h3>Character Name</h3>
						<?php 
							$default = "";
										
							if(!empty($_POST['character_name'])) {
								$default = "value=\"" . $_POST['character_name'] . "\"";
							}
							
							echo'
							<input type="text" class="character-search-input" id="character_name" maxlength="30" placeholder="Name" name="character_name" autocomplete="off" spellcheck="false" ' . $default . '>
						'?>
					</td>
				</tr>
				<tr>
					<td>
						<h3>Universe Name</h3>
						
						<div class="dropdown left">
							<div id="myDropdown" class="dropdown-content">
								<?php
									$dbconn = pg_connect("host = localhost port = 5432 dbname = postgres 
									user = postgres password = vgcdb")
									or database_error('Could not connect : ' . pg_last_error());

									$query = "SELECT DISTINCT formatted_universe, banner FROM characters";
									$results = pg_query($query) or database_error('Query failed : '.pg_last_error());

									while ($row = pg_fetch_row($results)) {
										echo "<div>
											<div class='image-cropper'>
												<img src='/Images/banners/$row[1]'>
											</div>
											<span>$row[0]</span>
										</div>";
									}
									pg_free_result($results);
									pg_close($dbconn);

								?>
								
							</div>
						</div>
						<?php 
							$default = "";
										
							if(!empty($_POST['universe'])) {
								$default = "value=\"" . $_POST['universe'] . "\"";
							}
							
							echo'
							<input type="text" class="universe-search-input show-shadow-border" id="universe_name" maxlength="30" placeholder="Universe" name="universe" spellcheck="false" autocomplete="off" onkeyup="filterFunction()" ' . $default . '>  
						'?>
						
					</td>
				</tr>
				<tr>
					<td>
						<h3>Role</h3>
						<div class="search-box-menu">
							<h3>Select Roles</h3>
						</div>
						<div class="checkbox-div soft-shadow">
							<table class="checkbox-table">
								<tr>
									<td>
										<?php 
											$values = null;
											if (!empty($_POST['role'])) {
												$values = $_POST['role'];
											}
											$value_array = array('Protagonist','Antagonist','Secondary','Enemy','Neutral');
											$checked_array = array();
											for($i=0; $i < count($value_array); $i++){
												$to_push = 0;
												if ($values != null && in_array($value_array[$i], $values)) {
													$to_push = 1;
												}
												array_push($checked_array, $to_push);
											}
											$index_counter = 0;
										?>
										<label class="container">
											Protagonist
											<?php 
												$checked = "";
												if ($checked_array[$index_counter]) {
													$checked = "checked";
												}
												$index_counter++;
												echo'
												<input type="checkbox" id="protagonist" value="Protagonist" name="role[]" ' . $checked . '>
											'?>
											<span class="checkmark"></span>
										</label>	
									</td>
									<td>
										<label class="container">
											Antagonist
											<?php 
												$checked = "";
												if ($checked_array[$index_counter]) {
													$checked = "checked";
												}
												$index_counter++;
												echo'
												<input type="checkbox" id="antagonist" value="Antagonist" name="role[]" ' . $checked . '>
											'?>
											<span class="checkmark"></span>
										</label>	
									</td>
								</tr>
								<tr>
									<td>
										<label class="container">
											Secondary
											<?php 
												$checked = "";
												if ($checked_array[$index_counter]) {
													$checked = "checked";
												}
												$index_counter++;
												echo'
												<input type="checkbox" id="secondary" value="Secondary" name="role[]" ' . $checked . '>
											'?>
											<span class="checkmark"></span>
										</label>	
									</td>
									<td>
										<label class="container">
											Enemy
											<?php 
												$checked = "";
												if ($checked_array[$index_counter]) {
													$checked = "checked";
												}
												$index_counter++;
												echo'
												<input type="checkbox" id="enemy" value="Enemy" name="role[]" ' . $checked . '>
											'?>
											<span class="checkmark"></span>
										</label>	
									</td>
								</tr>
								<tr>
									<td>
										<label class="container">
											Neutral
											<?php 
												$checked = "";
												if ($checked_array[$index_counter]) {
													$checked = "checked";
												}
												$index_counter++;
												echo'
												<input type="checkbox" id="neutral" value="Neutral" name="role[]" ' . $checked . '>
											'?>
											<span class="checkmark"></span>
										</label>	
									</td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<h3>Gender</h3>
						<div class="search-box-menu">
							<h3>Select Genders</h3>
						</div>
						<div class="checkbox-div soft-shadow">
							<table class="checkbox-table">
								<tr>
									<td>
										<?php 
											$values = null;
											if (!empty($_POST['gender'])) {
												$values = $_POST['gender'];
											}
											$value_array = array('Male','Female','Other');
											$checked_array = array();
											for($i=0; $i < count($value_array); $i++){
												$to_push = 0;
												if ($values != null && in_array($value_array[$i], $values)) {
													$to_push = 1;
												}
												array_push($checked_array, $to_push);
											}
											$index_counter = 0;
										?>
										<label class="container">
											Male
											<?php 
												$checked = "";
												if ($checked_array[$index_counter]) {
													$checked = "checked";
												}
												$index_counter++;
												echo'
												<input type="checkbox" id="male" value="Male" name="gender[]" ' . $checked . '>
											'?>
											<span class="checkmark"></span>
										</label>	
									</td>
									<td>
										<label class="container">
											Female
											<?php 
												$checked = "";
												if ($checked_array[$index_counter]) {
													$checked = "checked";
												}
												$index_counter++;
												echo'
												<input type="checkbox" id="female" value="Female" name="gender[]" ' . $checked . '>
											'?>
											<span class="checkmark"></span>
										</label>	
									</td>
								</tr>
								<tr>
									<td>
										<label class="container">
											Other
												<?php 
												$checked = "";
												if ($checked_array[$index_counter]) {
													$checked = "checked";
												}
												$index_counter++;
												echo'
												<input type="checkbox" id="other" value="Other" name="gender[]" ' . $checked . '>
											'?>
											<span class="checkmark"></span>
										</label>
									</td>
								</tr>
							</table> 
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<h3>Eye Color</h3>
						<div class="search-box-menu">
							<h3>Select Eye Colors</h3>
						</div>
						<div class="checkbox-div soft-shadow">
						<table class="checkbox-table">
							<tr>
								<td>
									<?php 
										// $values = implode('\',\'', $_POST['role']);
										$values = null;
										if (!empty($_POST['eye_color'])) {
											$values = $_POST['eye_color'];
										}
										$value_array  = array('Black','Blue','Brown','Green','Gray','Orange','Purple','Red','White','Yellow','Pink','None / Undefined');
										$checked_array = array();
										for($i=0; $i < count($value_array); $i++){
											$to_push = 0;
											if ($values != null && in_array($value_array[$i], $values)) {
												$to_push = 1;
											}
											array_push($checked_array, $to_push);
										}
										$index_counter = 0;
									?>
									<label class="container">
										Black
										<?php 
											$checked = "";
											if ($checked_array[$index_counter]) {
												$checked = "checked";
											}
											$index_counter++;
											echo'
											<input type="checkbox" id="eye_black" value="Black" name="eye_color[]" ' . $checked . '>
										'?>
										<span class="checkmark"></span>
									</label>	
								</td>
								<td>
									<label class="container">
										Blue
										<?php 
											$checked = "";
											if ($checked_array[$index_counter]) {
												$checked = "checked";
											}
											$index_counter++;
											echo'
											<input type="checkbox" id="eye_blue" value="Blue" name="eye_color[]" ' . $checked . '>
										'?>
										<span class="checkmark"></span>
									</label>	
								</td>
							</tr>
							<tr>
								<td> 
									<label class="container">
										Brown
										<?php 
											$checked = "";
											if ($checked_array[$index_counter]) {
												$checked = "checked";
											}
											$index_counter++;
											echo'
											<input type="checkbox" id="eye_brown" value="Brown" name="eye_color[]" ' . $checked . '>
										'?>
										<span class="checkmark"></span>
									</label>       	
								</td>
								<td>
									<label class="container">
										Green
										<?php 
											$checked = "";
											if ($checked_array[$index_counter]) {
												$checked = "checked";
											}
											$index_counter++;
											echo'
											<input type="checkbox" id="eye_green" value="Green" name="eye_color[]" ' . $checked . '>
										'?>
										<span class="checkmark"></span>
									</label>	
								</td>
							</tr>
							<tr>
								<td>
									<label class="container">
										Gray
										<?php 
											$checked = "";
											if ($checked_array[$index_counter]) {
												$checked = "checked";
											}
											$index_counter++;
											echo'
											<input type="checkbox" id="eye_gray" value="Gray" name="eye_color[]" ' . $checked . '>
										'?>
										<span class="checkmark"></span>
									</label>	
								</td>
								<td>
									<label class="container">
										Orange
										<?php 
											$checked = "";
											if ($checked_array[$index_counter]) {
												$checked = "checked";
											}
											$index_counter++;
											echo'
											<input type="checkbox" id="eye_orange" value="Orange" name="eye_color[]" ' . $checked . '>
										'?>
										<span class="checkmark"></span>
									</label>       	
								</td>
							</tr>
							<tr>
								<td>
									<label class="container">
										Purple
										<?php 
											$checked = "";
											if ($checked_array[$index_counter]) {
												$checked = "checked";
											}
											$index_counter++;
											echo'
											<input type="checkbox" id="eye_purple" value="Purple" name="eye_color[]" ' . $checked . '>
										'?>
										<span class="checkmark"></span>
									</label>	
								</td>
								<td>
									<label class="container">
										Red
										<?php 
											$checked = "";
											if ($checked_array[$index_counter]) {
												$checked = "checked";
											}
											$index_counter++;
											echo'
											<input type="checkbox" id="eye_red" value="Red" name="eye_color[]" ' . $checked . '>
										'?>
										<span class="checkmark"></span>
									</label>	
								</td>
							</tr>
							<tr>
								<td>
									<label class="container">
										White
										<?php 
											$checked = "";
											if ($checked_array[$index_counter]) {
												$checked = "checked";
											}
											$index_counter++;
											echo'
											<input type="checkbox" id="eye_white" value="White" name="eye_color[]" ' . $checked . '>
										'?>
										<span class="checkmark"></span>
									</label>	
								</td>
								<td>
									<label class="container">
										Yellow
										<?php 
											$checked = "";
											if ($checked_array[$index_counter]) {
												$checked = "checked";
											}
											$index_counter++;
											echo'
											<input type="checkbox" id="eye_yellow" value="Yellow" name="eye_color[]" ' . $checked . '>
										'?>
										<span class="checkmark"></span>
									</label>	
								</td>
							</tr>
							<tr>
								<td>
									<label class="container">
										Pink
										<?php 
											$checked = "";
											if ($checked_array[$index_counter]) {
												$checked = "checked";
											}
											$index_counter++;
											echo'
											<input type="checkbox" id="eye_pink" value="Pink" name="eye_color[]" ' . $checked . '>
										'?>
										<span class="checkmark"></span>
									</label>	
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<label class="container">
										None/Undefined
										<?php 
											$checked = "";
											if ($checked_array[$index_counter]) {
												$checked = "checked";
											}
											$index_counter++;
											echo'
											<input type="checkbox" id="eye_none" value="None / Undefined" name="eye_color[]" ' . $checked . '>
										'?>
										<span class="checkmark"></span>
									</label>	
								</td>
							</tr>
						</table>   
						</div>
						
					</td>
				</tr>
				<tr>
					<td>
						<h3>Hair Color</h3>
						<div class="search-box-menu">
							<h3>Select Hair Colors</h3>
						</div>
						<div class="checkbox-div soft-shadow">
						<table class="checkbox-table">
							<tr>
								<td>
									<?php 
										// $values = implode('\',\'', $_POST['role']);
										$values = null;
										if (!empty($_POST['hair_color'])) {
											$values = $_POST['hair_color'];
										}
										$value_array = array('Black','Blue','Brown','Green','Gray','Orange','Purple','Red','White','Yellow','Pink','Sky Blue','None / Undefined');
										$checked_array = array();
										for($i=0; $i < count($value_array); $i++){
											$to_push = 0;
											if ($values != null && in_array($value_array[$i], $values)) {
												$to_push = 1;
											}
											array_push($checked_array, $to_push);
										}
										$index_counter = 0;
									?>
									<label class="container">
										Black
										<?php 
											$checked = "";
											if ($checked_array[$index_counter]) {
												$checked = "checked";
											}
											$index_counter++;
											echo'
											<input type="checkbox" id="hair_black" value="Black" name="hair_color[]" ' . $checked . '>
										'?>
										<span class="checkmark"></span>
									</label>	
								</td>
								<td>
									<label class="container">
										Blue
										<?php 
											$checked = "";
											if ($checked_array[$index_counter]) {
												$checked = "checked";
											}
											$index_counter++;
											echo'
											<input type="checkbox" id="hair_blue" value="Blue" name="hair_color[]" ' . $checked . '>
										'?>
										<span class="checkmark"></span>
									</label>	
									</td>
								</tr>
								<tr>
									<td>
										<label class="container">
											Brown
											<?php 
											$checked = "";
											if ($checked_array[$index_counter]) {
												$checked = "checked";
											}
											$index_counter++;
											echo'
											<input type="checkbox" id="hair_brown" value="Brown" name="hair_color[]" ' . $checked . '>
										'?>
											<span class="checkmark"></span>
										</label>
									</td>
								<td>
									<label class="container">
										Green
										<?php 
											$checked = "";
											if ($checked_array[$index_counter]) {
												$checked = "checked";
											}
											$index_counter++;
											echo'
											<input type="checkbox" id="hair_green" value="Green" name="hair_color[]" ' . $checked . '>
										'?>
										<span class="checkmark"></span>
									</label>	
								</td>
							</tr>
							<tr>
								<td>
									<label class="container">
										Gray
										<?php 
											$checked = "";
											if ($checked_array[$index_counter]) {
												$checked = "checked";
											}
											$index_counter++;
											echo'
											<input type="checkbox" id="hair_gray" value="Gray" name="hair_color[]" ' . $checked . '>
										'?>
										<span class="checkmark"></span>
									</label>	
								</td>
								<td>
									<label class="container">
										Orange
										<?php 
											$checked = "";
											if ($checked_array[$index_counter]) {
												$checked = "checked";
											}
											$index_counter++;
											echo'
											<input type="checkbox" id="hair_orange" value="Orange" name="hair_color[]" ' . $checked . '>
										'?>
										<span class="checkmark"></span>
									</label>	
								</td>
							</tr>
							<tr>
								<td>        
									<label class="container">
										Purple
										<?php 
											$checked = "";
											if ($checked_array[$index_counter]) {
												$checked = "checked";
											}
											$index_counter++;
											echo'
											<input type="checkbox" id="hair_purple" value="Purple" name="hair_color[]" ' . $checked . '>
										'?>
										<span class="checkmark"></span>
									</label>	
								</td>
								<td>
									<label class="container">
										Red
										<?php 
											$checked = "";
											if ($checked_array[$index_counter]) {
												$checked = "checked";
											}
											$index_counter++;
											echo'
											<input type="checkbox" id="hair_red" value="Red" name="hair_color[]" ' . $checked . '>
										'?>
										<span class="checkmark"></span>
									</label>	
								</td>
							</tr>
							<tr>
								<td>  
									<label class="container">
										White
										<?php 
											$checked = "";
											if ($checked_array[$index_counter]) {
												$checked = "checked";
											}
											$index_counter++;
											echo'
											<input type="checkbox" id="hair_white" value="White" name="hair_color[]" ' . $checked . '>
										'?>
										<span class="checkmark"></span>
									</label>      	
								</td>
								<td>
									<label class="container">
										Yellow
										<?php 
											$checked = "";
											if ($checked_array[$index_counter]) {
												$checked = "checked";
											}
											$index_counter++;
											echo'
											<input type="checkbox" id="hair_yellow" value="Yellow" name="hair_color[]" ' . $checked . '>
										'?>
										<span class="checkmark"></span>
									</label>	
								</td>
							</tr>
							<tr>
								<td>
									<label class="container">
										Pink
										<?php 
											$checked = "";
											if ($checked_array[$index_counter]) {
												$checked = "checked";
											}
											$index_counter++;
											echo'
											<input type="checkbox" id="hair_pink" value="Pink" name="hair_color[]" ' . $checked . '>
										'?>
										<span class="checkmark"></span>
									</label>	
								</td>
								<td>
									<label class="container">
										Sky Blue
										<?php 
											$checked = "";
											if ($checked_array[$index_counter]) {
												$checked = "checked";
											}
											$index_counter++;
											echo'
											<input type="checkbox" id="hair_sky_blue" value="Sky Blue" name="hair_color[]" ' . $checked . '>
										'?>
										<span class="checkmark"></span>
									</label>	
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<label class="container">
										None/Undefined
										<?php 
											$checked = "";
											if ($checked_array[$index_counter]) {
												$checked = "checked";
											}
											$index_counter++;
											echo'
											<input type="checkbox" id="hair_none" value="None / Undefined" name="hair_color[]" ' . $checked . '>
										'?>
										<span class="checkmark"></span>
									</label>	
								</td>
							</tr>
						</table>   
						</div>
						
					</td>
				</tr>
				<tr>
					<td>
						<h3>Year of first appearance</h3>
						<table>
							<tr>
								<td class="year-input-text">
									<h3>From</h3>
								</td>
								<td>
								<?php 
									$default = "";
												
									if(!empty($_POST['year1'])) {
										$default = "value=\"" . $_POST['year1'] . "\"";
									}
									
									echo'
									<input type="text" class="year-search-input" id="year_1" minlength="4" maxlength="4"  placeholder="1970" name="year1" spellcheck="false" autocomplete="off" ' . $default . '>  
								'?>
								</td>
								<td class="year-input-text">
									<h3>to</h3>
								</td>
								<td>
								<?php 
									$default = "";
												
									if(!empty($_POST['year2'])) {
										$default = "value=\"" . $_POST['year2'] . "\"";
									}
									
									echo'
									<input type="text" class="year-search-input" id="year_2" minlength="4" maxlength="4" placeholder="today" name="year2" spellcheck="false" autocomplete="off" ' . $default . '>  
								'?>
								</td>

							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<div class="reset-button soft-shadow">
							<input class="button" type="reset" id="reset_button" value="Reset" onclick="return ResetHardcodedCheckboxes()">
						</div>
						<div class="search-button soft-shadow">
							<button type="submit" id="submit_button" value="Submit">Search</button>
						</div>
						
					</td>
				</tr>
			</table>
			</form>
		</div>

		<div id="results-section">

			<?php
				require("search_results.php");
			?>
			
		</div>
	</div>

	<?php
		require($_SERVER['DOCUMENT_ROOT'] . "/php/footer.php");
	?>

	<script type="text/javascript" src="script.js"></script>
	<script type="text/javascript" src="ajax_results.js"></script>
	<script type="text/javascript" src="/js/character-search.js"></script>

</body>
</html>