<?php
require_once ("userScore.php");
$page = $_SERVER['PHP_SELF'];
$sec = "10";
if (!isset($_COOKIE['matchno'])) {
	setcookie('matchno',0,time()+$sec+1);
}
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
		<h2 class="matchTeam"><?php echo "$teama VS $teamb"; ?></h2>
		<h2 class="matchTeam2">
			<?php
					if ($inn=='i1') {
						if ($res==0) {
							$result='ball';
						}
						else{
							$result='bat';
						}
					echo "$twint won the toss and choose to $result first\n";
					}
					else{
						echo "Target : $target";
					}
				?>
		</h2>
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
		</table>
	</div>
</body>
</html>