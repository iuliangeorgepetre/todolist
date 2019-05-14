<?php
	require "includes/dbh.inc.php";
	
	if($_GET['task_id']){
		$task_id = $_GET['task_id'];
		
		$conn->query("DELETE FROM `tasks` WHERE `idTask` = $task_id") or die;
		$conn->query("DELETE FROM `user_task_leg` WHERE `idTask` = $task_id") or die;
		header("location: index.php");
	}	
?>