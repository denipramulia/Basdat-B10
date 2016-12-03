<?php
function connectDB(){
	$conn_string = "host=localhost port=5432 dbname=postgres user=postgres password=chaoskaki";
	$conn = pg_connect($conn_string);
	
	// Check connection
	if (!$conn) {
		die("Connection failed: " . pg_last_error());
	}

	$sql = "SET search_path TO silutel";
	$result = pg_query($conn, $sql);
	if (!$result) {
		die("Error in SQL query: " . pg_last_error());
	}   
	
	return $conn;
}
?>
