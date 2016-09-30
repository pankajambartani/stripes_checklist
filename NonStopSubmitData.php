<!doctype html>
<html lang="en-US">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Non Stop Products</title>
	<link rel="stylesheet" type="text/css" media="all" href="css/NonStoppageCSS.css">
	<link rel="stylesheet" href="css/jquery-ui.css">
	<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/portal.js"></script>
</head>
<body>
	<div id="topbar"><h2>Non Stops Products</h2><a id="back" href="index.php">Back</a><a id="logout" href="logout.php">Log Out</a></div>
	<div id="w">
		<div id="content">
			<h1 style="font-size: 150%;"><?php echo $_POST['product_name'];?></h1>
			<?php
			require('connection.php');
			
			$product_name = mysqli_real_escape_string($conn, $_POST['product_name']); 
			$bug_id = mysqli_real_escape_string($conn, $_POST['bug_id']);
			$assigned_to = mysqli_real_escape_string($conn, $_POST['assigned_to']);
			$short_desc = mysqli_real_escape_string($conn, $_POST['short_desc']);
			$Remark = htmlspecialchars($_POST['Remark']);
			
			if ($_POST['SubmitBtn'] == "Save As Draft") {
				$sql1= "";
				$sql2= "";
				$sql = "INSERT INTO  checklist.nonstoptemp(`bug_id`,`assigned_to`,`short_desc`,`product_name`,`Remark`,";
					foreach ($_POST['questions'] as $id) {
						$sql2 .= "`$id`,";
					}
					$sql2 = substr($sql2 ,0,-1);
					$sql .= $sql2. ") VALUES ('$bug_id','$assigned_to','$short_desc','$product_name',$Remark',";

					foreach ($_POST['answers'] as $answer) {
						$sql1 .= "'$answer',";
					}
					$sql1 = substr($sql1 ,0,-1);
					$sql .= $sql1. ")";
					$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
					if($result){
						echo "<center>Record Added Successfully in Temporary Table.</center>";
					} 
					else{
						echo "<center>ERROR: Could not able to execute sql.</center> " . mysqli_error($conn);
					}
				}
				elseif ($_POST['SubmitBtn'] == "Submit") {
					$sql1= "";
					$sql2= "";
					$sql = "INSERT INTO  checklist.nonstopanswer(`bug_id`,`assigned_to`,`short_desc`,`product_name`,`Remark`,";
						foreach ($_POST['questions'] as $id) {
							$sql2 .= "`$id`,";
							}
							$sql2 = substr($sql2 ,0,-1);
							$sql .= $sql2. ") VALUES ('$bug_id','$assigned_to','$short_desc','$product_name','$Remark',";
							foreach ($_POST['answers'] as $answer) {
								$sql1 .= "'$answer',";
								}
							$sql1 = substr($sql1 ,0,-1);
							$sql .= $sql1. ")";

					$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
					if($result){
						echo "<center>Record Added successfully in Permanent table.</center>";
					}
					else{
						echo "<center>ERROR: Could not able to execute sql.</center> " . mysqli_error($conn);
					}
					$sql_delete = "DELETE FROM checklist.nonstoptemp WHERE bug_id=".$bug_id;
					$sql_delete_result = mysqli_query($conn, $sql_delete) or die($conn);
					if ($sql_delete_result) {
						echo "<center>Record Deleted successfully from Temporary table.</center>";
					}
					else{
						echo "<center>ERROR: Could not able to execute sql.</center> " . mysqli_error($conn);
					}
					echo "<div style= 'line-height: 300%; font-weight:bold;'><center><a href = 'http://gen88.in.rdlabs.hpecorp.net/stripes_checklist/NonStopDisplay.php?bugId=".urlencode($bug_id)."&product_name=".urlencode($product_name)."' target='_blank'>http://gen88.in.rdlabs.hpecorp.net/stripes_checklist/NonStopDisplay.php?bugId=".$bug_id."&product_name=".$product_name."</a></center></div>";
					}
				?>
		</div>
</body>
</html>
