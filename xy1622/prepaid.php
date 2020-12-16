<?php
require ("inc/php/header.inc.php");
$objAsterisk = new DB();
$objAsterisk->connect(ASTERISK);

if ($ausgefuellt=='ja')
	{
	echo "Please Login  /  Connectez vous SVP";
 	}
if($angemeldet > 0)
	{
	echo '<br/><div class="headline_global">'.translate("prepaid").'</div><br/>';
	$cust = mysql_query("SELECT * FROM ".ASTCC.".prepaid WHERE number='" . $sipnummer. "' ORDER BY id");
	$boucle=0;
	echo '<table border="1" align="center"><tr>';
	while($cu = mysql_fetch_row($cust))
		{
		echo"<td width='70'>".$cu[1]." ".$devise."</td><td width='100'>".$cu[2]."</td><td width='100'>";
		if ( $cu[6] == 'no')
			{
			echo 'Non payé';
			}
		else
			{
			echo 'Payé';
			}
		echo "</td><td width='60'>".$cu[4]."</td><td width='150'>".$cu[5]."</td></tr>";
		$boucle = $boucle + $cu[1];
		}
	echo'</table><table align="center" width="480"><tr><td align="center" width="480">TOTAL: '.$boucle.' '.$devise.'</tr></td></table>';
}
$objAsterisk->closeDb();