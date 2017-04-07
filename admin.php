<?php
	//error_reporting(~E_ALL);
	if (isset($_COOKIE['mistake'])) {
		echo "<script>confirm('Old Incomplete match was found, You can\'t start new one.Resuming old one')</script>";
	}
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
		$lastover=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `lastover` FROM `matches` WHERE `matchid`='$matchid'"));
		$lastover=$lastover['lastover'];
		$teami1id=substr($teami1,0,strpos($teami1,'-'));
		$teami2id=substr($teami2,0,strpos($teami2,'-'));
		$batstrk=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `pid`,`runs`,`inballs` FROM `scores` WHERE `status`='11' AND `matchid`='$matchid'"));
		$batstrkid=$batstrk['pid'];
		$batstrkRuns=$batstrk['runs'];
		$batstrkib=$batstrk['inballs'];
		$bowler=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `pid`,`over`,`wicket` FROM `scores` WHERE `status`='01' AND `matchid`='$matchid'"));
		$bowlerid=$bowler['pid'];
		$bowlerOv=$bowler['over'];
		$bowlerwic=$bowler['wicket'];
		$completed=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `completed` FROM `matches` WHERE `matchid`='$matchid'"));
		$completed=$completed['completed'];
		if (isset($_POST['update'])) {
			if (isset($_COOKIE['pbowler'])) {
				setcookie('pbowler','',time()-10*60);
			}
			if (isset($_COOKIE['striker'])) {
				setcookie('striker','',time()-10*60);
			}
			setcookie('lastball',"$runs,$over,$wicket,$lastover",time()+10*60);
			$run=$_POST['runs'];
			$del=$_POST['del'];
			if ($del=='fair') {
				$runs+=$run;
				if (intval($over*10)%5 == 0 &&  intval($over*10)%10 != 0) {
					$over+=0.5;
					$lastover.="[ $run ] ";
					$lastover[0]='n';
					chstrike();
					$completed[2]=0;
					mysqli_query($dbase,"UPDATE `matches` SET `completed`='$completed' WHERE `matchid`='$matchid'");
					setcookie('pbowler',$bowlerid,time()+10*60);
				}
				else{
					if ($lastover[0]=='n') {
						$lastover="c[ $run ] ";
					}
					else
					{
						$lastover.="[ $run ] ";
					}
					$over+=0.1;
				}
				switch ($run) {
					case '0':
						setcookie('playerError',$batstrkRuns.','.$batstrkib.',0,11',time()+10*60);
						break;
					case '1':
						setcookie('playerError',$batstrkRuns.','.$batstrkib.',1,11',time()+10*60);
						$batstrkRuns+=1;
						mysqli_query($dbase,"UPDATE `scores` SET `runs`='$batstrkRuns' WHERE `pid`='$batstrkid' AND `matchid`='$matchid'");
						chstrike();
						break;
					case '2':
						setcookie('playerError',$batstrkRuns.','.$batstrkib.',0,11',time()+10*60);
						$batstrkRuns+=2;
						mysqli_query($dbase,"UPDATE `scores` SET `runs`='$batstrkRuns' WHERE `pid`='$batstrkid' AND `matchid`='$matchid'");
						break;
					case '3':
						setcookie('playerError',$batstrkRuns.','.$batstrkib.',1,11',time()+10*60);
						$batstrkRuns+=3;
						mysqli_query($dbase,"UPDATE `scores` SET `runs`='$batstrkRuns' WHERE `pid`='$batstrkid' AND `matchid`='$matchid'");
						chstrike();
						break;
					case '4':
						setcookie('playerError',$batstrkRuns.','.$batstrkib.',0,11',time()+10*60);
						$batstrkRuns+=4;
						mysqli_query($dbase,"UPDATE `scores` SET `runs`='$batstrkRuns' WHERE `pid`='$batstrkid' AND `matchid`='$matchid'");
						break;
					case '6':
						setcookie('playerError',$batstrkRuns.','.$batstrkib.',0,11',time()+10*60);
						$batstrkRuns+=6;
						mysqli_query($dbase,"UPDATE `scores` SET `runs`='$batstrkRuns' WHERE `pid`='$batstrkid' AND `matchid`='$matchid'");
						break;

				}
				$batstrkib+=1;
				mysqli_query($dbase,"UPDATE `scores` SET `inballs`='$batstrkib' WHERE `pid`='$batstrkid' AND `matchid`='$matchid'");
			}
			elseif ($del=='wide' && $run=='0') {
				$runs+=($run+1);
				if($lastover[0]=='n') {
					$lastover="c[Wd($run)] ";
				}
				else
				{
					$lastover.="[Wd($run)] ";
				}
				setcookie('playerError',$batstrkRuns.','.$batstrkib.',0,11',time()+10*60);
			}
			elseif ($del=='noball') {
				$runs+=($run+1);
				if($lastover[0]=='n') {
					$lastover="c[Nb($run)] ";
				}
				else
				{
					$lastover.="[Nb($run)] ";
				}
				switch ($run) {
					case '0':
						setcookie('playerError',$batstrkRuns.','.$batstrkib.',0,11',time()+10*60);
						break;
					case '1':
						setcookie('playerError',$batstrkRuns.','.$batstrkib.',1,11',time()+10*60);
						$batstrkRuns+=1;
						mysqli_query($dbase,"UPDATE `scores` SET `runs`='$batstrkRuns' WHERE `pid`='$batstrkid' AND `matchid`='$matchid'");
						chstrike();
						break;
					case '2':
						setcookie('playerError',$batstrkRuns.','.$batstrkib.',0,11',time()+10*60);
						$batstrkRuns+=2;
						mysqli_query($dbase,"UPDATE `scores` SET `runs`='$batstrkRuns' WHERE `pid`='$batstrkid' AND `matchid`='$matchid'");
						break;
					case '3':
						setcookie('playerError',$batstrkRuns.','.$batstrkib.',1,11',time()+10*60);
						$batstrkRuns+=3;
						mysqli_query($dbase,"UPDATE `scores` SET `runs`='$batstrkRuns' WHERE `pid`='$batstrkid' AND `matchid`='$matchid'");
						chstrike();
						break;
					case '4':
						setcookie('playerError',$batstrkRuns.','.$batstrkib.',0,11',time()+10*60);
						$batstrkRuns+=4;
						mysqli_query($dbase,"UPDATE `scores` SET `runs`='$batstrkRuns' WHERE `pid`='$batstrkid' AND `matchid`='$matchid'");
						break;
					case '6':
						setcookie('playerError',$batstrkRuns.','.$batstrkib.',0,11',time()+10*60);
						$batstrkRuns+=6;
						mysqli_query($dbase,"UPDATE `scores` SET `runs`='$batstrkRuns' WHERE `pid`='$batstrkid' AND `matchid`='$matchid'");
						break;
				}
			}
			elseif ($del=='bold' || $del=='lbw' || $del=='caught' || $del=='stummped') {
				$wicket+=1;
				if (intval($over*10)%5 == 0 &&  intval($over*10)%10 != 0) {
					$over+=0.5;
					$lastover.="[$del($run)] ";
					$lastover[0]='n';
					$completed[2]=0;
					mysqli_query($dbase,"UPDATE `matches` SET `completed`='$completed' WHERE `matchid`='$matchid'");
					setcookie('pbowler',$bowlerid,time()+10*60);
				}
				else{
					if($lastover[0]=='n') {
						$lastover="c[$del($run)] ";
					}
					else
					{
						$lastover.="[$del($run)] ";
					}	
					$over+=0.1;
				}
				setcookie('playerError',$batstrkRuns.','.$batstrkib.',0,11',time()+10*60);
				setcookie('striker',$batstrkid,time()+10*60);
				$batstrkib+=1;
				mysqli_query($dbase,"UPDATE `scores` SET `takenby`='$bowlerid' WHERE `pid`='$batstrkid'  AND `matchid`='$matchid'");
				mysqli_query($dbase,"UPDATE `scores` SET `inballs`='$batstrkib' WHERE `pid`='$batstrkid'  AND `matchid`='$matchid'");
				mysqli_query($dbase,"UPDATE `scores` SET `status`='' WHERE `pid`='$batstrkid' AND `matchid`='$matchid'");
				$completed[1]=1;
				mysqli_query($dbase,"UPDATE `matches` SET `completed`='$completed' WHERE `matchid`='$matchid' ");
				$bowlerwic+=1;
				mysqli_query($dbase,"UPDATE `scores` SET `wicket`='$bowlerwic' WHERE `pid`='$bowlerid' AND `matchid`='$matchid'");	
			}
			elseif (explode(',', $del)[0]=="runout") {
				$wicket+=1;
				$runs+=$run;
				if (intval($over*10)%5 == 0 &&  intval($over*10)%10 != 0) {
					$over+=0.5;
					$lastover.="[ runout($run) ] ";
					$lastover[0]='n';
					$completed[2]=0;
					mysqli_query($dbase,"UPDATE `matches` SET `completed`='$completed' WHERE `matchid`='$matchid'");
					setcookie('pbowler',$bowlerid,time()+10*60);
				}
				else{
					if ($lastover[0]=='n') {
						$lastover="c[ runout($run) ] ";
					}
					else
					{
						$lastover.="[ runout($run) ] ";
					}
					$over+=0.1;
				}
				$del=explode(',',$del);
				$runoutpl=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `runs`,`inballs` FROM `scores` WHERE `pid`='$del[1]' AND `matchid`='$matchid'"));
				$runoutplruns=$runoutpl['runs'];
				$runoutplib=$runoutpl['inballs'];
				switch ($run) {
					case '0':
						if ($del[1]==$batstrkid) {
							$status='11';
						}
						else{
							$status='10';
							setcookie('striker2',$batstrkid.','.$batstrkRuns.','.$batstrkib,time()+10*60);
						}
						setcookie('playerError',$runoutplruns.','.$runoutplib.',0,'.$status,time()+10*60);
						break;
					case '1':
						if ($del[1]==$batstrkid) {
							$status='10';
						}
						else{
							$status='11';
							setcookie('striker2',$batstrkid.','.$batstrkRuns.','.$batstrkib,time()+10*60);
						}
						setcookie('playerError',$runoutplruns.','.$runoutplib.',1,'.$status,time()+10*60);
						$batstrkRuns+=1;
						mysqli_query($dbase,"UPDATE `scores` SET `runs`='$batstrkRuns' WHERE `pid`='$batstrkid' AND `matchid`='$matchid'");
						chstrike();
						break;
					case '2':
						if ($del[1]==$batstrkid) {
							$status='11';
						}
						else{
							$status='10';
							setcookie('striker2',$batstrkid.','.$batstrkRuns.','.$batstrkib,time()+10*60);
						}
						setcookie('playerError',$runoutplruns.','.$runoutplib.',0,'.$status,time()+10*60);
						$batstrkRuns+=2;
						mysqli_query($dbase,"UPDATE `scores` SET `runs`='$batstrkRuns' WHERE `pid`='$batstrkid' AND `matchid`='$matchid'");
						break;
					case '3':
						if ($del[1]==$batstrkid) {
							$status='10';
						}
						else{
							$status='11';
							setcookie('striker2',$batstrkid.','.$batstrkRuns.','.$batstrkib,time()+10*60);
						}
						setcookie('playerError',$runoutplruns.','.$runoutplib.',1,'.$status,time()+10*60);
						$batstrkRuns+=3;
						mysqli_query($dbase,"UPDATE `scores` SET `runs`='$batstrkRuns' WHERE `pid`='$batstrkid' AND `matchid`='$matchid'");
						chstrike();
						break;
				}
				setcookie('striker',$del[1],time()+10*60);
				$batstrkib+=1;
				mysqli_query($dbase,"UPDATE `scores` SET `inballs`='$batstrkib' WHERE `pid`='$batstrkid' AND `matchid`='$matchid'");
				mysqli_query($dbase,"UPDATE `scores` SET `takenby`='$bowlerid' WHERE `pid`='$del[1]'  AND `matchid`='$matchid'");
				mysqli_query($dbase,"UPDATE `scores` SET `status`='' WHERE `pid`='$del[1]' AND `matchid`='$matchid'");
				$completed[1]=1;
				mysqli_query($dbase,"UPDATE `matches` SET `completed`='$completed' WHERE `matchid`='$matchid' ");
				$bowlerwic+=1;
				mysqli_query($dbase,"UPDATE `scores` SET `wicket`='$bowlerwic' WHERE `pid`='$bowlerid' AND `matchid`='$matchid'");	
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
				$lastover="n";
				setcookie('lastball',"0,0,0,n",time()+10*60);
				$completed[1]=0;
				$completed[2]=0;
				mysqli_query($dbase,"UPDATE `matches` SET `completed`='$completed' WHERE `matchid`='$matchid' ");
				$batsmans=mysqli_query($dbase,"SELECT `pid` FROM `players` WHERE `pid` IN (SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `tid`='$teami1id')");
				foreach ($batsmans as $value) {
					$id=$value['pid'];
					mysqli_query($dbase,"UPDATE `scores` SET `status`='' WHERE (`status`='11' OR `status`='10' OR `status`='01') AND `matchid`='$matchid' ");
				}
				header("Location:admin.php");
			}
			else if(($over==12.0 || $wicket==10) && $inn=='i2')
			{
				if ($runs>=$target) {
					mysqli_query($dbase,"UPDATE `matches` SET `news`='$teami2' WHERE `matchid`='$matchid' ");
					$lastover="i2";
				}
				else
				{
					mysqli_query($dbase,"UPDATE `matches` SET `news`='$teami1' WHERE `matchid`='$matchid' ");
					$lastover="i1";
				}
				mysqli_query($dbase,"UPDATE `matches` SET `completed`='1' WHERE `matchid`='$matchid' ");
				mysqli_query($dbase,"UPDATE `matches` SET `lastover`='$lastover' WHERE `matchid`='$matchid' ");
				setcookie('adminbro',$matchid+1,time()+5*22*60*60);
				setcookie('matchStarted',0,time()-60);
				setcookie('lastball',"0,0.0,0,''",time()-60);
				setcookie('matchStarted',0,time()-60);
				setcookie('lastball',"0,0.0,0,''",time()-60);
				// $batsmans=mysqli_query($dbase,"SELECT `pid` FROM `players` WHERE `pid` IN (SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `tid`='$teami2id')");
				// foreach ($batsmans as $value) {
				// 	$id=$value['pid'];
				// 	mysqli_query($dbase,"UPDATE `scores` SET `status`='00' WHERE `pid`='$id' AND `matchid`='$matchid' ");
				// }

				$Teami1id=explode('-',$teami1);
				$Teami2id=explode('-',$teami2);
				$playerTeami1=mysqli_query($dbase,"SELECT `pid` FROM `teamalloc` WHERE `tid`='$Teami1id[0]' ");
				$playerTeami2=mysqli_query($dbase,"SELECT `pid` FROM `teamalloc` WHERE `tid`='$Teami2id[0]' ");

				while ($player=mysqli_fetch_assoc($playerTeami1)) {
					$player=$player['pid'];
					$runMatch=mysqli_query($dbase,"SELECT `runs` FROM `scores` WHERE `pid`='$player' AND `matchid`='$matchid' ");
					$overMatch=mysqli_query($dbase,"SELECT `over` FROM `scores` WHERE `pid`='$player' AND `matchid`='$matchid' ");
					$wicMatch=mysqli_query($dbase,"SELECT `wicket` FROM `scores` WHERE `pid`='$player' AND `matchid`='$matchid' ");
					$runTotal=mysqli_query($dbase,"SELECT `truns` FROM `players` WHERE `pid`='$player' ");
					$overTotal=mysqli_query($dbase,"SELECT `tover` FROM `players` WHERE `pid`='$player' ");
					$wicTotal=mysqli_query($dbase,"SELECT `twicket` FROM `players` WHERE `pid`='$player' ");

					$runTotal=mysqli_fetch_assoc($runTotal);
					$runTotal=$runTotal['truns'];
					$runMatch=mysqli_fetch_assoc($runMatch);
					$runMatch=$runMatch['runs'];
					$runTotal+=$runMatch;
					$overTotal=mysqli_fetch_assoc($overTotal);
					$overTotal=$overTotal['tover'];
					$overMatch=mysqli_fetch_assoc($overMatch);
					$overMatch=$overMatch['over'];
					$overTotal+=$overMatch;
					$wicTotal=mysqli_fetch_assoc($wicTotal);
					$wicTotal=$wicTotal['twicket'];
					$wicMatch=mysqli_fetch_assoc($wicMatch);
					$wicMatch=$wicMatch['wicket'];
					$wicTotal+=$wicMatch;

					mysqli_query($dbase,"UPDATE `players` SET `truns`='$runTotal' WHERE `pid`='$player'");
					mysqli_query($dbase,"UPDATE `players` SET `tover`='$overTotal' WHERE `pid`='$player'");
					mysqli_query($dbase,"UPDATE `players` SET `twicket`='$wicTotal' WHERE `pid`='$player'");
				}
				
				while ($player=mysqli_fetch_assoc($playerTeami2)) {
					$player=$player['pid'];
					$runMatch=mysqli_query($dbase,"SELECT `runs` FROM `scores` WHERE `pid`='$player' AND `matchid`='$matchid' ");
					$overMatch=mysqli_query($dbase,"SELECT `over` FROM `scores` WHERE `pid`='$player' AND `matchid`='$matchid' ");
					$wicMatch=mysqli_query($dbase,"SELECT `wicket` FROM `scores` WHERE `pid`='$player' AND `matchid`='$matchid' ");
					$runTotal=mysqli_query($dbase,"SELECT `truns` FROM `players` WHERE `pid`='$player' ");
					$overTotal=mysqli_query($dbase,"SELECT `tover` FROM `players` WHERE `pid`='$player' ");
					$wicTotal=mysqli_query($dbase,"SELECT `twicket` FROM `players` WHERE `pid`='$player' ");

					$runTotal=mysqli_fetch_assoc($runTotal);
					$runTotal=$runTotal['truns'];
					$runMatch=mysqli_fetch_assoc($runMatch);
					$runMatch=$runMatch['runs'];
					$runTotal+=$runMatch;
					$overTotal=mysqli_fetch_assoc($overTotal);
					$overTotal=$overTotal['tover'];
					$overMatch=mysqli_fetch_assoc($overMatch);
					$overMatch=$overMatch['over'];
					$overTotal+=$overMatch;
					$wicTotal=mysqli_fetch_assoc($wicTotal);
					$wicTotal=$wicTotal['twicket'];
					$wicMatch=mysqli_fetch_assoc($wicMatch);
					$wicMatch=$wicMatch['wicket'];
					$wicTotal+=$wicMatch;

					mysqli_query($dbase,"UPDATE `players` SET `truns`='$runTotal' WHERE `pid`='$player'");
					mysqli_query($dbase,"UPDATE `players` SET `tover`='$overTotal' WHERE `pid`='$player'");
					mysqli_query($dbase,"UPDATE `players` SET `twicket`='$wicTotal' WHERE `pid`='$player'");
				}
				mysqli_query($dbase,"UPDATE `matches` SET `lastover`='$lastover' WHERE `matchid`='$matchid' ");
				header("Location:startMatch.php");
			}
			else if(($runs>=$target) && $inn=='i2')
			{
				mysqli_query($dbase,"UPDATE `matches` SET `news`='$teami2' WHERE `matchid`='$matchid' ");
				mysqli_query($dbase,"UPDATE `matches` SET `completed`='1' WHERE `matchid`='$matchid' ");
				setcookie('adminbro',$matchid+1,time()+5*22*60*60);
				setcookie('matchStarted',0,time()-60);
				setcookie('lastball',"0,0.0,0,''",time()-60);
				$lastover="i2";
				mysqli_query($dbase,"UPDATE `matches` SET `lastover`='$lastover' WHERE `matchid`='$matchid' ");
				// $batsmans=mysqli_query($dbase,"SELECT `pid` FROM `players` WHERE `pid` IN (SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `tid`='$teami2id')");
				// foreach ($batsmans as $value) {
				// 	$id=$value['pid'];
				// 	mysqli_query($dbase,"UPDATE `scores` SET `status`='00' WHERE `pid`='$id' AND `matchid`='$matchid' ");
				// }
				$Teami1id=explode('-',$teami1);
				$Teami2id=explode('-',$teami2);
				$playerTeami1=mysqli_query($dbase,"SELECT `pid` FROM `teamalloc` WHERE `tid`='$Teami1id[0]' ");
				$playerTeami2=mysqli_query($dbase,"SELECT `pid` FROM `teamalloc` WHERE `tid`='$Teami2id[0]' ");

				while ($player=mysqli_fetch_assoc($playerTeami1)) {
					$player=$player['pid'];
					$runMatch=mysqli_query($dbase,"SELECT `runs` FROM `scores` WHERE `pid`='$player' AND `matchid`='$matchid' ");
					$overMatch=mysqli_query($dbase,"SELECT `over` FROM `scores` WHERE `pid`='$player' AND `matchid`='$matchid' ");
					$wicMatch=mysqli_query($dbase,"SELECT `wicket` FROM `scores` WHERE `pid`='$player' AND `matchid`='$matchid' ");
					$runTotal=mysqli_query($dbase,"SELECT `truns` FROM `players` WHERE `pid`='$player' ");
					$overTotal=mysqli_query($dbase,"SELECT `tover` FROM `players` WHERE `pid`='$player' ");
					$wicTotal=mysqli_query($dbase,"SELECT `twicket` FROM `players` WHERE `pid`='$player' ");

					$runTotal=mysqli_fetch_assoc($runTotal);
					$runTotal=$runTotal['truns'];
					$runMatch=mysqli_fetch_assoc($runMatch);
					$runMatch=$runMatch['runs'];
					$runTotal+=$runMatch;
					$overTotal=mysqli_fetch_assoc($overTotal);
					$overTotal=$overTotal['tover'];
					$overMatch=mysqli_fetch_assoc($overMatch);
					$overMatch=$overMatch['over'];
					$overTotal+=$overMatch;
					$wicTotal=mysqli_fetch_assoc($wicTotal);
					$wicTotal=$wicTotal['twicket'];
					$wicMatch=mysqli_fetch_assoc($wicMatch);
					$wicMatch=$wicMatch['wicket'];
					$wicTotal+=$wicMatch;

					mysqli_query($dbase,"UPDATE `players` SET `truns`='$runTotal' WHERE `pid`='$player'");
					mysqli_query($dbase,"UPDATE `players` SET `tover`='$overTotal' WHERE `pid`='$player'");
					mysqli_query($dbase,"UPDATE `players` SET `twicket`='$wicTotal' WHERE `pid`='$player'");
				}
				
				while ($player=mysqli_fetch_assoc($playerTeami2)) {
					$player=$player['pid'];
					$runMatch=mysqli_query($dbase,"SELECT `runs` FROM `scores` WHERE `pid`='$player' AND `matchid`='$matchid' ");
					$overMatch=mysqli_query($dbase,"SELECT `over` FROM `scores` WHERE `pid`='$player' AND `matchid`='$matchid' ");
					$wicMatch=mysqli_query($dbase,"SELECT `wicket` FROM `scores` WHERE `pid`='$player' AND `matchid`='$matchid' ");
					$runTotal=mysqli_query($dbase,"SELECT `truns` FROM `players` WHERE `pid`='$player' ");
					$overTotal=mysqli_query($dbase,"SELECT `tover` FROM `players` WHERE `pid`='$player' ");
					$wicTotal=mysqli_query($dbase,"SELECT `twicket` FROM `players` WHERE `pid`='$player' ");

					$runTotal=mysqli_fetch_assoc($runTotal);
					$runTotal=$runTotal['truns'];
					$runMatch=mysqli_fetch_assoc($runMatch);
					$runMatch=$runMatch['runs'];
					$runTotal+=$runMatch;
					$overTotal=mysqli_fetch_assoc($overTotal);
					$overTotal=$overTotal['tover'];
					$overMatch=mysqli_fetch_assoc($overMatch);
					$overMatch=$overMatch['over'];
					$overTotal+=$overMatch;
					$wicTotal=mysqli_fetch_assoc($wicTotal);
					$wicTotal=$wicTotal['twicket'];
					$wicMatch=mysqli_fetch_assoc($wicMatch);
					$wicMatch=$wicMatch['wicket'];
					$wicTotal+=$wicMatch;

					mysqli_query($dbase,"UPDATE `players` SET `truns`='$runTotal' WHERE `pid`='$player'");
					mysqli_query($dbase,"UPDATE `players` SET `tover`='$overTotal' WHERE `pid`='$player'");
					mysqli_query($dbase,"UPDATE `players` SET `twicket`='$wicTotal' WHERE `pid`='$player'");
				}
				header("Location:startMatch.php");
			}
			mysqli_query($dbase,"UPDATE `matches` SET `lastover`='$lastover' WHERE `matchid`='$matchid' ");
		}

		if (isset($_POST['opener'])) {
			$bat1=$_POST['bat1'];
			$bat2=$_POST['bat2'];
			if ($bat1==$bat2) {
				$showError='Invalid';
			}
			else
			{
				mysqli_query($dbase,"UPDATE `scores` SET `status`='11' WHERE `pid`='$bat1' AND `matchid`='$matchid'");
				mysqli_query($dbase,"UPDATE `scores` SET `status`='10' WHERE `pid`='$bat2' AND `matchid`='$matchid'");
				$completed[1]='2';
				mysqli_query($dbase,"UPDATE `matches` SET `completed`='$completed' WHERE `matchid`='$matchid'");
				setcookie('playerError','0-0-0',time()+10*60);
			}
			
		}
		if (isset($_POST['batsmn'])) {
			$bat2=$_POST['bat2'];
			$playerError=explode(',', $_COOKIE['playerError']);
			mysqli_query($dbase,"UPDATE `scores` SET `status`='$playerError[3]' WHERE `pid`='$bat2' AND `matchid`='$matchid'");
			$completed[1]='2';
			mysqli_query($dbase,"UPDATE `matches` SET `completed`='$completed' WHERE `matchid`='$matchid'");
			if ($lastover[0]=='n') {
				chstrike();
			}
		}
		if (isset($_POST['bowler'])) {
			$bowl=$_POST['bowl'];
			mysqli_query($dbase,"UPDATE `scores` SET `status`='01' WHERE `pid`='$bowl' AND `matchid`='$matchid'");
			$completed[2]='1';
			mysqli_query($dbase,"UPDATE `matches` SET `completed`='$completed' WHERE `matchid`='$matchid'");
			$bowler=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `over` FROM `scores` WHERE `status`='01' AND `matchid`='$matchid'"));
			$bowlerOv=$bowler['over'];
			$bowlerOv+=1;
			mysqli_query($dbase,"UPDATE `scores` SET `over`='$bowlerOv' WHERE `pid`='$bowl' AND `matchid`='$matchid'");
		}

		if (isset($_POST['correct'])) {
			$values=explode(',',$_COOKIE['lastball']);
			$runs=$values[0];
			$over=$values[1];
			$wicket=$values[2];
			$lastover=$values[3];
			
			//player error
			$playerError=$_COOKIE['playerError'];
			$playerError=explode(',',$playerError);
			if ($playerError[2]==1 && !isset($_COOKIE['striker'])) {
				chstrike();
			}
			if (isset($_COOKIE['striker'])) {
				if (intval($over*10)%10==5 ) {
					chstrike();
				}
				$striker=$_COOKIE['striker'];
				mysqli_query($dbase,"UPDATE `scores` SET `status`='' WHERE `status`='$playerError[3]' AND `matchid`='$matchid' ");
				mysqli_query($dbase,"UPDATE `scores` SET `status`='$playerError[3]' WHERE `pid`='$striker' AND `matchid`='$matchid' ");
				mysqli_query($dbase,"UPDATE `scores` SET `takenby`='0' WHERE `pid`='$striker' AND `matchid`='$matchid' ");
				if (isset($_COOKIE['striker2'])) {
					$striker2=explode(',', $_COOKIE['striker2']);
					$strikerID=$striker2[0];
					$strikerRuns=$striker2[1];
					$strikerIb=$striker2[2];
					mysqli_query($dbase,"UPDATE `scores` SET `runs`='$strikerRuns' WHERE `pid`='$strikerID' AND `matchid`='$matchid' ");
					mysqli_query($dbase,"UPDATE `scores` SET `inballs`='$strikerIb' WHERE `pid`='$strikerID' AND `matchid`='$matchid' ");
				}
			}
			if (isset($_COOKIE['pbowler'])) {
				if (!isset($_COOKIE['striker'])) {
					chstrike();	
				}
				//chstrike();
				$pbowler=$_COOKIE['pbowler'];
				$bowlerOv-=1;
				mysqli_query($dbase,"UPDATE `scores` SET `over`='$bowlerOv' WHERE `pid`='$bowlerid' AND `matchid`='$matchid'");
				mysqli_query($dbase,"UPDATE `scores` SET `status`='' WHERE `pid`='$bowlerid' AND `matchid`='$matchid'");
				mysqli_query($dbase,"UPDATE `scores` SET `status`='01' WHERE `pid`='$pbowler' AND `matchid`='$matchid'");

			}
			mysqli_query($dbase,"UPDATE `scores` SET `runs`='$playerError[0]' WHERE `status`='$playerError[3]' AND `matchid`='$matchid'");
			//echo "<script>alert('$playerError[0] $playerError[1] $playerError[2]')</script>";
			mysqli_query($dbase,"UPDATE `scores` SET `inballs`='$playerError[1]' WHERE `status`='$playerError[3]' AND `matchid`='$matchid'");

			if (isset($_COOKIE['striker'])) {
				if ($playerError[2]==1) {
					chstrike();
				}
				$wicket=mysqli_query($dbase,"SELECT `wicket` FROM `scores` WHERE `status`='01' AND `matchid`='$matchid'");
				$wicket=mysqli_fetch_assoc($wicket);
				$wicket=$wicket['wicket'];
				$wicket--;
				mysqli_query($dbase,"UPDATE `scores` SET `wicket`='$wicket' WHERE `status`='01' AND `matchid`='$matchid'");
			}
			//echo "<script>alert('$playerError[0] $playerError[1] $playerError[2]')</script>";

			//player error ends...

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
			mysqli_query($dbase,"UPDATE `matches` SET `lastover`='$lastover' WHERE `matchid`='$matchid' ");
		}
		if (isset($_POST['strike'])) {
			chstrike();
		}
	}

	function chstrike(){
		global $dbase,$matchid;
		mysqli_query($dbase,"UPDATE `scores` SET `status`= CASE WHEN (`status`='11' AND `matchid`='$matchid') THEN '10' WHEN (`status`='10' AND `matchid`='$matchid')  THEN '11' WHEN (`status`='00' AND `matchid`='$matchid')  THEN '00' WHEN (`status`='01' AND `matchid`='$matchid')  THEN '01' END ") ;
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
<div class="scoreEdit">
	<div class="myrow">
		<div class="col-5 col-m-12">
			<table id="scoreAdminTable">
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
					<td colspan="2">
						<p>
							<?php
								if ($inn=='i1') {
									echo "Now Batting : $teami1 Inn:1";
								}
								else{
									echo "Now Batting : $teami2 Inn:2";
								}
							?>
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<?php
						$bat1=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `pid`,`runs`,`inballs`,`pname` FROM `scores` NATURAL JOIN `players` WHERE `status`='11' AND `matchid`='$matchid'"));
						$name1=$bat1['pname'];
						$runs=$bat1['runs'];
						$inballs=$bat1['inballs'];
						$pid1=$bat1['pid'];
						echo "Batting* : $name1 --> $runs($inballs)";
						?>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<?php
						$bat2=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `pid`,`runs`,`inballs`,`pname` FROM `scores` NATURAL JOIN `players` WHERE `status`='10' AND `matchid`='$matchid'"));
						$name2=$bat2['pname'];
						$runs=$bat2['runs'];
						$inballs=$bat2['inballs'];
						$pid2=$bat2['pid'];
						echo "Batting : $name2 --> $runs($inballs)";
						?>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<?php
						$bowl=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `pname` FROM `scores` NATURAL JOIN `players` WHERE `status`='01' AND `matchid`='$matchid'"));
						$bowl=$bowl['pname'];
						echo "Bowling : $bowl";
						?>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<?php echo substr($lastover,1)?>
					</td>
				</tr>
			</table>
		</div>
		<div class="col-7 col-m-12">
			<form action="admin.php" method="post" id="updateForm">
				<table id="scoreEditTable">
					<tr>
						<td><label>Runs&nbsp: </label></td>
						<td>
							<input type="radio" name="runs" value="0" checked>&nbsp+0
							<input type="radio" name="runs" value="1">&nbsp+1
							<input type="radio" name="runs" value="2">&nbsp+2
							<input type="radio" name="runs" value="3">&nbsp+3<br>
							<input type="radio" name="runs" value="4">&nbsp+4
							<input type="radio" name="runs" value="6">&nbsp+6
						</td>
					</tr>
					<tr>
						<td><label>Delivery&nbsp: </label></td>
						<td>
							<input type="radio" name="del" value="fair" checked>&nbspFair&nbsp<br>
							<input type="radio" name="del" value="wide">&nbspWide&nbsp
							<input type="radio" name="del" value="noball">&nbspNo&nbspBall&nbsp<br>
							<hr>
							<h4>Wicket : </h4>
							<input type="radio" name="del" value="bold">&nbspBold&nbsp<br>
							<input type="radio" name="del" value="lbw">&nbspLBW&nbsp<br>
							<input type="radio" name="del" value="caught">&nbspCaught!&nbsp<br>
							<input type="radio" name="del" value="stummped">&nbspStummped&nbsp<br>RunOut : 
							<input type="radio" name="del" value="<?php echo 'runout,'.$pid1;?>">&nbsp<?php echo $name1;?>&nbsp
							<input type="radio" name="del" value="<?php echo 'runout,'.$pid2;?>">&nbsp<?php echo $name2;?>&nbsp
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" name="update" value="Update" class="submitb"></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" name="correct" value="Need Correction" class="submitb"></td>
					</tr>
					<!-- <tr>
						<td colspan="2"><input type="submit" name="strike" value="Change Strike" class="submitb"></td>
					</tr> -->
				</table>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
</body>
</html>

<?php
	if ($inn=='i1') {
		$batsmans=mysqli_query($dbase,"SELECT `pname`,`pid` FROM `players` WHERE `pid` IN (SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `tid`='$teami1id' AND `takenby`='0' AND `status`<>'10' AND `status`<>'11')");
	}
	else
	{
		$batsmans=mysqli_query($dbase,"SELECT `pname`,`pid` FROM `players` WHERE `pid` IN (SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `tid`='$teami2id' AND `takenby`='0' AND `status`<>'10')");
	}
	if ($inn=='i1') {
		$bowlers=mysqli_query($dbase,"SELECT `pname`,`pid` FROM `players` WHERE `pid` IN (SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `tid`='$teami2id' AND `over`<'3' AND `pid`<>'$bowlerid')");
	}
	else
	{
		$bowlers=mysqli_query($dbase,"SELECT `pname`,`pid` FROM `players` WHERE `pid` IN (SELECT `pid` FROM `teamalloc` NATURAL JOIN `scores` WHERE `matchid`='$matchid' AND `tid`='$teami1id' AND `over`<'3' AND `pid`<>'$bowlerid')");
	}
	$options="";
	foreach ($batsmans as $value) {
		$pid=$value['pid'];
		$pname=$value['pname'];
		$options.="<option value='$pid'>$pname</option>";
	}
	$options2="";
	foreach ($bowlers as $value) {
		$pid=$value['pid'];
		$pname=$value['pname'];
		$options2.="<option value='$pid'>$pname</option>";
	}
	if( $completed[1]==0) {
	echo "
		<div id='block'></div>
		<form action='admin.php' method='post'>
		<table id='openerTable'>
			<tr>
				<td colspan='2' style='color: red;'>$showError</td>
			</tr>
			<tr>
				<td><label for='opener'>Select Opening Batsman : </label></td>
				<td>
				<select name='bat1' class='teamc'>
					$options
				</select>
				</td>
			</tr>

			<tr>
				<td><label for='opener'>Select Batsman 2 : </label></td>
				<td>
				<select name='bat2' class='teamc'>
					$options
				</select>
				</td>
			</tr>

			<tr>
				<td colspan='2'>
					<input type='submit' value='Select' class='submitb' name='opener'>
				</td>
			</tr>
		</table>
		
		</form>
	";
	}
	elseif ($completed[1]==1) {
	echo "
		<div id='block'></div>
		<form action='admin.php' method='post'>
		<table id='openerTable'>
			<tr>
				<td><label for='opener'>Select Batsman : </label></td>
				<td>
				<select name='bat2' class='teamc'>
					$options
				</select>
				</td>
			</tr>

			<tr>
				<td colspan='2'>
					<input type='submit' value='Select' class='submitb' name='batsmn'>
				</td>
			</tr>
		</table>
		
		</form>
	";
	}
	elseif ($completed[2]==0) {
	echo "
		<div id='block'></div>
		<form action='admin.php' method='post'>
		<table id='openerTable'>
			<tr>
				<td><label for='opener'>Select Bowler : </label></td>
				<td>
				<select name='bowl' class='teamc'>
					$options2
				</select>
				</td>
			</tr>

			<tr>
				<td colspan='2'>
					<input type='submit' value='Select' class='submitb' name='bowler'>
				</td>
			</tr>
		</table>
		
		</form>
	";
	mysqli_query($dbase,"UPDATE `scores` SET `status`='' WHERE `pid`='$bowlerid'  AND `matchid`='$matchid'");

	}

?>