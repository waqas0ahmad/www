<?php
require ("../inc/php/admin_header.inc.php");
###############  Comdif Telecom Billing software  ###############
							$adminver= 01;
###############  Christian Zeler  Comdif Telecom  ###############
if($angemeldet == 1 && $aAdmin[0]['admin_status'] > 0)
{ 
	$sURI = "../inc/php/systemconfig.inc.php";
	
	# If form is sent..
	if ($_VARS['action'] == "send")
	{
		# Define system variables
		$sStarttag = "<?php\n\n";
		$sKommentar = "# System Config\n\n\n";
		$sFirmenname = "define ('FIRMENNAME', '" . $_VARS['input_firmenname'] . "');\n";
		$sVorname = "define ('VORNAME', '" . $_VARS['input_vorname'] . "');\n";
		$sNachname = "define ('NACHNAME', '" . $_VARS['input_nachname'] . "');\n";
		$sUstnr = "define ('UMSATZSTEUERNR', '" . $_VARS['input_ustnr'] . "');\n";
		$sStrasse = "define ('FIRMENSTRASSE', '" . $_VARS['input_strasse'] . "');\n";
		$sPlz = "define ('PLZ', '" . $_VARS['input_plz'] . "');\n";
		$sOrt = "define ('ORT', '" . $_VARS['input_ort'] . "');\n";
		$sLand = "define ('LAND', '" . $_VARS['input_land'] . "');\n";
		$sTelefon = "define ('TELEFON', '" . $_VARS['input_telefon'] . "');\n";
		$sFax = "define ('FAX', '" . $_VARS['input_fax'] . "');\n";
		$sEmail = "define ('EMAIL', '" . $_VARS['input_email'] . "');\n";
		$sCopyright = "define ('COPYRIGHT', 'Christian Zeler');\n";
		$sLink = "define ('LINK', 'http://www.comdif.com');\n";
		$sPublicServer = "define ('PUBLICSERVER', '" . $_VARS['input_publicserver'] . "');\n";
		$sCDRMail = "define ('CDRMAIL', '" . $_VARS['input_cdrmail'] . "');\n";
		$sDefaultLang = "define ('DEFAULTLANG', '" . $_VARS['input_defaultlang'] . "');\n";
		//$Etva = "\$tva=\"" . $_VARS['input_tva'] . "\";\n";
		if ($_VARS['input_devise'] == '€')
		{$Edevise = "\$devise=\"&euro;\";\n";}else{$Edevise = "\$devise=\"" . $_VARS['input_devise'] . "\";\n";}
		$Emep = "\$mep=\"" . $_VARS['input_mep'] . "\";\n";
		$sEndtag = "?>";
		
		# Write file
		$rHandle = fopen($sURI, "w"); 
				
		# Write constants to file
		fputs($rHandle, $sStarttag);
		fputs($rHandle, $sKommentar);
		fputs($rHandle, $sFirmenname);
		fputs($rHandle, $sVorname);
		fputs($rHandle, $sNachname);
		fputs($rHandle, $sUstnr);
		fputs($rHandle, $sStrasse);
		fputs($rHandle, $sPlz);
		fputs($rHandle, $sOrt);
		fputs($rHandle, $sLand);
		fputs($rHandle, $sTelefon);
		fputs($rHandle, $sFax);
		fputs($rHandle, $sEmail);
		fputs($rHandle, $sCopyright);
		fputs($rHandle, $sLink);
		fputs($rHandle, $sPublicServer);
		fputs($rHandle, $sCDRMail);
		fputs($rHandle, $sDefaultLang);
		//fputs($rHandle, $Etva);
		fputs($rHandle, $Edevise);
		fputs($rHandle, $Emep);
		fputs($rHandle, $sEndtag);
		# Close file
		fclose($rHandle);
		# Clear internal cache for saving ressources
		clearstatcache();
	}
	
	?>
<style type="text/css">
<!--
.style3 {
	font-size: 12px;
	color: #000099;
}
.style4 {color: #FF0000}
-->
</style>

	
	<div class="headline_global"><?=translate("adminsysheadline"); ?></div>
	<div class="boldblack"><?=translate("adminsyssubheadline"); ?></div>
	

	<?php
	if ($_VARS['input_firmenname']=='') {
	?>
	<form name="system_frm" method="POST" action="<?=$PHP_SELF;?>">
	<table class="systemconfigttbl" align="center">
	<input type="hidden" name="action" value="send" />
	<?=printFormTextToolTip(translate("companyname") ,"input_firmenname",FIRMENNAME, translate("companynamett"))?>
	<?=printFormText(translate("firstname") ,"input_vorname",VORNAME)?>
	<?=printFormText(translate("lastname") ,"input_nachname",NACHNAME)?>
	<?=printFormTextToolTip(translate("adminsystaxno") ,"input_ustnr",UMSATZSTEUERNR, translate("adminsystaxnott"))?>
	<?=printFormText(translate("street") ,"input_strasse",FIRMENSTRASSE)?>
	<?=printFormText(translate("postalcode") ,"input_plz",PLZ)?>
	<?=printFormText(translate("city") ,"input_ort",ORT)?>
	<?=printFormText(translate("country") ,"input_land",LAND)?>
	<?=printFormText(translate("phoneno") ,"input_telefon",TELEFON)?>
	<?=printFormText(translate("faxnumber") ,"input_fax",FAX)?>
	<?=printFormText(translate("emailaddress") ,"input_email",EMAIL)?>
	<?=printFormTextToolTip(translate("adminsysshowusersystem") ,"input_publicserver",PUBLICSERVER, translate("adminsysshowusersystemtt"))?>
	<?=printFormTextToolTip(translate("adminsysdailymail") ,"input_cdrmail",CDRMAIL, translate("adminsysdailymailtt"))?>
	<?=printFormText(("".translate("defaultlang")." FR, ES or EN only ")  ,"input_defaultlang",DEFAULTLANG, translate("defaultlangtt"))?>
	<? // =printFormText(translate("VAT") ,"input_tva",$tva, translate("VAT"))?>
	<?=printFormText(translate("DEVISE") ,"input_devise",$devise, translate("DEVISE"))?>
	<?=printFormText("Design 4 for low resolution 5 or 6 for hight resolution" ,"input_mep",$mep, "Design 4 for low resolution 5 or 6 for hight resolution")?>
	<tr>
	<td class="txt" style ="text-align:center; padding-top:5px;" colspan="2"><input type="submit" value="<?=translate("adminsyssave"); ?>" /></td>
	</tr>
	</table>
	</form>

	<?php
	} else {
		echo "<br><br><div class=\"boldlightgreen\">" . translate("adminsyssaved") . "</div>";
	}
	?>
<?php

}
else
{
?>
<div class="headline_global"><?=translate("adminsysheadline"); ?></div>
<div class="boldred"><?=translate("loginfailed"); ?></div>
<?php
}

require("../inc/php/admin_footer.inc.php");

?>
