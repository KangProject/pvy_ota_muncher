<?php
#
#	pvyParts
#	OTA Checker script
#

# variables
$Device = $_GET['device'] ;
$Ver = $_GET['otaname'] ;
$InOrOut = $_GET['type'] ;
$Download= $_GET['dlurl'] ;
$Md5= $_GET['md5'] ;
$Password = hash('md5', $_GET['pass']); 
$Pass='5e69ffa8a3f41c4c1de42b123f3c6db8';
# demo get data
# ota_PAC.php?device=maguro&otaname=nightly.today.23&md5=abc&dlurl=http://blahblah.com&type=check

# demo put data
# ota_PAC.php?device=maguro&otaname=nightly.today.23&md5=abc&dlurl=http://blahblah.com&type=upload&pass=####

# did we get the correct stuffs
if ($InOrOut == "upload"){
	# check pass
	if ($Password == $Pass){
		file_put_contents("./devices/" . $Device, $Download.",".$Device.",".$Ver.",".$Md5);
		if(file_exists ("./devices/" . $Device)) {
			# send the details to the remote for checking
			echo file_get_contents('./devices/'.$Device, FILE_USE_INCLUDE_PATH);
		} else {
			# couldnt save
			echo "#BLAMETYLER,FAILED_TO_UPDATE";
		}
	} else {
		# no permision!
		echo "#BLAMETYLER,NOT_AUTHORISED";
	}

} else if ($InOrOut == "check"){
	if(file_exists ("./devices/" . $Device)) {
		# send the details to the remote
		echo file_get_contents('./devices/'.$Device, FILE_USE_INCLUDE_PATH);
	} else {
		# no device on file!
		echo "#BLAMETYLER,NO_CONFIG_FOUND";
	}
} else {
	echo "#BLAMETYLER,NO_PARAMS";
}

?>
