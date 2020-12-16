<?php
//comdif Telecom @2011
require ("inc/php/header.inc.php");
$objAsterisk = new DB(); $objAsterisk->connect(ASTERISK);
$cID=mysql_fetch_array(mysql_query("SELECT callerid FROM asterisk.sipfriends WHERE name='".$sipnummer."' OR accountcode='".$sipnummer."'"));
$caid=explode(" ",$cID[0]);
if(!empty($_POST['oknow']))
	{
	if($_POST['changedid'] !='')
		{
		mysql_query("UPDATE asterisk.sipfriends SET callerid='".$_POST['changedid']." <".$_POST['changedid'].">' 
		WHERE name='".$sipnummer."' OR accountcode='".$sipnummer."'");
		echo "<SCRIPT LANGUAGE='JavaScript'>window.location.replace('".$_SERVER['PHP_SELF']."')</script>";
		}
	else
		{
		mysql_query("UPDATE asterisk.sipfriends SET callerid='' WHERE name='".$sipnummer."' OR accountcode='".$sipnummer."'");
		echo "<SCRIPT LANGUAGE='JavaScript'>window.location.replace('".$_SERVER['PHP_SELF']."')</script>";
		}
	}		

echo'<div class="headline_global">'.translate("linkmyaccount").'</div>';

if ($ausgefuellt=='ja')
	{
	echo "Please Login  /  Connectez vous SVP";
	}
	if($angemeldet > 0)
	{
	echo'<div class="boldblack">'.translate("myregdata").':</div><br>';
	require("inc/php/getsipdata.inc.php");
	echo'<table  cellpadding="0" cellspacing="0" border="2" align="center" width="300" ><tr>
		<td class="gap" align="center">'.translate("admincustsipserver").'</td>
		<td class="gap" align="center"><b>'.$_SERVER['SERVER_ADDR'].'</b></td>';
		
	echo'</tr><tr>';
	
	echo'<td class="gap" align="center">'.translate("admincustsipnumber").'</td>
		<td class="gap" align="center"><b>'.$sipnummer.'</b></td>';
		
	echo'</tr><tr>';
	
	echo'<td class="gap" align="center">'.translate("admincustsippassword").'</td>
		<td class="gap" align="center"><b>'.$secret.'</b></td>';

	echo'</tr><tr>';
	
		echo'<td class="gap" align="center">Callerid</td>
		<td class="gap" align="center"><form method="POST" action="'.$_SERVER['PHP_SELF'].'">
		<input type="text" name="changedid" value="'.$caid[0].'"><b></b></input>
		<input type="hidden" name="oknow" value="oknow" />
		<input type="submit" /></form></td>';
		
	echo'</tr><tr>';
	
	echo'<td class="gap" align="center">'.translate("adminbox3title").'</td>
		<td class="gap" align="center">';
	if($telefonangemeldet > 0)
  		{
		echo "<div class='boldlightgreen' style='text-align: center'>" . translate("admincustphoneonlinett") . "</div>
		<br />Refresh in: $telefonangemeldet s";
		}
  		else
  		{
		echo "<div class='boldred' style='text-align: center'>" . translate("admincustphoneofflinett") . "</div>";
		}
	echo'</td>';
	echo'</tr><tr>';
	echo'<td class="gap" align="center">IP</td><td class="gap" align="center">'.$ipaddr.'</td></tr></table>';
	}
	
$objAsterisk->closeDb();
require("inc/php/footer.inc.php");
?>
