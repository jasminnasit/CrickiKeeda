<!DOCTYPE html>
<html>
<head>
	<title>CrickiKeeda</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="rgba(0,0,0,0.8)" />
</head>
<body>
	<div class="userBack"></div>
	<div class="userBlack"></div>
	<h1 class="title">Summary</h1>
	<div class="startContainer">
			<?php
				$matchid=$_POST['matchid'];
				$dbase=@mysqli_connect('localhost','root','','crickikeeda') or die("<script>alert('Sorry! Couldn\'t connect to Database')</script>");
				$teams=mysqli_query($dbase,"SELECT `teama`,`teamb` FROM `matches` WHERE `matchid`='$matchid'");
				$teams=mysqli_fetch_assoc($teams);
				$teamb=$teams['teamb'];
				$teambid=substr($teamb,0,strpos($teamb,'-'));
				$teama=$teams['teama'];
				$teamaid=substr($teama,0,strpos($teama,'-'));
				$vic=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `news`,`lastover` FROM `matches` WHERE `matchid`='$matchid'"));
				$news=$vic['news'];
				$inn=$vic['lastover'];
				//echo "<script>alert('$news $inn')</script>";





				if ($news==$teama && $inn=='i1') {
					$runteama=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `runteama` FROM `matches` WHERE `matchid`='$matchid'"));
					$runteama=$runteama['runteama'];
					$runteamb=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `runteamb` FROM `matches` WHERE `matchid`='$matchid'"));
					$runteamb=$runteamb['runteamb'];
					$result="$news won the match by ".($runteama+1-$runteamb)." run/s";
				}
				elseif ($news==$teamb && $inn=='i1') {
					$runteama=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `runteama` FROM `matches` WHERE `matchid`='$matchid'"));
					$runteama=$runteama['runteama'];
					$runteamb=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `runteamb` FROM `matches` WHERE `matchid`='$matchid'"));
					$runteamb=$runteamb['runteamb'];
					$result="$news won the match by ".($runteamb+1-$runteama)." run/s";
				}
				elseif ($news==$teama && $inn=='i2') {
					$wic=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `wicteama` FROM `matches` WHERE `matchid`='$matchid'"));
					$wic=$wic['wicteama'];
					$result="$news won the match by ".(10-$wic)." wicket/s";
				}
				elseif ($news==$teamb && $inn=='i2') {
					$wic=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `wicteamb` FROM `matches` WHERE `matchid`='$matchid'"));
					$wic=$wic['wicteamb'];
					$result="$news won the match by ".(10-$wic)." wicket/s";
				}
				echo "<table class='pastScoreTable' border='1'>
				<tr>
					<td>$matchid</td>
					<td>$teama VS $teamb</td>
				</tr>
				<tr>
					<td colspan='2'>$result</td>
				</tr>
				</table>";






				if (($news==$teama && $inn=='i1') || ($news==$teamb && $inn=='i2') ) {



					$playersi1Bat=mysqli_query($dbase,"SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `batseq`<>'0' AND `tid`='$teamaid' ORDER BY `batseq` ASC");
					$playersi1Batnp=mysqli_query($dbase,"SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `batseq`='0' AND `tid`='$teamaid' ORDER BY `pid` ASC");
					$playersi2Bowl=mysqli_query($dbase,"SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `bowlseq`<>'0' AND `tid`='$teamaid' ORDER BY `bowlseq` ASC");
					$playersi2Bowlnp=mysqli_query($dbase,"SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `bowlseq`='0' AND `tid`='$teamaid' ORDER BY `pid` ASC");
					$playersi1Bowl=mysqli_query($dbase,"SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `bowlseq`<>'0' AND `tid`='$teambid' ORDER BY `bowlseq` ASC");
					$playersi1Bowlnp=mysqli_query($dbase,"SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `bowlseq`='0' AND `tid`='$teambid' ORDER BY `pid` ASC");
					$playersi2Bat=mysqli_query($dbase,"SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `batseq`<>'0' AND `tid`='$teambid' ORDER BY `batseq` ASC");
					$playersi2Batnp=mysqli_query($dbase,"SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `batseq`='0' AND `tid`='$teambid' ORDER BY `pid` ASC");

				}
				elseif (($news==$teamb && $inn=='i1') || ($news==$teama && $inn=='i2') ) {
					$playersi1Bat=mysqli_query($dbase,"SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `batseq`<>'0' AND `tid`='$teamaid' ORDER BY `batseq` ASC");
					$playersi1Batnp=mysqli_query($dbase,"SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `batseq`='0' AND `tid`='$teamaid' ORDER BY `pid` ASC");
					$playersi2Bowl=mysqli_query($dbase,"SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `bowlseq`<>'0' AND `tid`='$teamaid' ORDER BY `bowlseq` ASC");
					$playersi2Bowlnp=mysqli_query($dbase,"SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `bowlseq`='0' AND `tid`='$teamaid' ORDER BY `pid` ASC");
					$playersi1Bowl=mysqli_query($dbase,"SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `bowlseq`<>'0' AND `tid`='$teambid' ORDER BY `bowlseq` ASC");
					$playersi1Bowlnp=mysqli_query($dbase,"SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `bowlseq`='0' AND `tid`='$teambid' ORDER BY `pid` ASC");
					$playersi2Bat=mysqli_query($dbase,"SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `batseq`<>'0' AND `tid`='$teambid' ORDER BY `batseq` ASC");
					$playersi2Batnp=mysqli_query($dbase,"SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `batseq`='0' AND `tid`='$teambid' ORDER BY `pid` ASC");
				}
				echo "<table class='pastScoreTable'><tr><td colspan='5'>Inning-1 Batting Team</td></tr><tr><td colspan='5'>$teama</td></tr><tr><th>Sr. No.</th><th>Name</th><th>Runs</th><th>Balls</th><th>Wicket By</th></tr>";
				$srno=1;
				while ($player=mysqli_fetch_assoc($playersi1Bat)) {
					$pid=$player['pid'];
					$pname=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `pname`,`pid` FROM `players` WHERE `pid`=$pid"));
					$pname=$pname['pname'];
					$details=mysqli_query($dbase,"SELECT `runs`,`inballs`,`takenby`,`batseq`,`status` FROM `scores` WHERE `pid`='$pid' AND `matchid`='$matchid'") ;
					$details=mysqli_fetch_assoc($details);
					$runs=$details['runs'];
					$inballs=$details['inballs'];
					$takenby=$details['takenby'];
					$batseq=$details['batseq'];
					$bowlerName=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `pname` FROM `players` WHERE `pid`='$takenby'"));
					$bowlerName=$bowlerName['pname'];
					if ($bowlerName=='') {
						if ($batseq!='') {
							$bowlerName='Not Out';
						}
					}
					echo "
					<tr>
						<td>$srno</td>
						<td>$pname</td>
						<td>$runs</td>
						<td>$inballs</td>
						<td>$bowlerName</td>
					</tr>
					";
					$srno++;
				}

				while ($player=mysqli_fetch_assoc($playersi1Batnp)) {
					$pid=$player['pid'];
					$pname=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `pname`,`pid` FROM `players` WHERE `pid`=$pid"));
					$pname=$pname['pname'];
					$details=mysqli_query($dbase,"SELECT `runs`,`inballs`,`takenby`,`batseq`,`status` FROM `scores` WHERE `pid`='$pid' AND `matchid`='$matchid'") ;
					$details=mysqli_fetch_assoc($details);
					$runs=$details['runs'];
					$inballs=$details['inballs'];
					$takenby=$details['takenby'];
					$batseq=$details['batseq'];
					$bowlerName=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `pname` FROM `players` WHERE `pid`='$takenby'"));
					$bowlerName=$bowlerName['pname'];
					$bowlerName='-';
					echo "
					<tr>
						<td>$srno</td>
						<td>$pname</td>
						<td>$runs</td>
						<td>$inballs</td>
						<td>$bowlerName</td>
					</tr>
					";
					$srno++;
				}
				echo "</table>";

				echo "<table class='pastScoreTable'><tr><td colspan='4'>Inning-1 Bowling Team</td></tr><tr><td colspan='4'>$teamb</td></tr><tr><th>Id</th><th>Name</th><th>Overs</th><th>Wickets</th></tr>";
				$srno=1;
				while ($player=mysqli_fetch_assoc($playersi1Bowl)) {
					$pid=$player['pid'];
					$pname=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `pname`,`pid` FROM `players` WHERE `pid`=$pid"));
					$pname=$pname['pname'];
					$details=mysqli_query($dbase,"SELECT `over`,`wicket` FROM `scores` WHERE `pid`='$pid' AND `matchid`='$matchid'") ;
					$details=mysqli_fetch_assoc($details);
					$over=$details['over'];
					$wicket=$details['wicket'];
					echo "
					<tr>
						<td>$srno</td>
						<td>$pname</td>
						<td>$over</td>
						<td>$wicket</td>
					</tr>
					";
					$srno++;
				}

				// while ($player=mysqli_fetch_assoc($playersi1Bowlnp)) {
				// 	$pid=$player['pid'];
				// 	$pname=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `pname`,`pid` FROM `players` WHERE `pid`=$pid"));
				// 	$pname=$pname['pname'];
				// 	$details=mysqli_query($dbase,"SELECT `over`,`wicket` FROM `scores` WHERE `pid`='$pid' AND `matchid`='$matchid'") ;
				// 	$details=mysqli_fetch_assoc($details);
				// 	$over=$details['over'];
				// 	$wicket=$details['wicket'];
				// 	echo "
				// 	<tr>
				// 		<td>$srno</td>
				// 		<td>$pname</td>
				// 		<td>$over</td>
				// 		<td>$wicket</td>
				// 	</tr>
				// 	";
				// 	$srno++;
				// }
				echo "</table>";


				echo "<table class='pastScoreTable'><tr><td colspan='5'>Inning-2 Batting Team</td></tr><tr><td colspan='5'>$teamb</td></tr><tr><th>Id</th><th>Name</th><th>Runs</th><th>Balls</th><th>Wicket By</th></tr>";
				$srno=1;
				while ($player=mysqli_fetch_assoc($playersi2Bat)) {
					$pid=$player['pid'];
					$pname=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `pname`,`pid` FROM `players` WHERE `pid`=$pid"));
					$pname=$pname['pname'];
					$details=mysqli_query($dbase,"SELECT `runs`,`inballs`,`takenby`,`batseq` FROM `scores` WHERE `pid`='$pid' AND `matchid`='$matchid'") ;
					$details=mysqli_fetch_assoc($details);
					$runs=$details['runs'];
					$inballs=$details['inballs'];
					$takenby=$details['takenby'];
					$bowlerName=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `pname` FROM `players` WHERE `pid`='$takenby'"));
					$bowlerName=$bowlerName['pname'];
					if ($bowlerName=='') {
						if ($batseq!='') {
							$bowlerName='Not Out';
						}
					}
					echo "
					<tr>
						<td>$srno</td>
						<td>$pname</td>
						<td>$runs</td>
						<td>$inballs</td>
						<td>$bowlerName</td>
					</tr>
					";
					$srno++;
				}
				while ($player=mysqli_fetch_assoc($playersi2Batnp)) {
					$pid=$player['pid'];
					$pname=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `pname`,`pid` FROM `players` WHERE `pid`=$pid"));
					$pname=$pname['pname'];
					$details=mysqli_query($dbase,"SELECT `runs`,`inballs`,`takenby`,`batseq` FROM `scores` WHERE `pid`='$pid' AND `matchid`='$matchid'") ;
					$details=mysqli_fetch_assoc($details);
					$runs=$details['runs'];
					$inballs=$details['inballs'];
					$takenby=$details['takenby'];
					$bowlerName='-';
					echo "
					<tr>
						<td>$srno</td>
						<td>$pname</td>
						<td>$runs</td>
						<td>$inballs</td>
						<td>$bowlerName</td>
					</tr>
					";
					$srno++;
				}
				echo "</table>";

				echo "<table class='pastScoreTable'><tr><td colspan='4'>Inning-2 Bowling Team</td></tr><tr><td colspan='4'>$teama</td></tr><tr><th>Id</th><th>Name</th><th>Overs</th><th>Wickets</th></tr>";
				$srno=1;
				while ($player=mysqli_fetch_assoc($playersi2Bowl)) {
					$pid=$player['pid'];
					$pname=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `pname`,`pid` FROM `players` WHERE `pid`=$pid"));
					$pname=$pname['pname'];
					$details=mysqli_query($dbase,"SELECT `over`,`wicket` FROM `scores` WHERE `pid`='$pid' AND `matchid`='$matchid'") ;
					$details=mysqli_fetch_assoc($details);
					$over=$details['over'];
					$wicket=$details['wicket'];
					echo "
					<tr>
						<td>$srno</td>
						<td>$pname</td>
						<td>$over</td>
						<td>$wicket</td>
					</tr>
					";
					$srno++;
				}
				// while ($player=mysqli_fetch_assoc($playersi2Bowlnp)) {
				// 	$pid=$player['pid'];
				// 	$pname=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `pname`,`pid` FROM `players` WHERE `pid`=$pid"));
				// 	$pname=$pname['pname'];
				// 	$details=mysqli_query($dbase,"SELECT `over`,`wicket` FROM `scores` WHERE `pid`='$pid' AND `matchid`='$matchid'") ;
				// 	$details=mysqli_fetch_assoc($details);
				// 	$over=$details['over'];
				// 	$wicket=$details['wicket'];
				// 	echo "
				// 	<tr>
				// 		<td>$srno</td>
				// 		<td>$pname</td>
				// 		<td>$over</td>
				// 		<td>$wicket</td>
				// 	</tr>
				// 	";
				// 	$srno++;
				// }
				echo "</table>";
			?>
		</table>
		<div class="button" onclick="location.href='index.php'">Live Scores</div>
	</div>
</body>
</html>