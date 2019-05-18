<?php
	require "includes/dbh.inc.php";
	session_start();
	if(ISSET($_POST['add'])){
		if($_POST['project'] != ""){
			$project = $_POST['project'];
			$deadline = $_POST['deadline'];
			$adminId = $_SESSION['id'];
			
			
			$conn->query("INSERT INTO `projects` VALUES('', '$project', '$deadline','Undone','$adminId')");
			$query = $conn->query("SELECT * FROM `projects` ORDER BY idProiect DESC LIMIT 1");
			$fetch = $query->fetch_array();
			$idProject= $fetch['idProiect'];
			$conn->query("INSERT INTO `project_user_leg` VALUES('', '$adminId', '$idProject')");
			header('location:proiecte.php');
		}
	}
?>