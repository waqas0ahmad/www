<?php
require ("inc/php/header.inc.php");
###############  Comdif Telecom Billing software  ###############
							$userver= 01;
###############  Christian Zeler  Comdif Telecom  ###############
$objAsterisk = new DB(); $objAsterisk->connect(ASTERISK);
$cID=mysql_fetch_array(mysql_query("SELECT callerid FROM asterisk.sipfriends WHERE name='".$sipnummer."' OR accountcode='".$sipnummer."'"));
$caid=explode(" ",$cID[0]);
if(!empty($_POST['oknow']))
	{
	if($_POST['changedid'] !='')
		{
		mysql_query("UPDATE asterisk.sipfriends SET callerid='".$_POST['changedid']." <".$_POST['changedid'].">' 
		WHERE name='".$sipnummer."' OR accountcode='".$sipnummer."'");
		shell_exec("sudo /usr/sbin/asterisk -rx 'sip reload'");
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
	
	echo'<table cellpadding="2" cellspacing="5" border="1" align="center" width="300" class="cust"><tr>
		<td class="cust" align="center">'.translate("admincustsipserver").'</td>
		<td class="cust" align="center"><b>'.$_SERVER['SERVER_ADDR'].'</b></td>
		</tr><tr>
		<td class="cust" align="center">'.translate("admincustsipnumber").'</td>
		<td class="cust" align="center"><b>'.$sipnummer.'</b></td>
		</tr><tr>
		<td class="cust" align="center">'.translate("admincustsippassword").'</td>
		<td class="cust" align="center"><b>'.$secret.'</b></td>
		</tr><tr>
		<td class="cust" align="center">Callerid</td>
		<td class="cust" align="center"><form method="POST" action="'.$_SERVER['PHP_SELF'].'">
		<br/><input type="text" name="changedid" value="'.$caid[0].'" />
		<input type="hidden" name="oknow" value="oknow" />
		<input type="submit" /></form></td>
		</tr><tr>
		<td class="cust" align="center">'.translate("adminbox3title").'</td>
		<td class="cust" align="center">';
	if($telefonangemeldet > 0)
  		{
		echo "<div class='boldlightgreen' style='text-align: center'>" . translate("admincustphoneonlinett") . "</div>
		<br />Refresh in: $telefonangemeldet s";
		}
  		else
  		{
		echo "<div class='boldred' style='text-align: center'>" . translate("admincustphoneofflinett") . "</div>";
		}
	echo'</td>
		</tr><tr>
		<td class="cust" align="center">IP</td>
		<td class="cust" align="center">'.$ipaddr.'</td>
		</tr></table>';
	}
	
$objAsterisk->closeDb();
require("inc/php/footer.inc.php");
?>
