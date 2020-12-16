<?
require('header.php');
////// select pattern or name
echo'<form name="Myselect" action="'.$_SERVER['PHP_SELF'].'" method="POST">
	Pattern/Prefix, let empty to select all <input type="texte" name="letter" />
	<input type="button" value="Select" OnClick="document.Myselect.submit()"></form>';
////////////////////////////

////// select carriers
$count = mysqli_fetch_row(mysqli_query($ladmin,"SELECT COUNT(*) FROM asterisk.trunks"));
echo'<form action="routage.php" method="post">
	<input type="hidden" name="letter" value="'.$_POST['letter'].'" />
	<table align="center" border="0"><tr>';
for($i=1;$i<= $count[0];$i++)
	{
	echo'<td>Carrier '.$i.'</td>
		<td><select name="car'.$i.'" value=""><option></option>';
	$sCdrsql = mysqli_query($ladmin,"SELECT * FROM asterisk.trunks ORDER BY name");
	while($car = mysqli_fetch_row($sCdrsql))
		{
		echo'<option value="'.$car[0].'">'.$car[0].'</option>';
		}
	if($i == '5' || $i == '10')
		{
		echo'</select></td></tr><tr>';
		}
		else
		{
		echo'</select></td></tr>';
		}
	}
echo'<tr>
	<td colspan="'.($i * 2).'" align="center"><input type="hidden" name="change" value="change" />
	<input type="submit" value="Make change" />
	</td></tr>
	</table>';

if(isset($_POST['letter']))
	{
	$letter = $_POST['letter'];
	$sCdrsql = mysqli_query($ladmin,"SELECT pattern,comment,trunks,ek FROM admin.master WHERE comment LIKE '".$letter."%' || pattern LIKE '".$letter."%' ORDER BY comment");
	if((isset($_POST['car1'])) && $_POST['car1'] !='')
		{
		$counter = 0;
		foreach($_POST as $key => $val) if (!empty($val) && $key !='letter' && $key !='change'){$counter = $counter + 1;}
		for ($i = 1; $i <= $counter; $i++)
			{
			$road .= $_POST['car'.$i.''].':';
			}
		$route = substr($road,0,strlen($road)-1);
		mysqli_query($ladmin,"UPDATE admin.master SET trunks='".$route."' WHERE comment LIKE '".$letter."%' || pattern LIKE '".$letter."%'");
		unset($_POST['car1'],$_POST['letter']);
		echo "<SCRIPT LANGUAGE='JavaScript'>window.location.replace('routage.php?letter=".$letter."')</script>";
		}
	echo'<table align="center" width="900" border="1">';
	while($ya = mysqli_fetch_row($sCdrsql))
		{
		$yak = explode(":",$ya[2]);
		echo'<tr>
		<td>'.$ya[1].'</td>
		<td>'.$ya[0].'</td>
		<td>'.$yak[0].'</td>
		<td>'.$yak[1].'</td>
		<td>'.$yak[2].'</td>
		<td>'.$yak[3].'</td>
		<td>'.$yak[4].'</td>
		<td>'.$ya[3].'</td>
		</tr>';
		}
	echo'</table>';
	}

if(isset($_GET['letter']))
	{
	$letter = $_GET['letter'];
	$sCdrsql = mysqli_query($ladmin,"SELECT pattern,comment,trunks,ek FROM admin.master WHERE comment LIKE '".$letter."%' || pattern LIKE '".$letter."%' ORDER BY comment");
	echo'<table align="center" width="900" border="1">';
	while($ya = mysqli_fetch_row($sCdrsql))
		{
		$yak = explode(":",$ya[2]);
		echo'<tr><td>'.$ya[1].'</td><td>'.$ya[0].'</td><td>
		'.$yak[0].'</td><td>'.$yak[1].'</td><td>'.$yak[2].'</td><td>'.$yak[3].'</td><td>'.$yak[4].'</td><td>'.$ya[3].'</td></tr>';
		}
	echo'</table>';
	}
require('footer.php');
?>