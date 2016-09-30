<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title> Audit</title>
	<link rel="stylesheet" type="text/css" media="all" href="css/audit.css">
	<link  rel="stylesheet" href="css/jquery-ui.css" >
	<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script type="text/javascript">
		$(function(){
			$( "#nonstop" ).selectmenu({
				change : function( event, ui ){
					$.ajax({
						type : "POST",
						url : "changeAudit.php",
						data : "name="+$("#nonstop").val(),
						success : function(html){
							$("#bugidtable").html(html);
						}
					});
					$.ajax({
						type : "POST",
						url : "changeAuditDelivered.php",
						data : "name="+$("#nonstop").val(),
						success : function(html){
							$("#bugidDeliveredtable").html(html);
						}
					});
				}
			});
			$( "#storage").selectmenu();
			$( "#hpux" ).selectmenu();
			$( "#firmware" ).selectmenu();

		});
	</script>
</head>
<body>
	<div id="topbar"><h2>Welcome For Audit</h2>
		<div id="w">
			<div id="content">
				<div class="NewPrductFor">
					<label for="nonstop"> Non Stop</label>
					<select id="nonstop" name="nonstop">
						<option value="">Select User</option>
						<option value="shah.m@hp.com">Shah M</option>
						<option value="anilchowdari.kodavati@hp.com">Anilchowdari Kodavari</option>
						<option value="sakthipriya.karuppana-gounder@hp.com">Sakthipriya Karuppana Gounder</option>
						<option value="madhu.nadendla@hp.com">Madhu Babu N</option>
						<option value="bhaskar.a3@hp.com">Bhaskar</option>
						<option value="karunakar.tirupati@hp.com">Karunakar</option>
						<option value="nandita.arun@hp.com">Nandita Arun</option>
						<option value="mahapatra.meenakshee@hp.com">Meenakshee</option>
					</select>
					<label for="storage"> Storage</label>
					<select id="storage" name="storage"> 
						<option value="">1</option>
						<option value="">2</option>
						<option value="">3</option>
						<option value="">4</option>
						<option value="">5</option>
						<option value="">6</option>
						<option value="">6</option>
					</select>
					<label for="hpux"> HPUX</label>
					<select id="hpux" name="hpux"> 
						<option value="">1</option>
						<option value="">2</option>
						<option value="">3</option>
					</select>
					<label for="firmware"> Firmware</label>
					<select id="firmware" name="firmware"> 
						<option value="">1</option>
						<option value="">2</option>
						<option value="">3</option>
					</select>
				</div>
				<h1 style="font-size: 150%;">Name</h1>
				<table>
					<th>Requested Bug_id</th>	
					<tbody id="bugidtable">								
					</tbody>
				</table>	
				<table>
					<th>Delivered Bug_id</th>
					<tbody id="bugidDeliveredtable">								
					</tbody>
				</table>

			</div>
		</div>
	</div>
</body>
</html>