<!DOCTYPE html>
<html>
<head>
	<title>CrickiKeeda</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="rgba(0,0,0,0.8)" />
</head>
<body>
	<div class="userBack"></div>
	<div class="userBlack"></div>
	<h1 class="title">Past Scores</h1>
	<div class="startContainer">
		<table class="pastScoreTable" border="1">
			<?php
				$dbase=@mysqli_connect('localhost','root','','crickikeeda') or die("<script>alert('Sorry! Couldn\'t connect to Database')</script>");
				$matchid=mysqli_query($dbase,"SELECT `matchid` FROM `matches` WHERE `completed`='1'");
				

				while ($matchi=mysqli_fetch_assoc($matchid)) 
				{
					$matchids=$matchi['matchid'];
					$teams=mysqli_query($dbase,"SELECT `teama`,`teamb` FROM `matches` WHERE `matchid`='$matchids'");
					$teams=mysqli_fetch_assoc($teams);
					$teamb=$teams['teamb'];
					$teama=$teams['teama'];
					$vic=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `news`,`lastover` FROM `matches` WHERE `matchid`='$matchids'"));
					$news=$vic['news'];
					$inn=$vic['lastover'];
					if ($news==$teama && $inn=='i1') {
						$runteama=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `runteama` FROM `matches` WHERE `matchid`='$matchids'"));
						$runteama=$runteama['runteama'];
						$runteamb=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `runteamb` FROM `matches` WHERE `matchid`='$matchids'"));
						$runteamb=$runteamb['runteamb'];
						$result="$news won the match by ".($runteama+1-$runteamb)." run/s";
					}
					elseif ($news==$teamb && $inn=='i1') {
						$runteama=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `runteama` FROM `matches` WHERE `matchid`='$matchids'"));
						$runteama=$runteama['runteama'];
						$runteamb=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `runteamb` FROM `matches` WHERE `matchid`='$matchids'"));
						$runteamb=$runteamb['runteamb'];
						$result="$news won the match by ".($runteamb+1-$runteama)." run/s";
					}
					elseif ($news==$teama && $inn=='i2') {
						$wic=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `wicteama` FROM `matches` WHERE `matchid`='$matchids'"));
						$wic=$wic['wicteama'];
						$result="$news won the match by ".(10-$wic)." wicket/s";
					}
					elseif ($news==$teamb && $inn=='i2') {
						$wic=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `wicteamb` FROM `matches` WHERE `matchid`='$matchids'"));
						$wic=$wic['wicteamb'];
						$result="$news won the match by ".(10-$wic)." wicket/s";
					}
					echo "<tr>
						<td>$matchids</td>
						<td>$teama VS $teamb</td>
					</tr>
					<tr>
						<form action='summary.php' method='post'>
							<input type='hidden' name='matchid' value='$matchids'>
							<td><input type='submit' value='More' name='getsum'></td>
						</form>
						<td>$result</td>
					</tr>";
				}
			?>
		</table>
		<div class="button" onclick="location.href='index.php'">Live Scores</div>
	</div>
</body>
</html>