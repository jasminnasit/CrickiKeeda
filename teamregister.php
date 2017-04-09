<?php
if (!isset($_COOKIE['adminbro'])) {
	header("Location:adminl.php");
}
if (isset($_POST['register'])) {
	$i=0;
	$t1=$_POST['tname1'];
	$p=array();
	$p[0]=$_POST['pname1'];
	$p[1]=$_POST['pname2'];
	$p[2]=$_POST['pname3'];
	$p[3]=$_POST['pname4'];
	$p[4]=$_POST['pname5'];
	$p[5]=$_POST['pname6'];
	$p[6]=$_POST['pname7'];
    $p[7]=$_POST['pname8'];
    $p[8]=$_POST['pname9'];
   $p[9]=$_POST['pname10'];
   $p[10]=$_POST['pname11'];
   $p[11]=$_POST['pname12'];
   $p[12]=$_POST['pname13'];
   $p[13]=$_POST['pname14'];
   $p[14]=$_POST['pname15'];
	$dtbs=@mysqli_connect('localhost','root','','CrickiKeeda') or die("<script>alert('Sorry! Couldn\'t connect to Database')</script>");
	$dt=@mysqli_query($dtbs,"SELECT max(`tid`) FROM `teams`");
	$dt=mysqli_fetch_assoc($dt);
	$dt=$dt['max(`tid`)'];
	$dt++;
	mysqli_query($dtbs,"INSERT INTO teams (`tid`,`tname`) VALUES ('$dt','$t1')");	
	$pl=@mysqli_query($dtbs,"SELECT max(`pid`) FROM `Players`");
	$pl=mysqli_fetch_assoc($pl);
	$pl=$pl['max(`pid`)'];
	while ( $i<15) {
	      $pl++;
	      mysqli_query($dtbs,"INSERT INTO Players (`pid`,`pname`,`truns`,`tover`,`twicket`) VALUES ('$pl','$p[$i]','0','0','0')");
	      mysqli_query($dtbs,"INSERT INTO teamalloc (`tid`,`pid`) VALUES ('$dt','$pl')");
	      $i++;
	}
	header("Location: startMatch.php");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Team Registration</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="rgba(0,0,0,0.8)" />
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
	<script src="js/jquery-3.1.1.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
</head>
<body>
<div class="mainBack"></div>
<div class="mainBlack"></div>
<h1 class="title">CrickiKeeda</h1>
<div class="startContainer">
	<form class="teamname" onsubmit="return chk();" method="post" action="teamregister.php">
		<table id="logTable">
		    <tr><td colspan="2" style="text-align: center;"><h2>Team Registration</h2></td></tr>
		    <tr>
		    	<td><label for="t1name">TEAM NAME:</label></td>
		    	<td class="adminip"><input type="text" autocomplete="off" name="tname1" class="t1n" placeholder="Team Name"></td>
		    </tr>
			<tr>
				<td><label>Player 1:</label></td>
				<td class="adminip"><input type="text" autocomplete="off" name="pname1" class="pn1" placeholder="Player1"></td>
			</tr>
			<tr>
				<td><label>Player 2:</label></td>
				<td class="adminip"><input type="text" autocomplete="off" name="pname2" class="pn2" placeholder="Player2"></td>
			</tr>
			<tr>
				<td><label>Player 3:</label></td>
				<td class="adminip"><input type="text" autocomplete="off" name="pname3" class="pn3" placeholder="Player3"></td>
			</tr>
			<tr>
				<td><label>Player 4:</label></td>
				<td class="adminip"><input type="text" autocomplete="off" name="pname4" class="pn4" placeholder="Player4"></td>
			</tr>
			<tr>
				<td><label>Player 5:</label></td>
				<td class="adminip"><input type="text" autocomplete="off" name="pname5" class="pn5" placeholder="Player5"></td>
			</tr>
			<tr>
				<td><label>Player 6:</label></td>
				<td class="adminip"><input type="text" autocomplete="off" name="pname6" class="pn6" placeholder="Player6"></td>
			</tr>
			<tr>
				<td><label>Player 7:</label></td>
				<td class="adminip"><input type="text" autocomplete="off" name="pname7" class="pn7" placeholder="Player7"></td>
			</tr>
			<tr>
				<td><label>Player 8:</label></td>
				<td class="adminip"><input type="text" autocomplete="off" name="pname8" class="pn8" placeholder="Player8"></td>
			</tr>
			<tr>
				<td><label>Player 9:</label></td>
				<td class="adminip"><input type="text" autocomplete="off" name="pname9" class="pn9" placeholder="Player9"></td>
			</tr>
			<tr>
				<td><label>Player 10:</label></td>
				<td class="adminip"><input type="text" autocomplete="off" name="pname10" class="pn10" placeholder="Player10"></td>
			</tr>
			<tr>
				<td><label>Player 11:</label></td>
				<td class="adminip"><input type="text" autocomplete="off" name="pname11" class="pn11" placeholder="Player11"></td>
			</tr>
			<tr>
				<td><label>Player 12:</label></td>
				<td class="adminip"><input type="text" autocomplete="off" name="pname12" class="pn12" placeholder="Player12"></td>
			</tr>
			<tr>
				<td><label>Player 13:</label></td>
				<td class="adminip"><input type="text" autocomplete="off" name="pname13" class="pn13" placeholder="Player13"></td>
			</tr>
			<tr>
				<td><label>Player 14:</label></td>
				<td class="adminip"><input type="text" autocomplete="off" name="pname14" class="pn14" placeholder="Player14"></td>
			</tr>
			<tr>
				<td><label>Player 15:</label></td>
				<td class="adminip"><input type="text" autocomplete="off" name="pname15" class="pn15" placeholder="Player15"></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="register" value="Register" class="submitb"></td>
			</tr>
		</table>
		
	</form>
</div>


</body>
<script type="text/javascript">
	$(document).ready(function(){
		$(".t1n").on("input",function(){
			if($(".t1n").val()=='' ||$(".t1n").val().length<='4'||$(".t1n").val().length>'30' )
			{
				if($(".eort").val()!='')
				{
					$(".t1n").before("<span class='err eort'>Team Name should be of 5-30 character</span>");
				}
			}
			else
			{
				if($(".eort").val()=='')
				{
					$(".eort").remove();
				}
			}
		});
		$(".pn1").on("input",function(){
			if($(".pn1").val()==''||$(".pn1").val().length<='2'||$(".pn1").val().length>'30')
			{
				if($(".eor1").val()!='')
				{
					$(".pn1").before("<span class='err eor1'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor1").val()=='')
				{
					$(".eor1").remove();
				}
			}
		});
		$(".pn2").on("input",function(){
			if($(".pn2").val()==''||$(".pn2").val().length<='2'||$(".pn2").val().length>'30')
			{
				if($(".eor2").val()!='')
				{
					$(".pn2").before("<span class='err eor2'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor2").val()=='')
				{
					$(".eor2").remove();
				}
			}
		});
		$(".pn3").on("input",function(){
			if($(".pn3").val()==''||$(".pn3").val().length<='2'||$(".pn3").val().length>'30')
			{
				if($(".eor3").val()!='')
				{
					$(".pn3").before("<span class='err eor3'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor3").val()=='')
				{
					$(".eor3").remove();
				}
			}
		});
		$(".pn4").on("input",function(){
			if($(".pn4").val()==''||$(".pn4").val().length<='2'||$(".pn4").val().length>'30')
			{
				if($(".eor4").val()!='')
				{
					$(".pn4").before("<span class='err eor4'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor4").val()=='')
				{
					$(".eor4").remove();
				}
			}
		});
		$(".pn5").on("input",function(){
			if($(".pn5").val()==''||$(".pn5").val().length<='2'||$(".pn5").val().length>'30')
			{
				if($(".eor5").val()!='')
				{
					$(".pn5").before("<span class='err eor5'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor5").val()=='')
				{
					$(".eor5").remove();
				}
			}
		});
		$(".pn6").on("input",function(){
			if($(".pn6").val()==''||$(".pn6").val().length<='2'||$(".pn6").val().length>'30')
			{
				if($(".eor6").val()!='')
				{
					$(".pn6").before("<span class='err eor6'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor6").val()=='')
				{
					$(".eor6").remove();
				}
			}
		});
		$(".pn7").on("input",function(){
			if($(".pn7").val()==''||$(".pn7").val().length<='2'||$(".pn7").val().length>'30')
			{
				if($(".eor7").val()!='')
				{
					$(".pn7").before("<span class='err eor7'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor7").val()=='')
				{
					$(".eor7").remove();
				}
			}
		});
		$(".pn8").on("input",function(){
			if($(".pn8").val()==''||$(".pn8").val().length<='2'||$(".pn8").val().length>'30')
			{
				if($(".eor8").val()!='')
				{
					$(".pn8").before("<span class='err eor8'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor8").val()=='')
				{
					$(".eor8").remove();
				}
			}
		});
		$(".pn9").on("input",function(){
			if($(".pn9").val()==''||$(".pn9").val().length<='2'||$(".pn9").val().length>'30')
			{
				if($(".eor9").val()!='')
				{
					$(".pn9").before("<span class='err eor9'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor9").val()=='')
				{
					$(".eor9").remove();
				}
			}
		});
		$(".pn10").on("input",function(){
			if($(".pn10").val()==''||$(".pn10").val().length<='2'||$(".pn10").val().length>'30')
			{
				if($(".eor10").val()!='')
				{
					$(".pn10").before("<span class='err eor10'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor10").val()=='')
				{
					$(".eor10").remove();
				}
			}
		});
		$(".pn11").on("input",function(){
			if($(".pn11").val()==''||$(".pn11").val().length<='2'||$(".pn11").val().length>'30')
			{
				if($(".eor11").val()!='')
				{
					$(".pn11").before("<span class='err eor11'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor11").val()=='')
				{
					$(".eor11").remove();
				}
			}
		});
		$(".pn12").on("input",function(){
			if($(".pn12").val()==''||$(".pn12").val().length<='2'||$(".pn12").val().length>'30')
			{
				if($(".eor12").val()!='')
				{
					$(".pn12").before("<span class='err eor12'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor12").val()=='')
				{
					$(".eor12").remove();
				}
			}
		});
		$(".pn13").on("input",function(){
			if($(".pn13").val()==''||$(".pn13").val().length<='2'||$(".pn13").val().length>'30')
			{
				if($(".eor13").val()!='')
				{
					$(".pn13").before("<span class='err eor13'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor13").val()=='')
				{
					$(".eor13").remove();
				}
			}
		});
		$(".pn14").on("input",function(){
			if($(".pn14").val()==''||$(".pn14").val().length<='2'||$(".pn14").val().length>'30')
			{
				if($(".eor14").val()!='')
				{
					$(".pn14").before("<span class='err eor14'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor14").val()=='')
				{
					$(".eor14").remove();
				}
			}
		});
		$(".pn15").on("input",function(){
			if($(".pn15").val()==''||$(".pn15").val().length<='2'||$(".pn15").val().length>'30')
			{
				if($(".eor15").val()!='')
				{
					$(".pn15").before("<span class='err eor15'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor15").val()=='')
				{
					$(".eor15").remove();
				}
			}
		});





		$(".t1n").blur(function(){
			if($(".t1n").val()=='' ||$(".t1n").val().length<='4'||$(".t1n").val().length>'30' )
			{
				if($(".eort").val()!='')
				{
					$(".t1n").before("<span class='err eort'>Team Name should be of 5-30 character</span>");
				}
			}
			else
			{
				if($(".eort").val()!='')
				{
					$(".eort").remove();
				}
			}
		});
		$(".pn1").blur(function(){
			if($(".pn1").val()==''||$(".pn1").val().length<='2'||$(".pn1").val().length>'30')
			{
				if($(".eor1").val()!='')
				{
					$(".pn1").before("<span class='err eor1'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor1").val()=='')
				{
					$(".eor1").remove();
				}
			}
		});
		$(".pn2").blur(function(){
			if($(".pn2").val()==''||$(".pn2").val().length<='2'||$(".pn2").val().length>'30')
			{
				if($(".eor2").val()!='')
				{
					$(".pn2").before("<span class='err eor2'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor2").val()=='')
				{
					$(".eor2").remove();
				}
			}
		});
		$(".pn3").blur(function(){
			if($(".pn3").val()==''||$(".pn3").val().length<='2'||$(".pn3").val().length>'30')
			{
				if($(".eor3").val()!='')
				{
					$(".pn3").before("<span class='err eor3'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor3").val()=='')
				{
					$(".eor3").remove();
				}
			}
		});
		$(".pn4").blur(function(){
			if($(".pn4").val()==''||$(".pn4").val().length<='2'||$(".pn4").val().length>'30')
			{
				if($(".eor4").val()!='')
				{
					$(".pn4").before("<span class='err eor4'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor4").val()=='')
				{
					$(".eor4").remove();
				}
			}
		});
		$(".pn5").blur(function(){
			if($(".pn5").val()==''||$(".pn5").val().length<='2'||$(".pn5").val().length>'30')
			{
				if($(".eor5").val()!='')
				{
					$(".pn5").before("<span class='err eor5'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor5").val()=='')
				{
					$(".eor5").remove();
				}
			}
		});
		$(".pn6").blur(function(){
			if($(".pn6").val()==''||$(".pn6").val().length<='2'||$(".pn6").val().length>'30')
			{
				if($(".eor6").val()!='')
				{
					$(".pn6").before("<span class='err eor6'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor6").val()=='')
				{
					$(".eor6").remove();
				}
			}
		});
		$(".pn7").blur(function(){
			if($(".pn7").val()==''||$(".pn7").val().length<='2'||$(".pn7").val().length>'30')
			{
				if($(".eor7").val()!='')
				{
					$(".pn7").before("<span class='err eor7'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor7").val()=='')
				{
					$(".eor7").remove();
				}
			}
		});
		$(".pn8").blur(function(){
			if($(".pn8").val()==''||$(".pn8").val().length<='2'||$(".pn8").val().length>'30')
			{
				if($(".eor8").val()!='')
				{
					$(".pn8").before("<span class='err eor8'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor8").val()=='')
				{
					$(".eor8").remove();
				}
			}
		});
		$(".pn9").blur(function(){
			if($(".pn9").val()==''||$(".pn9").val().length<='2'||$(".pn9").val().length>'30')
			{
				if($(".eor9").val()!='')
				{
					$(".pn9").before("<span class='err eor9'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor9").val()=='')
				{
					$(".eor9").remove();
				}
			}
		});
		$(".pn10").blur(function(){
			if($(".pn10").val()==''||$(".pn10").val().length<='2'||$(".pn10").val().length>'30')
			{
				if($(".eor10").val()!='')
				{
					$(".pn10").before("<span class='err eor10'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor10").val()=='')
				{
					$(".eor10").remove();
				}
			}
		});
		$(".pn11").blur(function(){
			if($(".pn11").val()==''||$(".pn11").val().length<='2'||$(".pn11").val().length>'30')
			{
				if($(".eor11").val()!='')
				{
					$(".pn11").before("<span class='err eor11'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor11").val()=='')
				{
					$(".eor11").remove();
				}
			}
		});
		$(".pn12").blur(function(){
			if($(".pn12").val()==''||$(".pn12").val().length<='2'||$(".pn12").val().length>'30')
			{
				if($(".eor12").val()!='')
				{
					$(".pn12").before("<span class='err eor12'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor12").val()=='')
				{
					$(".eor12").remove();
				}
			}
		});
		$(".pn13").blur(function(){
			if($(".pn13").val()==''||$(".pn13").val().length<='2'||$(".pn13").val().length>'30')
			{
				if($(".eor13").val()!='')
				{
					$(".pn13").before("<span class='err eor13'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor13").val()=='')
				{
					$(".eor13").remove();
				}
			}
		});
		$(".pn14").blur(function(){
			if($(".pn14").val()==''||$(".pn14").val().length<='2'||$(".pn14").val().length>'30')
			{
				if($(".eor14").val()!='')
				{
					$(".pn14").before("<span class='err eor14'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor14").val()=='')
				{
					$(".eor14").remove();
				}
			}
		});
		$(".pn15").blur(function(){
			if($(".pn15").val()==''||$(".pn15").val().length<='2'||$(".pn15").val().length>'30')
			{
				if($(".eor15").val()!='')
				{
					$(".pn15").before("<span class='err eor15'>Player Name should be of 3-30 character</span>");
				}
			}
			else
			{
				if($(".eor15").val()=='')
				{
					$(".eor15").remove();
				}
			}
		});

	});
function chk(){

		if($(".t1n").val()==''||$(".t1n").val().length<'4'||$(".t1n").val().length>'30')
			{
				if($(".eort").val()!='')
				{
					$(".t1n").before("<span class='err eort'>Team Name should be of 5-30 character</span>");
				}
				return false;	
			}
			else if($(".pn1").val()==''||$(".pn1").val().length<='2'||$(".pn1").val().length>'30')
			{
				if($(".eor1").val()!='')
				{
					$(".pn1").before("<span class='err eor1'>Player Name should be of 3-30 character</span>");
				}
				return false;	
			}
			else if($(".pn2").val()==''||$(".pn2").val().length<='2'||$(".pn2").val().length>'30')
			{
				if($(".eor2").val()!='')
				{
					$(".pn2").before("<span class='err eor2'>Player Name should be of 3-30 character</span>");
				}
				return false;	
			}
			else if($(".pn3").val()==''||$(".pn3").val().length<='2'||$(".pn3").val().length>'30')
			{
				if($(".eor3").val()!='')
				{
					$(".pn3").before("<span class='err eor3'>Player Name should be of 3-30 character</span>");
				}
				return false;	
			}
			else if($(".pn4").val()==''||$(".pn4").val().length<='2'||$(".pn4").val().length>'30')
			{
				if($(".eor4").val()!='')
				{
					$(".pn4").before("<span class='err eor4'>Player Name should be of 3-30 character</span>");
				}
				return false;	
			}
			else if($(".pn5").val()==''||$(".pn5").val().length<='2'||$(".pn5").val().length>'30')
			{
				if($(".eor5").val()!='')
				{
					$(".pn5").before("<span class='err eor5'>Player Name should be of 3-30 character</span>");
				}
				return false;	
			}
			else if($(".pn6").val()==''||$(".pn6").val().length<='2'||$(".pn6").val().length>'30')
			{
				if($(".eor6").val()!='')
				{
					$(".pn6").before("<span class='err eor6'>Player Name should be of 3-30 character</span>");
				}
				return false;	
			}
			else if($(".pn7").val()==''||$(".pn7").val().length<='2'||$(".pn7").val().length>'30')
			{
				if($(".eor7").val()!='')
				{
					$(".pn7").before("<span class='err eor7'>Player Name should be of 3-30 character</span>");
				}
				return false;	
			}
			else if($(".pn8").val()==''||$(".pn8").val().length<='2'||$(".pn8").val().length>'30')
			{
				if($(".eor8").val()!='')
				{
					$(".pn8").before("<span class='err eor8'>Player Name should be of 3-30 character</span>");
				}
				return false;	
			}
			else if($(".pn9").val()==''||$(".pn9").val().length<='2'||$(".pn9").val().length>'30')
			{
				if($(".eor9").val()!='')
				{
					$(".pn9").before("<span class='err eor9'>Player Name should be of 3-30 character</span>");
				}
				return false;	
			}
			else if($(".pn10").val()==''||$(".pn10").val().length<='2'||$(".pn10").val().length>'30')
			{
				if($(".eor10").val()!='')
				{
					$(".pn10").before("<span class='err eor10'>Player Name should be of 3-30 character</span>");
				}
				return false;	
			}
			else if($(".pn11").val()==''||$(".pn11").val().length<='2'||$(".pn11").val().length>'30')
			{
				if($(".eor11").val()!='')
				{
					$(".pn11").before("<span class='err eor11'>Player Name should be of 3-30 character</span>");
				}
				return false;	
			}
			else if($(".pn12").val()==''||$(".pn12").val().length<='2'||$(".pn12").val().length>'30')
			{
				if($(".eor12").val()!='')
				{
					$(".pn12").before("<span class='err eor12'>Player Name should be of 3-30 character</span>");
				}
				return false;	
			}
			else if($(".pn13").val()==''||$(".pn13").val().length<='2'||$(".pn13").val().length>'30')
			{
				if($(".eor13").val()!='')
				{
					$(".pn13").before("<span class='err eor13'>Player Name should be of 3-30 character</span>");
				}
				return false;	
			}
			else if($(".pn14").val()==''||$(".pn14").val().length<='2'||$(".pn14").val().length>'30')
			{
				if($(".eor14").val()!='')
				{
					$(".pn14").before("<span class='err eor14'>Player Name should be of 3-30 character</span>");
				}
				return false;	
			}
			else if($(".pn15").val()==''||$(".pn15").val().length<='2'||$(".pn15").val().length>'30')
			{
				if($(".eor15").val()!='')
				{
					$(".pn15").before("<span class='err eor15'>Player Name should be of 3-30 character</span>");
				}
				return false;	
			}
		
	return true;	

}
</script>
</html>