<?php
	echo "
		<div id='block'></div>
		<form action='test.php' method='post'>
		<table id='openerTable'>
			<tr>
				<td><label for='opener'>Select Opening Batsban</label></td>
				<td>
				<select>
					<option>1</option>
					<option>11</option>
					<option>111</option>
					<option>1111</option>
				</select>
				</td>
			</tr>
		</table>
		
		</form>
	";
?>

<style type="text/css">
#block{
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	height: 100vh;
	background-color: rgba(0,0,0,0.9);
	z-index: 99;
}

#openerTable{
	position: absolute;
	top: 45%;
	left: 40%;
	z-index: 100;
	color: white;
	margin: 0 auto;
}
</style>