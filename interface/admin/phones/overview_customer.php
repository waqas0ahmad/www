<?
$sCdrsql = "SELECT b.regseconds, c.number, c.nomcab, c.facevalue, c.used FROM asterisk.sipfriends b, ".$bdd.".cards c WHERE b.accountcode = c.number AND b.accountcode <= '$endcabine' AND b.accountcode > '$starcabine' ORDER BY c.number";

$sCountQuery = "SELECT b.regseconds, c.facevalue, c.used FROM asterisk.sipfriends b, ".$bdd.".cards c WHERE b.accountcode = c.number AND b.accountcode <= '$endcabine' AND b.accountcode > '$starcabine'";

$objAsterisk = new DB(); $objAsterisk->connect(ASTERISK);
$aCustomer = $objAsterisk->select($sCdrsql);

echo '<div class="headline_global">'.translate("admincusttitle").'</div>
		<div class="boldblack">'.translate("admincustconftext").'</div>
    	<table class="bigtbl" align="center" ><tr>
				<th class="bigtbl_th" colspan="6">'.translate("admincustcust").'</th></tr>
				<tr>
				<th class="bigtbl_th">'.translate("firstname").'</th>
				<th class="bigtbl_th">'.translate("sipaccount").'</th>
				<th class="bigtbl_th">'.translate("balance").'</th>
				<th class="bigtbl_th">'.translate("state").'</th>
				<th class="bigtbl_th">Edit</th>
				<th class="bigtbl_th">Delete</th>
				</tr>';
for($i = 0; $i < count($aCustomer); $i++)
	{
	//$newname = 	$i + 1;
	//mysql_query("UPDATE ".$bdd.".cards SET nomcab='".$newname."' WHERE number='".$aCustomer[$i]['number']."'");
	//unset($newname);

	echo'<tr id="tr_'.$i.'" onmouseout="showRow('.$i.',0)" onmousemove="showRow('.$i.',1);">
		<td class="bigtbl_td">'.$aCustomer[$i]['nomcab'].'</td>
		<td class="bigtbl_td">'.$aCustomer[$i]['number'].'</td>
		<td class="bigtbl_td">';
	$fCurrentPrepaid = ($aCustomer[$i]['facevalue'] - $aCustomer[$i]['used']) / 10000;
	$fPrepaid = number_format($fCurrentPrepaid , 2, ",", ".");
	echo   ''.$fPrepaid.'</td><td class="bigtbl_td">';

	echo ( ($aCustomer[$i]['regseconds'] > date('U')) ? "<img src='../imgs/gimmics/online_small.gif' width='12' height='12' border='0' valign='top' alt='Online' title='Online' />" : "<img src='../imgs/gimmics/offline_small.gif' width='12' height='12' border='0' valign='top' alt='Offline' title='Offline' />");
			
	echo'</td>
		<td class="bigtbl_td"><a href="'.$_SERVER['PHP_SELF'].'?action=details&info='.$aCustomer[$i]['number'].'">
		<img src="../imgs/gimmics/info.gif" width="12" height="12" border="0" valign="absmiddle" alt="Info/Edit" title="Info/Edit" /></a></td>
		<td class="bigtbl_td">';

	echo'<a class="big_links" 
	href="javascript:if(confirm(\''.translate("admincustconfirmdelete").' '.$aCustomer[$i]['number'].'\')) document.location.href=\''.$_SERVER['PHP_SELF'].'?action=del&sipnr='.$aCustomer[$i]['number'].'\';">';

	echo'<img src="../imgs/gimmics/del.gif" width="12" height="12" border="0" valign="absmiddle" alt="Delete User" title="Delete User" /></a></td></tr>';
	}
echo '<tr><td colspan="6" class="gapright">';
if ( count($aCustomer) == 0 )	
{ echo'<a class="big_links" href="'.$PHP_SELF.'?action=addmulti"><font color="red">MULTI CREATION ONLY FOR FIRST SETUP</font> &nbsp;&nbsp;&nbsp;&nbsp;- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -&nbsp;&nbsp;&nbsp;&nbsp; </a>'; }
echo '<a href="'.$PHP_SELF.'?action=add"><font color="blue">'.translate("admincustconfnewuser").'</a></font></td></tr></table><br />';
$sHeadline;
$objAsterisk->closeDb();
?>