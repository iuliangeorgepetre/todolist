<?php

require "includes/dbh.inc.php";
if(isset($_GET['task_id'])){
	if ($_GET['task_id'] != "") {
		$task_id = $_GET['task_id'];

		$conn->query("UPDATE `tasks` SET `status` = 'inTrash' WHERE `idTask` = $task_id") or die;
		
		header("location: ../todolist-master/index.php");
	}
}else if(isset($_GET['project_id'])){
	if ($_GET['project_id'] != "") {
		$project_id = $_GET['project_id'];

		$conn->query("UPDATE `projects` SET `status` = 'inTrash' WHERE `idProiect` = $project_id") or die;

		#stergem si task-urile afiliate proiectului 

		$interogare = $conn->query("SELECT * FROM `project_task_leg` WHERE idProject = $project_id ");
        
        while ($iadate = $interogare->fetch_array()) {
        $idTask = $iadate['idTask'];
			$query = $conn->query("SELECT * FROM `tasks` WHERE idTask = $idTask ");
			while ($fetch = $query->fetch_array()) {
				$conn->query("UPDATE `tasks` SET `status` = 'inTrash' WHERE `idTask` = $idTask") or die;
			}
		}
		header("location: proiecte.php");
	}
}
?>


