<?
		$objAsterisk = new DB(); $objAsterisk->connect(ASTERISK);
		echo '<div class="headline_global">'.translate("admincusttitle").'</div><div class="boldblack">'.translate("admincustinfo").'</div>';

		if ($_VARS['button'] == "send" AND (sizeof($reval)) == 0)
		{
		$_VARS['input_account'] = $_POST['input_account'];
		$_VARS['input_webuser'] = $_VARS['input_account'];
		echo $_VARS['input_account'];
# Insert dialplan into asterisk database

$iDelpool = $objAsterisk->query("DELETE FROM ".$bdd.".numberpool WHERE extnumber=".$_VARS['input_account']."");

$iDialplan = $objAsterisk->query("INSERT INTO dialplan SET context='$context', exten='".$_VARS['input_account']."', 
priority='1', app='Dial', appdata='SIP/\${EXTEN}|90'");
$iDialplan = $objAsterisk->query("INSERT INTO dialplan SET context='$context', exten='".$_VARS['input_account']."', 
priority='2', app='Hangup'");


# Save new user in database
$sInputSQL = "INSERT INTO ".$bdd.".webuser SET webuser='".$_VARS['input_account']."', webpw='".$_VARS['input_webpw']."', vorname='".$_VARS['input_vorname']."', nachname='".$_VARS['input_nachname']."', firma='".$_VARS['input_firma']."', adresszusatz='".$_VARS['input_adresszusatz']."', telefon='".$_VARS['input_telefon']."', email='".$_VARS['input_email']."', account='".$_VARS['input_account']."'";
$iAddCustomer = $objAsterisk -> query($sInputSQL);




# Insert user into asterisk database
$temp_secret = ($_VARS['input_webpw']);
$sSipsql = "INSERT INTO sipfriends SET name='".$_VARS['input_account']."', accountcode='".$_VARS['input_account']."', callerid='".$_VARS['input_callerid']." <".$_VARS['input_callerid'].">',canreinvite='no', context='".$context."',dtmfmode='rfc2833',host='dynamic',secret='".$_VARS['input_webpw']."',type='friend',username='".$_VARS['input_account']."',allow='g729;g723;ulaw;alaw;gsm'";
$iSip = $objAsterisk->query($sSipsql);

# Create prepaid phone account
srand ((double)microtime()*1000000); $iCardPIN = rand(1000, 9999);
$iCard = $objAsterisk->query("INSERT INTO ".$bdd.".cards SET number='".$_VARS['input_account']."', language='fr', facevalue='0', used='0', inc='0', markup='0', inuse='0', brand='pp', nextfee='0', pin='" . $iCardPIN . "', nomcab='" .$_VARS['input_vorname']. "'");

?>
		<div class="boldlightgreen"><?=(strlen($sErrMessage) > 1) ? $sErrMessage : translate("admincustuserinserted"); ;?></div>
		<div class="boldlightgreen"><?=translate("admincustclicklink"); ?> <a href="<?=$PHP_SELF;?>" class="big_links">Link<a/></div>
<?php
echo "<SCRIPT LANGUAGE='JavaScript'>";
echo "window.location.replace('show_customer.php')";
echo "</script>";
		
		}
# End of sending new registration

		if($_VARS['button'] == "send" AND (sizeof($reval) > 0))
  		{

	echo '<div class="messages">'.translate("thereareerrors").'<br /><br />';

    		foreach ($reval as $v => $key)
    		{
	echo "<p>&raquo;&nbsp;" . $errormessages[$v] . "</p>";
    		}
	echo '</div>';
  		}
		
//CREATION DES CABINES --------------------------------------------
		echo '<form action="'.$PHP_SELF.'" method="post"><table class="accounttbl" border="0" cellpadding="0" cellspacing="0" align="center">';
		
		printFormTextToolTip("Callerid","input_callerid",$_VARS['input_callerid'], "Enter Callerid");
		printFormPassword(translate("admincustformtext2") . " <sup>*</sup>","input_webpw","");
		printFormPassword(translate("admincustformtext3") . " <sup>*</sup>","input_webpw2","");
		printFormTextToolTip(translate("firstname"),"input_vorname",$_VARS['input_vorname'], translate("firstname"));
		printFormTextToolTip(translate("lastname"),"input_nachname",$_VARS['input_nachname'], translate("lastname"));
		printFormTextToolTip(translate("companyname"),"input_firma",$_VARS['input_firma'], translate("companyname"));
		printFormTextToolTip("adresse","input_adresszusatz",$_VARS['input_adresszusatz'], "adresse");
		printFormTextToolTip(translate("phoneno"),"input_telefon",$_VARS['input_telefon'], translate("phoneno"));
		printFormTextToolTip(translate("emailaddress"),"input_email",$_VARS['input_email'], translate("emailaddress"));
		
		
		

		# Show numbers
		$resulta = mysql_query("SELECT * FROM ".$bdd.".numberpool");

		echo '<div align="center">'.translate("admincustsipnr").' <select name="input_account">';
		while($sele=mysql_fetch_array($resulta))
			{
			echo '<option value="'.$sele["extnumber"].'">'.$sele["extnumber"].'</option>';
			}
		echo '</select></div>';

		
	  	echo '<tr><td>&nbsp;</td><td><input type=submit value="'.translate("admincustsubmit").'"></td></tr></table>
		<input type="hidden" name="action" value="add">
		<input type="hidden" name="button" value="send"></form><br />';
		
		$objAsterisk->closeDb();
		?>