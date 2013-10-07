
<?php
//
// pvyParts
// OTA Checker script
//

// variables
$Device = htmlspecialchars ( $_GET ['device'] );
$Ver = htmlspecialchars ( $_GET ['version'] );
$Download = htmlspecialchars ( $_GET ['dlurl'] );
$Md5 = htmlspecialchars ( $_GET ['md5'] );
$Password = htmlspecialchars ( hash ( 'md5', $_GET ['pass'] ) );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>OTA Muncher!</title>
	<link rel="stylesheet" type="text/css" href="view.css" media="all">

</head>
<body id="main_body">
	<img id="top" src="top.png" alt="">
		<div id="form_container_muncher">
			<h1>
				<img style="float: middle"
					src="http://www.pac-rom.com/images/logo.png" alt="PAC-man logo" />
			</h1>
			<form action="ota_PAC.php" method="get">
				<div class="form_description">
					<h2>OTA Muncher!</h2>

					<p align="center">Update the records for a device by filling in the
						form!</p>
				</div>
				<ul>
					<li id="li_1">
						<p>
							Device
							<cap>(eg. Maguro)</cap>
						</p>
						
						
						<div>
							<input type="text" id="device" name="device" size="50"
								value="<?php echo $Device; ?>" required/>
						</div>
					</li>
					<li id="li_2">
						<p>
							Version
							<cap>(eg. Milestone1.2013.07.18)</cap>
						</p>
						<div>
							<input type="text" id="version" name="otaname" size="50"
								value="<?php echo $Ver; ?>" required/>
						</div>
					</li>
					<li id="li_3">
						<p>
							Download URL
							<cap>(Direct Link! not anything that takes you to a webpage
							first!)</cap>
						</p>
						<div>
							<input type="text" name="dlurl" size="50"
								value="<?php echo $Download; ?>" required/>
						</div>
					</li>
					<li id="li_4">
						<p>
							MD5 Hash
							<cap>(of update zip)</cap>
						</p>
						<div>
							<input type="text" id="md5" name="md5" size="50"
								value="<?php echo $Md5; ?>" required/>
						</div>
					</li>
					<li id="li_5">
						<p>
							Password
							<cap>(if you dont know then go away!)</cap>
						</p>
						<div>
							<input type="password" name="pass" size="50"
								value="<?php echo $Password; ?>" required/>
						</div>
					</li>
					<li id="li_6">
						<p>
							Rom Status
							<cap>(Hint: Unofficial-Official = Self Built)</cap>
						</p> <input id="unofficial" type="radio"  name="type" value="unofficial" checked>
						<label for="unofficial" style="margin: 2px;width:150px;">Unofficial-Official</label><br>								
					
					</li>
					<li>
						<p align="center">
							<input type="submit" id="submit" style="width:90%;align:middle;" name="from" value="Send this bad boy!">
						
						</p>
					</li>
				</ul>
				<footer>© pvyParts 2013</footer>

			</form>
		</div>
	<img id="bottom" src="bottom.png" alt="">

</body>
</html>
