<?php
require "includes/dbh.inc.php";
if (isset($_GET['task_id'])) {
	if ($_GET['task_id'] != "") {
		$task_id = $_GET['task_id'];
		$status = $_GET['status'];
		echo $status;

		$conn->query("UPDATE `tasks` SET `status` = 'Undone' WHERE `idTask` = $task_id ") or die;
		header("location: index.php");
	}
} else if (isset($_GET['project_id'])) {
	echo "da";
	if ($_GET['project_id'] != "") {
		$project_id = $_GET['project_id'];


		$conn->query("UPDATE `projects` SET `status` = 'Undone' WHERE `idProiect` = $project_id ") or die;
		header("location: proiecte.php");
	}
}
