<?php
$dBServername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "loginsystemtut";

// Creeaza conexiunea
$conn = mysqli_connect($dBServername, $dBUsername, $dBPassword, $dBName);

// Verifica conexiunea
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
