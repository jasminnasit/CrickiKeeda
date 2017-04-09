<?php
	//error_reporting(~E_ALL);
	if (!isset($_COOKIE['adminbro'])) 
	{
		header('Location:adminl.php');
	}
	else if (!isset($_COOKIE['matchStarted']))
	{
		header('Location:startMatch.php');
	}
	else
	{
		$matchid=$_COOKIE['adminbro'];
		$dbase=@mysqli_connect('localhost','root','','crickikeeda') or die("<script>alert('Sorry! Couldn\'t connect to Database')</script>");
		$teams=mysqli_query($dbase,"SELECT `teama`,`teamb` FROM `matches` WHERE `matchid`='$matchid'");
		$teams=mysqli_fetch_assoc($teams);
		$teamb=$teams['teamb'];
		$teama=$teams['teama'];
		$teamna=substr($teama,strpos($teama,'-')+1);
		$teamnb=substr($teamb,strpos($teamb,'-')+1);
		$teama=substr($teama,0,strpos($teama,'-'));
		$teamb=substr($teamb,0,strpos($teamb,'-'));
		$playersa=mysqli_query($dbase,"SELECT `pid`,`pname` FROM `players` NATURAL JOIN `teamalloc` WHERE `tid`='$teama'");
		$playersb=mysqli_query($dbase,"SELECT `pid`,`pname` FROM `players` NATURAL JOIN `teamalloc` WHERE `tid`='$teamb'");

		if (isset($_POST['select'])) 
		{
			$playersa=$_POST['playersa'];
			$playersb=$_POST['playersb'];
			foreach ($playersa as $player) {
				mysqli_query($dbase,"INSERT INTO `scores` VALUES ('$matchid','$player','0','0','0','0','','','','')") or die();
			}
			foreach ($playersb as $player) {
				mysqli_query($dbase,"INSERT INTO `scores` VALUES ('$matchid','$player','0','0','0','0','','','','')");
			}
			header("Location:admin.php");
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
	<meta name="theme-color" content="rgba(0,0,0,0.8)" />
</head>
<body>
<div class="mainBack"></div>
<div class="mainBlack"></div>
<h1 class="title">Selection Panel</h1>
<div class="scoreEdit">
	<form onsubmit="return verifyPls()" action="selectpl.php" method="post">
	<div class="myrow">
		<div class="col-6 col-mb-12">
			<table class="selectplTable" border="1">
				<tr>
					<td colspan="2">
						<span class='errors errorofpa'>Select Only 11 Players</span>
					</td>
				</tr>
				<tr>
					<td colspan="2">Select 11 Players of <?php echo "$teamna"; ?></td>
				</tr>
				<?php
					$cnt=0;
					while ($player=mysqli_fetch_assoc($playersa)) {
						$pid=$player['pid'];
						$name=$player['pname'];
						$cnt++;
						if ($cnt<=11) {
							$checked="checked";
						}
						else{
							$checked="";
						}
						echo "<tr>
							<td><input type='checkbox' class='playersa' name='playersa[]' value='$pid' $checked></td>
							<td>$name</td>
						</tr>";
					}
				?>
			</table>
		</div>
		<div class="col-6 col-mb-12">
			<table class="selectplTable" border="1" id="pl2tb">
				<tr>
					<td colspan="2">
						<span class='errors errorofpb'>Select Only 11 Players</span>
					</td>
				</tr>
				<tr>
					<td colspan="2">Select 11 Players of <?php echo "$teamnb"; ?></td>
				</tr>
				<?php
					$cnt=0;;
					while ($player=mysqli_fetch_assoc($playersb)){
						$name=$player['pname'];
						$pid=$player['pid'];
						$cnt++;
						if ($cnt<=11) {
							$checked="checked";
						}
						else{
							$checked="";
						}
						echo "<tr>
							<td><input type='checkbox'  class='playersb' name='playersb[]' value='$pid' $checked></td>
							<td>$name</td>
						</tr>";
					}
				?>
			</table>
		</div>
	</div>
	<input type="submit" name="select" value="OK" class="submitb">
	</form>
</div>
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/verify.js"></script>
</body>
</html>