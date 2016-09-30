<!doctype html>
<html lang="en-US">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Storage Products</title>
	<link rel="stylesheet" type="text/css" media="all" href="css/NonStoppageCSS.css">
	<link rel="stylesheet" href="css/jquery-ui.css">
	<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/portal.js"></script>
</head>
<body>
	<div id="topbar"><h2>Storage Products</h2><a id="back" href="index.php">Back</a><a id="logout" href="logout.php">Log Out</a></div>
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

			$arrAns = array();
			foreach ($_POST['answers'] as $answer) {
				$arrAns[] =  $answer;
			}
			$max = count($arrAns);
			$arrQue = array();
			foreach ($_POST['questions'] as $qid) {
				$arrQue[] = $qid;
			}
			
			if ($_POST['SubmitBtn'] == "Update") {

				$sql="";
				$sql1="";
				$sql = "UPDATE checklist.storagetemp SET bug_id ='$bug_id',assigned_to ='$assigned_to', short_desc='$short_desc', product_name='$product_name', Remark = '$Remark',";
				for ($i=0; $i < $max ; $i++) { 

					$sql1 .= " `$arrQue[$i]`='$arrAns[$i]',";
				}
				$sql1 = substr($sql1 ,0,-1);
				$sql .= $sql1. " where bug_id ='$bug_id'";
				// echo $sql;
				$result_update = mysqli_query($conn, $sql) or die(mysqli_error($conn));

				if($result_update){
					echo "<center>Records Updated Successfully.</center>";
				} 
				else{
					echo "<center>ERROR: Could not able to execute $sql.</center> " . mysqli_error($conn);
				}
			} 
			elseif ($_POST['SubmitBtn'] == "Submit") {

				$sql1= "";
				$sql2= "";
				$sql = "INSERT INTO  checklist.storageanswer(`bug_id`,`assigned_to`,`short_desc`,`Remark`,";
					foreach ($_POST['questions'] as $id) {
						$sql2 .= "`$id`,";
					}
					$sql2 = substr($sql2 ,0,-1);
					$sql .= $sql2. ") VALUES ('$bug_id','$assigned_to','$short_desc','$Remark',";

					foreach ($_POST['answers'] as $answer) {
						$sql1 .= "'$answer',";
					}
					$sql1 = substr($sql1 ,0,-1);
					$sql .= $sql1. ")";
					$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
					if($result){
						echo "<center>Record Added Successfully in Permanent Table.</center>";
					}
					else{
						echo "<center>ERROR: Could not able to execute $sql.</center> " . mysqli_error($conn);
					}

				$sql_delete = "DELETE FROM checklist.storagetemp WHERE bug_id=".$bug_id;
				$sql_delete_result = mysqli_query($conn,$sql_delete) or die(mysqli_error($conn));

				if ($sql_delete_result) {
					echo "<center> Record Deleted from Temporary Table </center> ";
				}
				else{
					echo "<center> ERROR : Could not able to execute delete.</center>". mysqli_error($conn);
				}
				echo "<div style= 'line-height: 300%; font-weight:bold;'><center><a href = 'http://gen88.in.rdlabs.hpecorp.net/stripes_checklist/StorageDisplay.php?bugId=".urlencode($bug_id)."&product_name=".urlencode($product_name)."' target='_blank'>http://gen88.in.rdlabs.hpecorp.net/stripes_checklist/StorageDisplay.php?bugId=".$bug_id."&product_name=".$product_name."</a></center></div>";
				
				}
			?>
</div>
</body>
</html>