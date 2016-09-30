 <?php
 require('connection.php');
 session_start();
 if (!isset($_SESSION['username']))
 {
 	header('Location:login.php');
 }
 ?>
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
 	<div id="topbar"><h2>Storage Products</h2><a id="back" href="index.php">Back</a><a id="logout" href="logout.php">Log Out</a></div>
 	<div id="w">
 		<div id="content">
 			<h1 style="font-size: 150%;"><?php echo $_GET['product_name'];?></h1>
 			<form method="GET" action="StoragePage.php">
 				Search by Bug ID: <input type="text" name="bugId">
 				<input type="hidden" name="product_name" value="<?php echo $_GET['product_name'];?>">

 				<div ><input type="submit" name="SearchBtn" class="flatbtn-blu" value="Search"></div>		
 			</form>
 			<?php
 			if (isset($_GET['bugId']))
 			{		
 				$product_name = $_GET['product_name'];
 				$bugId= $_GET['bugId'];
 				
 				$sql_FinalSubmitCheck = "SELECT bug_id FROM storageanswer where bug_id=".$bugId;     //Answers database for storing submitted data
 				$countfinal = mysqli_query($conn, $sql_FinalSubmitCheck) or die(mysqli_error($conn));

 				if (mysqli_num_rows($countfinal) > 0) {
 					echo "<script> alert('Bug_id is freezed') </script>";
 					return;
 				}

				$sql_idcheck = "SELECT bug_id FROM storagetemp where bug_id=".$bugId;     //Answers database for storing submitted data
				$count = mysqli_query($conn, $sql_idcheck) or die(mysqli_error($conn));

				if (mysqli_num_rows($count) > 0) 	//checking wheather data is present in temporary table if yes update it 
				{
					$sql_bugs= "SELECT bug_id, short_desc,assigned_to, Remark FROM storagetemp where bug_id=".$bugId;
					$bug_result = mysqli_query($conn, $sql_bugs) or die(mysqli_error($conn));
					$rowInitial = mysqli_fetch_assoc($bug_result);

					if ($product_name == 'DMMT') {
						$sql_questionId = "SELECT question_id FROM storagequestion WHERE product_name='$product_name'";
						$questionId_result = mysqli_query($conn, $sql_questionId) or die(mysqli_error($conn));
					}
					else{
						$sql_questionId = "SELECT question_id FROM storagequestion WHERE product_name='COMMON' OR product_name='".$product_name."'";
						$questionId_result = mysqli_query($conn, $sql_questionId) or die(mysqli_error($conn));

					}
					$arr_questionId = array();
					$index = 0;
					while($arr = mysqli_fetch_assoc($questionId_result)) {
						$arr_questionId[$index] = $arr;
						$index++;
					}
					// echo $arr_questionId[0][question_id];
					$i = 0;
					$sql_answer = "SELECT "; 
					$sql="";
					foreach ($arr_questionId as $id) {
						$id = $arr_questionId[$i]['question_id'];
						$sql .= "`$id`,";
						$i++;
					}
					$sql = substr($sql ,0,-1);
					$sql_answer .= $sql ." FROM storagetemp WHERE bug_id=".$bugId;
					// echo $sql_answer;
					$Result_sql_answer = mysqli_query($conn, $sql_answer) or die(mysqli_error($conn)); // Submitted answers
					
					if ($product_name == 'DMMT') {
						$sql_quetions = "SELECT question FROM storagequestion WHERE product_name='$product_name'";
						$Result_sql_questions = mysqli_query($conn, $sql_quetions) or die(mysqli_error($conn)); // question from question table	
					}
					else{
						$sql_quetions = "SELECT question FROM storagequestion WHERE product_name='COMMON' OR product_name='".$product_name."'";
						$Result_sql_questions = mysqli_query($conn, $sql_quetions) or die(mysqli_error($conn)); // question from question table
					}
					?>
					<form name="myFormSubmit" method="post" action="StorageUpdateData.php">
						<table>
							<thead>
								<tr>
									<th>Questions</th>
									<th>Answers</th>
								</tr>
							</thead>
							<tbody>
								<?php
								echo '<input type= hidden name="product_name" value="'.$product_name.'"">';

								echo '<tr>';
								echo '<td> Request_Id </td>';  //Its Bug_id only
								echo '<td><input readonly type="text" name="bug_id" value="'.$rowInitial['bug_id'].'"</td>';
								echo '</tr>';

								echo '<tr>';
								echo '<td> Short Descripation</td>';
								echo '<td><input readonly type="text" name="short_desc" value="'.$rowInitial['short_desc'].'"</td>';
								echo '</tr>';
								echo '<tr>';

								echo '<tr>';
								echo '<td> Assigned-To name</td>';
								echo '<td><input readonly type="text" name="assigned_to" value="'.$rowInitial['assigned_to'].'"</td>';
								echo '</tr>';

								$i=0;
								$j=0;
								$rowans = $Result_sql_answer->fetch_assoc();
								while($row = $Result_sql_questions->fetch_assoc()) {
									echo '<tr>';
									echo '<td>'.$row['question'].'</td>';
									echo '<input name="answers['.$i.']" type="hidden" value="NULL" />';
									if ($rowans[$arr_questionId[$i]['question_id']] == 'YES')
									{
										echo '<td><input type="radio" name="answers['.$j.']" value="YES" checked> YES <input type="radio" name="answers['.$j.']" value="NO"> NO <input type="radio" name="answers['.$j.']" value="N/A"> N/A</td>';
									}
									elseif ($rowans[$arr_questionId[$i]['question_id']] == 'NO')
									{
										echo '<td><input type="radio" name="answers['.$j.']" value="YES" > YES <input type="radio" name="answers['.$j.']" value="NO" checked> NO <input type="radio" name="answers['.$j.']" value="N/A"> N/A</td>';
									}
									elseif ($rowans[$arr_questionId[$i]['question_id']] == 'N/A') {
										echo '<td><input type="radio" name="answers['.$j.']" value="YES" > YES <input type="radio" name="answers['.$j.']" value="NO"> NO <input type="radio" name="answers['.$j.']" value="N/A" checked> N/A</td>';
									}
									else {
										echo '<td><input type="radio" name="answers['.$j.']" value="YES" > YES <input type="radio" name="answers['.$j.']" value="NO"> NO <input type="radio" name="answers['.$j.']" value="N/A"> N/A</td>';
									}
									echo '<input type= "hidden" name="questions['.$i.']" value="'.$arr_questionId[$i]['question_id'].'">';
										// echo '<td>' .$rowans[$arr_questionId[$i++]['question_id']].'</td>';
									echo '</tr>';
									$i++;
									$j++;
								}
								echo '<tr>';
								echo '<td> Remark</td>';
								echo '<td><textarea id= "Remark" name="Remark">'.$rowInitial['Remark'].'</textarea></td>';
								echo '</tr>';
								?>
							</tbody>
						</table>
						<div class="center">
							<input type="submit" name="SubmitBtn" class="flatbtn-blu" onclick="return confirm('Temporary Submit, this will be stored as DRAFT only!!!, this will allow you to come back and edit later, you will need to click on SUBMIT to commit your final changes')" value="Update">
                                                                <input type="submit" name="SubmitBtn" class="flatbtn-blu" onclick="return confirm('Are you sure you want to do a FINAL Submit, you cannot revert back after this changes')" value="Submit">
						</div>
					</form>
					<?php }

					else // New Submit
					{	 
						$sql_bugs= "SELECT bug_id, short_desc FROM bugs where bug_id=".$bugId;
						$bug_result = mysqli_query($conn1, $sql_bugs) or die(mysqli_error($conn1));
						$bugs_row = mysqli_fetch_assoc($bug_result);
						
						if (mysqli_num_rows($bug_result) <= 0) {
							echo "<script> alert('Bug Id is Not Present');</script>";
							return;
						}

						$sql_profile= "SELECT login_name from profiles where userid=(SELECT assigned_to FROM bugs where bug_id=".$bugId.")";
						$profile_result = mysqli_query($conn1, $sql_profile) or die(mysqli_error($conn1));
						$profile_row =  mysqli_fetch_assoc($profile_result);

						if ($product_name == "DMMT") {
							$sql_question = "SELECT * FROM storagequestion where product_name='".$product_name."'";
							$result_question = mysqli_query($conn, $sql_question) or die(mysqli_error($conn));
						}
						else{
							$sql_question = "SELECT * FROM storagequestion where product_name='COMMON' OR product_name='".$product_name."'";
							$result_question = mysqli_query($conn, $sql_question) or die(mysqli_error($conn));
						}
						
						?>
						<form name="myFormDraftSubmit" method="post" action="StorageSubmitData.php">
							<table>
								<thead>
									<tr>
										<th>Questions</th>
										<th>Answers</th>
									</tr>
								</thead>
								<tbody>
									<?php
									echo '<input type= hidden name="product_name" value="'.$product_name.'"">';

									echo '<tr>';
									echo '<td> Request_Id</td>';
									echo '<td><input readonly type="text" name="bug_id" value="'.$bugs_row['bug_id'].'" </td>';
									echo '</tr>';

									echo '<tr>';
									echo '<td> Short Descripation</td>';
									echo '<td><input readonly type="text" name="short_desc" value="'.$bugs_row['short_desc'].'" </td>';
									echo '</tr>';
									
									echo '<tr>';
									echo '<td> Assigned-To name</td>';
									echo '<td><input readonly type="text" name="assigned_to" value="'.$profile_row['login_name'].'" </td>';
									echo '</tr>';

									$i=1;
									while($row = $result_question->fetch_assoc()) {
										echo '<tr>';
										echo '<td>'.$row['question'].'</td>';
										echo '<input name="answers['.$i.']" type="hidden" value="NULL" />';
										echo '<td><input type="radio" value="YES" name="answers['.$i.']">YES 
										<input type="radio" value="NO" name="answers['.$i.']">NO 
										<input type="radio" value="N/A" name="answers['.$i.']">N/A</td>';
										echo '<input type= "hidden" name="questions['.$i.']" value="'.$row['question_id'].'">';
										echo '</tr>';
										$i++;
									}
									echo '<tr>';
									echo '<td> Remark</td>';
									echo '<td><textarea id= "Remark" name="Remark"></textarea></td>';
									echo '</tr>';
									?>
								</tbody>
							</table>
							<div class="center" >
								<input type="submit" name="SubmitBtn" class="flatbtn-blu" onclick="return confirm('Temporary Submit, this will be stored as DRAFT only!!!, this will allow you to come back and edit later, you will need to click on SUBMIT to commit your final changes')" value="Save As Draft">
                                                                <input type="submit" name="SubmitBtn" class="flatbtn-blu" onclick="return confirm('Are you sure you want to do a FINAL Submit, you cannot revert back after this changes')" value="Submit">
							</div>
						</form>
						<?php } } ?>
					</div>
				</div>
			</body>
			</html>
