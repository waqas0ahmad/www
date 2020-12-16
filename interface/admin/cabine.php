<?php
############################
### 2018 MYSQLI SUPPORT ###
############################
require_once("../inc/php/admin_init.inc.php");
//require ("../inc/php/astcc.inc.php");
//print_r($_COOKIE);
#Numero de cabine
$query = mysqli_query($ladmin,"select * from ".ASTCC.".cards where ( number > $startcabine AND number <= $endcabine ) order by number");
$k=$mep; $i = 1; $zz = 1;
echo '<table align="center"><tr>';

while ($cab1=mysqli_fetch_assoc($query))
	{
	require_once("../inc/php/astcc.inc.php");
	$cab= $cab1['number'];
	$somme = mysqli_query($ladmin,"SELECT SUM(billcost) as total FROM ".ASTCC.".cumul WHERE cardnum='$cab'")or die(mysqli_error($ladmin)); 
	$detail = mysqli_fetch_assoc($somme); $a = $detail['total'] / 10000;
	
	if ($a >'0')
		{
		$bgcel='../imgs/fndbill.gif';
		}
	else
		{
		$bgcel='../imgs/fndo.gif';
		}
	echo'<td>
		<table width="220" height="132" border="0" cellpadding="0" cellspacing="0"">
		<tr  style="line-height: 1px">
		<td width="7" height="7"><img src="../imgs/angleHGs.gif" width="7" height="7" /></td>
		<td width="100" bgcolor="#114694" height="7">&nbsp;</td>
		<td bgcolor="#114694">&nbsp;</td>
		<td width="7"><img src="../imgs/angleHDs.gif" width="7" height="7" /></td></tr>
		<td height="100" rowspan="3" bgcolor="#114694"></td>
		<td rowspan="3" background="'.$bgcel.'">';
	$codeY = str_split($cab1['number']); $cabineY = ($codeY[2] + $codeY[3] + '1'); $numcabY = '&nbsp;'.$cabineY.''; $nomcab =$cab1['nomcab']; 
	$cabine = mysqli_query($ladmin,"SELECT inuse, brand, facevalue FROM ".ASTCC.".cards WHERE number='$cab'"); 
	$etatcabine = mysqli_fetch_array($cabine);
	echo'<font size="5" color="blue">'.$nomcab.' </font>';

	//////////////////////////////////////////////////////////////// PHONE ONLINE ///////////////////////////
	if($etatcabine['inuse'] == 1)
		{
		########To display realtime call datas 03/05/2010 new dynamic db datas incremented and erased by agi ##############
		$mydyn = mysqli_query($ladmin,"SELECT * FROM ".ASTCC.".dynacab WHERE cardnumo='".$cab."'"); $reg = mysqli_fetch_row($mydyn);
		//echo $reg["commento"];
		$tst = $reg[2]; $dnum = $reg[3]; $desti = $reg[4]; $rcost = $reg[5]; $ccon = $reg[6]; $secinc = $reg[7];
		####################################################################################################################
	
		echo '<font color="purple">'.$desti.'</font><br/>
			<a href="javascript: void(0)" title="'.translate("hangup").'" onclick="window.open(\'hangup.php?cabineID='.(log($cab)*99999991234).'\', \'windowname2\', 
			\'width=500, height=250, directories=no, location=no, menubar=no, resizable=yes, scrollbars=0, status=no, toolbar=no\'); return false;">
			<div align="center"><img src="../imgs/rph.png" width="70" height="70" title="'.translate("hangup").'" title="'.translate("hangup").'"/></a><br/>
			<a href="javascript: void(0)" title="Dial" onclick="window.open(\'dial.php?cab='.(log($cab)*99999991234).'\', \'windowname2\', 
			\'width=240, height=120, directories=no, location=no, menubar=no, resizable=yes, scrollbars=yes, status=no, toolbar=no\'); 
			return false;">Dial</div>';	   
		mysqli_free_result($cabine);
		}
	else
	//////////////////////////////////////////////////////////////// PHONE OFFLINE ///////////////////////////
		{
		if($etatcabine['brand'] != 'pp')
			{ 
			echo'<a href="javascript: void(0)" title="Prepaid" onclick="window.open(\'fonctions/prepaid.php?cabineID='.(log($cab)*99999991234).'\', 
			\'windowname22\', \'width=700, height=300, directories=no, location=no, menubar=no, resizable=yes, scrollbars=yes, status=no, toolbar=no\'); return false;">
			<font color="red">Prepay '.(($etatcabine['facevalue'])/(10000)).' '.$devise.'</font></a>';
			}
		else
			{
			echo'<a href="javascript: void(0)" title="Prepaid" onclick="window.open(\'fonctions/prepaid.php?cabineID='.(log($cab)*99999991234).'\', 
			\'windowname22\', \'width=700, height=300, directories=no, location=no, menubar=no, resizable=yes, scrollbars=yes, status=no, toolbar=no\'); return false;">
			<font color="green">Prepay</font></a>';
			}
		echo'<br/><div align="center"><a href="javascript: void(0)" title="History" onclick="window.open(\'histo.php?cabineID='.(log($cab)*99999991234).'\', 
		\'windowname2\', \'width=700, height=300, directories=no, location=no, menubar=no, resizable=yes, scrollbars=yes, status=no, toolbar=no\'); return false;">
		<img src="../imgs/bph.png" width="70" height="70" /></a>';
		
		echo'<br/><a href="javascript: void(0)" title="Dial" onclick="window.open(\'dial.php?cab='.(log($cab)*99999991234).'\', \'windowname2\', 
		\'width=240, height=120, directories=no, location=no, menubar=no, resizable=yes, scrollbars=yes, status=no, toolbar=no\'); return false;">Dial</div>';
		 mysqli_free_result($cabine);
		 }
	//AFFICHAGE sous cabines montant de tous les appels et nombre d'appels
	echo'</td><td background="'.$bgcel.'">';
	echo'<div align="center"><a href="javascript: void(0)" onclick="window.open(\'transfert.php?cab='.(log($cab)*99999991234).'\', \'windowname6\', \'width=200, 
	height=80, directories=no, location=no, menubar=no, resizable=yes, scrollbars=no, status=no, toolbar=no\'); return false;"><font class="a">Transfert</a></font><br/> 
	<td rowspan="3" bgcolor="#114694">&nbsp;</td></tr><tr>';
	if ($a >'0')
		{
		echo'<td height="4" background="'.$bgcel.'">';
		require ("cabfon1.php");
		}
	else
		{
		echo'<td height="4" background="'.$bgcel.'">';
		require ("cabfon2.php");
		}
	echo '</td></tr><tr><td height="7" bgcolor="#114694"></td>';
########################### DISPLAY REALTIME CALL #########################################
	if ( isset($tst) && $tst != '')
		{
		$adjtime = round((((time()- $tst))/60),1);
		if ($adjtime <= ($secinc/60))
			{
			$cronop = $ccon;
			}
		else
			{
			$cronop = $rcost * ceil($adjtime);
			}
		echo'<td bgcolor="#FFFFB3"><font size="3" color="purple">'.ceil($adjtime).'</font><font size="2" color="purple"> MIN </font>
		<font size="2" color="red">'.$dnum.' </font></td><td bgcolor="#FFFFB3"><font size="4" color="purple">'.($cronop/10000).''.$devise.'</font>';
		}
	############################################################################################
	else
		{
		echo '<td background="'.$bgcel.'"></td><td background="'.$bgcel.'">';
		}
	echo'</td><td bgcolor="#114694"></td></tr><tr style="line-height: 1px"><td height="7"><img src="../imgs/angleBGs.gif" width="7" height="7" />
	</td><td bordercolor="#FFFFFF" bgcolor="#114694">&nbsp;</td><td bgcolor="#114694">&nbsp;</td>
	<td><img src="../imgs/angleBDs.gif" width="7" height="7" /></td></tr></table>';

	//RECUPERATION detail des appels cabine
	$result = mysqli_query($ladmin,"SELECT callerid,callednum,disposition,billseconds,billcost,datecall,includedseconds,routecost,comment,opcost,trunk 
	FROM ".ASTCC.".cdrs WHERE disposition='ANSWER' and cardnum='".$cab."' order by datecall Desc")or die(mysqli_error($ladmin)); 
	//FIN RECUPERATION detail des appels cabine
	while($row = mysqli_fetch_array($result))
		{
		//Si appel superieur à included second
		if ($row['billseconds'] > $row['includedseconds'] )
			{
			//combien il y a de paliers dans une minute
			$palliersminute= 60/$palier;
			//on compte le nombre de paliers
			$time = ceil($row['billseconds']/$palier);
			//on multiplie le nombre de paliers par le cout minute/ nombre de paliers minute de la route
			$cost = $time * ($row['routecost'] / $palliersminute);
			//on renseigne une variable prix
			$costcumul = $cost;
			//on ajuste le nombre de seconde avec le temps arrangé en minute pleines
			$timecumul = $time * $palier;
			}
		else
			//appels de moins que le includedsecond
			{
			$cost = (($row['billcost']));
			//on arrondi legerement le nombre de minutes pour éviter les virguless
			$time = round((($row['billseconds'])/60),2);
			//on retransforme en secondes arrangées
			$costcumul = $cost ; $timecumul = $time * 60;
			}
		//ENVOI des données vers la table cumul
		$calldate1 = mysqli_query($ladmin,"SELECT * FROM ".ASTCC.".cumul WHERE cardnum='$cab' and datecall='$row[5]'")or die(mysqli_error($ladmin));
		$calldate = mysqli_fetch_array($calldate1);

		if (!isset($calldate['datecall']))
			{
			mysqli_query($ladmin,"INSERT INTO ".ASTCC.".cumul 
			(`callerid`,`cardnum`,`callednum`,`disposition`,`billseconds`,`billcost`,`callstart`,`datecall`,`comment`,`trunk`,`opcost`) 
			VALUES ( '".$row['callerid']."','$cab','".$row['callednum']."',
			'".$row['disposition']."','$timecumul','$costcumul','".$row['opcost']."','".$row['datecall']."',
			'".$row['comment']."', '".$row['billseconds']."', '".$row['trunk']."')")or die(mysqli_error($ladmin));
			}
		mysqli_free_result($calldate1); }

		//FIN ENVOI des données vers la table cumul
		mysqli_free_result($result); 
		echo '</td>';
		unset ($tst , $dnum , $desti , $rcost , $ccon , $secinc);
//---------------------------------
		if ($i == $k) {echo '</tr><tr>'; $i = 1; $zz = $zz + 1; }else {$i= $i + 1; $zz = $zz + 1;}
		}
	echo'</table>';
require_once("cabinecyber.php");
?>