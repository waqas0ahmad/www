<?php
############################
### 2018 MYSQLI SUPPORT ###
############################
$aNumber = "".($starcabine + 1)."";
echo '<form action="'.$PHP_SELF.'" method="post"><table class="accounttbl" border="0" cellpadding="0" cellspacing="0" align="center">';
printFormTextToolTip(translate("howmany"),"numbercab",$_VARS['numbercab'], translate("howmany"));
printFormPassword(translate("admincustformtext2"),"input_webpw","");
printFormPassword(translate("admincustformtext3"),"input_webpw2","");
echo "<input type=\"hidden\" name=\"input_account\" value=\"".$aNumber."\">";
echo '<tr><td>&nbsp;</td><td><input type=submit value="'.translate("admincustsubmit").'"></td></tr></table><input type="hidden" name="action" value="addmulti"><input type="hidden" name="button" value="send"></form><br />';

$_VARS['input_webuser'] = $_VARS['input_account']; $reval = checkrequiredValuesAdmin($_VARS);
if (isset($_VARS['button']) AND $_VARS['button'] == "send" AND (sizeof($reval)) == 0)
	{
	$max = $endcabine - $starcabine;
	if ($_VARS['numbercab'] > $max )
		{
		echo '<div align="center">ERROR max '.translate("howmany").' must be < or = to '.$max.'</div>';
		}
	else
		{
		$i = 0;
		while ($i <= (($_VARS['numbercab'])-(1)))
			{
			$Zesip = ($_VARS['input_account'] + $i);
			if(substr( $Zesip , -2, 1) % 2 == 0)
				{
				$Zename = ''.(($Zesip % 10) + 1).'';
				}
			elseif((substr( $Zesip , -2, 1)) % 2 != 0)
				{
				if 	((($Zesip % 10) + 1) == 10)
					{
					$Zename = 20;
					}
				else
					{
					$Zename = '1'.(($Zesip % 10) + 1).'';
					}	
				}	
			$temp_secret = ($_VARS['input_webpw']); srand ((double)microtime()*1000000); $iCardPIN = rand(1000, 9999);

			mysqli_query($ladmin,"INSERT INTO asterisk.dialplan SET context='$context',exten='".$Zesip."',priority='1',app='Dial',appdata='SIP/\${EXTEN}|90'");
	
			mysqli_query($ladmin,"INSERT INTO asterisk.dialplan SET context='$context', exten='".$Zesip."', priority='2', app='Hangup'");

			mysqli_query($ladmin,"DELETE FROM asterisk.numberpool WHERE extnumber=".$Zesip."");

			mysqli_query($ladmin,"INSERT INTO asterisk.sipfriends SET name='".$Zesip."', accountcode='".$Zesip."', callerid='331707".$Zesip." <331707".$Zesip.">',canreinvite='no',
			context='".$context."',dtmfmode='rfc2833',host='dynamic',secret='".$_VARS['input_webpw']."',type='friend',username='".$Zesip."',
			defaultuser='".$Zesip."',allow='g729;alaw;ulaw'");

			mysqli_query($ladmin,"INSERT INTO ".$bdd.".cards SET number='".$Zesip."',language='fr',facevalue='50000000',used='0',inc='0',markup='0',inuse='0',
			brand='pp',nextfee='0',pin='" . $iCardPIN . "',nomcab='".$Zename."'");
			$i++;
			}
		}
	mysqli_close($ladmin);
	shell_exec("sudo /usr/sbin/asterisk -rx 'dialplan reload'");
	shell_exec("sudo /usr/sbin/asterisk -rx 'sip reload'");
	echo"<SCRIPT LANGUAGE='JavaScript'>window.location.replace('show_customer.php')</script>";
	}
?>