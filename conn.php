<?php
	$conn = new mysqli("localhost", "root", "", "loginsystemtut");
 
	if(!$conn){
		die("Error: Cannot connect to the database");
	}
?>