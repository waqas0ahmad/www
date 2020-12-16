<?php
require('header.php');
//////////////////////////// REGISTER ///////////////////////////////////////////
if ($_GET['action'] == 'register' || $_POST['action'] == 'register')
	{
	if($_POST['button'] == 'create' && $_POST['input_carrierhost'] !='' ) 
		{
		$sComment = $_POST['input_comment'] . "\n";
		if ($_POST['input_fromuser'] =='')
			{
			$sCarrier='register => '.$_POST['input_username'].':'.$_POST['input_password'].'@'.$_POST['input_carrierhost'].'/'.$_POST['input_routingnumber'].'';
			$Ouser = $_POST['input_username'];
			}
		if ($_POST['input_fromuser'] !='')
			{
			$sCarrier = 'register => '.$_POST['input_fromuser'].':'.$_POST['input_password'].'@'.$_POST['input_carrierhost'].'/'.$_POST['input_routingnumber'].'';
			$Ouser = $_POST['input_fromuser'];
			}
		$sPath = "/etc/asterisk/sip-register/"; $sURI = $sPath . $_POST['input_carrierhost'] . "-" . $_POST['input_username'];
		if (!file_exists($sPath .$_POST['input_carrierhost']."-".$_POST['input_username']))
			{
			$reg = $_POST['reg'];
			/// IF NEED REGISTERING ///
			if ($reg == 1)
				{
				$rHandle = fopen($sURI, "w");
				fputs($rHandle, "; $sComment");
				fputs($rHandle, $sCarrier);
				fclose($rHandle);
				clearstatcache();
				}
			mysqli_query($ladmin,"INSERT INTO asterisk.sipfriends SET context='sippool', language='fr',name='".$_POST['input_carrierhost']."-".$_POST['input_username']."',
			insecure='very',secret='".$_POST['input_password']."',fromuser='".$Ouser."',username='".$_POST['input_username']."',type='peer',
			host='".$_POST['input_carrierhost']."',fromdomain='".$_POST['input_carrierhost']."',disallow='all', allow='g729;g723;alaw;ulaw;gsm',canreinvite='no'");
			///////////// INSERT TRUNK NAME IN trunks TABLE //////////////////////			
			mysqli_query($ladmin,"INSERT INTO asterisk.trunks SET name='".$_POST['input_carrierhost']."-".$_POST['input_username']."',tech='SIP',
			path='".$_POST['input_carrierhost']."-".$_POST['input_username']."', prefix='".$_POST['input_prefix']."'");
			//////////// RELOAD ASTERISK /////////////////////////////////////
			$back=`/usr/sbin/asterisk -rx reload`;
			////////// SET IT AS DEFAULT ON DEMANDE /////////////////////////
			$useit = $_POST['useit'];
			if ($useit == 1)
				{
				$iUpdateRoutes = mysqli_query($ladmin,"UPDATE admin.master SET trunks='". $_POST['input_carrierhost']."-".$_POST['input_username']."'");
				$iUpdateRoutesht = mysqli_query($ladmin,"UPDATE admin.masterht SET trunks='". $_POST['input_carrierhost']."-".$_POST['input_username']."'");
				}
			 unset($_GET['action'], $_POST['action'], $_POST['button']); 
			}
		else
			{
			$sMessage = "Deja existant ".$_POST['input_carrierhost']."-".$_POST['input_username'];
			}
		}
	////////// THE FORM ////////////////////////////////////////////
	echo'<div>Nouveau carrier</div><br />';
	echo'<form action="'.$_SERVER['PHP_SELF'].'" method="post">
		<input type="hidden" name="action" value="register" />
		<input type="hidden" name="button" value="create" />
		<table border="1" cellpadding="0" cellspacing="0" align="center">
		<tr><td>Utilisateur:</td><td><input type="text" name="input_username" /></td></tr>
		<tr><td>Mot de passe:</td><td><input type="text" name="input_password" /></td></tr>
		<tr><td>Serveur:</td><td><input type="text" name="input_carrierhost" /></td></tr>
		<tr><td>Description:</td><td><input type="text" name="input_comment" /></td></tr>
		<tr><td>Poste de Destination:</td><td><input type="text" name="input_routingnumber" /></td></tr>
		<tr><td>Fromuser:</td><td><input type="text" name="input_fromuser" /></td></tr>
		<tr><td>Prefix (option):</td><td><input type="text" name="input_prefix" /></td></tr>';

	echo'<tr><td>Register:</td><td><select name="reg">
		<option value="">No</option>
		<option value="1">Yes</option>
		</select></td></tr>
		<tr><td>Use it as default:</td><td><select name="useit">
		<option value="">No</option>
		<option value="1">Yes</option>
		</select></td></tr>
		<tr><td colspan="2" style="text-align:center;"><input type=submit></td></tr></table></form>
		<tr><td colspan="2" style="text-align:center;"></td></tr>
		</table>';
	}
			
//////////////////////////// DELETE /////////////////////////////////////////
if($_GET['action'] == 'del')
	{
	$filereg = '/etc/asterisk/sip-register/'.$_GET['carriername'].'';
	if (file_exists($filereg))
		{
		@unlink("/etc/asterisk/sip-register/".$_GET['carriername']);
		}
	mysqli_query($ladmin,"DELETE FROM asterisk.sipfriends WHERE name='".$_GET['carriername']."' LIMIT 1");
	mysqli_query($ladmin,"DELETE FROM asterisk.trunks WHERE name='".$_GET['carriername']."' LIMIT 1");
	$back=`/usr/sbin/asterisk -rx reload`;	
	$sMessage = "carrier deleted";
	unset($_GET['carriername'], $_GET['action']); 
	}
////////////////////////// DEFAULT DISPLAY //////////////////////////////////
$sCdrsql = mysqli_query($ladmin,"SELECT * FROM asterisk.trunks ORDER BY name");
echo"<table border='0' cellspacing='0' cellpadding='0' align='center'><tr>";
echo'<div align="center">Lignes</div><table width="500" align="center"><tr>
	<th>Provider</th>
	<th>Action</th>
	<th>Status</th></tr>';

while($aCarrierlist = mysqli_fetch_row($sCdrsql))
	{
	echo '<tr><td>'.$aCarrierlist[0].'</td>
	<td style="text-align:center">';
	/*echo'<a href="'.$_SERVER['PHP_SELF'].'?action=edit&carriername='.$aCarrierlist['0'].'">
	<img src="imgs/info.gif" width="12" height="12" border="0" valign="absmiddle" alt="Info/Edit" title="Info/Edit" /></a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';*/
	echo'<a href=\''.$_SERVER['PHP_SELF'].'?action=del&carriername='.$aCarrierlist[0].'\';">
	<img src="imgs/del.gif" width="12" height="12" border="0" valign="absmiddle" alt="Delete" title="Delete" />
	</a></td><td class="border_tds" style="text-align:center">';

	$yo= preg_replace ('(-.*)','',($aCarrierlist[0]));
	$ya= preg_replace ('(.*-)','',($aCarrierlist[0]));
	$back=`/usr/sbin/asterisk -rx 'sip show registry'`;
	preg_match('#('.$yo.')(.*)('.$ya.')(.*)(Registered)(.*,)#s', $back, $status);
	if ($status[1] =='')
		{
		echo '<font color="#FF0000">Not Registered</font>';
		}
	else
		{
		$trunk= ''.$status[1].'-'.$status[3].'';
		echo '<font color="#006600">'.$trunk.' '.$status[5].'</font>';
		}
	}
echo '</td></tr>';
echo '<tr><td colspan="3" align="right">';
echo '<a href="'.$_SERVER['PHP_SELF'].'?action=register">Nouveau</a>';
echo '</td></tr></table><br />';

###############################################################################
//$variable=mysqli_query($ladmin,"SELECT name from asterisk.trunks where path like '%GO%' OR path like '%ISDN%' OR path like '%78.249.%'");
//while($toping = mysqli_fetch_array($variable))
//{
//$ligne = $toping['name'];
//$type = mysqli_fetch_array(mysql_query($ladmin,"SELECT * from asterisk.sipfriends WHERE name='".$ligne."'"));

//if( $type['type'] == 'friend')
//	{
//	$IPAD = $type['ipaddr'];
//	}
//else
//	{
//	$IPAD = $type['host'];
//	}
// la on a enfin les IP dans la variable $IPAD
//tu peux maintenant mettre la fonction ping ici
	//$pingresult = exec("ping -n -W 2 -c 1 ".$IPAD."|grep \"1 received\"");
//	if (!empty($pingresult))
//		{
//		echo $ligne.', '.$IPAD.', est:<font color="green"> OK</font><br/>';
//		}
//	else
//		{
//		echo $ligne.', '.$IPAD.', est:<font color="#FF0000"> DOWN</font><br/>';
//		}			
//  }

###############################################################################
//function pingAddress($ip) {
//    $pingresult = exec("ping -c 1 $ip", $outcome, $status);
//    if (0 == $status) {
//        $status = "OK";
//    } else {
//        $status = "INJOIGNABLE";
//    }
//    echo "ISDN 1, $ip, est  ".$status;
//}

//pingAddress("78.223.125.43");
			
require("footer.php");
?>