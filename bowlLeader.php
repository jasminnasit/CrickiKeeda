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
	<h1 class="title">Batsman LeaderBoard</h1>
	<div class="startContainer">
		<input type='text' class='search' name='search' placeholder='Search Player' onkeyup='search(this.value)'>
		<div id="searchResult">
			<?php
				include 'dbconfig.php';
				$rank=1;
				$playerData2=mysqli_query($dbase,"SELECT * FROM `players` WHERE `twicket`<>'0' ORDER BY `twicket` DESC ");
				echo "<table class='pastScoreTable'><tr><th>Rank</th><th>Name</th><th>Total Wickets</th></tr>";
				while ($player=mysqli_fetch_assoc($playerData2)) {
					$playerName=$player['pname'];
					$totalWicket=$player['twicket'];
					echo "
					<tr>
						<td>$rank</td>
						<td>$playerName</td>
						<td>$totalWicket</td>
					</tr>
					";
					$rank++;
				}
		echo "</table>";
			?>
		</div>
	</div>
</body>
<script type="text/javascript">
	function search(val1)
	{
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("searchResult").innerHTML = this.responseText;
			}
		};
		xhttp.open("GET", "ajax/searchBowler.php?name="+val1, true);
		xhttp.send();
	}
</script>
</html>