<?php
############################
### 2018 MYSQLI SUPPORT ###
############################
echo '<div class="headline_global">'.translate("admincusttitle").'</div><div class="boldblack">'.translate("admincustinfo").'</div>';
# Check form
if(isset($_VARS['input_account'])) $_VARS['input_webuser'] = $_VARS['input_account'];
$reval = checkrequiredValuesAdmin($_VARS);
if (isset($_VARS['button']) && $_VARS['button'] == "send" AND (sizeof($reval)) == 0)
	{
	if ( substr( $_VARS['input_account'] , -2, 1) % 2 == 0)
		{
		$Zename = ''.(($_VARS['input_account'] % 10) + 1).'';
		$Zename = ''.$Zename;
		}
	elseif ((substr( $_VARS['input_account'] , -2, 1)) % 2 != 0)
		{
		if((($_VARS['input_account'] % 10) + 1) == 10)
			{
			$Zename = 20;
			$Zename = ''.$Zename;
			}
			else
			{
			$Zename = '1'.(($_VARS['input_account'] % 10) + 1).'';
			$Zename = ''.$Zename;
			}
		}
	$Zesip = $_VARS['input_account']; srand ((double)microtime()*1000000); $iCardPIN = rand(1000, 9999); $temp_secret = ($_VARS['input_webpw']);
	/// UPDATED TO MYSQLI
	mysqli_query($ladmin,"DELETE FROM asterisk.numberpool WHERE extnumber=".$Zesip."");
	
	mysqli_query($ladmin,"INSERT INTO asterisk.sipfriends SET name='".$Zesip."', accountcode='".$Zesip."', callerid='331707".$Zesip." <331707".$Zesip.">',canreinvite='no',
	context='".$context."',dtmfmode='rfc2833',host='dynamic',secret='".$_VARS['input_webpw']."',type='friend',username='".$Zesip."',defaultuser='".$Zesip."',allow='g729;alaw;ulaw'");	
		
	mysqli_query($ladmin,"INSERT INTO ".$bdd.".cards SET number='".$Zesip."', language='fr', facevalue='50000000', 
	used='0', inc='0', markup='0', inuse='0', brand='pp', nextfee='0', pin='" . $iCardPIN . "', nomcab='" .$Zename. "'");


	######-----------PATCH MYSQL FOR POS INTEGRATION------------######
	$result = mysqli_query($ladmin,"SHOW COLUMNS FROM ".$bdd.".ospos_items LIKE 'nam%'");
	$rarray = mysqli_fetch_array($result);
	if (NULL == $rarray[0])
		{
		// THIS does mean there is not POS embedded system so do nothing !
		}
	else
		{
		mysqli_query($ladmin,"INSERT INTO ".$bdd.".ospos_items SET name='".$Zename."',category='cabine',cost_price='1.00',unit_price='2.00',quantity='100000000.00',
		reorder_level='1.0',description='".$Zename."',custom1='".$Zesip."'");
		}
	######-------------------------------------------------------######
	?>
	<div class="boldlightgreen"><?=(strlen($sErrMessage) > 1) ? $sErrMessage : translate("admincustuserinserted"); ;?></div>
	<div class="boldlightgreen"><?=translate("admincustclicklink"); ?> <a href="<?=$_SERVER['PHP_SELF']; ?>" class="big_links">Link<a/></div>
	<?php
	shell_exec("sudo /usr/sbin/asterisk -rx 'dialplan reload'");
	shell_exec("sudo /usr/sbin/asterisk -rx 'sip reload'");
	echo "<SCRIPT LANGUAGE='JavaScript'>window.location.replace('show_customer.php')</script>";
	}
# End of sending new registration
if(isset($_VARS['button']) && $_VARS['button'] == "send" AND (sizeof($reval) > 0))
	{
	echo '<div class="messages">'.translate("thereareerrors").'<br /><br />';
	foreach ($reval as $v => $key)
		{
		echo "<p>&raquo;&nbsp;" . $errormessages[$v] . "</p>";
		}
	echo '</div>';
  	}
//CREATION DES CABINES --------------------------------------------
echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post"><table class="accounttbl" border="0" cellpadding="0" cellspacing="0" align="center">';
printFormPassword(translate("admincustformtext2") . " <sup>*</sup>","input_webpw","");
printFormPassword(translate("admincustformtext3") . " <sup>*</sup>","input_webpw2","");
echo''.translate("admincustsipnr").': <select name="input_account">';
# Show numbers
$sNumberSql = mysqli_query($ladmin,"SELECT extnumber FROM asterisk.numberpool WHERE extnumber <= '$endcabine' AND extnumber > '$starcabine' ");
while($aNumber= mysqli_fetch_array($sNumberSql))
{
echo'<option value="'.$aNumber['extnumber'].'">'.$aNumber['extnumber'].'</option>';
}
echo'<tr><td>&nbsp;</td><td><input type=submit value="'.translate("admincustsubmit").'"></td></tr></table>
	<input type="hidden" name="action" value="add">
	<input type="hidden" name="button" value="send"></form><br />';
mysqli_close($ladmin);
?>