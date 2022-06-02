<?php

	$username = $_POST['username'];
	$name = $_POST['character'];
	$universe = $_POST['universe'];
	$add = $_POST['add'];

	include($_SERVER['DOCUMENT_ROOT'] . "/php/database_error.php");
	
    $dbconn = pg_connect("host = localhost port = 5432 dbname = postgres 
    	user = postgres password = vgcdb")
    or database_error('Could not connect : ' . pg_last_error());

	if ($add != "") {
		$data = pg_insert($dbconn, "favourites", array("username" => $username, "character" => $name, "universe" => $universe) );
	} else {
		$data = pg_delete($dbconn, "favourites", array("username" => $username, "character" => $name, "universe" => $universe) );
	}

	pg_free_result($data);
	pg_close($dbconn);
?>