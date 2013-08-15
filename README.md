pvy ota muncher
===============

Some Basic OTA Scripts

still very much in progress

(i'm not a php'er)

Usage is simple

for a direct update no form use (ALL FIELDS REQ'D)

`[host url]/pac_OTA.php?device=[ro.cm.device value]  
		&otaname=[ro.pacversion value in new update]  
		&dlurl=[url to the update]  
		&md5=[md5 of the update zip]  
		&pass=[password for the uploads] `

		
		
for prefiling the form with data (not all fields are req'd)  

`[host url]/?device=[ro.cm.device value]  
		&version=[ro.pacversion value in new update]  
		&dlurl=[url to the update]  
		&md5=[md5 of the update zip]  
		&pass=[password for the uploads] `
		
Demo Site! [link](http://blownco.com/ota/ota_PAC.php?device=it_is_easy_to&otaname=pass_data_to_the_form&dlurl=See_what_i_mean&md5=abc123def456&pass=###)

![demo][1]

[1]: http://i789.photobucket.com/albums/yy180/aaronkable/muncher_zpsa83d32cc.png
