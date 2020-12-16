<?
if($_VARS['button'] == "create" && $_VARS['input_carrierhost'] !="" ) 
	{
	$sComment = $_VARS['input_comment'] . "\n";

		if ($_VARS['input_fromuser'] =='')
		{
		$sCarrier="register => ".$_VARS['input_username'].":".$_VARS['input_password']."@".$_VARS['input_carrierhost']."/
		".$_VARS['input_routingnumber']."\n";
		$Ouser = $_VARS['input_username'];
		}

		if ($_VARS['input_fromuser'] !='')
		{
		$sCarrier = "register => ".$_VARS['input_fromuser'].":".$_VARS['input_password']."@".$_VARS['input_carrierhost']."/
		".$_VARS['input_routingnumber']."\n";
		$Ouser = $_VARS['input_fromuser'];
		}

$sPath = "/etc/asterisk/sip-register/"; $sURI = $sPath . $_VARS['input_carrierhost'] . "-" . $_VARS['input_username'];
	if (!file_exists($sPath . $_VARS['input_carrierhost'] . "-" . $_VARS['input_username']))
	{
		if($_POST['regme'] == 1)
		{
		$rHandle = fopen($sURI, "w");
		fputs($rHandle, $sCarrier);
		fclose($rHandle); clearstatcache();
		}
		else
		{
		$rHandle = fopen($sURI, "w");
		fclose($rHandle); clearstatcache();
		}
		
	//sipfriends
	$iSipfriends = $objAsterisk->query("INSERT INTO asterisk.sipfriends SET context='".ASTCC."', language='fr', 
	name='".$_VARS['input_carrierhost']."-".$_VARS['input_username']."', insecure='very',secret='".$_VARS['input_password']."', 
	fromuser='".$Ouser."', username='".$_VARS['input_username']."', type='peer', host='".$_VARS['input_carrierhost']."', 
	fromdomain='".$_VARS['input_carrierhost']."', disallow='all', allow='g729;g723;alaw;ulaw;gsm',  canreinvite='yes'");
	//astcc
	$iTrunks = $objAstcc->query("INSERT INTO ".ASTCC.".trunks SET name='".$_VARS['input_carrierhost']."-".$_VARS['input_username']."', 
	tech='SIP', path='".$_VARS['input_carrierhost']."-".$_VARS['input_username']."'");
	//reload sip server
	$back=`/usr/sbin/asterisk -rx reload`;
	//CHECK IF FIRST CARRIER REGISTERED
	$first_carrier=`ls -1 /etc/asterisk/sip-register|wc -l`;
	//SET IT AS DEFAULT ON DEMAND
	$useit = $_POST['useit'];
	if ($useit == 1)
		{
		$iUpdateRoutes = $objAstcc->query("UPDATE ".ASTCC.".routes SET trunks='".$_VARS['input_carrierhost']."-".$_VARS['input_username']."'");
		}
	}
	else
	{
	$sMessage = translate("admincarrierfileexists")." ".$_VARS['input_carrierhost']."-".$_VARS['input_username'];
	}
}

////////// THE FORM ////////////////////////////////////////////
echo '<div class="headline_global">'.translate("admincarrierheadlinenew").'</div>
<div class="boldlightgreen">'.translate("admincarriersubheadlinenew").'</div><br />';

echo'<form action="'.$_SERVER['PHP_SELF'].'" method="post">
			<input type="hidden" name="action" value="register" />
			<input type="hidden" name="button" value="create" />
			<table class="carriertbl" border="1" cellpadding="0" cellspacing="0" align="center">';
			printFormText(translate("username") ,"input_username",$_VARS['input_username']);
			printFormText(translate("admincustformtext2") ,"input_password",$_VARS['input_password']);
			printFormText(translate("admincarrierhost") ,"input_carrierhost",$_VARS['input_carrierhost']);
			printFormText(translate("admincarrierdest") ,"input_routingnumber",$_VARS['input_routingnumber']);
			printFormText("FROMUSER if needed or leave empty" ,"input_fromuser",$_VARS['input_fromuser']);

			echo'<tr><td align="right"><strong>Use it as default&nbsp;&nbsp;</strong></td>
			<td><select name="useit"><option value="">No</option><option value="1">Yes</option></td></tr>
			<tr><td align="right"><strong>Register&nbsp;&nbsp;</strong></td>
			<td><select name="regme"><option value="1">Yes</option><option value="">No</option></td></tr>
			<tr><td colspan="2" style="text-align:center;"><input type=submit></td></tr></table></form>
			<tr><td colspan="2" style="text-align:center;"></td></tr>
			</table>y';
exit;
?>