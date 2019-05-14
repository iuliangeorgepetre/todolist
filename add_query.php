<?php
	require "includes/dbh.inc.php";
	session_start();
	if(ISSET($_POST['add'])){
		if($_POST['task'] != ""){
			$task = $_POST['task'];
			$deadline = $_POST['deadline'];
			$descriere = $_POST['descriere'];
			$userId = $_SESSION['id'];
			$conn->query("INSERT INTO `tasks` VALUES('', '$task', '$deadline', '$descriere','Undone')");
			$query = $conn->query("SELECT * FROM `tasks` ORDER BY idTask DESC LIMIT 1");
			$fetch = $query->fetch_array();
			$idTask= $fetch['idTask'];
			$conn->query("INSERT INTO `user_task_leg` VALUES('', '$userId', '$idTask')");
			header('location:index.php');
		}
	}
?>