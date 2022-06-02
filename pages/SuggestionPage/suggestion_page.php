<!DOCTYPE html>

<?php

	$username = "";
	if(isset($_SESSION['username']) && $_SESSION['username'] != "") {
		$username = $_SESSION['username'];
	}

?>

<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Suggestion - VGCDB</title>
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

	<script type="text/javascript" src='alert.js'></script>

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


		<div class="suggest-info soft-shadow">
			<h2>Suggest a character</h2>
			<h3>Here you can suggest a character for VGCDB.</h3>
			<h3>Insert at least the character name and its relative universe.</h3>
		</div>

		<div class="card soft-shadow">
			<form action="index.php" method="POST" onsubmit="return formTransitionTo(this)" id="my-form">
				<table class="soft-shadow">
					<tr>
						<td>
						Character Name:
						</td>
					</tr>
				
					<tr>
						<td>
						<input type="text" class="text-input" id="character_name" maxlength="30" placeholder="Name" autocomplete="off" name="character_name" spellcheck="false">
						</td>
					</tr>
				</table>
				<table class="soft-shadow">
					<tr>
						<td>
						Universe Name:
						</td>
					</tr>
				
					<tr>
						<td>
						<input type="text" class="text-input" id="universe_name" maxlength="30" placeholder="Universe" autocomplete="off" name="universe_name" spellcheck="false">
						</td>
					</tr>
				</table>
				<table class="soft-shadow">
					<tr>
						<td>
						Role:
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div class="line"></div>
						</td>
					</tr>
					<tr>
						<td>
							<label class="container">
								Protagonist
								<input type="radio" id="protagonist" value="Protagonist" name='role'>
								<span class="radio-selection"></span>
							</label>	
						</td>
						<td>
							<label class="container">
								Antagonist
								<input type="radio" id="antagonist" value="Antagonist" name='role'>
								<span class="radio-selection"></span>
							</label>	
						</td>
					</tr>
					<tr>
						<td>
							<label class="container">
								Secondary
								<input type="radio" id="secondary" value="Secondary" name='role'>
								<span class="radio-selection"></span>
							</label>	
						</td>
						<td>
							<label class="container">
								Enemy
								<input type="radio" id="enemy" value="Enemy" name='role'>
								<span class="radio-selection"></span>
							</label>	
						</td>
					</tr>
					<tr>
						<td>
							<label class="container">
								Neutral
								<input type="radio" id="neutral" value="Neutral" name='role'>
								<span class="radio-selection"></span>
							</label>	
						</td>
					</tr>
				</table>
				<table class="soft-shadow">
					<tr>
						<td>
						Gender:
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div class="line"></div>
						</td>
					</tr>
					<tr>
						<td>
							<label class="container">
								Male
								<input type="radio" id="male" value="Male" name="gender">
								<span class="radio-selection"></span>
							</label>	
						</td>
						<td>
							<label class="container">
								Female
								<input type="radio" id="female" value="Female" name="gender">
								<span class="radio-selection"></span>
							</label>	
						</td>
					</tr>
					<tr>
						<td>
							<label class="container">
								Other
								<input type="radio" id="other" value="Other" name="gender">
								<span class="radio-selection"></span>
							</label>
						</td>
					</tr>
					<tr style="opacity: 0;">
						<td>
							...
						</td>
					</tr>
				</table>
				<table class="soft-shadow">	
					<tr>
						<td>
						Eye Color:
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div class="line"></div>
						</td>
					</tr>
					<tr>
						<td>
							<label class="container">
								Black
								<input type="radio" id="eye_black" value="Black" name="eye_color">
								<span class="radio-selection"></span>
							</label>	
						</td>
						<td>
							
							<label class="container">
								Blue
								<input type="radio" id="eye_blue" value="Blue" name="eye_color">
								<span class="radio-selection"></span>
							</label>	
						</td>
					</tr>
						<tr>
							<td> 
								
								<label class="container">
									Brown
									<input type="radio" id="eye_brown" value="Brown" name="eye_color">
									<span class="radio-selection"></span>
								</label>
							</td>
							<td>
								
								<label class="container">
									Green
									<input type="radio" id="eye_green" value="Green" name="eye_color">
									<span class="radio-selection"></span>
								</label>	
							</td>
					</tr>
						<tr>
							<td>
								
								<label class="container">
									Gray
									<input type="radio" id="eye_gray" value="Gray" name="eye_color">
									<span class="radio-selection"></span>
								</label>	
							</td>
							<td>
								
								<label class="container">
									Orange
									<input type="radio" id="eye_orange" value="Orange" name="eye_color">
									<span class="radio-selection"></span>
								</label>   	
							</td>
					</tr>
						<tr>
							<td>
								
								<label class="container">
									Purple
									<input type="radio" id="eye_purple" value="Purple" name="eye_color">
									<span class="radio-selection"></span>
								</label>	
							</td>
							<td>
								
								<label class="container">
									Red
									<input type="radio" id="eye_red" value="Red" name="eye_color">
									<span class="radio-selection"></span>
								</label>	
							</td>
					</tr>
						<tr>
							<td>
								
								<label class="container">
									White
									<input type="radio" id="eye_white" value="White" name="eye_color">
									<span class="radio-selection"></span>
								</label>	
							</td>
							<td>
								
								<label class="container">
									Yellow
									<input type="radio" id="eye_yellow" value="Yellow" name="eye_color">
									<span class="radio-selection"></span>
								</label>	
							</td>
					</tr>
						<tr>
							<td>
								
								<label class="container">
									Pink
									<input type="radio" id="eye_pink" value="Pink" name="eye_color">
									<span class="radio-selection"></span>
								</label>	
							</td>
					</tr>
						<tr>
							<td colspan="2">
								
								<label class="container">
									None/Undefined
									<input type="radio" id="eye_none" value="None / Undefined" name="eye_color">
									<span class="radio-selection"></span>
								</label>	
							</td>
					</tr>
				</table>
				<table class="soft-shadow">			
					<tr>
						<td>
							Hair Color:
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div class="line"></div>
						</td>
					</tr>
					<tr>
						<td>
							<label class="container">
								Black
								<input type="radio" id="hair_black" value="Black" name="hair_color">
								<span class="radio-selection"></span>
							</label>	
						</td>
						<td>
							<label class="container">
								Blue
								<input type="radio" id="hair_blue" value="Blue" name="hair_color">
								<span class="radio-selection"></span>
							</label>	
							</td>
					</tr>
						<tr>
							<td>
								<label class="container">
									Brown
									<input type="radio" id="hair_brown" value="Brown" name="hair_color">
									<span class="radio-selection"></span>
								</label>
							</td>
						<td>
							<label class="container">
								Green
								<input type="radio" id="hair_green" value="Green" name="hair_color">
								<span class="radio-selection"></span>
							</label>	
						</td>
					</tr>
					<tr>
						<td>
							<label class="container">
								Gray
								<input type="radio" id="hair_gray" value="Gray" name="hair_color">
								<span class="radio-selection"></span>
							</label>	
						</td>
						<td>
							<label class="container">
								Orange
								<input type="radio" id="hair_orange" value="Orange" name="hair_color">
								<span class="radio-selection"></span>
							</label>	
						</td>
					</tr>
					<tr>
						<td>
							<label class="container">
								Purple
								<input type="radio" id="hair_purple" value="Purple" name="hair_color">
								<span class="radio-selection"></span>
							</label>	
						</td>
						<td>
							<label class="container">
								Red
								<input type="radio" id="hair_red" value="Red" name="hair_color">
								<span class="radio-selection"></span>
							</label>	
						</td>
					</tr>
					<tr>
						<td>  
							<label class="container">
								White
								<input type="radio" id="hair_white" value="White" name="hair_color">
								<span class="radio-selection"></span>
							</label>  	
						</td>
						<td>
							<label class="container">
								Yellow
								<input type="radio" id="hair_yellow" value="Yellow" name="hair_color">
								<span class="radio-selection"></span>
							</label>	
						</td>
					</tr>
					<tr>
						<td>
							<label class="container">
								Pink
								<input type="radio" id="hair_pink" value="Pink" name="hair_color">
								<span class="radio-selection"></span>
							</label>	
						</td>
						<td>
							<label class="container">
								Sky Blue
								<input type="radio" id="hair_sky_blue" value="Sky Blue" name="hair_color">
								<span class="radio-selection"></span>
							</label>	
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<label class="container">
								None/Undefined
								<input type="radio" id="hair_none" value="None / Undefined" name="hair_color">
								<span class="radio-selection"></span>
							</label>	
						</td>
					</tr>
				</table>
				<table class="year-table soft-shadow">
					<tr>
						<td>
						Year of First Appearance:
						</td>
						<td>
							<input type="text" class="year-input" id="year_1" placeholder="1970" name="year" spellcheck="false" autocomplete="off">  
						</td>
					</tr>
					
				</table>
				<table class="soft-shadow">
					<tr>
						<td>
							Additional notes:
						</td>
					</tr>
					
					<tr>
						<td>
							<textarea class="text-area" name="notes" form="my-form" cols="80" rows="5" autocomplete="off" spellcheck="false" placeholder="Enter your comment here..."></textarea>
						</td>
					</tr>
				</table>
				<div class="submit-button soft-shadow">
					<button type="submit" id="submit_button" name="submit_button" value="Submit form">Submit character</button>
				</div>
			</form>
		</div>

		<?php
			if(isset($_SESSION['username']) && $_SESSION['username'] != "") {
				echo"<div id='user-is-logged-in' style='display: none;'></div>";
			}
		?>
		
		<?php
			require($_SERVER['DOCUMENT_ROOT'] . "/php/footer.php");
		?>

	</div>

</body>
</html>