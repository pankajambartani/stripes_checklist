<?php
$db_servername = "localhost";
$db_username = "root";
$db_password = "Stripes*team";
$db_database1 = "checklist";
$db_database2 = "bugzilla";

// Create connection with checklist
$conn = mysqli_connect($db_servername, $db_username, $db_password, $db_database1);
// Create connection with bugzilla
$conn1 = mysqli_connect($db_servername, $db_username, $db_password, $db_database2);
// Check connection
if (!$conn) {
	die("Connection failed with checklist database: " . mysqli_connect_error());
}
//Echo connected Successfully
if (!$conn1) {
	die("Connection failed with bugzilla database: " . mysqli_connect_error());
}
//Echo connected Successfully
?>