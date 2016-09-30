<?php
require('connection.php');
// Start Session
session_start();

$username= mysqli_real_escape_string($conn,$_POST["username"]);
$password= mysqli_real_escape_string($conn,$_POST["password"]);

if ($username !="" && $password !="")
{
  $sql_login= "select * from user where username='$username' and password='$password'";
  $login_result = mysqli_query($conn, $sql_login) or die(mysqli_error($conn));
  $row= mysqli_num_rows($login_result);
  if($row)
  {
    $_SESSION['username']= $username;       // Initializing Session with value username Variable
    echo "1";
  }
  else
  {
    echo "Invalid Username or Password";
  }
}
else
{
  echo "Invalid Username or Password";
}
?>
