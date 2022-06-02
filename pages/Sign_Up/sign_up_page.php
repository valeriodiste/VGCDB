<!DOCTYPE html>

<?php

	// Funzione per gestire la mancata connessione al database
	include($_SERVER['DOCUMENT_ROOT'] . "/php/database_error.php");
?>

<html>
<head>

	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Sign Up - VGCDB</title>
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

	<script type="text/javascript" src='script.js'></script>

	
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

		<div class="card bg-primary soft-shadow">
		
			<div class="title">
				<div>Create an account</div>
				<div class="line"></div>
			</div>
				
			<form action="index.php" method="POST" onsubmit="return SubmitLoginForm(this)">
				<div>
					<h3>Username</h3>
					<input id="username-input" type="text" class="text-input soft-shadow" name="username" placeholder="Your Username" required autocomplete="off">
				</div>
				<div>
					<h3>Password</h3>
					<input id="password-input" type="text" class="text-input soft-shadow" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Password" maxlength="32" required autocomplete="off">
				</div>
				
				<div class="password-validation">
					<div class="soft-shadow">
						<div><b>Password must have:</b></div>
						<div id="letter" class="not-valid extra-soft-shadow">at least <b>one lowercase</b> letter</div>
						<div id="capital" class="not-valid extra-soft-shadow">at least <b>one uppercase</b> letter</div>
						<div id="number" class="not-valid extra-soft-shadow">at least <b>one number</b></div>
						<div id="length" class="not-valid extra-soft-shadow">at least <b>8 characters</b></div>
					</div>
				</div>

				<!-- bisogna modificare il value dei radio in base a come lo gestiamo nel database -->
				<h3>Select your profile icon</h3>
				<div class="radio-container">
					<label class="container">
						<input type="radio" name="icon" value="profile_icon_01.png" checked>
						<div class="tick_container extra-soft-shadow">
							<div class="tick"></div>
						</div>
						<div class="image-container">
							<img src="/Icons/profile-icons/profile_icon_01.png" class="icon-dark-mode-responsive" alt="Image 1">
						</div>
						
					</label>
					<label class="container">
						<input type="radio" name="icon" value="profile_icon_02.png">
						<div class="tick_container extra-soft-shadow">
							<div class="tick"></div>
						</div>
						<div class="image-container">
							<img src="/Icons/profile-icons/profile_icon_02.png" class="icon-dark-mode-responsive" alt="Image 2">
						</div>
					</label>
					<label class="container">
						<input type="radio" name="icon" value="profile_icon_03.png">
						<div class="tick_container extra-soft-shadow">
							<div class="tick"></div>
						</div>
						<div class="image-container">
							<img src="/Icons/profile-icons/profile_icon_03.png" class="icon-dark-mode-responsive" alt="Image 3">
						</div>
					</label>
					<label class="container">
						<input type="radio" name="icon" value="profile_icon_04.png">
						<div class="tick_container extra-soft-shadow">
							<div class="tick"></div>
						</div>
						<div class="image-container">
							<img src="/Icons/profile-icons/profile_icon_04.png" class="icon-dark-mode-responsive" alt="Image 4">
						</div>
					</label>
					<label class="container">
						<input type="radio" name="icon" value="profile_icon_05.png">
						<div class="tick_container extra-soft-shadow">
							<div class="tick"></div>
						</div>
						<div class="image-container">
							<img src="/Icons/profile-icons/profile_icon_05.png" class="icon-dark-mode-responsive" alt="Image 5">
						</div>
					</label>
					<label class="container">
						<input type="radio" name="icon" value="profile_icon_06.png">
						<div class="tick_container extra-soft-shadow">
							<div class="tick"></div>
						</div>
						<div class="image-container">
							<img src="/Icons/profile-icons/profile_icon_06.png" class="icon-dark-mode-responsive" alt="Image 6">
						</div>
					</label>
				</div>

				<div class="submit-button soft-shadow">
					<button type="submit" id="registration_button" name='registration_button' value="Submit form">Sign Up</button>
				</div>
				
			</form>

			<div>
				<a href="javascript:transitionTo('/pages/Sign_In/sign_in_page.php')">Already have an account?<br/><b>Click here to login</b></a>
			</div>

		<!-- 
			<form action="index.php" method="POST" onsubmit="save_data()">
			
				<label for="username" class="form-label">Username</label>
				<input type="text" id="username" name="username" placeholder="Your Username" required autocomplete="off">

				<label for="password" class="form-label">Password</label>
				<input type="password" id="password" name="password" maxlength="32" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" placeholder="Password" required>

				<div id="message">
				<h3>Password must contain the following:</h3>
				<p id="letter" class="invalid">A <b>lowercase</b> letter</p>
				<p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
				<p id="number" class="invalid">A <b>number</b></p>
				<p id="length" class="invalid">Minimum <b>8 characters</b></p>
				</div> -->

				<!-- bisogna modificare il value dei radio in base a come lo gestiamo nel database -->
				<!-- <div class="container parent">
					<div class="row">
						<div class='col text-center'>
						<input type="radio" name="icon" id="img1" class="d-none imgbgchk" value="profile_icon_01.png" checked>
							<label for="img1">
								<img src="/Icons/profile-icons/profile_icon_01.png" alt="Image 1">
								<div class="tick_container">
									<div class="tick">&checkmark;</div>
								</div>
							</label>
						</div>
						<div class='col text-center'>
						<input type="radio" name="icon" id="img2" class="d-none imgbgchk" value="profile_icon_02.png">
							<label for="img2">
								<img src="/Icons/profile-icons/profile_icon_02.png" alt="Image 2">
								<div class="tick_container">
									<div class="tick">&checkmark;</div>
								</div>
							</label>
						</div>
						<div class='col text-center'>
						<input type="radio" name="icon" id="img3" class="d-none imgbgchk" value="profile_icon_03.png">
							<label for="img3">
								<img src="/Icons/profile-icons/profile_icon_03.png" alt="Image 3">
								<div class="tick_container">
									<div class="tick">&checkmark;</div>
								</div>
							</label>
						</div>
						<div class='col text-center'>
						<input type="radio" name="icon" id="img4" class="d-none imgbgchk" value="profile_icon_04.png">
							<label for="img4">
								<img src="/Icons/profile-icons/profile_icon_04.png" alt="Image 4">
								<div class="tick_container">
									<div class="tick">&checkmark;</div>
								</div>
							</label>
						</div>
						<div class='col text-center'>
						<input type="radio" name="icon" id="img5" class="d-none imgbgchk" value="profile_icon_05.png">
							<label for="img5">
								<img src="/Icons/profile-icons/profile_icon_05.png" alt="Image 5">
								<div class="tick_container">
									<div class="tick">&checkmark;</div>
								</div>
							</label>
						</div>
						<div class='col text-center'>
						<input type="radio" name="icon" id="img6" class="d-none imgbgchk" value="profile_icon_06.png">
							<label for="img6">
								<img src="/Icons/profile-icons/profile_icon_06.png" alt="Image 6">
								<div class="tick_container">
									<div class="tick">&checkmark;</div>
								</div>
							</label>
						</div>
					</div>
				</div>

				<input type="submit" value="Submit" name="registration_button">

			</form> -->

		
		
		</div>
		
		<?php
			require($_SERVER['DOCUMENT_ROOT'] . "/php/footer.php");
		?>

	</div>

</body>
</html>