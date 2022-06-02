
<?php
	// Funzione per gestire la mancata connessione al database
	function database_error($error_message = "Could not connect to database") {
		// Redirect alla "Message page"
		$img = "disappointed-face-icon";				
		$header = "An error occured...";		
		$message = "<span>$error_message</span>";	
		$url = "/pages/HomePage/home_page.php";		
		$buttontext = "Back to HomePage";						
		
		
		$redirect_url = "/pages/MessagePage/message_page.php?" . 
			"icon=" . $img . "&" .
			"header=" . $header . "&" .
			"message=" . $message . "&" .
			"url=" . $url . "&" .
			"buttontext=" . $buttontext;
			
		echo "<script>
			window.location.href = '$redirect_url';
		</script>";
		
		die(pg_last_error());
	}
?>