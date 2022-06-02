<!DOCTYPE html>

<html>
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
	<link rel="stylesheet" href="/css/page-transition.css" type="text/css">
	<link rel="stylesheet" href="style.css" type="text/css">
	
	<script type="text/javascript" src='/libraries/jquery/jquery-3.6.0.min.js'></script>
	<script type="text/javascript" src='/js/page-transition.js'></script>
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

	<div id="body-wrapper" class="bg-white bg-pattern">

		<div id="page-transition-in"></div>

		<div class="card soft-shadow">
			<div class="message-icon soft-shadow">
				<?php
					if (!empty($_GET['icon'])) {
						$icon = "/icons/MessageIcons/" . $_GET['icon'] . ".png";
					} else {
						$icon = "/icons/MessageIcons/question-mark-icon.png";
					}
				echo"<img class='icon-dark-mode-responsive' src='$icon'>";
				?>
			</div>
			<div class="header">
				<?php
					if (!empty($_GET['header'])) {
						$header = $_GET['header'];
					} else {
						$header = "Something went wrong...";
					}
					echo"$header";
				?>
			</div>
			<div class="message">
				<?php
					if (!empty($_GET['message'])) {
						$message = $_GET['message'];
					} else {
						$message = "An error occured";
					}
					echo"$message";
				?>
			</div>
			<div class="submit-button soft-shadow">
				<?php
					if (!empty($_GET['url'])) {
						$url = $_GET['url'];
						if (!empty($_GET['buttontext'])) {
							$button_text = $_GET['buttontext'];
						} else {
							$button_text = "Click here to be redirected";
						}
						echo "<button onclick=\"transitionTo('$url');\">$button_text</button>";
					} else {
						$current_page_url = $_SERVER['REQUEST_URI'];
						$uri = $_SESSION['last_page_visited'];
						if ($uri != $current_page_url) {
							echo "<button onclick=\"transitionTo('$uri');\">Back to previous page</button>";
						} else {
							echo "<button onclick=\"transitionTo('/pages/HomePage/homepage.php');\">Back to homepage</button>";
						}
					}
					
				?>
			</div>
			<?php
				if (!empty($_GET['url2']) && !empty($_GET['buttontext2'])) {
					echo'<div class="submit-button-2 soft-shadow">';
					$url = $_GET['url2'];
					$button_text = $_GET['buttontext2'];
					echo "<button onclick=\"transitionTo('$url')\";>$button_text</button>";
					echo'</div>';
				} 
			?>
		</div>

		<?php
			require($_SERVER['DOCUMENT_ROOT'] . "/php/footer.php");
		?>

    </div>

</body>
</html>