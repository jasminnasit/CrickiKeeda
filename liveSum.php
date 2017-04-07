<?php
$dbase=@mysqli_connect('localhost','root','','crickikeeda') or die("<script>alert('Sorry! Couldn\'t connect to Database')</script>");
$matchid=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `matchid` FROM `matches` WHERE `completed` LIKE '0__'"));
$matchid=$matchid['matchid'];
if ($matchid=='') 
{
	$matchid=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT max(`matchid`) FROM `matches` WHERE `completed` = '1'"));
	$matchid=$matchid['max(`matchid`)'];
	if ($matchid=='') {
		header("Location:index.php");
	}
	else{
		header("Location:pastScore.php");
	}
}
else
{
	require_once ("userScore.php");
	if ($inn=='i1') 
	{
		if ($res==0) 
		{
			$result='ball';
		}
		else
		{
			$result='bat';
		}
		$print1="$twint won the toss and choose to $result first\n";
		$batting="Now Batting : $teami1-->Inn:1";
	}
	else
	{
		$print1="Target : $target";
		$batting="Now Batting : $teami2-->Inn:2";
	}
	$teamName="$teama VS $teamb";
}
$page = $_SERVER['PHP_SELF'];
$sec = "30";
?>
<!DOCTYPE html>
<html>
<head>
	<title>CrickiKeeda</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
</head>
<body>
	<div class="userBack"></div>
	<div class="userBlack"></div>
	<h1 class="title">Live Match Summary</h1>
	<div class="startContainer">
		<h2 class="matchTeam"><?php echo $teamName; ?></h2>
		<h2 class="matchTeam2">
			<?php echo $print1; ?>
		</h2>
		<h2 class="matchTeam3"><?php echo $batting; ?></h2>
		<table class="pastScoreTable">
			<tr>
				<td>Runs : </td>
				<td><?php echo $runs; ?></td>
			</tr>
			<tr>
				<td>Over : </td>
				<td><?php echo $over; ?>/12.0</td>
			</tr>
			<tr>
				<td>Wicket : </td>
				<td><?php echo $wicket; ?>/10</td>
			</tr>
			<tr>
					<td colspan="2">
						<?php
						$bat1=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `runs`,`inballs`,`pname` FROM `scores` NATURAL JOIN `players` WHERE `status`='11' AND `matchid`='$matchid'"));
						$name=$bat1['pname'];
						$runs=$bat1['runs'];
						$inballs=$bat1['inballs'];
						echo "Batting* : $name --> $runs($inballs)";
						?>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<?php
						$bat2=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `runs`,`inballs`,`pname` FROM `scores` NATURAL JOIN `players` WHERE `status`='10' AND `matchid`='$matchid'"));
						$name=$bat2['pname'];
						$runs=$bat2['runs'];
						$inballs=$bat2['inballs'];
						echo "Batting : $name --> $runs($inballs)";
						?>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<?php
						$bowl=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `pname` FROM `scores` NATURAL JOIN `players` WHERE `status`='01' AND `matchid`='$matchid'"));
						$bowl=$bowl['pname'];
						echo "Bowling : $bowl";
						?>
					</td>
				</tr>
			<tr>
				<td colspan="2"><?php echo "<span style='font-size:20px;'>$lastover</span>";?></td>
			</tr>
		</table>
		<?php
		$teami1id=substr($teami1,0,strpos($teami1,'-'));
		$teami2id=substr($teami2,0,strpos($teami2,'-'));
		$playersi1Bat=mysqli_query($dbase,"SELECT `pname`,`pid` FROM `players` WHERE `pid` IN (SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `tid`='$teami1id')");
		$playersi2Bowl=mysqli_query($dbase,"SELECT `pname`,`pid` FROM `players` WHERE `pid` IN (SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `tid`='$teami1id')");;
		$playersi1Bowl=mysqli_query($dbase,"SELECT `pname`,`pid` FROM `players` WHERE `pid` IN (SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `tid`='$teami2id')");
		$playersi2Bat=mysqli_query($dbase,"SELECT `pname`,`pid` FROM `players` WHERE `pid` IN (SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `tid`='$teami2id')");;

		echo "<table class='pastScoreTable'><tr><td colspan='5'>Inning-1 Batting Team</td></tr><tr><td colspan='5'>$teama</td></tr><tr><th>Id</th><th>Name</th><th>Runs</th><th>Balls</th><th>Wicket By</th></tr>";
		while ($player=mysqli_fetch_assoc($playersi1Bat)) {
			$pid=$player['pid'];
			$pname=$player['pname'];
			$details=mysqli_query($dbase,"SELECT `runs`,`inballs`,`takenby` FROM `scores` WHERE `pid`='$pid' AND `matchid`='$matchid'") ;
			$details=mysqli_fetch_assoc($details);
			$runs=$details['runs'];
			$inballs=$details['inballs'];
			$takenby=$details['takenby'];
			$bowlerName=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `pname` FROM `players` WHERE `pid`='$takenby'"));
			$bowlerName=$bowlerName['pname'];
			echo "
			<tr>
				<td>$pid</td>
				<td>$pname</td>
				<td>$runs</td>
				<td>$inballs</td>
				<td>$bowlerName</td>
			</tr>
			";
		}
		echo "</table>";

		echo "<table class='pastScoreTable'><tr><td colspan='4'>Inning-1 Bowling Team</td></tr><tr><td colspan='4'>$teamb</td></tr><tr><th>Id</th><th>Name</th><th>Overs</th><th>Wickets</th></tr>";
		while ($player=mysqli_fetch_assoc($playersi1Bowl)) {
			$pid=$player['pid'];
			$pname=$player['pname'];
			$details=mysqli_query($dbase,"SELECT `over`,`wicket` FROM `scores` WHERE `pid`='$pid' AND `matchid`='$matchid'") ;
			$details=mysqli_fetch_assoc($details);
			$over=$details['over'];
			$wicket=$details['wicket'];
			echo "
			<tr>
				<td>$pid</td>
				<td>$pname</td>
				<td>$over</td>
				<td>$wicket</td>
			</tr>
			";
		}
		echo "</table>";


		if ($inn=='i2') {
			echo "<table class='pastScoreTable'><tr><td colspan='5'>Inning-2 Batting Team</td></tr><tr><td colspan='5'>$teamb</td></tr><tr><th>Id</th><th>Name</th><th>Runs</th><th>Balls</th><th>Wicket By</th></tr>";
			while ($player=mysqli_fetch_assoc($playersi2Bat)) {
				$pid=$player['pid'];
				$pname=$player['pname'];
				$details=mysqli_query($dbase,"SELECT `runs`,`inballs`,`takenby` FROM `scores` WHERE `pid`='$pid' AND `matchid`='$matchid'") ;
				$details=mysqli_fetch_assoc($details);
				$runs=$details['runs'];
				$inballs=$details['inballs'];
				$takenby=$details['takenby'];
				$bowlerName=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `pname` FROM `players` WHERE `pid`='$takenby'"));
				$bowlerName=$bowlerName['pname'];
				echo "
				<tr>
					<td>$pid</td>
					<td>$pname</td>
					<td>$runs</td>
					<td>$inballs</td>
					<td>$bowlerName</td>
				</tr>
				";
			}
			echo "</table>";

			echo "<table class='pastScoreTable'><tr><td colspan='4'>Inning-2 Bowling Team</td></tr><tr><td colspan='4'>$teama</td></tr><tr><th>Id</th><th>Name</th><th>Overs</th><th>Wickets</th></tr>";
			while ($player=mysqli_fetch_assoc($playersi2Bowl)) {
				$pid=$player['pid'];
				$pname=$player['pname'];
				$details=mysqli_query($dbase,"SELECT `over`,`wicket` FROM `scores` WHERE `pid`='$pid' AND `matchid`='$matchid'") ;
				$details=mysqli_fetch_assoc($details);
				$over=$details['over'];
				$wicket=$details['wicket'];

				echo "
				<tr>
					<td>$pid</td>
					<td>$pname</td>
					<td>$over</td>
					<td>$wicket</td>
				</tr>
				";
			}
			echo "</table>";	
		}	
		?>
	</div>
</body>
</html>