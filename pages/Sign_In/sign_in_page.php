<!DOCTYPE html>

<html>
<head>

	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title>Sign in - VGCDB</title>
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

		<div class="card soft-shadow">

			<div class="title">
				<div>Login to your account</div>
				<div class="line"></div>
			</div>

			<form action="index.php" method="POST" onsubmit="return SubmitLoginForm(this)">
				<div>
					<h3>Username</h3>
					<input id="username-input" type="text" class="text-input soft-shadow" name="username" placeholder="Your Username" required autocomplete="off">
				</div>
				<div>
					<h3>Password</h3>
					<?php
						if (!empty($_GET['pw'])) {
							echo '<div class="incorrect-password">
								<div class="soft-shadow">
									Incorrect password
								</div>
							</div>';
						}
					?>
					<input type="password" class="text-input soft-shadow" name="password" placeholder="Password" required autocomplete="off">
				</div>
				

				<div class="submit-button soft-shadow">
					<button type="submit" id="submit_button" name='login_button' value="Submit form">login</button>
				</div>
				
			</form>

			<div>
				<a href="javascript:transitionTo('/pages/Sign_Up/sign_up_page.php')">Don't have an account?<br/><b>Click here to sign up</b></a>
			</div>

		</div>
		
		<?php
			require($_SERVER['DOCUMENT_ROOT'] . "/php/footer.php");
		?>

	</div>

</body>
</html>