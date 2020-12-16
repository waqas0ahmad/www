<?php
require ("../inc/php/admin_header.inc.php");
###############  Comdif Telecom Billing software  ###############
							$adminver= 01;
###############  Christian Zeler  Comdif Telecom  ###############
if($angemeldet == 1)
{
//DETECT AND SET THE DID CONF PATH
$aZ = getcwd(); preg_match('/^\/.*\//',$aZ, $matches); $dir= $matches[0].'/inc/did';
// OPEN DATABASE
$objAstcc = new DB(); $objAstcc->connect(ASTCC);

// default display
echo'<br /><table align="center" class="ar"><tr>
		<th align="center">Line</th>
			<th align="center">Account</th>
				<th align="center">Delete</th>
					</tr>';
					
$Select=mysql_query("SELECT callednumo,commento from dynacab");
while($sel=mysql_fetch_row($Select))
	{
	echo'<tr>
		<td align="center" class="cust">'.$sel[0].'</td>
			<td align="center" class="cust">'.$sel[1].'</td>
				<td align="center" class="cust"><a href="'.$_SERVER['PHP_SELF'].'?delaccount='.$sel[0].'"><strong>X</strong></td>
					</tr>';
	}
echo'
	</table>';
//	add new
$card=mysql_query("SELECT number, nomcab FROM cards");
echo'
	<p align="center"><strong>NEW LINE</strong></p><form action="'.$_SERVER['PHP_SELF'].'" method="POST"><table align="center" border="0">
		<tr>
			<td align="center">Line number: <input type="text" name="tdl" /></td>
				<td align="center">Account: <select name="compte">
					<option></option>';
while($acc=mysql_fetch_array($card))
	{
	echo'<option value="'.$acc['number'].'">'.$acc['number'].'-'.$acc['nomcab'].'</option>';
	}
echo'
	</select>
		</td>
			<td><input type="submit" /></td>
				</tr></table>';
if(!empty($_POST['tdl']) && !empty($_POST['compte']))
	{
	mysql_query("INSERT INTO dynacab SET callednumo='".$_POST['tdl']."', commento='".$_POST['compte']."'") or die(mysql_error());
		touch("".$dir."/".$_POST['tdl']."");
			$myFile = $dir."/".$_POST['tdl'];
			$fh = fopen($myFile, 'a+') or die("can't open file");
						$stringData = "exten => ".$_POST['tdl'].",1,SIPAddHeader(INFO: \${SIP_HEADER(TO)})\n"; fwrite($fh, $stringData);
							$stringData = "exten => ".$_POST['tdl'].",n,Dial(SIP/".$_POST['compte'].")\n"; fwrite($fh, $stringData);
									$stringData = "exten => ".$_POST['tdl'].",n,hangup()\n"; fwrite($fh, $stringData);
											fclose($fh);
											$back=`/usr/sbin/asterisk -rx reload`;
											echo"<SCRIPT LANGUAGE='JavaScript'>window.location.replace('collecte.php')</script>";
	}
// Delete
$todel = $_GET['delaccount'];
if (!empty($todel))
	{
	mysql_query("DELETE FROM dynacab WHERE callednumo ='".$todel."'");
		unlink("".$dir."/".$todel."");
			$back=`/usr/sbin/asterisk -rx reload`;
				echo "<SCRIPT LANGUAGE='JavaScript'>window.location.replace('collecte.php')</script>";
	}
	 
}
else

{ 
echo '<div class="headline_global">'.translate("admincarrierheadline").'</div><br />
<div class="boldred">'.translate("loginfailed").'</div><br />';
}
/////////////////////// INCLUDE FOOTER /////////////////////////////////////		
		require("../inc/php/admin_footer.inc.php");

?>