<?php
	$dbase=mysqli_connect('localhost','root','','crickikeeda') or die();
	// mysqli_query($dbase,"INSERT INTO `teams` VALUES ('1','Team1') ");
	// mysqli_query($dbase,"INSERT INTO `teams` VALUES ('2','Team2') ");
	// mysqli_query($dbase,"INSERT INTO `teams` VALUES ('3','Team3') ");
	// mysqli_query($dbase,"INSERT INTO `teams` VALUES ('4','Team4') ");
	// mysqli_query($dbase,"INSERT INTO `teams` VALUES ('5','Team5') ");
	// mysqli_query($dbase,"INSERT INTO `teams` VALUES ('6','Team6') ");
	// mysqli_query($dbase,"INSERT INTO `teams` VALUES ('7','Team7') ");
	// mysqli_query($dbase,"INSERT INTO `teams` VALUES ('8','Team8') ");
	// mysqli_query($dbase,"INSERT INTO `teams` VALUES ('9','Team9') ");
	// mysqli_query($dbase,"INSERT INTO `teams` VALUES ('10','Team10') ");
	// mysqli_query($dbase,"INSERT INTO `teams` VALUES ('11','Team11') ");
	// mysqli_query($dbase,"INSERT INTO `teams` VALUES ('12','Team12') ");
	// mysqli_query($dbase,"INSERT INTO `teams` VALUES ('13','Team13') ");
	// mysqli_query($dbase,"INSERT INTO `teams` VALUES ('14','Team14') ");
	// mysqli_query($dbase,"INSERT INTO `teams` VALUES ('15','Team15') ");


	for ($i=1; $i <31 ; $i++) { 
		mysqli_query($dbase,"INSERT INTO `players` VALUES ('$i','Player$i','0','0') ");
	}



?>