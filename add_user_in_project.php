<?php
	require "includes/dbh.inc.php";
	session_start();
	if(ISSET($_POST['add'])){
		if($_POST['username'] != ""){
			$user = $_POST['username'];
            $idProject = $_POST['projectId'];
            echo $user . '<br>' . $idProject;
			$query = $conn->query("SELECT * FROM `users` WHERE `uidUsers` = '$user'");
			$fetch = $query->fetch_array();
            $idUser= $fetch['idUsers'];
            echo $idUser;
			$conn->query("INSERT INTO `project_user_leg` VALUES('', '$idUser', '$idProject')");
			
            
			header('location:index.php?project_id=' . $_GET['project_id']);
		}
	}
?>