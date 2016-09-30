<?php
require('connection.php');
$name = mysqli_real_escape_string($conn, $_POST['name']);
$project = mysqli_real_escape_string($conn, $_POST['project']);

if ($project == "nonstopanswer") {
	echo $project;
	// Bug_ids from Checklist database
	$mysqlquery = "SELECT bug_id, product_name FROM nonstopanswer where assigned_to ='".$name."'";
	$mysqlquery_result = mysqli_query($conn, $mysqlquery) or die(mysqli_error($conn));
}
elseif ($project == "storageanswer") {
	// Bug_ids from Checklist database
	$mysqlquery = "SELECT bug_id, product_name FROM storageanswer where assigned_to ='".$name."'";
	$mysqlquery_result = mysqli_query($conn, $mysqlquery) or die(mysqli_error($conn));	
}
while ($row = mysqli_fetch_assoc($mysqlquery_result)) {	
		echo "<tr><td>".$row['bug_id']."</td></tr>";
		}
?>
<!--  <a href='http://localhost:81/stripes_checklist/NonStopDisplay.php?bugId=".$row['bug_id']."&product_name=".$row['product_name']."' target='_blank'> </a>-->