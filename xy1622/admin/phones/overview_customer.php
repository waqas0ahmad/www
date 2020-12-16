<?
$objAsterisk = new DB(); $objAsterisk->connect(ASTERISK);
$sCdrsql = mysql_query("SELECT a.vorname, a.firma, a.webuser, b.name, b.regseconds, b.ipaddr, c.facevalue, c.used FROM ".ASTCC.".webuser a, asterisk.sipfriends b, ".$bdd.".cards c WHERE b.name = a.webuser AND a.webuser = c.number  ");


echo '<div class="headline_global">'.translate("admincusttitle").'</div>
		<div class="boldblack">'.translate("admincustconftext").'</div><br/><br/>
    	<table align="center"><tr>
		<th colspan="9">'.translate("admincustcust").'</th></tr><tr>
		
        			
						<th>'.translate("firstname").'</th>
							<th>'.translate("companyname").'</th>
								<th>'.translate("username").'</th>
									<th>'.translate("sipaccount").'</th>
										<th>IP</th>
											<th>'.translate("balance").'</th>
												<th>'.translate("callist").'</th>
													<th>'.translate("state").'</th>
														<th>Functions</th><tr></tr>';
while ($i = mysql_fetch_array($sCdrsql))
			{
$fCurrentPrepaid = (($i['facevalue'] - $i['used']) / 10000); $fPrepaid = number_format($fCurrentPrepaid , 2, ",", ".");
echo '
					<td class="bigtbl_td">'.$i['vorname'].'</td>
						<td class="bigtbl_td">'.$i['firma'].'</td>
							<td class="bigtbl_td">'.$i['webuser'].'</td>
								<td class="bigtbl_td">'.$i['webuser'].'</td>
									<td class="bigtbl_td"><a href="http://'.$i['ipaddr'].'" target="_new">'.$i['ipaddr'].'</a></td>
											<td class="bigtbl_td">'.$fCurrentPrepaid.'</td>
												<td class="bigtbl_td"><a href="repo.php?sipnummer='.$i['webuser'].'&name='.$i['vorname'].'" target="_new">'.translate("callist").'</a></td>
													<td class="bigtbl_td">';

//echo '</td><td class="bigtbl_td">';

echo ( ($i['regseconds'] > date(U)) ? "<img src='../imgs/gimmics/online_small.gif' width='12' height='12' border='0' valign='top' alt='Online' title='Online' />" : "<img src='../imgs/gimmics/offline_small.gif' width='12' height='12' border='0' valign='top' alt='Offline' title='Offline' /></td>");
///////////////////////////////////////////////DETAIL/////////////////////////////////					
					echo '						<td class="bigtbl_td">
<a href="'.$PHP_SELF.'?action=purch&sipnr='.$i['webuser'].'">&nbsp;&nbsp;&nbsp;&nbsp;<img src="../imgs/gimmics/cost.gif" width="8" height="12" border="0" valign="absmiddle" alt="History" title="History" /></a>&nbsp;

<a href="'.$PHP_SELF.'?action=details&info='.$i['webuser'].'">&nbsp;&nbsp;&nbsp;&nbsp;<img src="../imgs/gimmics/info.gif" width="12" height="12" border="0" valign="absmiddle" alt="Info/Edit" title="Info/Edit" /></a>&nbsp;';
///////////////////////////////////////////////DELETE/////////////////////////////////
echo '<a class="big_links" href="javascript:if(confirm(\''.translate("admincustconfirmdelete").' '.$i['id'].'\')) document.location.href=\''.$PHP_SELF.'?action=del&sipnr='.$i['webuser'].'\';">';


echo '&nbsp;&nbsp;&nbsp;&nbsp;<img src="../imgs/gimmics/del.gif" width="12" height="12" border="0" valign="absmiddle" alt="Delete User" title="Delete User" /></a></td></tr>';
	}
echo '<tr><td colspan="9" class="gapright">';
echo '<a href="'.$PHP_SELF.'?action=add"><font color="blue">'.translate("admincustconfnewuser").'</a></font></td></tr></table><br />';
$sHeadline;
$objAsterisk->closeDb();
?>