<?php
	require "includes/dbh.inc.php";
	
	if($_GET['task_id'] != ""){
		$task_id = $_GET['task_id'];
		$status = $_GET['status'];
		echo $status;
		
			$conn->query("UPDATE `tasks` SET `status` = 'Undone' WHERE `idTask` = $task_id ") or die;
			header("location: index.php");
		
		
		
	}
?>