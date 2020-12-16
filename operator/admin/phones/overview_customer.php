<?
###############  Comdif Telecom Billing software  ############### UPDATED ON 18/10/2014
							$adminver= 01;
###############  Christian Zeler  Comdif Telecom  ############### UPDATED ON 18/10/2014
$objAsterisk = new DB(); $objAsterisk->connect(ASTERISK);
$sCdrsql = mysql_query("SELECT a.vorname, a.firma, a.webuser, b.name, b.regseconds, b.ipaddr, c.facevalue, c.used, a.gebdat, c.nextfee, b.username FROM
 ".ASTCC.".webuser a, asterisk.sipfriends b, ".$bdd.".cards c WHERE b.name = a.webuser AND a.webuser = c.number  ");

if(!empty($_GET['lock']))
	{
	if($_GET['lock'] == 'yes')
		{
		mysql_query("UPDATE ".$bdd.".cards SET nextfee='1' WHERE number='".$_GET['sipnr']."'");
		$objAsterisk->closeDb();
		echo "<SCRIPT LANGUAGE='JavaScript'>"; echo "window.location.replace('".$_SERVER['PHP_SELF']."')"; echo "</script>";
		}
	else
		{
		mysql_query("UPDATE ".$bdd.".cards SET nextfee='10' WHERE number='".$_GET['sipnr']."'");
		$objAsterisk->closeDb();
		echo "<SCRIPT LANGUAGE='JavaScript'>"; echo "window.location.replace('".$_SERVER['PHP_SELF']."')"; echo "</script>";
		}
	
	}

echo'<div class="headline_global">'.translate("admincusttitle").'</div>
	<div class="boldblack">'.translate("admincustconftext").'</div><br/><br/>
    <table align="center"><tr>
		<th colspan="9"> '.translate("admincustcust").' </th></tr><tr>
			<th> '.translate("firstname").' </th>
				<th> '.translate("companyname").' </th>
					<th> Group </th>
						<th> '.translate("sipaccount").' </th>
							<th> IP </th>
								<th> '.translate("balance").' </th>
									<th> '.translate("callist").' </th>
										<th> '.translate("state").' </th>
											<th> Functions </th><tr></tr>';
while ($i = mysql_fetch_array($sCdrsql))
	{
	$fCurrentPrepaid = (($i['facevalue'] - $i['used']) / 10000); $fPrepaid = number_format($fCurrentPrepaid , 2, ",", ".");
	
			echo'<td class="bigtbl_td">';
	######################## FUNCTION TO DISPLAY CUSTOMER NAME ########################
	echo $i['vorname'];
	
				echo'</td><td class="bigtbl_td">';
	######################## FUNCTION TO DISPLAY COMPANY NAME ########################	
	echo $i['firma'];
				
				echo'</td><td class="bigtbl_td">';
	######################## FUNCTION TO DISPLAY GROUP NUMBER ########################			
	echo $i['gebdat'];

				echo'</td><td class="bigtbl_td">';
	######################## FUNCTION TO DISPLAY SIP USERNAME ########################				
	echo $i['username'];

				echo'</td><td class="bigtbl_td">';
	######################## FUNCTION TO DISPLAY CUSTOMER IP ADDRESS ########################	
	echo'<a href="http://'.$i['ipaddr'].'" target="_new">'.$i['ipaddr'].'</a>';
						
				echo'</td><td class="bigtbl_td">';
	######################## FUNCTION TO DISPLAY CUSTOMER BALANCE ########################
	echo $fCurrentPrepaid;
	
				echo'</td><td class="bigtbl_td">';
	######################## FUNCTION TO DISPLAY CUSTOMER CDRS ########################			
	echo'<a href="repo.php?sipnummer='.$i['webuser'].'&name='.$i['vorname'].'" target="_new">'.translate("callist").'</a>';
								
				echo'</td><td class="bigtbl_td">';
	######################## FUNCTION TO DISPLAY ONLINE OR OFFLINE ########################
	echo(($i['regseconds'] > date(U)) ? "<img src='../imgs/gimmics/online_small.gif' width='12' height='12' border='0' valign='top' alt='Online' title='Online' />" 
	: "<img src='../imgs/gimmics/offline_small.gif' width='12' height='12' border='0' valign='top' alt='Offline' title='Offline' />");
	
				echo'</td><td class="bigtbl_td">';	
	######################## FUNCTION FOR TEMPORARY LOCK A CUSTOMER ########################
	if($i['nextfee'] == 1)
		{
		echo'<a href="'.$_SERVER['PHP_SELF'].'?lock=no&sipnr='.$i['webuser'].'">&nbsp;Debloquer&nbsp;</a>';
		}
	else
		{
		echo'<a href="'.$_SERVER['PHP_SELF'].'?lock=yes&sipnr='.$i['webuser'].'">&nbsp; Bloquer &nbsp;</a>';
		}
	######################## FUNCTION CHECK REFILL HISTORY ########################
	echo'<a href="'.$_SERVER['PHP_SELF'].'?action=purch&sipnr='.$i['webuser'].'">&nbsp;&nbsp;&nbsp;&nbsp;
		<img src="../imgs/gimmics/cost.gif" width="8" height="12" border="0" valign="absmiddle" alt="History" title="History" /></a>&nbsp;';
	######################## FUNCTION EDIT CUSTOMER INFO AND REFILL ########################	
	echo'<a href="'.$_SERVER['PHP_SELF'].'?action=details&info='.$i['webuser'].'">&nbsp;&nbsp;&nbsp;&nbsp;
		<img src="../imgs/gimmics/info.gif" width="12" height="12" border="0" valign="absmiddle" alt="Info/Edit" title="Info/Edit" /></a>&nbsp;';
	######################## FUNCTION DELETE CUSTOMER ########################
	echo'<a class="big_links" href="javascript:if(confirm(\''.translate("admincustconfirmdelete").' '.$i['id'].'\')) 
		document.location.href=\''.$_SERVER['PHP_SELF'].'?action=del&sipnr='.$i['webuser'].'\';">
		&nbsp;&nbsp;&nbsp;&nbsp;<img src="../imgs/gimmics/del.gif" width="12" height="12" border="0" valign="absmiddle" alt="Delete User" title="Delete User" /></a>
		</td></tr>';
	}
	
	echo'<tr><td colspan="9" class="gapright">
	<a href="'.$_SERVER['PHP_SELF'].'?action=add"><font color="blue">'.translate("admincustconfnewuser").'</a></font></td></tr></table><br />';
	$sHeadline; $objAsterisk->closeDb();
?>