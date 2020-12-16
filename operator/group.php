<?php
require ("inc/php/header.inc.php");
###############  Comdif Telecom Billing software  ###############
							$userver= 01;
###############  Christian Zeler  Comdif Telecom  ###############
if ($ausgefuellt=='ja')
	{
	echo "Please Login  /  Connectez vous SVP";
	}
	if($angemeldet > 0)
	{
	
	$objAsterisk = new DB(); $objAsterisk->connect(ASTERISK);
	$sCdrsql = mysql_query("SELECT a.vorname, a.firma, a.webuser, b.name, b.regseconds, b.ipaddr, c.facevalue, c.used FROM ".ASTCC.".webuser a,
	asterisk.sipfriends b, ".$bdd.".cards c WHERE b.name = a.webuser AND a.webuser = c.number  AND a.gebdat ='".$aUser[0]['gebdat']."'");
	echo'<br/>
    	<table align="center"><tr>
		<th colspan="6">Group '.translate("admincustcust").'</th></tr><tr>
			<th>'.translate("firstname").'</th>
				<th>'.translate("companyname").'</th>
					<th>'.translate("username").'</th>
						<th>IP</th>
							<th>'.translate("balance").'</th>
								<th>'.translate("state").'</th>
									<tr></tr>';
										
	while ($i = mysql_fetch_array($sCdrsql))
		{
		$fCurrentPrepaid = (($i['facevalue'] - $i['used']) / 10000); $fPrepaid = number_format($fCurrentPrepaid , 2, ",", ".");
		echo'
			<td class="bigtbl_td">'.$i['vorname'].'</td>
				<td class="bigtbl_td">'.$i['firma'].'</td>
					<td class="bigtbl_td">'.$i['webuser'].'</td>
						<td class="bigtbl_td"><a href="http://'.$i['ipaddr'].'" target="_new">'.$i['ipaddr'].'</a></td>
							<td class="bigtbl_td">'.$fCurrentPrepaid.'</td>
								<td class="bigtbl_td">';

		echo(($i['regseconds'] > date(U)) ? "<img src='imgs/gimmics/online_small.gif' width='12' height='12' border='0' valign='top' alt='Online' title='Online' />"
			 : "<img src='imgs/gimmics/offline_small.gif' width='12' height='12' border='0' valign='top' alt='Offline' title='Offline' /></td>");
		echo '</tr>';
		}
	echo'</table><br />';
	$sHeadline; $objAsterisk->closeDb();
	}