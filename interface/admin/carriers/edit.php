<?
$aShowCarrier = $objAsterisk->select("SELECT name, username FROM sipfriends WHERE name='" . $_VARS['carriername'] . "'");
			
if ($_VARS['button'] == "save")
{
$sComment = $_VARS['input_comment'] . "\n";
$sCarrier = "register => " . $_VARS['input_username'] . ":" . $_VARS['input_password'] . "@" . $_VARS['input_carrierhost'] . "/" . $_VARS['input_routingnumber'] . "\n";
		
$sPath = "/etc/asterisk/sip-register/"; $sURI = $sPath . $_VARS['input_username']; unlink($sPath . $_VARS['carriername']);
				
if (!file_exists($sPath . $_VARS['input_carrierhost'] . "-" . $_VARS['input_username']))
				{
					$rHandle = fopen($sURI, "w"); 
					fputs($rHandle, "# $sComment");
					fputs($rHandle, $sCarrier);
					fclose($rHandle);
					clearstatcache();
					
$iSipfriends = $objAsterisk->query("UPDATE asterisk.sipfriends SET name='" . $_VARS['input_carrierhost'] . "-" . $_VARS['input_username'] . "', insecure='very',secret='" . $_VARS['input_password'] . "', username='" .$_VARS['input_username'] . "',fromuser='" . $_VARS['input_username'] . "', type='friend', context='".ASTCC."', host='" . $_VARS['input_carrierhost'] . "', canreinvite='no' WHERE name='" . $_VARS['carriername'] . "' LIMIT 1");

$iTrunks = $objAstcc->query("UPDATE ".ASTCC.".trunks SET name='" . $_VARS['input_carrierhost'] . "-" . $_VARS['input_username'] . "', tech='SIP', path='" . $_VARS['input_carrierhost'] . "-" . $_VARS['input_username'] . "' WHERE name='" . $_VARS['carriername'] . "' LIMIT 1");

echo 'Carrier data changed';
}else{ $sMessage = translate("admincarriernotdeleted") . " " . $_VARS['input_carrierhost'] . "-" . $_VARS['username']; }
}

echo '<div class="headline_global">'.translate("admincarrierheadlineedit").'</div><br />
<div class="boldlightgreen">'.translate("admincarriersubheadlineedit").'</div><br />';
?>