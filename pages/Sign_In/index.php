<!DOCTYPE html>
<html>

	<?php
		include($_SERVER['DOCUMENT_ROOT'] . "/php/database_error.php");

	?>

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Signing In...</title>
	</head>
	<body>
		<?php

			session_start();
			
			$dbconn = pg_connect("host = localhost port =5432 dbname = postgres 
			user = postgres password = vgcdb") 
			or database_error('Could not connect : ' . pg_last_error());

			// ================================== Si è arrivati in questa pagina digitando l'url sulla barra di ricerca ======================================================
			if( !(isset($_POST['password'])) ) {
				header("Location: /pages/Sign_In/sign_in_page.php");
			} else {

				$username = $_POST['username'];
				$q1 = "SELECT * FROM users WHERE username=$1";
				$result = pg_query_params($dbconn, $q1, array($username)) or database_error('Query failed : '.pg_last_error());

				if($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
					
					$password = md5($_POST['password']);
					$q2 = "SELECT * FROM users WHERE username=$1 AND password=$2";
					$result1 = pg_query_params($dbconn, $q2, array($username, $password)) or database_error('Query failed : '.pg_last_error());
					if($line = pg_fetch_array($result1, null, PGSQL_ASSOC)) {
						// ================================== SUCCESFULLY LOGGED IN ========================================================================================
						$_SESSION['username'] = $username;
						echo "<script>
						    sessionStorage.setItem('username', '');
						</script>";
						$uri = $_SESSION['last_page_visited'];
						echo "<script>
							window.location = '$uri';
						</script>";
					} else {
						// =========================== INCORRECT PASSWORD (MA USERNAME ESISTE) ==============================================================================

						echo "<script>
							// setTimeout(function() {
							// 	window.location = '/pages/Sign_In/sign_in_page.php';
							// }, 5000); 
							window.location.href = '/pages/Sign_In/sign_in_page.php?pw=incorrect';
						</script>";
					}
					// echo "<h1>Sorry, the username already exists<h1>
					// <a href='../Sign_Up/index.html'> Click here to login </a>";
		
					pg_free_result($result1);

				} else {
					// =============================== USERNAME NON ESISTE ==================================================================================

					// Redirect alla "Message Page"
					$img = "disappointed-face-icon";				
					$header = "The username \"" . $username . "\" does not exist";		
					$message = '<span>Maybe you typed your username incorrectly</span><span>You can <b>Sign up</b> if you are not registered</span>';	
					$url = "/pages/Sign_In/sign_in_page.php";		
					$buttontext = "Try again";						
					$url2 = "/pages/Sign_Up/sign_up_page.php";		
					$buttontext2 = "Sign Up";						
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

				}
				pg_free_result($result);
			}
			pg_close($dbconn);

		?>
	</body>
</html>