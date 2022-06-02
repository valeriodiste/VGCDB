
<?php 
	session_start();

	include($_SERVER['DOCUMENT_ROOT'] . "/php/database_error.php");
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Signing up...</title>
	<link rel="icon" href="/icons/logo.png">
</head>
<body>
<?php
	
	$dbconn = pg_connect("host = localhost port =5432 dbname = postgres 
	user = postgres password = vgcdb") 
	or database_error('Could not connect : ' . pg_last_error());

    // Redirect alla pagina corretta se l'utente digita l'url nella barra di ricerca
    if(!(isset($_POST['password']))) {
        header("Location: /pages/Sign_Up/sign_up_page.php");
    } else {
        $username = $_POST['username'];
        $q1 = "SELECT * FROM users WHERE username=$1";
        $result = pg_query_params($dbconn, $q1, array($username)) or database_error('Query failed : '.pg_last_error());
        if($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {

			
			// Redirect alla "Message page"
			$img = "disappointed-face-icon";				
			$header = "The username \"" . $username . "\" already exists";		
			$message = '<span>Please try again with a different username</span><span>If you are trying to login, click the "login" button below</span>';	
			$url = "/pages/Sign_Up/sign_up_page.php";		
			$buttontext = "Try a different username";						
			$url2 = "/pages/Sign_In/sign_in_page.php";		
			$buttontext2 = "Login";						
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

        } else {
            $password = md5($_POST['password']);
            if (!empty($_POST['icon'])) {
                $icon = $_POST['icon'];
            }
            $q2 = "INSERT INTO users VALUES ($1, $2, $3)";
            $data = pg_query_params($dbconn, $q2, array($username, $password, $icon)) or database_error('Query failed : '.pg_last_error());
            if ($data) {

				// Go to message page
				$img = "happy-face-icon";				
				$header = "Registration completed!";		
				$message = '<span>Hi ' . $username . ', you succesfully registered!</span><span>Click the button below to login</span>';	
				$url = "/pages/Sign_In/sign_in_page.php";		
				$buttontext = "Login";						
				
				$redirect_url = "/pages/MessagePage/message_page.php?" . 
					"icon=" . $img . "&" .
					"header=" . $header . "&" .
					"message=" . $message . "&" .
					"url=" . $url . "&" .
					"buttontext=" . $buttontext;
					
				echo "<script>
					window.location.href = '$redirect_url';
				</script>";

            }

            pg_free_result($data);

        }

        pg_free_result($result);
    }

    pg_close($dbconn);

?>
</body>
</html>