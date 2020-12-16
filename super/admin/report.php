<?php
require('header.php');
echo'<table align="center" border="0"><tr>
	<td>';
include ("calendar.php"); echo'</td>';

echo'<td width="100" align="right"><form action="'.$_SERVER['PHP_SELF'].'" method="post"><input type="hidden" name="per" value="day" />
	<input type="submit" value="Day" class="butlink" /></form></td>
	<td width="100" align="right"><form action="'.$_SERVER['PHP_SELF'].'" method="post"><input type="hidden" name="per" value="month" />
	<input type="submit" value="Month" class="butlink" /></form></td>
	</tr></table>';

if (!empty($_POST["date"]))
	{
	$starti = ''.$_POST["date"].' 00:00:00'; $endi = ''.$_POST["date2"].' 23:59:59';
	$where = "datecall >= '".$starti."' AND datecall <= '".$endi."'";
	echo'<div align="center" style="background-color:#58ACFA;width:700;">From: <strong>'.$starti.'</strong> To: <strong>'.$endi.'</strong></div><br>';
	}
// if current month or day is requested
if(!empty($_POST["per"]))
	{
	if( $_POST["per"] == month )
		{
		$curd = date("Y-m");
		echo'<div align="center" style="background-color:#58ACFA;width:700;"><strong>Month: '.$curd.'</strong></div><br>';
		}
		else
		{
		$curd = date("Y-m-d");
		echo'<div align="center" style="background-color:#58ACFA;width:700;"><strong>Day: '.$curd.'</strong></div><br>';
		}
	$where = "datecall LIKE '".$curd."%'";
	}
// defaut display current day		
if((empty($_POST["per"])) && (empty($_POST["date"])))
	{
	$curd = date("Y-m-d");
	$where = "datecall LIKE '".$curd."%'";
	echo'<div align="center" style="background-color:#58ACFA;width:700;"><strong>Day: '.$curd.'</strong></div>';
	}

if(!empty($_POST["trunks"]))
	{
	$where = "".$where." AND trunk='".$_POST["trunks"]."'";
	echo'<div align="center"><strong>Trunk: '.$_POST["trunks"].'</strong></div>';
	}
if(!empty($_POST["custom"]))
	{
	$where = "".$where." AND account='".$_POST["custom"]."'";
	echo'<div align="center"><strong>Account: '.$_POST["custom"].'</strong></div>';
	}

// extract an display data
$data = mysqli_fetch_array(mysqli_query($ladmin,"SELECT SUM(opcost) AS opcost, SUM(normalcost) AS normalcost, SUM(billseconds) AS time FROM admin.cdrs WHERE ".$where.""));
$count = mysqli_fetch_row(mysqli_query($ladmin,"SELECT COUNT(*) FROM admin.cdrs WHERE ".$where.""));
$countgr = mysqli_fetch_row(mysqli_query($ladmin,"SELECT COUNT(*) FROM admin.cdrs WHERE billseconds <= '14' AND ".$where.""));
$reste1=((($data['time']/60)*10) % 10); $reste2=((($data['time']/60)*100) % 10); $reste= ''.$reste1.''.$reste2.'';
$secondes= round((($reste / 100) * 60 ),0);

if(($count[0]) == 0)
	{
	$durbrut = 0;
	}
else
	{
	$durbrut= (($data['time'])/($count[0]));
	}

$du1=((($durbrut/60)*10) % 10); 
$du2=((($durbrut/60)*100) % 10); 
$du= ''.$du1.''.$du2.'';
$dusec= round((($du / 100) * 60 ),0);

echo 'Facturé: '.($data['opcost'] /10000).' &euro;';
echo'<br/>Normalement facturable: '.($data['normalcost'] / 10000).' &euro;';
echo '<br/>Offert inferieur au pallier : '.round((($data['normalcost'] / 10000)-($data['opcost'] /10000)),2).' &euro;';
echo'<br/>Nombre appels: '.$count[0].'';
echo'<br/>Minutes: '.round(($data['time']/60),0).':'.$secondes;
echo'<br/>Durée moyenne: '.round(($durbrut/60),0).':'.$dusec;

if(($count[0]) == 0)
	{
	echo'<br/>Facturation moyenne par appel: 0 &euro;';
	}
else
	{
	echo'<br/>Facturation moyenne par appel: '.round((($data['opcost'] /10000) / ($count[0])),2).' &euro;';
	}
echo'<br/>Nombre appels non facturés inférieurs au pallier: '.$countgr[0].'';
echo'<br/>Nombre appels facturés : '.( $count[0] - $countgr[0]).'';

if(($count[0]) == 0)
	{
	echo'<br/>Pourcentage facturés: 0 %';
	}
else
	{
	echo'<br/>Pourcentage facturés: '.round(((($count[0] - $countgr[0])/ $count[0])*100),1).' %';
	}
echo'<br/><a href="excdrs.php?where='.$where.'">export</a>';
// select a trunk
echo'<br/><br/><br/><div align="center"><form action="'.$_SERVER['PHP_SELF'].'" method="post">
	SELECT a TRUNK: <select name="trunks"><option value=""></option>';
	
$trun = mysqli_query($ladmin,"SELECT name FROM asterisk.trunks");
while ($tru=mysqli_fetch_row($trun))
	{
	echo'<option value="'.$tru[0].'">'.$tru[0].'</option>';
	}
echo'</select>
	<input type="hidden" name="per" value="'.$_POST["per"].'" />
	<input type="hidden" name="date" value="'.$_POST["date"].'" />
	<input type="hidden" name="date2" value="'.$_POST["date2"].'" />
	<input type="hidden" name="custom" value="'.$_POST["custom"].'" />
	<input type="submit" value="Select" /></form>';

// select customer
echo'<div align="center"><form action="'.$_SERVER['PHP_SELF'].'" method="post">
	SELECT a CUSTOMER: <select name="custom"><option value=""></option>';
$cust = mysqli_query($ladmin,"SELECT user FROM admin.custom order by USER ASC");
while ($cus=mysqli_fetch_row($cust))
	{
	echo'<option value="'.$cus[0].'">'.$cus[0].'</option>';
	}
echo'</select>
	<input type="hidden" name="per" value="'.$_POST["per"].'" />
	<input type="hidden" name="date" value="'.$_POST["date"].'" />
	<input type="hidden" name="date2" value="'.$_POST["date2"].'" />
	<input type="hidden" name="trunks" value="'.$_POST["trunks"].'" />
	<input type="submit" value="Select" /></form>';
require('footer.php');
?>