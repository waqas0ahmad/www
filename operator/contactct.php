<?php
require ("./inc/php/init.inc.php");
###############  Comdif Telecom Billing software  ###############
							$userver= 01;
###############  Christian Zeler  Comdif Telecom  ###############
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<link rel="stylesheet" type="text/css" href="inc/css/main.css">
<link rel="stylesheet" type="text/css" href="main.css">
<script type="text/javascript" language="JavaScript" src="inc/js/highlite_trs.js"></script>
</head>
<body>
<?
if ($_VARS['action'] == "send")
	{
	$reval = checkContactFrm($_VARS);
	if (sizeof($reval) == 0)
		{
		$sMessage = translate("wecontactyou");
		$status = 'sent';
		requestmail($_VARS);
		}
		else
		{
		$sError = "<p><b>" . translate("thereareerrors") . ":</b><br /><br /><span class='big_red'>";
    	foreach ($reval as $v => $key)
			{
   			$sError .= ">>" . $errormessages[$v]."<br /><br />";
			}
        $sError .= "</span></p>";
		}
	}
?>

<div class="headline_global"><center><strong>Contact Us</strong></center></div>
<div class="messages">
<?
if($status == 'sent') { echo '<p>&nbsp;</p><p>&nbsp;</p><p align="center">Thank you, '.$sMessage.'</p>'; exit; }
echo $sMessage;

?>
</div>
<center><?=$sError;?></center>
  <table class="bigtbl" align="center">
    <tr><td>
<form name="contact_frm" method="post" action="<?=$_SERVER['PHP_SELF'];?>">
<input type="hidden" name="action" value="send" />
<input type="hidden" name="title" value="Kontakt" />
<table class="contacttbl" align="center">
<?=printFormText( translate("firstname") . " <sup>*</sup>","input_vorname",$_VARS['input_vorname'])?>
<?=printFormText( translate("lastname") . " <sup>*</sup>","input_nachname",$_VARS['input_nachname'])?>
<?=printFormText( translate("emailaddress") . " <sup>*</sup>","input_email",$_VARS['input_email'])?>
<?=printFormText( translate("phoneno") , "input_telefon",$_VARS['input_telefon'])?>
<?=printFormText( translate("street") , "input_strasse",$_VARS['input_strasse'])?>
<?=printFormText( translate("postalcode") , "input_plz",$_VARS['input_plz'])?>
<?=printFormText( translate("city") , "input_ort",$_VARS['input_ort'])?>
	<tr>
	</tr>
<?=printFormText(translate("faxnumber"),"input_fax",$_VARS['input_fax'])?>
	<tr>
		<th class="txt" colspan="2">
			<b><?=translate("pleasecontactme"); ?>:</b><br /><input name="input_contact" type="radio" value="1" checked>
			<b><?=translate("byemail"); ?></b> <input type="radio" name="input_contact" value="2"> <b><?=translate("byphone"); ?></b>
		</th>
    </tr>
<?=printFormTextarea(translate("formmessagebody"), "input_text");?>
	<tr>
		<td colspan="2" style="text-align:center; padding:5px;"><input type="submit" value="<?=translate("submit"); ?>" /></td>
	</tr>
</table>
</form>
</td></tr></table>
