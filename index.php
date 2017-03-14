<?php
$dbase=@mysqli_connect('localhost','root','','crickikeeda') or die("<script>alert('Sorry! Couldn\'t connect to Database')</script>");
$matchid=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `matchid` FROM `matches` WHERE `completed`='0'"));
$matchid=$matchid['matchid'];
if ($matchid=='') 
{
	$print1='Try Again Later!';
	$teamName='No Live Matches!';	
	$batting="";
	$runs='-';
	$over='-';
	$wicket='-';
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
		$batting="Now Batting : $teami1 Inn:1";
	}
	else
	{
		$print1="Target : $target";
		$batting="Now Batting : $teami2 Inn:2";
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
	<meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<div class="userBack"></div>
	<div class="userBlack"></div>
	<h1 class="title">CrickiKeeda Score Table</h1>
	<div class="startContainer">
		<h2 class="matchTeam"><?php echo $teamName; ?></h2>
		<h2 class="matchTeam2">
			<?php echo $print1; ?>
		</h2>
		<h2 class="matchTeam3"><?php echo $batting; ?></h2>
		<table id="userScoreTable">
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
				<form action="index.php" method="post">
					<input type="submit" name="scoreup" class="submitb" value="Refresh" style="background-color: rgba(0,0,0,0.8);">
				</form>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>