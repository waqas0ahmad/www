<?php
require ("../inc/php/admin_header.inc.php");

if($angemeldet == 1 && $statadmin['admin_status'] > 0 || $statadmin1['admin_status'] > 0)
	{ 
	$sURI = "/var/www/".$_COOKIE["workdir"]."/inc/php/systemconfig.inc.php";
	if ($_VARS['action'] == "send")
		{		
		$sStarttag = "<?php\n\n";
		$sKommentar = "# System Config\n\n\n";
		$sFirmenname = "define ('FIRMENNAME', '" . addslashes($_VARS['input_firmenname']) . "');\n";
		$sVorname = "define ('VORNAME', '" . addslashes($_VARS['input_vorname']) . "');\n";
		$sNachname = "define ('NACHNAME', '" . addslashes($_VARS['input_nachname']) . "');\n";
		$sUstnr = "define ('UMSATZSTEUERNR', '" . addslashes($_VARS['input_ustnr']) . "');\n";
		$sStrasse = "define ('FIRMENSTRASSE', '" . addslashes($_VARS['input_strasse']) . "');\n";
		$sPlz = "define ('PLZ', '" . addslashes($_VARS['input_plz']) . "');\n";
		$sOrt = "define ('ORT', '" . addslashes($_VARS['input_ort']) . "');\n";
		$sLand = "define ('LAND', '" . addslashes($_VARS['input_land']) . "');\n";
		$sTelefon = "define ('TELEFON', '" . addslashes($_VARS['input_telefon']) . "');\n";
		$sFax = "define ('FAX', '" . addslashes($_VARS['input_fax']) . "');\n";
		$sEmail = "define ('EMAIL', '" . addslashes($_VARS['input_email']) . "');\n";
		$sCopyright = "define ('COPYRIGHT', '@2018-Christian Zeler');\n";
		$sLink = "define ('LINK', 'http://www.comdif.com');\n";
		$sPublicServer = "define ('PUBLICSERVER', '" . $_VARS['input_publicserver'] . "');\n";
		$sCDRMail = "define ('CDRMAIL', '" . $_VARS['input_cdrmail'] . "');\n";
		$sDefaultLang = "define ('DEFAULTLANG', '" . $_VARS['input_defaultlang'] . "');\n";
		//$Etva = "\$tva=\"" . $_VARS['input_tva'] . "\";\n";
		if ($_VARS['input_devise'] == '€')
		{$Edevise = "\$devise=\"&euro;\";\n";}else{$Edevise = "\$devise=\"" . $_VARS['input_devise'] . "\";\n";}
		$Emep = "\$mep=\"" . $_VARS['input_mep'] . "\";\n";
		$Ebutdesign = "\$butdesign=\"" . $_VARS['input_butdesign'] . "\";\n";
		$Epalier = "\$palier=\"" . $_VARS['input_palier'] . "\";\n";
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
		fputs($rHandle, $Ebutdesign);
		fputs($rHandle, $Epalier);		
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
	if ($_VARS['input_firmenname']=='')
		{
		?>
		<form name="system_frm" method="POST" action="<?=$_SERVER['PHP_SELF'];?>">
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
		
		<?php
		 echo'</tr><tr><td align="right"><strong>'.translate("defaultlang").'</strong> &nbsp; </td><td><select name="input_defaultlang" style="width:127px;" >
			<option selected value="'.DEFAULTLANG.'">'.DEFAULTLANG.'</option>
			<option value="FR">Francais</option>
			<option value="EN">English</option>
			<option value="ES">Espanol</option>
			<option value="PT">Portugal</option>
			<option value="RO">Romania</option>
			</select>';
		
		 echo'</tr><tr><td align="right"><strong>Step / Palier</strong> &nbsp; </td><td><select name="input_palier" style="width:127px;" >
			<option selected value="'.$palier.'">'.$palier.'</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			<option value="10">10</option>
			<option value="12">12</option>
			<option value="15">15</option>
			<option value="20">20</option>
			<option value="30">30</option>
			<option value="60">60</option>
			</select>';
		
		 echo'</tr><tr><td align="right"><strong>Design 4 for low resolution 5 or 6 for hight resolution</strong> &nbsp; </td><td>
			 <select name="input_mep" style="width:127px;" >
			 <option selected value="'.$mep.'">'.$mep.'</option>
			 <option value="3">3</option>
			 <option value="4">4</option>
			 <option value="5">5</option>
			 <option value="6">6</option>
			 <option value="7">7</option>
			 <option value="8">8</option>
			 <option value="9">9</option>
			 <option value="10">10</option>
			 </select>';
		?>
		<?=printFormText(translate("DEVISE") ,"input_devise",$devise, translate("DEVISE"))?>
		<?=printFormText("Design Empty for TEXTE link or 1 for Icones buttons" ,"input_butdesign",$butdesign, "Empty for TEXTE link or 1 for Icones buttons")?>	
		<?php		
		echo'<tr>
			<td class="txt" style ="text-align:center; padding-top:5px;" colspan="2"><input type="submit" value="'.translate("adminsyssave").'" /></td>
			</tr></table></form>';
		}
	else 
		{
		echo "<br><br><div class=\"boldlightgreen\">" . translate("adminsyssaved") . "</div>";
		}
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