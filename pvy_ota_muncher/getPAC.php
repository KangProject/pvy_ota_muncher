<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
$DEV_COUNT=0;

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
if ($_POST["deleted_items"]) {
	
    $deleted_items = "\"" . join('", "', $_POST["deleted_items"]). "\"";
    echo $deleted_items;
    if ($InOrOut == 'nightly' || $InOrOut == '') {
    	$sql = "DELETE FROM `nightly` WHERE `device` IN ($deleted_items)";
    } else if ($InOrOut == 'stable') {
   		$sql = "DELETE FROM `stable` WHERE `device` IN ($deleted_items)";
    }
    echo "sending - " . $sql;
    $sqlr = call_sql ( $con, $sql );
    echo "got - " .  $sqlr;
}
//
// pvyParts
// OTA Checker script sql database reqd
//

$InOrOut = htmlspecialchars ( $_GET ['type'] );
$Device = htmlspecialchars ( $_GET ['device'] );
$Password = htmlspecialchars ( hash ( 'md5', $_GET ['pass'] ) );
$Pass = '5e69ffa8a3f41c4c1de42b123f3c6db8';

if ($Password == $Pass){
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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
	<link rel="stylesheet" type="text/css" href="view.css" media="all">

</head>
<body id="main_body">
	<img id="top" src="top.png" alt="">
		<div id="form_container">
			<img style="float: middle"
				src="http://www.pac-rom.com/images/logo.png" alt="PAC-man logo" />
			<h2>Get PAC!</h2>
			<p align="center">Find your Device Below!</p>
			<form method="get" align="right">
				<input type="radio" name="type" id="unofficial" value="unofficial"
					<?php if($InOrOut=='unofficial'){ echo " checked";}?> />
				<label for="unofficial"
					style="-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;">Unofficial</label>
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
			
	        <form method="post">
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
				} else if ($InOrOut == 'unofficial') {
					$sql = "SELECT * FROM (`unofficial`) ORDER BY (`device`) ASC";
				}
				$sqlr = call_sql ( $con, $sql );
				while ( $row = mysqli_fetch_array ( $sqlr ) ) {
					$DEV_COUNT++;
					echo "\n<tr><td ";
					if ($Device == $row ['device']){
						echo "style=\"background-color:#440\";";
					}
					echo ">";
					echo "<h3>" . $row ['device'] . "</td><td ";
					if ($Device == $row ['device']){
						echo "style=\"background-color:#440\";";
					}
					echo "><p>" . $row ['version'] . "</p></td></h3><td ";
					if ($Device == $row ['device']){
						echo "style=\"background-color:#440\";";
					}
					echo ">";
					echo "<a href=\"" . $row ['dlurl'] . "\">" . $row ['dlurl'] . "</a></p>";
					echo "<cap> MD5: " . $row ['md5'] . "</cap>";
					echo "</td>";
					if ($perm) {
	                    echo "    <td>" .
	                              "<input type=\"hidden\" name=\"Action\" value=\"deleted_items\">" .
	                              "<input type=\"checkbox\" name=\"deleted_items[]\" " . "value=\"".$row['device']."\" style=\"display:inherit\" />" .
	                              "</td>\n";
		                
	                } else {
	                   
	                }
	                "</tr>\n";
				}
				?>
				<tr>
					<th>Device</th>
					<th>Version</th>
					<th>URL</th>
				</tr>
			</table>
			<?php 
			if ($perm){
				echo "<input type=\"submit\" value=\"Delete Selected\" />";
			}	
			?>
			</form>
			<footer>Total Devices <?php echo $DEV_COUNT?></footer>
			<footer>© pvyParts 2013</footer>

			</form>
		</div> <img id="bottom" src="bottom.png" alt="">

</body>
</html>