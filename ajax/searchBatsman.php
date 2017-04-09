<?php
	include '../dbconfig.php';
	$data = $_GET["name"];
	$rank=1;
	$found=0;
	$tableData='';
	$playerData=mysqli_query($dbase,"SELECT * FROM `players` WHERE `truns`<>'0' ORDER BY `truns` DESC ");
	$playerData2=mysqli_query($dbase,"SELECT * FROM `players` WHERE `truns`<>'0' ORDER BY `truns` DESC ");
	while ($player=mysqli_fetch_assoc($playerData)) {
		$playerName=$player['pname'];
		$totalRuns=$player['truns'];
		if (stripos($playerName,$data)===0) {
			$found=1;
			$tableData.= "
				<tr>
					<td>$rank</td>
					<td>$playerName</td>
					<td>$totalRuns</td>
				</tr>
				";
		}
		$rank++;
	}

	if ($found===1) {
		echo "<table class='pastScoreTable'><tr><th>Rank</th><th>Name</th><th>Total Runs</th></tr>";
		echo "$tableData";
		echo "</table>";
	}
	else
	{
		$rank=1;
		echo "<table class='pastScoreTable'><tr><td colspan='3' style='color: #f44336;'>No Player Found!Showing LeaderBoard</td></tr><tr><th>Rank</th><th>Name</th><th>Total Runs</th></tr>";
		while ($player=mysqli_fetch_assoc($playerData2)) {
			$playerName=$player['pname'];
			$totalRuns=$player['truns'];
			echo "
			<tr>
				<td>$rank</td>
				<td>$playerName</td>
				<td>$totalRuns</td>
			</tr>
			";
			$rank++;
		}
		echo "</table>";
	}
?>