<?php
	require "includes/dbh.inc.php";
	session_start();
	if(ISSET($_POST['edit'])){
		if($_POST['task'] != ""){
			$task = $_POST['task'];
			$deadline = $_POST['deadline'];
			$task_id = $_POST['bookId'];

			$conn->query("UPDATE `tasks` SET `name` = $task WHERE `idTask` =$task_id") or die;
			$conn->query("UPDATE `tasks` SET `deadline` = $deadline WHERE `idTask` =$task_id")or die;
			echo $task;
			echo $deadline;
			echo $task_id;
			#header('location:index.php');
		}
	}
?>