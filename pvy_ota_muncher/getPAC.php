<?php
//
// pvyParts
// OTA Checker script sql database reqd
//
include ("config.php");

$InOrOut = htmlspecialchars ( $_GET ['type'] );

$DEBUG = false;
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

$con = mysqli_connect ( $dbhost, $dbuser, $dbpass, $dbname );
// Check connection
if (mysqli_connect_errno ()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error ();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Get PAC! <?php
	if ($InOrOut == 'nightly') {
		echo 'Nightly Builds';
	} else if ($InOrOut == 'stable') {
		echo 'Stable Builds';
	} else {
		// DEFAULT TO SOMTHING...
		echo 'Waka Waka Waka';
	}
	?></title>
	<link rel="stylesheet" type="text/css" href="view.css" media="all">

</head>
<body id="main_body">
	<div id="form_container">
		<img style="float: middle"
			src="http://www.pac-rom.com/images/logo.png" alt="PAC-man logo" />
		<h2>Get PAC!</h2>
		<p align="center">Find your Device Below!</p>
		<form method="get" align="right">
			<input type="radio" name="type" id="nightly" value="nightly"
				<?php if($InOrOut=='nightly' || $InOrOut==''){ echo " checked";}?> />
			<label for="nightly"
				style="-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;">Nighlies</label>
			<input type="radio" name="type" id="stable" value="stable"
				<?php if($InOrOut=='stable'){ echo " checked";}?> /> <label
				for="stable"
				style="-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;">Stable</label>
			<input type="submit" value="Update!" id="submit" />
		</form>

		<table class="table table-bordered table-striped">
			<tr>
				<th>Device</th>
				<th>Version</th>
				<th>URL</th>
			</tr>
				
				<?php
				if ($InOrOut == 'nightly' || $InOrOut == '') {
					$sql = "SELECT * FROM (`nightly`) ORDER BY (`device`) ASC";
				} else if ($InOrOut == 'stable') {
					$sql = "SELECT * FROM (`stable`) ORDER BY (`device`) ASC";
				}
				$sqlr = call_sql ( $con, $sql );
				while ( $row = mysqli_fetch_array ( $sqlr ) ) {
					echo "<tr><td>";
					echo "<h3>" . $row ['device'] . "</td><td><p>" . $row ['version'] . "</p></td></h3><td>";
					echo "<a href=\"" . $row ['dlurl'] . "\">" . $row ['dlurl'] . "</a></p>";
					echo "<cap> MD5: " . $row ['md5'] . "</cap>";
					echo "</td></tr>";
				}
				?>
				<tr>
				<th>Device</th>
				<th>Version</th>
				<th>URL</th>
			</tr>
		</table>
		<footer>� pvyParts 2013</footer>

		</form>
	</div>
</body>
</html>