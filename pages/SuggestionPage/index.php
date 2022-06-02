<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Uploading Character...</title>

</head>
<body>
	<?php

		include($_SERVER['DOCUMENT_ROOT'] . "/php/database_error.php");

		session_start();
	
		$username = "";

		if ( isset($_SESSION['username']) && $_SESSION['username'] != "") {

			$username = $_SESSION['username'];

			$dbconn = pg_connect("host = localhost port =5432 dbname = postgres 
			user = postgres password = vgcdb") 
			or database_error('Could not connect : ' . pg_last_error());
	
			// Redirect to correct page if user writes this url in the browser tab
			if(!(isset($_POST['universe_name']))) {
				header("Location: /pages/SuggestionPage/suggestion_page.php");
			} else {
				$character_name = "";
				$universe = "";
				$year = 0;
				$eye_color = "";
				$hair_color = "";
				$role = "";
				$gender = "";
				$notes = "";
	
				if(!empty($_POST['character_name'])) {
					$character_name = $_POST['character_name'];
				}
				if(!empty($_POST['universe_name'])) {
					$universe = $_POST['universe_name'];
				}
				if(!empty($_POST['year'])) {
					$year = intval($_POST['year']);
				}
				if(!empty($_POST['role'])) {
					$role = $_POST['role'];
				}
				if(!empty($_POST['gender'])) {
					$gender = $_POST['gender'];
				}
				if(!empty($_POST['eye_color'])) {
					$eye_color = $_POST['eye_color'];
				}
				if(!empty($_POST['hair_color'])) {
					$hair_color = $_POST['hair_color'];
				}
				if(!empty($_POST['notes'])) {
					$notes = $_POST['notes'];
				}
	
				$q1 = "INSERT INTO suggestions VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9)";
				$data = pg_query_params($dbconn, $q1, array($username, $character_name, $universe, $year, $eye_color, $hair_color, $role, $gender, $notes)) or database_error('Query failed : '.pg_last_error());
				if ($data) {

					// Go to message page
					$img = "happy-face-icon";				// Defaults to "question-mark-icon"
					$header = "Character suggested succesfully!";		// Defaults to "Something went wrong..."
					$message = "<span>You suggested $character_name from $universe</span><span>We will try to add the character to the database as soon as possible</span>";	// Defaults to "An error occured"
					$url = "/pages/SuggestionPage/suggestion_page.php";		// Defaults to previously visited page url
					$buttontext = "Suggest another character";		// Defaults to "Back"
					$url2 = "/pages/HomePage/home_page.php";		// If not set, the button with this url will not appear
					$buttontext2 = "Back to HomePage";						// If not set, the button with this text will not appear
					$redirect_url = "/pages/MessagePage/message_page.php?" . 
						"icon=" . $img . "&" .
						"header=" . $header . "&" .
						"message=" . $message . "&" .
						"url=" . $url . "&" .
						"buttontext=" . $buttontext . "&" .
						"url2=" . $url2 . "&" .
						"buttontext2=" . $buttontext2;
					echo "<script>
						window.location.href = '$redirect_url';
					</script>";

					// echo "<h1>Character succesfully suggested! <br>You will be redirected in a moment...<h1>";
					// echo "<script>
					// 	setTimeout(function() {
					// 		window.location = '/pages/AdvancedSearch/advanced_search_page.php';
					// 	}, 5000); 
					// </script>";

				}
				pg_free_result($data);
	
			}
	
			pg_close($dbconn);

		} else {

			echo"Something went wrong...";
			echo "<script>
				setTimeout(function() {
					window.location = '/pages/SuggestionPage/suggestion_page.php';
				}, 1000); 
			</script>";

		}


	?>
</body>
</html>