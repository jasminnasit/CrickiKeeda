<?php
	$result='';
	$auname='';
	if (isset($_COOKIE['adminbro'])) 
	{
		if (isset($_COOKIE['matchStarted'])) {
			header('Location:admin.php');	
		}
		else{
			header('Location:startMatch.php');
		}
	}
	else
	{
		if(isset($_POST['adminl']))
		{
			$auname=$_POST['auname'];
			$apass=$_POST['apass'];
			if ($auname=='vatjassu' && $apass=='12345') 
			{
				$dbase=mysqli_connect('localhost','root','','crickikeeda');
				$matchid=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT max(`matchid`) FROM `matches` WHERE `completed`	='1'"));
				$matchid=$matchid['max(`matchid`)'];
				echo "<script>alert('$matchid')</script>";
				setcookie('adminbro',$matchid+1,time()+5*24*60*60);
				$result="<span class='logged'>Logged in Admin Bro!</span>";
				header('Location:startMatch.php');
			}
			else
			{
				$result="<span class='error'>Incorrect Admin Bro!</span>";
			}
		}
	}
		
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Login</title>
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
<h1 class="title">CrickiKeeda</h1>
<div id="loginPannel">
	<form action="adminl.php" method="post">
	<?php echo $result;?>
	<table id="loginTable">
		<tr>
			<td><label for="username" class="lbls">Admin ID:</label></td>
		</tr>
		<tr>
			<td class="adminip"><i class="fa fa-user"></i><input type="text" autocomplete="off" value="<?php echo "$auname"; ?>" name="auname" placeholder="Admin ID"></td>
		</tr>
		<tr>
			<td><label for="password" class="lbls">Password:</label></td>
		</tr>
		<tr>
			<td class="adminip"><i class="fa fa-lock"></i><input type="password" name="apass" placeholder="Password"></td>
		</tr>
		<tr>
			<td><input type="submit" name="adminl" value="Login" class="submitb"></td>
		</tr>
	</table>
	</form>
</div>


</body>
</html>