<?php
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
//
// pvyParts
// OTA Checker script sql database reqd
//



$con = mysqli_connect ( $dbhost, $dbuser, $dbpass, $dbname );
// Check connection
if (mysqli_connect_errno ()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error ();
}

		
				if ($Device == "") {
					echo "<p> Please Select Your device from the List </p>";
				} else {
						
					$sql = "SELECT * FROM (`nightly`) WHERE (`device`) = '" . $Device . "'";
					$sqln = call_sql ( $con, $sql );
					$sql = "SELECT * FROM (`stable`) WHERE (`device`) = '" . $Device . "'";
					$sqls = call_sql ( $con, $sql );
					$sql = "SELECT * FROM (`unofficial`) WHERE (`device`) = '" . $Device . "'";
					$sqlu = call_sql ( $con, $sql );
					echo "<div class=\"row span12\" id=\"commits\">";
					if (mysqli_num_rows( $sqls ) > 0) {
				
						
##<div class="col-lg-4">
##<h3>Commit Title <span>Time</span></h3>
##<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
##<a class="btn btn-default" href="#">View details »</a>
##<span>
##<span class="ui-icon ui-icon-script ui-widget-header"></span> 42 Modified Files <br>
##<span class="ui-icon ui-icon-person ui-widget-header"></span>Author
##</span>
##</div>				

						while ( $row = mysqli_fetch_array ( $sqls ) ) {
							echo "\n<div class=\"col-lg-4\">";
							echo "<h3>Stable<span>" . $row ['device'] . "</span></h3>";
							echo "<p>" . $row ['version'] . "</p>";
							echo "<a class=\"btn btn-default\" href=\"" . $row ['url'] . "\">Download ></a>";
							echo "<span>";
							echo "<span class=\"ui-icon ui-icon-script ui-widget-header\"></span> date of release <br>";
							echo "</span>";
							echo "</div>";
						}
						
					} else {
						#echo "<caption>No Stable Roms found for $Device</caption>";
					}
					if (mysqli_num_rows( $sqln ) > 0) {
						while ( $row = mysqli_fetch_array ( $sqln ) ) {
							echo "\n<div class=\"col-lg-4\">";
							echo "<h3>Nightly<span>" . $row ['device'] . "</span></h3>";
							echo "<p>" . $row ['version'] . "</p>";
							echo "<a class=\"btn btn-default\" href=\"" . $row ['url'] . "\">Download ></a>";
							echo "<span>";
							echo "<span class=\"ui-icon ui-icon-script ui-widget-header\"></span> date of release <br>";
							echo "</span>";
							echo "</div>";
						}
					} else {
					#echo "<caption>No Nightly Roms found for $Device</caption>";
					}
					if (mysqli_num_rows( $sqlu ) > 0) {
						while ( $row = mysqli_fetch_array ( $sqlu ) ) {
							echo "\n<div class=\"col-lg-4\">";
							echo "<h3>Unofficial<span>" . $row ['device'] . "</span></h3>";
							echo "<p>" . $row ['version'] . "</p>";
							echo "<a class=\"btn btn-default\" href=\"" . $row ['url'] . "\">Download ></a>";
							echo "<span>";
							echo "<span class=\"ui-icon ui-icon-script ui-widget-header\"></span> date of release <br>";
							echo "</span>";
							echo "</div>";
						}
						
					echo "</div>";
					} else {
					#echo "<caption>No Unofficial Roms found for $Device</caption>";
					}
					}
				
				
				
				?>
