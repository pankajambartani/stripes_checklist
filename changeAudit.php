<?php
require('connection.php');
$name = mysqli_real_escape_string($conn, $_POST['name']);
$project = mysqli_real_escape_string($conn, $_POST['project']);

// Bug_ids from bugzilla databases
$mysqlquery= "SELECT bug_id from bugs where assigned_to = (SELECT userid FROM profiles where login_name='".$name."')";

$mysqlquery_result = mysqli_query($conn1, $mysqlquery) or die(mysqli_error($conn1));
while ($row = mysqli_fetch_assoc($mysqlquery_result)) {
		echo "<tr><td>".$row['bug_id']."</td></tr>";
		}
?>
<!-- <a href='http://localhost:81/stripes_checklist/NonStopDisplay.php?bugId=".$row['bug_id']."&product_name=".$row['product_name']."' target='_blank'> </a> -->