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
		$twint=substr($_COOKIE['matchStarted'],0,-3);
		$inn=substr($_COOKIE['matchStarted'],-3,-1);
		$res=substr($_COOKIE['matchStarted'], -1);
		$teams=mysqli_query($dbase,"SELECT `teama`,`teamb` FROM `matches` WHERE matchid='$matchid'");
		$teams=mysqli_fetch_assoc($teams);
		$teamb=$teams['teamb'];
		$teama=$teams['teama'];
		$target=0;
		if (($twint==$teama && $res==1) || ($twint==$teamb && $res==0)) {
			if ($inn=='i1' ) {
				$teami1=$teama;
				$teami2=$teamb;
				$runs=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `runteama` FROM `matches` WHERE `matchid`='$matchid'"));
				$runs=$runs['runteama'];
				$over=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `overteamb` FROM `matches` WHERE `matchid`='$matchid'"));
				$over=$over['overteamb'];
				$wicket=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `wicteama` FROM `matches` WHERE `matchid`='$matchid'"));
				$wicket=$wicket['wicteama'];
			}
			else if ($inn=='i2') {
				$teami1=$teama;
				$teami2=$teamb;
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
				$teami1=$teamb;
				$teami2=$teama;
				$runs=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `runteamb` FROM `matches` WHERE `matchid`='$matchid'"));
				$runs=$runs['runteamb'];
				$over=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `overteama` FROM `matches` WHERE `matchid`='$matchid'"));
				$over=$over['overteama'];
				$wicket=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `wicteamb` FROM `matches` WHERE `matchid`='$matchid'"));
				$wicket=$wicket['wicteamb'];
			}
			else if ($inn=='i2') {
				$teami1=$teamb;
				$teami2=$teama;
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
		if (isset($_POST['update'])) {
			$run=$_POST['runs'];
			$del=$_POST['del'];
			if ($del=='fair') {
				$runs+=$run;
				if (intval($over*10)%5 == 0 &&  intval($over*10)%10 != 0) {
					$over+=0.5;
				}
				else{
					$over+=0.1;
				}
			}
			elseif ($del=='wide' || $del=='noball') {
				$runs+=($run+1);
			}
			elseif($del=='wicket'){
				$runs+=$run;
				$wicket+=1;
				if (intval($over*10)%5 == 0 &&  intval($over*10)%10 != 0) {
					$over+=0.5;
				}
				else{
					$over+=0.1;
				}
				
			}
			if (($twint==$teama && $res==1) || ($twint==$teamb && $res==0)) {
				if ($inn=='i1' ) {
					mysqli_query($dbase,"UPDATE `matches` SET `runteama`='$runs' WHERE `matchid`='$matchid' ");
					mysqli_query($dbase,"UPDATE `matches` SET `overteamb`='$over' WHERE `matchid`='$matchid' ");
					mysqli_query($dbase,"UPDATE `matches` SET `wicteama`='$wicket' WHERE `matchid`='$matchid' ");
				}
				else if ($inn=='i2') {
					mysqli_query($dbase,"UPDATE `matches` SET `runteamb`='$runs' WHERE `matchid`='$matchid' ");
					mysqli_query($dbase,"UPDATE `matches` SET `overteama`='$over' WHERE `matchid`='$matchid' ");
					mysqli_query($dbase,"UPDATE `matches` SET `wicteamb`='$wicket' WHERE `matchid`='$matchid' ");
				}
			}
			elseif (($twint==$teama && $res==0) || ($twint==$teamb && $res==1)) {
				if ($inn=='i1' ) {
					mysqli_query($dbase,"UPDATE `matches` SET `runteamb`='$runs' WHERE `matchid`='$matchid' ");
					mysqli_query($dbase,"UPDATE `matches` SET `overteama`='$over' WHERE `matchid`='$matchid' ");
					mysqli_query($dbase,"UPDATE `matches` SET `wicteamb`='$wicket' WHERE `matchid`='$matchid' ");
				}
				else if ($inn=='i2') {
					mysqli_query($dbase,"UPDATE `matches` SET `runteama`='$runs' WHERE `matchid`='$matchid' ");
					mysqli_query($dbase,"UPDATE `matches` SET `overteamb`='$over' WHERE `matchid`='$matchid' ");
					mysqli_query($dbase,"UPDATE `matches` SET `wicteama`='$wicket' WHERE `matchid`='$matchid' ");
				}
			}
			if (($over==12.0 || $wicket==10) && $inn=='i1') {
				setcookie('matchStarted',$twint.'i2'.$res,time()+60*60);
				header("Location:admin.php");
			}
			else if(($over==12.0 || $wicket==10) && $inn=='i2')
			{
				if ($runs>=$target) {
					mysqli_query($dbase,"UPDATE `matches` SET `news`='$teami2' WHERE `matchid`='$matchid' ");
				}
				else
				{
					mysqli_query($dbase,"UPDATE `matches` SET `news`='$teami1' WHERE `matchid`='$matchid' ");
				}
				mysqli_query($dbase,"UPDATE `matches` SET `completed`='1' WHERE `matchid`='$matchid' ");
				setcookie('adminbro',$matchid+1,time()+5*22*60*60);
				setcookie('matchStarted',0,time()-60);
				header("Location:startMatch.php");
			}
			else if(($runs>=$target) && $inn=='i2')
			{
				mysqli_query($dbase,"UPDATE `matches` SET `news`='$teami2' WHERE `matchid`='$matchid' ");
				mysqli_query($dbase,"UPDATE `matches` SET `completed`='1' WHERE `matchid`='$matchid' ");
				setcookie('adminbro',$matchid+1,time()+5*22*60*60);
				setcookie('matchStarted',0,time()-60);
				header("Location:startMatch.php");
			}
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
</head>
<body>
<div class="mainBack"></div>
<div class="mainBlack"></div>
<h1 class="title">CrickiKeeda Score Table</h1>
<div id="scoreEdit">
	<div class="myrow">
		<div class="col-5 col-m-12">
			<table id="scoreAdminTable">
				<tr>
					<td colspan="2">
						<p>
							<?php
								if ($inn=='i1') {
									if ($res==0) {
										$result='ball';
									}
									else{
										$result='bat';
									}
									echo "$twint won the toss and choose to $result first";
								}
								else{
									echo "Target : $target";
								}
							?>
						</p>
					</td>
				</tr>
				<tr>
					<td><b>Runs&nbsp: </b></td>
					<td><b><?php echo $runs ?></b></td>
				</tr>
				<tr>
					<td><b>Overs&nbsp: </b></td>
					<td><b><?php echo $over ?>&nbsp/&nbsp12.0</b></td>
				</tr>
				<tr>
					<td><b>Wickets&nbsp: </b></td>
					<td><b><?php echo $wicket ?>&nbsp/&nbsp10</b></td>
				</tr>
			</table>
		</div>
		<div class="col-7 col-m-12">
			<form action="admin.php" method="post">
				<table id="scoreEditTable">
					<tr>
						<td><label>Runs&nbsp: </label></td>
						<td>
							<input type="radio" name="runs" value="0" checked>&nbsp+0
							<input type="radio" name="runs" value="1">&nbsp+1
							<input type="radio" name="runs" value="2">&nbsp+2
							<input type="radio" name="runs" value="3">&nbsp+3<br>
							<input type="radio" name="runs" value="4">&nbsp+4
							<input type="radio" name="runs" value="5">&nbsp+5
							<input type="radio" name="runs" value="6">&nbsp+6
							<input type="radio" name="runs" value="7">&nbsp+7
						</td>
					</tr>
					<tr>
						<td><label>Delivery&nbsp: </label></td>
						<td>
							<input type="radio" name="del" value="fair" checked>&nbspFair&nbsp<br>
							<input type="radio" name="del" value="wide">&nbspWide&nbsp
							<input type="radio" name="del" value="noball">&nbspNo&nbspBall&nbsp<br>
							<input type="radio" name="del" value="wicket">&nbspWicket&nbsp
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" name="update" value="Update" class="submitb"></td>
					</tr>
					<tr>
						<td colspan="2"><div id="correctDiv">Need Correction</div></td>
					</tr>
					<tr>
						<td colspan="2"><div id="correctDiv">New Match</div></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>

</body>
</html>