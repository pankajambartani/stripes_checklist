<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Stripes Checklist Modification</title>
	<link rel="stylesheet" type="text/css" media="all" href="css/ModificationpageCSS.css">
	<link rel="stylesheet" href="css/jquery-ui.css">
	<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script type="text/javascript" charset="utf-8" src="js/jquery.leanModal.min.js"></script>
	<script src="js/portal.js"></script>
	<script type="text/javascript">
		$(function() {
			$("#projectNewproduct").selectmenu();
			$("#NoQuestions").selectmenu();
			$("#project").selectmenu({
				change: function( event, ui ) {
					if ($("#project").val() =="") {
						$( "#product" ).selectmenu("disable");
						$("#operation").selectmenu( "disable" );
					}else{
						$( "#product" ).selectmenu("enable");
					} ;

					$.ajax({
						type: "POST", 
						url: "change.php",
						data: "project="+$("#project").val(),
						success: function(html) {
							$("#product").html(html);
							$("#product").selectmenu( "refresh" );
						}
					});
				} });
			$( "#product" ).selectmenu();
			$( "#product" ).selectmenu("disable");
			$( "#product" ).selectmenu({
				change: function(event, ui){
					if ($("#product").val() == "") {
						$("#operation").selectmenu( "disable" );
					}else{
						$("#operation").selectmenu( "enable" );
					};
				}
			});			
			$('#operation').selectmenu();
			$('#operation').selectmenu("disable");
			$('#operation').selectmenu({
				change: function(event, ui){
					if ($("#operation").val()== "insert") {
						$( "#NoRows" ).selectmenu("enable");			
					}else{
						$( "#NoRows" ).selectmenu("disable");
					};
				}
			});
			$( "#NoRows" ).selectmenu();
			$( "#NoRows" ).selectmenu("disable");
		});
</script>
</head>
<body>
	<div id="topbar"><h2>Stripes Checklist Modification</h2><a id="back" href="index.php">Home</a></div>
	<div id="w">
		<div id="content">
			<div style="margin-left:7%;">
				<form id="FormMain" method="GET" action="Modification.php">
					<input type="submit" class="flatbtn-main" name="NewOperation"  value="New Project">
					<input type="submit" class="flatbtn-main" name="NewOperation"  value="New Product">
					<input type="submit" class="flatbtn-main" name= "NewOperation" value="Modification in Product">
				</form>
			</div>

			<?php
			if (isset($_GET['NewOperation'])) {
				require('connection.php');
				$NewOperation = mysqli_real_escape_string($conn, $_GET['NewOperation']);

				if ($NewOperation == "New Product") {  //For New product in Project 
					?>
					<div class="NewPrductForm">
						<form id="NewPrductForm" method="GET" action="Modification.php">
							
							<input type="hidden" name="NewOperation" value="<?php echo $NewOperation;?>">

							<select name="projectNewproduct" id="projectNewproduct">
								<option value="" selected="selected">Select Project</option>
								<option value="nonstop">Non Stop</option>
								<option value="storage">Storage</option>
								<option value="hpux">HPUX</option>
								<option value="firmware">Firmwares</option>
							</select>
							<input type="text" name="NewProductName" class="txtfieldNewProduct" placeholder="100 Characters" maxlength='100' onkeypress="if (this.value.length==this.getAttribute('maxlength')) alert('Maximum character reached')" />
							<select name="NoQuestions" id="NoQuestions">
								<option value="" selected="selected">No. of Questions</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
								<option value="16">16</option>
								<option value="17">17</option>
								<option value="18">18</option>
								<option value="19">19</option>
								<option value="20">20</option>
							</select>
							<div>
								<center><input type="submit" name="submitNewProduct" class="flatbtn-blu" value="Submit"></center>								
							</div>
						</form>
					</div>
					<?php 
					require('connection.php');
					if (isset($_GET['submitNewProduct'])) {
						if ($_GET['projectNewproduct'] == "" OR $_GET['NewProductName']== "" OR $_GET['NoQuestions']== ""  ) {
							echo '<script type="text/javascript">$( document ).ready(function() { alert("Please fill all fields."); }); </script>';
							return;
						}

						$NewOperation = mysqli_real_escape_string($conn,$_GET['NewOperation']);
						$projectNewproduct = mysqli_real_escape_string($conn,$_GET['projectNewproduct']);
						$NewProductName = mysqli_real_escape_string($conn, $_GET['NewProductName']);
						$NoQuestions = mysqli_real_escape_string($conn, $_GET['NoQuestions']);
						
						?>
						<h1 style="font-size: 150%;"><?php echo 'New Product '.$NewProductName;?></h1>
						<form  method="POST" action="ModifyDB.php">
							<table>
								<thead>
									<tr>
										<th>Number</th>
										<th>Question</th>
									</tr>
								</thead>
								<tbody>
									<?php
									echo '<input type= "hidden" name="NewOperation" value ="'.$NewOperation.'">';
									echo '<input type= "hidden" name="projectNewproduct" value="'.$projectNewproduct.'">';
									echo '<input type= "hidden" name="NewProductName" value="'.$NewProductName.'">';
									echo '<input type= "hidden" name="NoQuestions" value="'.$NoQuestions.'">';
									
									$j =1;
									for ($i=0; $i < $NoQuestions ; $i++) {
										echo '<tr>';
										echo '<td>'.$j.'</td>';
										echo '<td><input class="txtfield" type="text" name="question['.$i.']"</td>';
										echo '</tr>';
										$j++;
									} ?>
								</tbody>
							</table>
							<div class="padding: 20px;">
								<center><input type="submit" name="submitNewProduct" class="flatbtn-blu" value="Submit"></center>
							</div>
						</form>
						<?php }
					}
					elseif ($NewOperation == "Modification in Product") {
						?>
						<div class="ModificationForm">
							<form  id="ModificationForm" method="GET" action="Modification.php">
								<div>
									<input type="hidden" name="NewOperation" value="<?php echo $NewOperation;?>">
									<select name="project" id="project">
										<option value="" selected="selected">Select Project</option>
										<option value="nonstop">Non Stop</option>
										<option value="storage">Storage</option>
										<option value="hpux">HPUX</option>
										<option value="firmware">Firmwares</option>
									</select>

									<select name="product" id="product">
										<option value="" selected="selected">Select Product</option>

									</select>

									<select name="operation" id="operation">
										<option value="" selected="selected">Select Operation</option>
										<option value="insert">Insert Questions</option>
										<option value="update">Update Questions</option>
									</select>

									<select name="NoRows" id="NoRows">
										<option value="" selected="selected">No. of Questions</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>
									</select>
									<div style="padding: 20px;">
										<center><input type="submit" name="submitMod" class="flatbtn-blu" value="Submit"></center>
									</div>
								</div>
							</form>
						</div>

						<?php
						require('connection.php');

						if (isset($_GET['submitMod'])) {
							if ($_GET['project'] == "" OR $_GET['product'] == "" OR $_GET['operation'] == "") {
								echo '<script type="text/javascript">$( document ).ready(function() { alert("Please fill all fields."); });</script>';
								return;
							}
							$NewOperation = mysqli_real_escape_string($conn,$_GET['NewOperation']);
							$project = mysqli_real_escape_string($conn, $_GET['project']);
							$product_name = mysqli_real_escape_string($conn, $_GET['product']);
							$operation = mysqli_real_escape_string($conn, $_GET['operation']);

							if ($operation == 'update') 
							{					
								if ($project == 'nonstop') {
									$mysql_query = 'SELECT question_id, question FROM nonstopquestion WHERE product_name ="'.$product_name.'"';

								}elseif ($project == 'hpux') {
									$mysql_query = 'SELECT question_id, question FROM hpuxquestion WHERE product_name ="'.$product_name.'"';

								}elseif ($project == 'storage') {
									$mysql_query = 'SELECT question_id, question FROM storagequestion WHERE product_name="Common" OR product_name ="'.$product_name.'"';

								}elseif ($project == 'firmware') {
									$mysql_query = 'SELECT question_id, question FROM firmwarequestion WHERE product_name ="'.$product_name.'"';

								}
								$mysql_query_result = mysqli_query($conn,$mysql_query) or die(mysqli_error($conn));
								?>

								<h1 style="font-size: 150%;"><?php echo 'Updation in '.$product_name;?></h1>
								<form name="myForm" method="POST" action="ModifyDB.php">
									<table>
										<thead>
											<tr>
												<th>Questions_ID</th>
												<th>Question</th>
											</tr>
										</thead>
										<tbody>
											<?php
											echo '<input type= "hidden" name="NewOperation" value="'.$NewOperation.'">';
											echo '<input type= "hidden" name="project" value="'.$project.'">';
											echo '<input type= "hidden" name="product_name" value="'.$product_name.'">';
											echo '<input type= "hidden" name="operation" value="'.$operation.'">';

											$i=0;
											while ($row = mysqli_fetch_assoc($mysql_query_result)) {																						
												echo '<tr>';
												echo '<td><input readonly class="numberfield" type="number" name="question_id['.$i.']" value="'.$row['question_id'].'"</td>';
												echo '<td><input class="txtfield" type="text" name="question['.$i.']" value="'.$row['question'].'"</td>';
												echo '</tr>';
												$i++;
											}
											?>
										</tbody>
									</table>
									<div style="padding: 20px;">
										<center><input type="submit" name="submit" class="flatbtn-blu" value="Submit"></center>
									</div>
								</form>

								<?php 
							} elseif ($operation == 'insert') {
								$NoRows = $_GET['NoRows'];
								?>

								<h1 style="font-size: 150%;"><?php echo 'Inseration in '.$product_name;?></h1>
								<form name="myForm1" method="post" action="ModifyDB.php">
									<table>
										<thead>
											<tr>
												<th>Number</th>
												<th>Question</th>
											</tr>
										</thead>
										<tbody>
											<?php
											echo '<input type= "hidden" name="NewOperation" value ="'.$NewOperation.'">';
											echo '<input type= hidden name="project" value="'.$project.'"">';
											echo '<input type= hidden name="product_name" value="'.$product_name.'"">';
											echo '<input type= hidden name="operation" value="'.$operation.'"">';
											$j =1;
											for ($i=0; $i < $NoRows ; $i++) {
												echo '<tr>';
												echo '<td>'.$j.'</td>';
												echo '<td><input class="txtfield" type="text" name="question['.$i.']"</td>';
												echo '</tr>';
												$j++;
											} ?>
										</tbody>
									</table>
									<div class="padding: 20px;">
										<center><input type="submit" name="submit" class="flatbtn-blu" value="Submit"></center>
									</div>

								</form>
								<?php } 
							} 
						}
					}
					?>

				</div>
			</div>
		</body>
		</html>
