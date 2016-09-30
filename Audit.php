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
						data : "name="+$("#nonstop").val()+"&project=nonstopanswer",
						success : function(html){
							$("#bugidtable").html(html);
						}
					});
					$.ajax({
						type : "POST",
						url : "changeAuditDelivered.php",
						data : "name="+$("#nonstop").val()+"&project=nonstopanswer",
						success : function(html){
							$("#bugidDeliveredtable").html(html);
						}
					});
				}
			});

			$( "#storage").selectmenu({
				change : function (event, ui ){
					$.ajax({
						type : "POST",
						url : "changeAudit.php",
						data : "name="+$("#nonstop").val()+"&project=storageanswer",
						success : function(html){
							$("#bugidtable").html(html);
						}
					})
					$.ajax({
						type : "POST",
						url : "changeAuditDelivered.php",
						data : "name="+$("#nonstop").val()+"&project=storageanswer",
						success : function(html){
							$("#bugidDeliveredtable").html(html);
						}
					});
				}
			});

			$( "#hpux" ).selectmenu();
			$( "#firmware" ).selectmenu();

		});
	</script>
</head>
<body>
	<div id="topbar"><h2>Welcome For Audit</h2>
		<div id="w">
			<div id="content">
				<div class="form-group cb-col-100">
				<div class="form-group">
					<strong>NonStop</strong>
					<select class="form-control" id="nonstop" name="nonstop">
						<option value="" selected>Select User</option>
						<option value="shah.m@hp.com">Shah M</option>
						<option value="anilchowdari.kodavati@hp.com">Anilchowdari Kodavari</option>
						<option value="sakthipriya.karuppana-gounder@hp.com">Sakthipriya Karuppana Gounder</option>
						<option value="madhu.nadendla@hp.com">Madhu Babu N</option>
						<option value="bhaskar.a3@hp.com">Bhaskar</option>
						<option value="karunakar.tirupati@hp.com">Karunakar</option>
						<option value="nandita.arun@hp.com">Nandita Arun</option>
						<option value="mahapatra.meenakshee@hp.com">Meenakshee</option>
					</select>
				</div>
				<div class="form-group">
					<strong> Storage</strong>
					<select class="form-control" id="storage" name="storage"> 
						<option selected="">Select user</option>
						<option value="madhusudhan.l@hp.com">L, Madhusudhan Reddy (STSD)</option>
						<option value="pankaj.ambartani@hp.com">Ambartani, Pankaj Ram</option>
						<option value="c-a.nischal@hp.com">Nischal, C A</option>
						<option value="swamy.cnn@hp.com">CNN, Swamy</option>
					</select>
				</div>
				<div class="form-group">
					<strong>HP-UX</strong>
					<select class="form-control" id="hpux" name="hpux"> 
						<option option selected>Select user</option>
						<option value=""></option>
						<option value=""></option>
					</select>
				</div>				
				<div class="form-group">
					<strong> Firmware</strong>
					<select class="form-control" id="firmware" name="firmware"> 
						<option selected>Select User</option>
						<option value=""></option>
						<option value=""></option>
					</select>
				</div>

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