<?
###############  Comdif Telecom Billing software  ###############
							$adminver= 01;
###############  Christian Zeler  Comdif Telecom  ###############
echo '<div class="headline_global">'.translate("prepaid").'</div>';
$objAsterisk = new DB(); $objAsterisk->connect(ASTERISK);
$display = "SELECT * FROM ".ASTCC.".prepaid WHERE number='".$_VARS['sipnr']."'";
$cust = mysql_query($display);
$boucle=0; $i = 0;
echo"<table border='1' align='center'><tr>
	<td width='70'>MONTANT</td><td width='100'>NOM</td>
		<td width='100'>PRENOM</td>
			<td width='60'>LIGNE</td>
				<td width='150'>DATE</td>
					<td width='100'>PAIEMENT</td></tr>";

while($cu = mysql_fetch_row($cust))
	{
	echo"<tr>
		<td width='70'>".$cu[1]." ".$devise."</td>
			<td width='100'>".$cu[2]."</td>
				<td width='100'>".$cu[3]."</td>
					<td width='60'>".$cu[4]."</td>
						<td width='150'>".$cu[5]."</td>
							<td width='100' align='center'>";
if ($cu[6] == 'no')
	{
	echo"<a href='".$PHP_SELF."?action=purch&sipnr=".$_VARS['sipnr']."&billprepaid=".$cu[0]."' title='classer payé'>".$cu[6]."</a>";
	}
else
	{
	echo"".$cu[6]."";
	}
if ($_GET['billprepaid'] != '')
	{
	$setstate = $objAsterisk->query("UPDATE ".ASTCC.".prepaid SET state='yes' WHERE id='".$_GET['billprepaid']."'");
	echo'<SCRIPT LANGUAGE=\'JavaScript\'>window.history.back();</script>';
 	}
echo"</td></tr>";
$boucle = $boucle + $cu[1]; $i++;
}
echo'</tr></table>
	<table align="center" width="480"><tr>
		<td align="center" width="480">TOTAL: '.$boucle.' '.$devise.'</tr></td>
			</table>';
$objAsterisk->closeDb();