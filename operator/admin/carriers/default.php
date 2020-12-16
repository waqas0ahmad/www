<?
###############  Comdif Telecom Billing software  ###############
							$adminver= 01;
###############  Christian Zeler  Comdif Telecom  ###############
$sCdrsql = "SELECT name, tech, path FROM ".ASTCC.".trunks ORDER BY name";
$sCountQuery = "SELECT name FROM ".ASTCC.".trunks";
$aCarrierlist = $objAsterisk->select($sCdrsql);

echo'<div class="headline_global">'.translate("admincarrierheadline").'</div><table width="500" align="center"><tr>
	<th class="small_headline">'.translate("provider").'</th>
	<th class="small_headline">'.translate("action").'</th>
	<th class="small_headline">'.translate("admincarrierstatus").'</th></tr>';

	for($i = 0; $i < count($aCarrierlist); $i++)
	{
	echo '<tr><td class="border_tds">'.$aCarrierlist[$i]['name'].'</td><td class="border_tds" style="text-align:center">';
		if ($angemeldet == 1 && $aAdmin[0]['admin_status'] == 1)
		{
		/*echo'<a class="big_links" href="'.$PHP_SELF.'?action=edit&carriername='.$aCarrierlist[$i]['name'].'">
		<img src="../imgs/gimmics/info.gif" width="12" height="12" border="0" valign="absmiddle" alt="Info/Edit" title="Info/Edit" />
		</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';*/
		echo'<a class="big_links" href="javascript:if(confirm(\'Confirm '.$aCarrierlist[$i]['name'].' will be deleted ?\')) 
		document.location.href=\''.$PHP_SELF.'?action=del&carriername='.$aCarrierlist[$i]['name'].'\';"> 
		<img src="../imgs/gimmics/del.gif" width="12" height="12" border="0" valign="absmiddle" alt="Delete" title="Delete" />
		</a></td><td class="border_tds" style="text-align:center">';
		}
	$yo= preg_replace ('(-.*)','',($aCarrierlist[$i]['name']));
	$ya= preg_replace ('(.*-)','',($aCarrierlist[$i]['name']));
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
	echo '</td></tr>';
	}
echo '<tr><td class="gapright" colspan="3">';
if ($angemeldet == 1 && $aAdmin[0]['admin_status'] == 1)
	{
	echo '<a class="big_links" href="'.$PHP_SELF.'?action=register">'.translate("admincarrieraddcarrier").'</a>';
	}
echo '</td></tr></table><br />'; $sHeadline; echo '<br><div class="boldlightgreen">'.$sMessage.'</div>';
echo'<div align="center"><strong>ATTENTION, ne jamais détruire ici une ligne qui à été importée la ligne serais détruite pour l\'ensemble du switch</strong></div>';
echo'<div align="center"><strong>Les lignes que vous créez ici sont privées et uniquement valables sur cette interface</strong></div>';
echo'<div align="center"><strong>Si vous ne voulez pas créer de ligne spécifique et simplement utiliser celles existantes, utilisez l\'import</strong></div>';
echo'<div align="center"><strong><a href="'.$_SERVER['PHP_SELF'].'?importtrunk=importtrunk">Cliquez ICI pour importez vos lignes deja en service sur ce switch</a></strong></div>';
if(!empty($_GET['importtrunk']) && $_GET['importtrunk']='importtrunk')
{
$seltr = mysql_query("SELECT * FROM asterisk.trunks");
while($imptr = mysql_fetch_row($seltr))
{
echo 'IMPORTING: '.$imptr[0].' OK<br/>';
mysql_query("INSERT INTO ".ASTCC.".trunks (name,tech,path,prefix) VALUE ('".$imptr[0]."','".$imptr[1]."','".$imptr[2]."','".$imptr[4]."') ");
}

}

$objAstcc->closeDb(); $objAsterisk->closeDb();
echo '<br><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><div class="boldblack">'.translate("admincarriertext1").'</div><br>';
?>