<?php
$dbase=@mysqli_connect('localhost','root','','crickikeeda') or die("<script>alert('Sorry! Couldn\'t connect to Database')</script>");
$matchid=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `matchid` FROM `matches` WHERE `completed`='0'"));
$matchid=$matchid['matchid'];
$news=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `news` FROM `matches` WHERE `matchid`='$matchid'"));
$news=$news['news'];

$twint=substr($news,0,-3);
$inn=substr($news,-3,-1);
$res=substr($news, -1);
$teams=mysqli_query($dbase,"SELECT `teama`,`teamb` FROM `matches` WHERE matchid='$matchid'");
$teams=mysqli_fetch_assoc($teams);
$teamb=$teams['teamb'];
$teama=$teams['teama'];
if (($twint==$teama && $res==1) || ($twint==$teamb && $res==0)) {
	if ($inn=='i1' ) {
		$runs=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `runteama` FROM `matches` WHERE `matchid`='$matchid'"));
		$runs=$runs['runteama'];
		$over=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `overteamb` FROM `matches` WHERE `matchid`='$matchid'"));
		$over=$over['overteamb'];
		$wicket=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `wicteama` FROM `matches` WHERE `matchid`='$matchid'"));
		$wicket=$wicket['wicteama'];
	}
	else if ($inn=='i2') {
		$target=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `runteama` FROM `matches` WHERE `matchid`='$matchid'"));
		$target=$target['runteama']+1;
		$runs=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `runteamb` FROM `matches` WHERE `matchid`='$matchid'"));
		$runs=$runs['runteamb'];
		$over=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `overteama` FROM `matches` WHERE `matchid`='$matchid'"));
		$over=$over['overteama'];
		$wicket=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `wicteamb` FROM `matches` WHERE `matchid`='$matchid'"));
		$wicket=$wicket['wicteamb'];
	}
}
elseif (($twint==$teama && $res==0) || ($twint==$teamb && $res==1)) {
	if ($inn=='i1' ) {
		$runs=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `runteamb` FROM `matches` WHERE `matchid`='$matchid'"));
		$runs=$runs['runteamb'];
		$over=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `overteama` FROM `matches` WHERE `matchid`='$matchid'"));
		$over=$over['overteama'];
		$wicket=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `wicteamb` FROM `matches` WHERE `matchid`='$matchid'"));
		$wicket=$wicket['wicteamb'];
	}
	else if ($inn=='i2') {
		$target=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `runteamb` FROM `matches` WHERE `matchid`='$matchid'"));
		$target=$target['runteamb']+1;
		$runs=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `runteama` FROM `matches` WHERE `matchid`='$matchid'"));
		$runs=$runs['runteama'];
		$over=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `overteamb` FROM `matches` WHERE `matchid`='$matchid'"));
		$over=$over['overteamb'];
		$wicket=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `wicteama` FROM `matches` WHERE `matchid`='$matchid'"));
		$wicket=$wicket['wicteama'];
	}
}
?>