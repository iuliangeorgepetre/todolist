<?php
	require "includes/dbh.inc.php";
	
	if($_GET['task_id'] != ""){
		$task_id = $_GET['task_id'];
		
		$conn->query("UPDATE `tasks` SET `status` = 'Done' WHERE `idTask` = $task_id") or die;
		header('location: index.php');
	}
?>