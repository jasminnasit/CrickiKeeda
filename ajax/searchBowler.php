<?php
	include '../dbconfig.php';
	$data = $_GET["name"];
	$rank=1;
	$found=0;
	$tableData='';
	$playerData=mysqli_query($dbase,"SELECT * FROM `players` WHERE `twicket`<>'0' ORDER BY `twicket` DESC ");
	$playerData2=mysqli_query($dbase,"SELECT * FROM `players` WHERE `twicket`<>'0' ORDER BY `twicket` DESC ");
	while ($player=mysqli_fetch_assoc($playerData)) {
		$playerName=$player['pname'];
		$totalWicket=$player['twicket'];
		if (stripos($playerName,$data)===0) {
			$found=1;
			$tableData.= "
				<tr>
					<td>$rank</td>
					<td>$playerName</td>
					<td>$totalWicket</td>
				</tr>
				";
		}
		$rank++;
	}

	if ($found===1) {
		echo "<table class='pastScoreTable'><tr><th>Rank</th><th>Name</th><th>Total Wickets</th></tr>";
		echo "$tableData";
		echo "</table>";
	}
	else
	{
		$rank=1;
		echo "<table class='pastScoreTable'><tr><td colspan='3' style='color: red;'>No Player Found!Showing LeaderBoard</td></tr><tr><th>Rank</th><th>Name</th><th>Total Wickets</th></tr>";
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
	}
?>