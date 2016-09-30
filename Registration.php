<?php
require('connection.php');
// define variables and set to empty values
$Newname = mysqli_real_escape_string($conn,$_POST["Newname"]);
$Newusername = mysqli_real_escape_string($conn,$_POST["Newusername"]);
$Newpassword = mysqli_real_escape_string($conn,$_POST["Newpassword"]);

if (empty($Newname)) {
	echo "Name is required";
} 
elseif (empty($Newusername)) {
	echo "Email is required";
} 
elseif (empty($Newpassword)){
	echo "Paasword is required"; 
}
else{
	$sql_insert = "insert into user (Name, username, password) values ('$Newname', '$Newusername', '$Newpassword')";
	$sql_result = mysqli_query($conn, $sql_insert) or die(mysqli_error($conn));
	if ($sql_result) {
		echo "1";
	}
}
?>