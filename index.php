<?php
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
	<title>Team Stripes Login</title>
	<link rel="stylesheet" type="text/css" media="all" href="css/index_style.css">
	<link  rel="stylesheet" href="css/jquery-ui.css" > 
	<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/portal.js"></script>
</head>
<body>

	<?php
	$db_servername = "localhost";
	$db_username = "root";
	$db_password = "Stripes*team";
	$db_database = "checklist";

	// Create connection
	$conn = mysqli_connect($db_servername, $db_username, $db_password, $db_database);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	// echo "Connected successfully";
	$sql_NS = "SELECT product_name FROM nonstop";
	$result_NS = mysqli_query($conn, $sql_NS) or die(mysqli_error($conn));
	
	$sql_HPUX = "SELECT product_name FROM hpux";
	$result_HPUX = mysqli_query($conn, $sql_HPUX) or die(mysqli_error($conn));

	$sql_STOR = "SELECT product_name FROM storage";
	$result_STOR = mysqli_query($conn, $sql_STOR) or die(mysqli_error($conn));

	$sql_Firm = "SELECT product_name FROM firmware";
	$result_Firm = mysqli_query($conn, $sql_Firm) or die(mysqli_error($conn));
	
	?>
	<div id="topbar"><a id="audit" href="Audit.php">Go to Audit</a><h2>Welcome to Team Stripes Checklist Portal</h2><a id="modify" href="Modification.php">Modification To Checklist?</a><a id="logout" href="logout.php">Log Out</a>
	</div>

	<div id="w">
		<div id="content">
			<h1 style="font-size: 30px;">Products</h1>
			<div id="catalog" >
				<h2>Non-Stop</h2>
				<div>
					<form id="ProjectSelectionNonStop" name="ProjectSelectionNonStop" method="GET" action="NonStopPage.php">
						<ul>
							<?php
							while($row = $result_NS->fetch_assoc()) {
								echo '<li><input type="submit" value="'.$row["product_name"].'" class="ui-accordion-header ui-state-default ui-accordion-header-active ui-state-active ui-corner-top ui-accordion-icons" name="product_name" style="width:100%"></li>'."\n";
							} ?>
						</ul>
					</form>
				</div>

				<h2>HP-UX</h2>
				<div>
					<form id="ProjectSelectionHPUX" name="ProjectSelectionHPUX" method="GET" action="HPUXPage.php">
						<ul>
							<?php while($row = $result_HPUX->fetch_assoc()) { 
								echo '<li><input type="submit" value="'.$row["product_name"].'" class="ui-accordion-header ui-state-default ui-accordion-header-active ui-state-active ui-corner-top ui-accordion-icons" name="product_name" style="width: 100%"> </li>';
							} ?>
						</ul>
					</form>
				</div>

				<h2>Storage</h2>
				<div>
					<form id="ProjectSelectionStorage" name="ProjectSelectionStorage" method="GET" action="StoragePage.php">
						<ul>
							<?php while($row = $result_STOR->fetch_assoc()) { 
								echo '<li><input type="submit" value="'.$row["product_name"].'" class="ui-accordion-header ui-state-default ui-accordion-header-active ui-state-active ui-corner-top ui-accordion-icons" name="product_name" style="width: 100%"> </li>';
							} ?>
						</ul>
					</form>
				</div>

				<h2>Firmware</h2>
				<div>
					<form id="ProjectSelectionFirmware" name="ProjectSelectionFirmware" method="GET" action="Firmware.php">
						<ul>
							<?php while($row = $result_Firm->fetch_assoc()) { 
								echo '<li><input type="submit" value="'.$row["product_name"].'" class="ui-accordion-header ui-state-default ui-accordion-header-active ui-state-active ui-corner-top ui-accordion-icons" name= "product_name" style="width: 100%"> </li>';
							}?>
						</ul>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
