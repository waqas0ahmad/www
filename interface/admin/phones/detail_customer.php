<?
$objAsterisk = new DB(); $objAsterisk->connect(ASTERISK);

$aStatus = $objAsterisk->select("SELECT * FROM sipfriends WHERE accountcode='".$_VARS['info']."'");
@extract($aStatus[0]); 	$aOnorOff = $regseconds-date(U);

$objAstcc = new DB(); $objAstcc->connect(ASTCC);
$aPrepaid = $objAsterisk->select("SELECT facevalue FROM ".ASTCC.".cards WHERE number='".$_VARS['info']."'")or die('Erreur SQL !'.$sql.'<br>'.mysql_error());
$suck = $aPrepaid[0]['facevalue'];

if ($_VARS['load_account'])
		{
			$iLoadValue = (($_VARS['input_suck']) + ($_VARS['input_facevalue'] * 100));
			$iEditCard = $objAstcc->query("UPDATE cards SET facevalue='" . $iLoadValue . "' WHERE number='" . $_VARS['load_account'] . "'");

if (!$iEditCard -1)
		{ $sMessage = translate("admincustamountsaved"); }else{ $sMessage = translate("admincustamountnotsaved"); }
		}

$aCards = $objAstcc->select("SELECT number, facevalue, used, creation AS created, firstuse AS firstused, brand FROM cards WHERE number='" . $_VARS['info'] ."'");
$fCurrentPrepaid = ($aCards[0]['facevalue'] - $aCards[0]['used']) / 10000; 
$fPrepaid = number_format($fCurrentPrepaid , 2, ",", ".");

echo '<div class="headline_global">'.translate("admincusttitle").'</div><div class="bigboldblack">'.$_VARS['info'].'</div><br />
<table align="center"><tr><td class="cab_tds"><center>'.$fPrepaid.' '.$devise.'</center></td></tr><tr><td class="cab_tds"><center>';
						
echo '<form action="'.$PHP_SELF.'" method="POST">'.translate("admincustaddamount").'&nbsp;<input type="text" name="input_facevalue" size="15"/> cent.<br /><br />
								<input type="hidden" name="load_account" value="'.$aCards[0]['number'].'" />
								<input type="hidden" name="info" value="'.$_VARS['info'].'" />
								<input type="hidden" name="input_suck" value="'.$aCards[0]['facevalue'].'" />
								<input type="hidden" name="action" value="details" />
								<input type="hidden" name="title" value="'.translate("admincusttitle").'" />
								<input type="submit" value="'.translate("admincustaddamount").'" />
</form></center></td></tr><tr><td>'.$sMessage.'</div></td></tr></table><br />
<table width="200" border="0" cellpadding="0" cellspacing="0" align="center"><tr><td rowspan="2" class="status">';
								
echo ($aOnorOff > 0 ? "<img src='../imgs/gimmics/online.gif' width='50' height='50' border='0' valign='top' alt='Online' title='".translate("admincustphoneonlinett")."' />" :
								"<img src='../imgs/gimmics/offline.gif' width='50' height='50' border='0' valign='top' alt='Offline' title='".translate("admincustphoneofflinett")."' />");

echo '</td><td class="headline_phone">'.translate("admincustphonedata").'</td></tr><tr>
<td class="phoneparameter">'.translate("admincustsipserver").': <b>'.$SERVER_ADDR.'</b><br />'.translate("admincustsipnumber").': <b>'.$_VARS['info'].'</b><br />
'.translate("admincustsippassword").': <b>'.$aStatus[0]['secret'].'</b></td></tr></table></td></tr></table>';

	$objAsterisk->closeDb(); $objAstcc->closeDb();
?>