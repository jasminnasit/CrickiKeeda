<?php
	if (!isset($_COOKIE['adminbro'])) {
		header('Location:adminl.php');
	}
	else
	{
		if (isset($_COOKIE['matchStarted'])) {
			header('Location:selectpl.php');
		}
		else
		{
			$dbase=@mysqli_connect('localhost','root','','crickikeeda') or die("<script>alert('Sorry! Couldn\'t connect to Database')</script>");
			$teams=mysqli_query($dbase,"SELECT * FROM `teams`");
			$teams2=mysqli_query($dbase,"SELECT * FROM `teams`");
			if (isset($_POST['submitMatch']))
			{
				$matchid=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `matchid` FROM `matches` WHERE `completed` LIKE '0__'"));
				$matchid=$matchid['matchid'];
				if ($matchid!='') {
					$news=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `news` FROM `matches` WHERE `matchid`='$matchid'"));
					$news=$news['news'];
					setcookie('matchStarted',$news,time()+2*60*60);
					setcookie('mistake','adminBewafa',time()+5);
					header('Location:admin.php');
				}
				else
				{
					$teama=$_POST['teama'];
					$teamb=$_POST['teamb'];
					$twint=$_POST['twint'];
					$batball=$_POST['batball'];
					if ($batball=='bat') {
						$res=1;
					}
					elseif ($batball=='ball') {
						$res=0;
					}
					$cookie=$twint.'i1'.$res;
					$matchid=$_COOKIE['adminbro'];
					mysqli_query($dbase,"INSERT INTO matches (`matchid`,`teama`,`teamb`,`runteama`,`runteamb`,`overteama`,`overteamb`,`wicteama`,`wicteamb`,`completed`,`news`,`lastover`) VALUES ('$matchid','$teama','$teamb','0','0','0.0','0.0','0','0','000','$cookie','n')");
					setcookie('matchStarted',$cookie,time()+2*60*60);
					setcookie('lastball',"0,0,0,n",time()+10*60);
					header('Location:selectpl.php');
				}
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Start Match</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="rgba(0,0,0,0.8)" />
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>
<body>
<div class="mainBack"></div>
<div class="mainBlack"></div>
<h1 class="titlestart">CrickiKeeda Match Selector</h1>
<div class="startContainer">
	<span class='errors'>Same Teams Not Allowed</span>
	<form id="matchTeams" method="post" action="startMatch.php" onsubmit="return checkTeams();">
		<table id="startTable">
			<tr>
				<td class="starttd">
					<select class="teamc" name="teama" id="teama">
					<?php
						while ($team1=mysqli_fetch_assoc($teams)) {
							$id=$team1['tid'];
							$name=$team1['tname'];
							echo "<option value='$id-$name'>$id-$name</option>";
						}
					?>
					</select>
				</td>
				<td class="starttd">
					<select class="teamc" name="teamb" id="teamb">
					<?php
						while ($team1=mysqli_fetch_assoc($teams2)) {
							$id=$team1['tid'];
							$name=$team1['tname'];
							if ($id==2) {
								$selected="selected";
							}
							else
							{
								$selected='';
							}
							echo "<option value='$id-$name' $selected>$id-$name</option>";
						}
					?>
					</select>
				</td>
			</tr>
			<!-- <tr>
				<td colspan="2" class="starttd">
					<span class='errorst'>Select Wining Team</span>
				</td>
			</tr> -->
			<tr>
				<td class="starttd"><p>Which Team Won Toss?</p></td>
				<td class="starttd">
					<input type="radio" name="twint" id="teamai" value="1-Team1" checked><span id="teamac">1-Team1</span><br>
					<input type="radio" name="twint" id="teambi" value="2-Team2"><span id="teambc">2-Team2</span>
				</td>
			</tr>
			<!-- <tr>
				<td colspan="2" class="starttd">
					<span class='errorstc'>Wining Team Decision?</span>
				</td>
			</tr> -->
			<tr>
				<td class="starttd"><p>What Toss winning Team choose?</p></td>
				<td class="starttd">
					<input type="radio" name="batball" value="bat" checked>Bat<br>
					<input type="radio" name="batball" value="ball">Ball
				</td>
			</tr>
			<tr>
				<td class="starttd" colspan="2">
					<input type="submit" name="submitMatch" value="Start" class="submitb">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<button type="button" class="submitb" onclick="location.href='teamregister.php'">Register Team</button>
				</td>
			</tr>
		</table>
	</form>
</div>
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/int.js"></script>
</body>
</html>