<?
require('header.php');
$db_list = mysqli_query($ladmin,"SHOW DATABASES");
#############################################################
echo'<p>&nbsp;</p><div align="center">
	<form method="POST" action="'.$_SERVER['PHP_SELF'].'">
	<select name="dbase">';
while ($row = mysqli_fetch_row($db_list))
	{
	//preg_match('/astcc_[a-zA-Z0-9]+/',$row[0],$aa);
	//echo '<option value="'.$aa[0].'">'.$aa[0].'</option>';
	echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
echo'</select>
	<input type="submit" value="SELECT CLIENT" /></form></div>';
#############################################################
if ($_POST["dbase"]!='')
	{
	$yo = $ladmin->query('SHOW TABLES from '.$_POST["dbase"].'');
	echo'<div align="center">CLIENT: '.$_POST["dbase"].'</div>';
	echo'<br/><div align="center"><form method="POST" action="exportex.php">
		<select name="table">';
	while($yi=mysqli_fetch_row($yo))
		{
		echo '<option value="'.$yi[0].'">'.$yi[0].'</option>';
		}
	echo'</select>
		<input type="hidden" name="dbase" value="'.$_POST["dbase"].'" />
		<input type="submit" value="SELECT DBASE" />
		</form></div>';
	}
?>