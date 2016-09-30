<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Stripes_Checklist Modification</title>
	<link rel="stylesheet" type="text/css" media="all" href="css/ModificationpageCSS.css">
	<link rel="stylesheet" href="css/jquery-ui.css">
	<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/portal.js"></script>
</head>
<body>
	<div id="topbar"><h2>Stripes Checklist Modification</h2><a id="back" href="index.php">Home</a></div>
	<div id="w">
		<div id="content">
			<?php 
			require('connection.php');
			$NewOperation = mysqli_real_escape_string($conn, $_POST['NewOperation']);

			if ($NewOperation == "New Product") {

				$projectNewproduct = mysqli_real_escape_string($conn, $_POST['projectNewproduct']);
				$NewProductName = mysqli_real_escape_string($conn, $_POST['NewProductName']);
				$NoQuestions = mysqli_real_escape_string($conn, $_POST['NoQuestions']);

				$mysql_insert_project = "INSERT INTO `".$projectNewproduct."`(`product_name`) VALUES ('".$NewProductName."')";
				$mysql_insert_project_result = mysqli_query($conn, $mysql_insert_project) or die(mysqli_error($conn));

				foreach ($_POST['question'] as $Qvalue) {
					$mysql_insert_question = "INSERT INTO `".$projectNewproduct."question`(`question`,`product_name`) VALUES ('".$Qvalue."','".$NewProductName."')";
					$mysql_insert_question_result = mysqli_query($conn, $mysql_insert_question) or die(mysqli_error($conn));
				}
				if ($mysql_insert_question_result) {
					echo "<center>New Product ".$NewProductName." has been added to ".$projectNewproduct."</center>";
				}else{
					echo "<center>ERROR: Could not able to execute sql.</center> " .mysqli_error($conn);
				}

				#Altering the answer table for NEW Product
				$mysql_updateAnswerTabel = "SELECT question_id FROM `".$projectNewproduct."question` WHERE product_name='$NewProductName'";
				// echo $mysql_updateAnswerTabel;
				$mysql_updateAnswerTabelResult = mysqli_query($conn, $mysql_updateAnswerTabel) or die(mysqli_error($conn));
 				
 				$updateTabel = array();
 				$index = 0;
 				while($arr = mysqli_fetch_assoc($mysql_updateAnswerTabelResult)){
 					//echo $arr;
 					$updateTabel[$index] = $arr;
 					$index++;
 				}
 				$i=0;
 				foreach ($updateTabel as $id) {
 					$id = $updateTabel[$i]['question_id'];
 					
 					$mysql_insertTemp = "ALTER TABLE `".$projectNewproduct."temp` Add `".$id."` varchar(5) NOT NULL";
 					$mysql_insertTempResult = mysqli_query($conn, $mysql_insertTemp) or die(mysqli_error($conn));

 					$mysql_insertPermanent = "ALTER TABLE `".$projectNewproduct."answer` Add `".$id."` varchar(5) NOT NULL";
 					$mysql_insertTempResult = mysqli_query($conn, $mysql_insertPermanent) or die(mysqli_error($conn));
 					$i++;
 				}
			}elseif ($NewOperation == "Modification in Product") {

				$project = mysqli_real_escape_string($conn, $_POST['project']);
				$product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
				$operation = mysqli_real_escape_string($conn, $_POST['operation']);

				if ($operation == 'insert') {
					foreach ($_POST['question'] as $Qvalue) {
						$mysql_insert_question = "INSERT INTO `".$project."question`(`question`,`product_name`) VALUES ('".$Qvalue."','".$product_name."')";
						// echo $mysql_insert_question;
						$mysql_insert_question_result = mysqli_query($conn, $mysql_insert_question) or die(mysqli_error($conn));
					}
					if ($mysql_insert_question_result) {
						echo "<center>Product ".$product_name." has been modified in ".$project." with new questions.</center>";
					}else{
						echo "<center>ERROR: Could not able to execute sql.</center> " .mysqli_error($conn);
					}
					
					#Altering the answer table for Insert new question in Existing product
					$mysql_updateAnswerTabel = "SELECT question_id FROM `".$project."question` WHERE product_name='$product_name'";
					$mysql_updateAnswerTabelResult = mysqli_query($conn, $mysql_updateAnswerTabel) or die(mysqli_error($conn));

					$update_Table = array();
					$index= 0;
					while ($arr = mysqli_fetch_assoc($mysql_updateAnswerTabelResult)) {
						$update_Table[$index] = $arr;
						$index++;
					}
					$mysqlColumnCheck = "SHOW COLUMNS FROM ".$project."temp";
					$columnsCheck_Result = mysqli_query($conn,$mysqlColumnCheck);
					
					$i =0;
					foreach ($update_Table as $id) {
						$id = $update_Table[$i]['question_id'];
						$exists = false;
						while ($c = mysqli_fetch_assoc($columnsCheck_Result)) {		
							if ($c['Field'] == $id) {
								$exists = true;
								break;
								} 
						}
						if (!$exists) {
							$mysql_insertTemp = "ALTER TABLE `".$project."temp` Add `".$id."` varchar(5) NOT NULL";
							$mysql_insertTempResult = mysqli_query($conn, $mysql_insertTemp) or die(mysqli_error($conn));

							$mysql_insertPermanent = "ALTER TABLE `".$project."answer` Add `".$id."` varchar(5) NOT NULL";
							$mysql_insertTempResult = mysqli_query($conn, $mysql_insertPermanent) or die(mysqli_error($conn));
							}
							$i++;
						}											

				}
				elseif ($operation == 'update') {
					$arrQueId = array();
					foreach ($_POST['question_id'] as $id) {
						$arrQueId[] =  $id;
					}
					$max = count($arrQueId);

					$arrQue = array();
					foreach ($_POST['question'] as $question) {
						$arrQue[] = $question;
					}
					for ($i=0; $i < $max ; $i++) { 
						$mysql_modify_question = "UPDATE checklist.".$project."question SET `question`='".$arrQue[$i]."' WHERE question_id=".$arrQueId[$i];
						$mysql_modify_question_result = mysqli_query($conn, $mysql_modify_question) or die(mysqli_error($conn));
					}
					if ($mysql_modify_question_result) {
						echo "<center>Product ".$product_name." has been modified in ".$project.".</center>";
					}else{
						echo "<center>ERROR: Could not able to execute sql.</center>" .mysqli_error($conn);
					}					
				}				
			}
			?>
		</div>
	</div>
</body>
</html>
