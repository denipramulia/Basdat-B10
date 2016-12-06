<?php
	$conn_string = "host=dbpg.cs.ui.ac.id port=5432 dbname=sisidang user=postgres password=";
	$conn = pg_connect($conn_string);
	
	// Check connection
	if (!$conn) {
		die("Connection failed: " . pg_last_error());
	}

	$sql = "SET search_path TO sisidang";
	$result = pg_query($conn, $sql);
	if (!$result) {
		die("Error in SQL query: " . pg_last_error());
	}   
	
	$conn;
?>