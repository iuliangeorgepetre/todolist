<?php
require "includes/dbh.inc.php";

if ($_GET['id'] != "") {
	$id = $_GET['id'];
    
	$conn->query("DELETE FROM tasks WHERE idTask='" . $id . "'") or die;

	header("location: ../todolist-master/trash.php");
}
?>
