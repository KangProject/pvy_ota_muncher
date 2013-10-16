<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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

$Device = htmlspecialchars ( $_GET ['device'] );

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
	<title>Get PAC!</title>
	<link rel="stylesheet" type="text/css" href="view.css" media="all">

</head>
<body id="main_body">
	<img id="top" src="top.png" alt="">
		<div id="form_container">
			<img style="float: middle"
				src="http://www.pac-rom.com/images/logo.png" alt="PAC-man logo" />
			<h2><?php $Device ?></h2>
			
	        <form method="post">
				<?php 
				
				
				
				
				
				
				?>
			<footer><br/>© pvyParts 2013</footer>

			</form>
		</div> <img id="bottom" src="bottom.png" alt="">

</body>
</html>