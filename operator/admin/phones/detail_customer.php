<?
###############  Comdif Telecom Billing software  ###############
							$adminver= 01;
###############  Christian Zeler  Comdif Telecom  ###############
$objAsterisk = new DB(); $objAsterisk->connect(ASTERISK);
$aStatus = $objAsterisk->select("SELECT * FROM sipfriends WHERE accountcode='".$_VARS['info']."'");
@extract($aStatus[0]); 	$aOnorOff = $regseconds-date(U);
$objAstcc = new DB(); $objAstcc->connect(ASTCC);
$aPrepaid = $objAsterisk->select("SELECT facevalue FROM ".ASTCC.".cards WHERE number='".$_VARS['info']."'");
$suck = $aPrepaid[0]['facevalue'];

if ($_VARS['load_account'])
		{
			$aCust = $objAsterisk->select("SELECT * FROM ".ASTCC.".webuser WHERE account='".$_VARS['info']."'");
			$iLoadValue = (($_VARS['input_suck']) + ($_VARS['input_facevalue'] * 10000));
			$iEditCard = $objAstcc->query("UPDATE cards SET facevalue='" . $iLoadValue . "' WHERE number='" . $_VARS['load_account'] . "'");
			#Insert prepaid history in prepaid astcc table for the customer
			$now= date("Y-m-d H:i:s");
			$Saveprepaid = $objAstcc->query("INSERT INTO ".ASTCC.".prepaid SET prepaid='".$_VARS['input_facevalue']."' , 
			vorname='".$aCust[0]['vorname']."' , nachname='".$aCust[0]['nachname']."' , number='".$_VARS['load_account']."', date='".$now."', state='no'");

if (!$iEditCard -1)
		{
			$sMessage = translate("admincustamountsaved");
		}
		else
		{
			$sMessage = translate("admincustamountnotsaved"); }
		}

$aCards = $objAstcc->select("SELECT number, facevalue, used, creation AS created, firstuse AS firstused, brand FROM cards WHERE number='" . $_VARS['info'] ."'");
$fCurrentPrepaid = ($aCards[0]['facevalue'] - $aCards[0]['used']) / 10000; 
$fPrepaid = number_format($fCurrentPrepaid , 2, ",", ".");

echo '
	<div class="headline_global">'.translate("admincusttitle").'</div>
	<div class="bigboldblack">'.$_VARS['info'].'</div><br />
	<table align="center"><tr><td class="cab_tds">
	<center>'.$fPrepaid.' '.$devise.'</center></td></tr>
	<tr><td class="cab_tds"><center>';
						
echo '<form action="'.$PHP_SELF.'" method="POST">'.translate("admincustaddamount").'&nbsp;<input type="text" name="input_facevalue" size="15"/> &euro;<br /><br />
								<input type="hidden" name="load_account" value="'.$aCards[0]['number'].'" />
								<input type="hidden" name="info" value="'.$_VARS['info'].'" />
								<input type="hidden" name="input_suck" value="'.$aCards[0]['facevalue'].'" />
								<input type="hidden" name="action" value="details" />
								<input type="hidden" name="title" value="'.translate("admincusttitle").'" />
								<input type="submit" value="'.translate("admincustaddamount").'" />
								</form></center></td></tr><tr><td>'.$sMessage.'</div></td></tr></table><br />';
								
	echo'
		<table align="center" border="1"><tr><td align="center" width="50%">
		';

			echo ($aOnorOff > 0 ? "<img src='../imgs/gimmics/online.gif' width='50' height='50' border='0' valign='top' alt='Online' 
			title='".translate("admincustphoneonlinett")."' />" : 
			"<img src='../imgs/gimmics/offline.gif' width='50' height='50' border='0' valign='top' alt='Offline' 
			title='".translate("admincustphoneofflinett")."' />");
			$aCus = $objAsterisk->select("SELECT * FROM ".ASTCC.".webuser WHERE account='".$_VARS['info']."'");
			$bCus = $objAsterisk->select("SELECT * FROM asterisk.sipfriends WHERE accountcode='".$_VARS['info']."'");
			
			if($aCus[0]['plz'] == 'ppp'){ $Mde='Free'; }elseif($aCus[0]['plz'] == 'pop'){ $Mde='Postpay'; }else{ $Mde='Prepay';}
			echo '
			<br/>'.translate("admincustphonedata").'<br/>
			'.translate("admincustsipserver").': '.$_SERVER['SERVER_ADDR'].'<br />
			'.translate("admincustsipnumber").': '.$_VARS['info'].'<br />
			'.translate("admincustsippassword").': '.$aStatus[0]['secret'].'<br/>
			Codecs: '.$aStatus[0]['allow'].'<br/>
			'.$aCus[0]['vorname'].' '.$aCus[0]['nachname'].'<br/>
			'.$aCus[0]['firma'].'<br/>
			'.$aCus[0]['adresszusatz'].'<br/>
			'.$aCus[0]['telefon'].'<br/>
			'.$aCus[0]['email'].'<br/>
			Callerid: '.$bCus[0]['callerid'].'<br/>
			Channels: '.$bCus[0]['call-limit'].'<br/>
			Groupe: '.$aCus[0]['gebdat'].'<br/>
			Mode: '.$Mde.'';
			
			
			echo '
			</td><td align="center" width="50%">
			<form action="'.$PHP_SELF.'" method="post">
			
			<table><tr>
			<input type="hidden" name="info" value="'.$_VARS['info'].'" /><br/>
			<td>'.translate("admincustsippassword").':</td><td><input type="text" name="secret" value="'.$aStatus[0]['secret'].'" /><td/></tr>
			<td>Codecs: </td><td><input type="text" name="codec" value="'.$aStatus[0]['allow'].'" /><td/></tr>
			<td>'.translate("firstname").':</td><td><input type="text" name="vorname" value="'.$aCus[0]['vorname'].'" /><td/></tr>
			<td>'.translate("lastname").':</td><td><input type="text" name="nachname" value="'.$aCus[0]['nachname'].'" /><td/></tr>
			<td>'.translate("companyname").':</td><td><input type="text" name="firma" value="'.$aCus[0]['firma'].'" /><td/></tr>
			<td>'.translate("city").':</td><td><input type="text" name="adresszusatz" value="'.$aCus[0]['adresszusatz'].'" /><td/></tr>
			<td>'.translate("phoneno").':</td><td><input type="text" name="telefon" value="'.$aCus[0]['telefon'].'" /><td/></tr>
			<td>'.translate("emailaddress").':</td><td><input type="text" name="email" value="'.$aCus[0]['email'].'" /><td/></tr>
			<td>Callerid::</td><td><input type="text" name="callerid" value="'.$bCus[0]['callerid'].'" /><td/></tr>
			<td>Call limit:</td><td><input type="text" name="call-limit" value="'.$bCus[0]['call-limit'].'" /><td/></tr>
			<td>Group:</td><td><input type="text" name="group" value="'.$aCus[0]['gebdat'].'" /><td/></tr>
			<td>Mode:</td>
			<td><select name="pmode">
			<option value="'.$aCus[0]['plz'].'">'.$Mde.'</option>
			<option value="prp">Prepay</option><option value="pop">Postpay</option><option value="ppp"/>Free</option></select><td/></tr>
			<input type="hidden" name="where" value="'.$_VARS['info'].'" />
			<input type="hidden" name="action" value="details" />
			<input type="hidden" name="chinfo" value="chinfo" />
			<td colspan="2"><input type="submit" value="Change infos" /><td/>
			</form>
			</tr></table>
			
			
			
			</center>
			</td></tr></table>
			';
			$aC = $_VARS['info']; $cL = $_POST['call-limit']; $cI = $_POST['callerid']; $pM = $_POST['pmode'];
			if (empty($_POST['codec'])){$_POST['codec']="g729;ulaw;alaw";}
			if  ( $_POST['chinfo'] == 'chinfo')
			{
			$aC = $_VARS['info'];
			mysql_query("UPDATE ".ASTCC.".webuser SET webuser='".$_POST['info']."',webpw='".$_POST['secret']."',`gebdat`='".$_POST['group']."',`plz` ='".$_POST['pmode']."',
			`vorname`='".$_POST['vorname']."',nachname='".$_POST['nachname']."',firma='".$_POST['firma']."',adresszusatz='".$_POST['adresszusatz']."',
			`telefon`='".$_POST['telefon']."',email='".$_POST['email']."' WHERE webuser='".$_POST['where']."'" ) or die(mysql_error());
			
			mysql_query("UPDATE asterisk.sipfriends SET callerid = '".$cI."', accountcode='".$_POST['info']."',name='".$_POST['info']."',username='".$_POST['info']."',
			`secret`='".$_POST['secret']."', `call-limit` = '".$cL."', `allow` = '".$_POST['codec']."' WHERE accountcode='".$aC."'") or die(mysql_error());

			shell_exec("sudo /usr/sbin/asterisk -rx 'sip reload'");
			echo "<SCRIPT LANGUAGE='JavaScript'>window.location.replace('show_customer.php?action=details&info=".$_POST['where']."')</script>";
			}
	$objAsterisk->closeDb(); $objAstcc->closeDb();
?>
