<?php
//
// pvyParts
// OTA Checker script sql database reqd
//

// Thanks Tom :P

include("config.php");

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

// variables
$Device = htmlspecialchars ( $_GET ['device'] );
$Ver = htmlspecialchars ( $_GET ['otaname'] );
$InOrOut = htmlspecialchars ( $_GET ['type'] );
$Download = htmlspecialchars ( $_GET ['dlurl'] );
$Md5 = htmlspecialchars ( $_GET ['md5'] );
$Password = htmlspecialchars ( hash ( 'md5', $_GET ['pass'] ) );
$from = htmlspecialchars ( $_GET ['from'] );
$Pass = '5e69ffa8a3f41c4c1de42b123f3c6db8';
if ($Download == ''){
	$Password = "asdf";
}

// demo get data
// ota_PAC_sql.php?device=maguro&otaname=nightly.today.23&md5=abc&dlurl=http://blahblah.com&type=check

// demo put data
// ota_PAC_sql.php?device=maguro&otaname=nightly.today.23&md5=abc&dlurl=http://blahblah.com&type=upload&pass=####
$con = mysqli_connect ($dbhost, $dbuser, $dbpass, $dbname);
// Check connection
if (mysqli_connect_errno ()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error ();
}
// INSERT INTO <table> (field1, field2, field3, ...)
// VALUES ('value1', 'value2','value3', ...)
// ON DUPLICATE KEY UPDATE
// field1='value1', field2='value2', field3='value3', ...

// Create tabl
$sql = "CREATE TABLE IF NOT EXISTS venom_nightly(device CHAR(30),version TINYTEXT,dlurl TINYTEXT, md5 CHAR(35))";
call_sql ( $con, $sql );
$sql = "ALTER TABLE nightly ADD PRIMARY KEY (device)";
call_sql ( $con, $sql );
// Create table
$sql = "CREATE TABLE IF NOT EXISTS venom_stable(device CHAR(30),version TINYTEXT,dlurl TINYTEXT, md5 CHAR(35))";
call_sql ( $con, $sql );
$sql = "ALTER TABLE stable ADD PRIMARY KEY (device)";
call_sql ( $con, $sql );
// Create table
$sql = "CREATE TABLE IF NOT EXISTS venom_unofficial(device CHAR(30),version TINYTEXT,dlurl TINYTEXT, md5 CHAR(35))";
call_sql ( $con, $sql );
$sql = "ALTER TABLE unofficial ADD PRIMARY KEY (device)";
call_sql ( $con, $sql );

// did we get the correct stuffs
if ($InOrOut == "nightly") {
	// check pass
	if ($Password == $Pass && $Device != null) {
		$sql = "INSERT INTO venom_nightly (device, version, dlurl, md5) 
				VALUES ('$Device', '$Ver','$Download', '$Md5')
				ON DUPLICATE KEY UPDATE
				device='$Device', version='$Ver', dlurl='$Download', md5='$Md5'";
		call_sql ( $con, $sql );
		//echo "";
		$sql = "select * from venom_nightly WHERE device='$Device'";
		$rslt = mysqli_fetch_array ( call_sql ( $con, $sql ) );
		//echo $rslt ['dlurl'];
		//echo ",";
		//echo $rslt ['device'];
		//echo ",";
		//echo $rslt ['version'];
		//echo ",";
		//echo $rslt ['md5'];
		//header( 'Location: http://www.pac-rom.com/ota/getPAC.php?device='.$Device."&type=".$InOrOut );
						
	} else {
		// no permision!
		echo "#BLAMETYLER,NOT_AUTHORISED";
	}
} else if ($InOrOut == "stable") {
	// check pass
	if ($Password == $Pass && $Device != null) {
		$sql = "INSERT INTO venom_stable (device, version, dlurl, md5) 
				VALUES ('$Device', '$Ver','$Download', '$Md5')
				ON DUPLICATE KEY UPDATE
				device='$Device', version='$Ver', dlurl='$Download', md5='$Md5'";
		call_sql ( $con, $sql );
		//echo "";
		$sql = "select * from venom_stable WHERE device='$Device'";
		$rslt = mysqli_fetch_array ( call_sql ( $con, $sql ) );
		//echo $rslt [dlurl];
		//echo ",";
		//echo $rslt [device];
		//echo ",";
		//echo $rslt [version];
		//echo ",";
		//echo $rslt [md5];
		//echo "";
		//header( 'Location: http://www.pac-rom.com/ota/getPAC.php?device='.$Device."&type=".$InOrOut );
				
	} else {
		// no permision!
		echo "#BLAMETYLER,NOT_AUTHORISED";
	}
} else if ($InOrOut == "checkn") {
	// send the details to the remote
	$sql = "SELECT * from venom_nightly WHERE device='$Device'";
	$sqlr = call_sql ( $con, $sql );
	$rslt = mysqli_fetch_array ( $sqlr );
	
	if ($rslt) {
		echo $rslt [dlurl];
		echo ",";
		echo $rslt [device];
		echo ",";
		echo $rslt [version];
		echo ",";
		echo $rslt [md5];
						
	} else {
		echo "#BLAMETYLER,NO_NIGHTLY_CONFIG_FOUND$";
	}
	
	#$sql = "SELECT * from stable WHERE device='$Device'";
	#$sqlr = call_sql ( $con, $sql );
	#$rslt = mysqli_fetch_array ( $sqlr );
	
	#if ($rslt) {
	#	echo $rslt [dlurl];
	#	echo ",";
	#	echo $rslt [device];
	#	echo ",";
	#	echo $rslt [version];
	#	echo ",";
	#	echo $rslt [md5];
	#	echo "";
	#} else {
	#	echo "#BLAMETYLER,NO_STABLE_CONFIG_FOUND";
	#}
	#
	// no device on file!
} else if ($InOrOut == "checks") {
	// send the details to the remote
	$sql = "SELECT * from venom_stable WHERE device='$Device'";
	$sqlr = call_sql ( $con, $sql );
	$rslt = mysqli_fetch_array ( $sqlr );
	
	if ($rslt) {
		echo $rslt [dlurl];
		echo ",";
		echo $rslt [device];
		echo ",";
		echo $rslt [version];
		echo ",";
		echo $rslt [md5];
						
	} else {
		echo "#BLAMETYLER,NO_STABLE_CONFIG_FOUND$";
	}
	
	#$sql = "SELECT * from stable WHERE device='$Device'";
	#$sqlr = call_sql ( $con, $sql );
	#$rslt = mysqli_fetch_array ( $sqlr );
	
	#if ($rslt) {
	#	echo $rslt [dlurl];
	#	echo ",";
	#	echo $rslt [device];
	#	echo ",";
	#	echo $rslt [version];
	#	echo ",";
	#	echo $rslt [md5];
	#	echo "";
	#} else {
	#	echo "#BLAMETYLER,NO_STABLE_CONFIG_FOUND";
	#}
	#
	// no device on file!
}  else if ($InOrOut == "checku") {
	// send the details to the remote
	$sql = "SELECT * from venom_unofficial WHERE device='$Device'";
	$sqlr = call_sql ( $con, $sql );
	$rslt = mysqli_fetch_array ( $sqlr );
	
	if ($rslt) {
		echo $rslt [dlurl];
		echo ",";
		echo $rslt [device];
		echo ",";
		echo $rslt [version];
		echo ",";
		echo $rslt [md5];
						
	} else {
		echo "#BLAMETYLER,NO_UNOFFICIAL_CONFIG_FOUND$";
	}
	
	#$sql = "SELECT * from stable WHERE device='$Device'";
	#$sqlr = call_sql ( $con, $sql );
	#$rslt = mysqli_fetch_array ( $sqlr );
	
	#if ($rslt) {
	#	echo $rslt [dlurl];
	#	echo ",";
	#	echo $rslt [device];
	#	echo ",";
	#	echo $rslt [version];
	#	echo ",";
	#	echo $rslt [md5];
	#	echo "";
	#} else {
	#	echo "#BLAMETYLER,NO_STABLE_CONFIG_FOUND";
	#}
	#
	// no device on file!
} else if ($InOrOut == 'unofficial'){
	// check pass
	if ($Password == $Pass && $Device != null) {
		$sql = "INSERT INTO venom_unofficial (device, version, dlurl, md5)
		VALUES ('$Device', '$Ver','$Download', '$Md5')
		ON DUPLICATE KEY UPDATE
		device='$Device', version='$Ver', dlurl='$Download', md5='$Md5'";
		call_sql ( $con, $sql );
		//echo "";
		$sql = "select * from venom_unofficial WHERE device='$Device'";
		$rslt = mysqli_fetch_array ( call_sql ( $con, $sql ) );
		//echo $rslt [dlurl];
		//echo ",";
		//echo $rslt [device];
		//echo ",";
		//echo $rslt [version];
		//echo ",";
		//echo $rslt [md5];
		//echo "";
		//header( 'Location: http://www.pac-rom.com/ota/getPAC.php?device='.$Device."&type=".$InOrOut );
	
	} else {
	// no permision!
	echo "#BLAMETYLER,NOT_AUTHORISED";
	}
	
} else {//
	echo "#BLAMETYLER,NO_PARAMS";
}
?>
