<?
$iRecords_per_page = 20; $iOffset_record = $iPage * $iRecords_per_page; $iPages_per_pageList = 10;
$sCdrsql = "SELECT name, tech, path FROM ".ASTCC.".trunks ORDER BY name LIMIT ".$iOffset_record.", ".$iRecords_per_page;
$sCountQuery = "SELECT name, tech, path FROM ".ASTCC.".trunks ORDER BY name";
$aPager = $objAsterisk->pager($iPage, $iRecords_per_page, $iPages_per_pageList, $sCdrsql, $sCountQuery);
			
if($aPager->total_pages!=1)
{
$sHeadline.="<table border='0' cellspacing='0' cellpadding='0' align='center'>";
$sHeadline.="<tr>";

if($aPager->current_page>3) $sHeadline.="<td><a href=\"new_carrier.php?iPage=0\" class='pager'><img src='../imgs/pager/pagerBack2.gif' border='0'></a></td>";
				if($aPager->pageList_preceding) $sHeadline.="<td><a href=\"new_carrier.php?iPage=".(($aPager->last_page_in_pageList)-20)."\" class='pager'><img src='../imgs/pager/pagerBack1.gif' border='0'></a></td>";
			  
for($i=$aPager->offset_page;$i<$aPager->last_page_in_pageList;$i++)
{
if($iPage==$i)
{ $sHeadline.="<td background='../imgs/pager/pagerCurrent.gif' width='20' height='20' align='center' class='pager'>".($i+1)."</td> "; }
else
{ $sHeadline.="<td background='../imgs/pager/pager.gif' width='20' height='20' align='center'><a href=\"new_carrier.php?iPage=$i\" class='pager'>".($i+1)."</a></td> "; }
}
					
if($aPager->pageList_subsequent) $sHeadline.="<td align='center' width='20' height='20'><a href=\"new_carrier.php?iPage=".(($aPager->last_page_in_pageList))."\" class='pager'><img src='../imgs/pager/pagerFor1.gif' border='0'></a></td>";
					  
if($aPager->total_pages>=10 && $aPager->last_page_in_pageList!=$aPager->total_pages) $sHeadline.="<td align='center' width='20' height='20'><a href=\"new_carrier.php?iPage=".($aPager->total_pages-1)."\" class='pager'><img src='../imgs/pager/pagerFor2.gif' border='0'></a></td>";
$sHeadline.="</tr>"; $sHeadline.="</table>";	
			}
$aCarrierlist = $objAsterisk->select($sCdrsql);

echo '<div class="headline_global">'.translate("admincarrierheadline").'</div><table width="500" align="center"><tr>
<th class="small_headline">'.translate("provider").'</th>
<th class="small_headline">'.translate("action").'</th>
<th class="small_headline">'.translate("admincarrierstatus").'</th></tr>';

				for($i = 0; $i < count($aCarrierlist); $i++)
				{
echo '<tr><td class="border_tds">'.$aCarrierlist[$i]['name'].'</td><td class="border_tds" style="text-align:center">';

if ($angemeldet == 1 && $aAdmin[0]['admin_status'] == 1)
			{					
echo '<a class="big_links" href="'.$PHP_SELF.'?action=edit&carriername='.$aCarrierlist[$i]['name'].'"><img src="../imgs/gimmics/info.gif" width="12" height="12" border="0" valign="absmiddle" alt="Info/Edit" title="Info/Edit" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a class="big_links" href="javascript:if(confirm(\'Confirm '.$aCarrierlist[$i]['name'].' will be deleted ?\')) document.location.href=\''.$PHP_SELF.'?action=del&carriername='.$aCarrierlist[$i]['name'].'\';"> <img src="../imgs/gimmics/del.gif" width="12" height="12" border="0" valign="absmiddle" alt="Delete" title="Delete" /></a></td><td class="border_tds" style="text-align:center">';
}

$yo= preg_replace ('(-.*)','',($aCarrierlist[$i]['name']));
$ya= preg_replace ('(.*-)','',($aCarrierlist[$i]['name']));
$back=`/usr/sbin/asterisk -rx 'sip show registry'`;
preg_match('#('.$yo.')(.*)('.$ya.')(.*)(Registered)(.*,)#s', $back, $status);
if ($status[1] =='')
{
echo '<font color="#FF0000">Not Registered</font>';
}else{
$trunk= ''.$status[1].'-'.$status[3].'';
echo '<font color="#006600">'.$trunk.' '.$status[5].'</font>';
}
echo '</td></tr>';
}
echo '<tr><td class="gapright" colspan="3">';
if ($angemeldet == 1 && $aAdmin[0]['admin_status'] == 1)
{ echo '<a class="big_links" href="'.$PHP_SELF.'?action=register">'.translate("admincarrieraddcarrier").'</a>'; }

echo '</td></tr></table><br />'; $sHeadline; echo '<br><div class="boldlightgreen">'.$sMessage.'</div>';
$objAstcc->closeDb(); $objAsterisk->closeDb();

echo '<br><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><div class="boldblack">'.translate("admincarriertext1").'</div><br>';

?>