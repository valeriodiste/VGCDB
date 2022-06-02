<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signing Out...</title>
	<?php

		session_start();

		$_SESSION['username'] = "";

		$uri = $_SESSION['last_page_visited'];
		echo '<script>

			if (typeof(Storage) !== "undefined") {
				sessionStorage.setItem("username", "");
			}';

			if (strtolower($uri) != strtolower("/pages/ProfilePage/profile_page.php") ) {
				echo'window.location = \'' . $uri . '\';';
			} else {
				echo'window.location = "/pages/HomePage/home_page.php";';
			}
		echo'</script>';

	?>
</head>
<body>
	
</body>
</html>