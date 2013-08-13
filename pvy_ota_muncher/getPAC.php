<?php
//
// pvyParts
// OTA Checker script sql database reqd
//
$DEBUG = true;
function call_sql($a, $b) {
	$rslts = mysqli_query ( $a, $b );
	if ($rslts) {
		return $rslts;
	} else {
		if ($DEBUG) {
			echo "Error: " . mysqli_error ( $a );
		}
	}
}

$con = mysqli_connect ( "localhost", "blownco_ota", "blownco_ota", "blownco_ota" );
// Check connection
if (mysqli_connect_errno ()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error ();
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Get PAC!</title>
	<link rel="stylesheet" type="text/css" href="view.css" media="all">
</head>
<body id="main_body">
	<img id="top" src="top.png" alt="">
		<div id="form_container">
			<h1>
				Get PAC!
			</h1>
			
			<form action="ota_PAC.php" method="get">
				<div class="form_description">
					<h2>Get PAC!</h2>
					<p align="center">find your Device Below!</p>
				</div>
				<ul>
				<?php
				$sql = "SELECT * FROM (`nightly`) JOIN (`stable`) ON (`nightly`.device = `stable`.device)";
				$sqlr = call_sql ( $con, $sql );

				while ( $row = mysqli_fetch_array ( $sqlr ) ) {
					echo "<li>";
					echo "<h3>" . $row ['device'] . "</h3>";
					echo "<p>" . $row ['version'];
					echo "<br>";
					echo "<a href=\"" . $row ['dlurl'] . "\">" . $row ['dlurl'] . "</a></p>";
					echo "</li>";						
				}
				?>
				
				</ul>
									<footer>© pvyParts 2013</footer>
				
			</form>
		</div> <img id="bottom" src="bottom.png" alt="">
</body>
</html>