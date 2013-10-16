<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
$DEV_COUNT = 0;

include ("config.php");

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

$con = mysqli_connect ( $dbhost, $dbuser, $dbpass, $dbname );
// Check connection
if (mysqli_connect_errno ()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error ();
}

// If the form was submitted, delete the items selected from the database
if ($_POST ["deleted_items"]) {
	
	$deleted_items = "\"" . join ( '", "', $_POST ["deleted_items"] ) . "\"";
	echo $deleted_items;
	if ($InOrOut == 'nightly' || $InOrOut == '') {
		$sql = "DELETE FROM `nightly` WHERE `device` IN ($deleted_items)";
	} else if ($InOrOut == 'stable') {
		$sql = "DELETE FROM `stable` WHERE `device` IN ($deleted_items)";
	}
	echo "sending - " . $sql;
	$sqlr = call_sql ( $con, $sql );
	echo "got - " . $sqlr;
}
//
// pvyParts
// OTA Checker script sql database reqd
//

$InOrOut = htmlspecialchars ( $_GET ['type'] );
$Device = htmlspecialchars ( $_GET ['device'] );
$Password = htmlspecialchars ( hash ( 'md5', $_GET ['pass'] ) );
$Pass = '5e69ffa8a3f41c4c1de42b123f3c6db8';

if ($Password == $Pass) {
	$perm = true;
} else {
	$perm = false;
}
$DEBUG = false;

$con = mysqli_connect ( $dbhost, $dbuser, $dbpass, $dbname );
// Check connection
if (mysqli_connect_errno ()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error ();
}

?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Get PAC! <?php
if ($InOrOut == 'nightly') {
	echo 'Nightly Builds';
} else if ($InOrOut == 'stable') {
	echo 'Stable Builds';
} else {
	// EFAULT TO SOMTHING...
	echo 'Waka Waka Waka';
}
?></title>
<link rel="stylesheet" type="text/css" href="view.css" media="all" />

</head>
<body id="main_body">
	<img id="top" src="top.png" alt="" />
	<div id="form_container">
		<img style="float: middle"
			src="http://www.pac-rom.com/images/logo.png" alt="PAC-man logo" />
		<h2>Get PAC!</h2>
		<?php
				if ($Device == "") {
			echo "<p align=\"center\">Find your Device Below!</p>";
			echo "<form method=\"get\" align=\"right\" action=\"\">
			<input type=\"radio\" name=\"type\" id=\"unofficial\" value=\"unofficial\"";
			
			if($InOrOut=='unofficial'){ echo " checked";}
			echo " />
			<label for=\"unofficial\"
				style=\"-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;\">Unofficial</label>
			<input type=\"radio\" name=\"type\" id=\"nightly\" value=\"nightly\"";
				
			if($InOrOut=='nightly' || $InOrOut==''){ echo " checked";}
			echo " />";
			echo "<label for=\"nightly\"
				style=\"-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;\">Nighlies</label>
			<input type=\"radio\" name=\"type\" id=\"stable\" value=\"stable\"";
			if($InOrOut=='stable'){ echo " checked";}
			echo " />
			<label for=\"stable\"
				style=\"-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;\">Stable</label>
			<input type=\"submit\" value=\"Update!\" id=\"submit\" />
		</form>";
			} else {
			echo "<h4>Displaying Rom for the $Device</h4>";
			}
			?>

		<form method="post" action="">
				
				<?php
				if ($Device == "") {
					Echo "<table class=\"table table-bordered table-striped\">
					<tr>
					<th>Device</th>
					<th>Version</th>
					<th>URL</th>
					</tr>";
					if ($InOrOut == 'nightly' || $InOrOut == '') {
						$sql = "SELECT * FROM (`nightly`) ORDER BY (`device`) ASC";
					} else if ($InOrOut == 'stable') {
						$sql = "SELECT * FROM (`stable`) ORDER BY (`device`) ASC";
					} else if ($InOrOut == 'unofficial') {
						$sql = "SELECT * FROM (`unofficial`) ORDER BY (`device`) ASC";
					}
					$sqlr = call_sql ( $con, $sql );
					while ( $row = mysqli_fetch_array ( $sqlr ) ) {
						$DEV_COUNT ++;
						echo "\n<tr><td ";
						echo ">";
						echo "<h3>" . $row ['device'] . "</td><td ";
						echo "><p>" . $row ['version'] . "</p></td></h3><td ";
						echo ">";
						echo "<a href=\"" . $row ['dlurl'] . "\">" . $row ['dlurl'] . "</a></p>";
						echo "<cap> MD5: " . $row ['md5'] . "</cap>";
						echo "</td>";
						if ($perm) {
							echo "    <td>" . "<input type=\"hidden\" name=\"Action\" value=\"deleted_items\">" . "<input type=\"checkbox\" name=\"deleted_items[]\" " . "value=\"" . $row ['device'] . "\" style=\"display:inherit\" />" . "</td>\n";
						} else {
						}
						"</tr>\n<tr>
						<th>Device</th>
						<th>Version</th>
						<th>URL</th>
					</tr>
				</table>";
					}
				} else {
					
					$sql = "SELECT * FROM (`nightly`) WHERE (`device`) = '" . $Device . "'";
					$sqln = call_sql ( $con, $sql );
					$sql = "SELECT * FROM (`stable`) WHERE (`device`) = '" . $Device . "'";
					$sqls = call_sql ( $con, $sql );
					$sql = "SELECT * FROM (`unofficial`) WHERE (`device`) = '" . $Device . "'";
					$sqlu = call_sql ( $con, $sql );
					echo "<h3>Stable</h3>";
					if (mysqli_num_rows( $sqls ) > 0) {

						echo "<table class=\"table table-bordered table-striped\"><tr>
					<th>Device</th>
					<th>Version</th>
					<th>URL</th>
					</tr>";
						while ( $row = mysqli_fetch_array ( $sqls ) ) {
							echo "\n<tr><td ";
							echo ">";
							echo "<h3>" . $row ['device'] . "</td><td ";
							echo "><p>" . $row ['version'] . "</p></td></h3><td ";
							echo ">";
							echo "<a href=\"" . $row ['dlurl'] . "\">" . $row ['dlurl'] . "</a></p>";
							echo "<cap> MD5: " . $row ['md5'] . "</cap>";
							echo "</td>";
							"</tr>\n";
						}
						echo "</table>";
					} else {
						echo "<caption>No Stable Roms found for $Device</caption>";
					}
					echo "<h3>Nightly</h3>";
					if (mysqli_num_rows( $sqln ) > 0) {
						echo "<table class=\"table table-bordered table-striped\"><tr>
					<th>Device</th>
					<th>Version</th>
					<th>URL</th>
					</tr>";
						while ( $row = mysqli_fetch_array ( $sqln ) ) {
							echo "\n<tr><td ";
							echo ">";
							echo "<h3>" . $row ['device'] . "</td><td ";
							echo "><p>" . $row ['version'] . "</p></td></h3><td ";
							echo ">";
							echo "<a href=\"" . $row ['dlurl'] . "\">" . $row ['dlurl'] . "</a></p>";
							echo "<cap> MD5: " . $row ['md5'] . "</cap>";
							echo "</td>";
							"</tr>\n";
						}
						echo "</table>";
					} else {
						echo "<caption>No Nightly Roms found for $Device</caption>";
					}
					echo "<h3>Unofficial</h3>";
					if (mysqli_num_rows( $sqlu ) > 0) {
					echo	"<table class=\"table table-bordered table-striped\"><tr>
					<th>Device</th>
					<th>Version</th>
					<th>URL</th>
					</tr>";
						while ( $row = mysqli_fetch_array ( $sqlu ) ) {
							echo "\n<tr><td ";
							echo ">";
							echo "<h3>" . $row ['device'] . "</td><td ";
							echo "><p>" . $row ['version'] . "</p></td></h3><td ";
							echo ">";
							echo "<a href=\"" . $row ['dlurl'] . "\">" . $row ['dlurl'] . "</a></p>";
							echo "<cap> MD5: " . $row ['md5'] . "</cap>";
							echo "</td>";
							"</tr>\n";
						}
						echo "</table>";
					} else {
						echo "<caption>No Unofficial Roms found for $Device</caption>";
					}
				}
			if ($perm) {
				echo "<input type=\"submit\" value=\"Delete Selected\" />";
			}
			?>
			</form>
		<?php if ($DEV_COUNT>0){
		echo "<footer>Total Devices $DEV_COUNT</footer>";
		}?>
		<p> </p>
		<footer>© pvyParts 2013</footer>
	</div>
	<img id="bottom" src="bottom.png" alt="" />

</body>
</html>
