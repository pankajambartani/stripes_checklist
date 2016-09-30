<!doctype html>
<html lang="en-US">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Storage</title>
	<link rel="stylesheet" type="text/css" media="all" href="css/NonStoppageCSS.css">
	<link rel="stylesheet" href="css/jquery-ui.css">
	<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/portal.js"></script>
</head>
<body>
	<div id="topbar"><h2>Storage</h2><a id="back" href="index.php">Home</a></div>
	<div id="w">
		<div id="content">
			<h1 style="font-size: 150%;"><?php echo $_GET['product_name'];?></h1>
			<?php
			require('connection.php');
			$product_name = mysqli_real_escape_string($conn, $_GET['product_name']);
			$bugId= mysqli_real_escape_string($conn, $_GET['bugId']);
			
			$sql_bugs= "SELECT bug_id, short_desc, assigned_to, Remark FROM storageanswer where bug_id=".$bugId;
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
			
			$i = 0;
			$sql_answer = "SELECT "; 
			$sql="";
			foreach ($arr_questionId as $id) {
				$id = $arr_questionId[$i]['question_id'];
				$sql .= "`$id`,";
				$i++;
			}
			$sql = substr($sql ,0,-1);
			$sql_answer .= $sql ." FROM storageanswer WHERE bug_id=".$bugId;
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
			<table>
				<thead>
					<tr>
						<th>Questions</th>
						<th>Answers</th>
					</tr>
				</thead>
				<tbody>
					<?php
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
					echo '<td> Assigned-To Name</td>';
					echo '<td><input readonly type="text" name="assigned_to" value="'.$rowInitial['assigned_to'].'"</td>';
					echo '</tr>';

					$i=0;
					$j=0;
					$rowans = mysqli_fetch_assoc($Result_sql_answer);
					while($row = mysqli_fetch_assoc($Result_sql_questions)) {
						echo '<tr>';
						echo '<td>'.$row['question'].'</td>';
						echo '<input name="answers['.$i.']" type="hidden" value="NULL" />';
						if ($rowans[$arr_questionId[$i]['question_id']] == 'YES')
						{
							echo '<td><input type="radio" name="answers['.$j.']" value="YES" checked> YES <input type="radio" name="answers['.$j.']" value="NO" disabled> NO <input type="radio" name="answers['.$j.']" value="N/A" disabled> N/A</td>';
						}
						elseif ($rowans[$arr_questionId[$i]['question_id']] == 'NO')
						{
							echo '<td><input type="radio" name="answers['.$j.']" value="YES" disabled> YES <input type="radio" name="answers['.$j.']" value="NO" checked> NO <input type="radio" name="answers['.$j.']" value="N/A" disabled> N/A</td>';
						}
						elseif ($rowans[$arr_questionId[$i]['question_id']] == 'N/A') 
						{
							echo '<td><input type="radio" name="answers['.$j.']" value="YES" disabled > YES <input type="radio" name="answers['.$j.']" value="NO" disabled> NO <input type="radio" name="answers['.$j.']" value="N/A" checked> N/A</td>';
						}
						else
						{
							echo '<td><input type="radio" name="answers['.$j.']" value="YES" disabled> YES <input type="radio" name="answers['.$j.']" value="NO" disabled> NO <input type="radio" name="answers['.$j.']" value="N/A" disabled> N/A</td>';
						}
						echo '</tr>';
						$i++;
						$j++;
					}
					echo '<tr>';
					echo '<td> Remark</td>';
					echo '<td><textarea readonly id= "Remark" name="Remark">'.$rowInitial['Remark'].'</textarea></td>';
					echo '</tr>';
					?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>