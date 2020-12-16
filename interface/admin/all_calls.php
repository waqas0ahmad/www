<?php
require ("../inc/php/admin_header.inc.php");

if($angemeldet == 1)
{ 
switch ($_VARS['action'])
  	{
/////////////////////////////////////////////////////////////////////////////////////////////////////
case "select_sipnumber":
$iRecords_per_page = 100; $iOffset_record = $iPage * $iRecords_per_page; $iPages_per_pageList = 100;

if (strlen($_VARS['sipnummer']) == 0)
			{
$sCdrsql = "SELECT id, callerid, cardnum, callednum, disposition, billcost, billseconds, datecall as callstart FROM ".ASTCC.".cdrs ORDER BY id DESC LIMIT ".$iOffset_record.", ".$iRecords_per_page; 
$sCountQuery = "SELECT id, callerid, cardnum, callednum, disposition, billcost, billseconds, datecall as callstart FROM ".ASTCC.".cdrs ORDER BY id DESC";
					
$sLimitsql = "SELECT id, callerid, cardnum, callednum, disposition, billcost, billseconds, datecall as callstart FROM ".ASTCC.".cdrs ORDER BY id DESC LIMIT " . $iOffset_record . ", " . $iRecords_per_page;
			}
			else
			{
$sCdrsql = "SELECT id, callerid, cardnum, callednum, disposition, billcost, billseconds, datecall as callstart FROM ".ASTCC.".cdrs WHERE cardnum='".$_VARS['sipnummer']."' OR callednum='".$_VARS['sipnummer']."' ORDER BY id DESC LIMIT ".$iOffset_record.", ".$iRecords_per_page; 
				
$sCountQuery = "SELECT id, callerid, cardnum, callednum, disposition, billcost, billseconds, datecall as callstart FROM ".ASTCC.".cdrs WHERE cardnum='".$_VARS['sipnummer']."' OR callednum='".$_VARS['sipnummer']."' ORDER BY id DESC";

$sLimitsql = "SELECT id, callerid, cardnum, callednum, disposition, billcost, billseconds, datecall as callstart FROM ".ASTCC.".cdrs WHERE cardnum='".$_VARS['sipnummer']."' OR callednum='".$_VARS['sipnummer']."' ORDER BY id DESC LIMIT " . $iOffset_record . ", " . $iRecords_per_page;
			}
						
$objAstcc = new DB(); $objAstcc->connect(ASTCC); $aPager = $objAstcc->pager($iPage, $iRecords_per_page, $iPages_per_pageList, $sCdrsql, $sCountQuery);

if($aPager->total_pages!=1)
			{
			  $sHeadline.="<table border='0' cellspacing='0' cellpadding='0' align='center'>";
			  $sHeadline.="<tr>";
			  if($aPager->current_page>3) $sHeadline.="<td><a href=\"all_calls.php?action=select_sipnumber&iPage=0&sipnummer="
				.$_VARS['sipnummer']."\" class='pager'><img cardnum='../imgs/pager/pagerBack2.gif' border='0'></a></td>";
			  if($aPager->pageList_preceding) $sHeadline.="<td><a href=\"all_calls.php?action=select_sipnumber&iPage="
				.(($aPager->last_page_in_pageList)-20)."&sipnummer=".$_VARS['sipnummer']."\" class='pager'><img cardnum='../imgs/pager/pagerBack1.gif' border='0'></a></td>";
			  
			  for($i=$aPager->offset_page;$i<$aPager->last_page_in_pageList;$i++)
			  {
				if($iPage==$i)
				{
				  $sHeadline.="<td background='../imgs/pager/pagerCurrent.gif' width='20' height='20' align='center' class='pager'>".($i+1)."</td> ";
				}
				else
				{
				  $sHeadline.="<td background='../imgs/pager/pager.gif' width='20' height='20' align='center'>
					<a href=\"all_calls.php?action=select_sipnumber&iPage=$i&sipnummer=".$_VARS['sipnummer']."\" class='pager'>".($i+1)."</a></td> ";
				}
			  }
					
			  if($aPager->pageList_subsequent) $sHeadline.="<td align='center' width='20' height='20'>
				<a href=\"all_calls.php?action=select_sipnumber&iPage=".(($aPager->last_page_in_pageList))."&sipnummer=".$_VARS['sipnummer']."\" class='pager'>
				<img cardnum='../imgs/pager/pagerFor1.gif' border='0'></a></td>";
					  
			  if($aPager->total_pages>=10 && $aPager->last_page_in_pageList!=$aPager->total_pages) $sHeadline.="<td align='center' width='20' height='20'>
				<a href=\"all_calls.php?action=select_sipnumber&iPage=".($aPager->total_pages-1)."&sipnummer=".$_VARS['sipnummer']."\" class='pager'>
				<img cardnum='../imgs/pager/pagerFor2.gif' border='0'></a></td>";
			  
			  $sHeadline.="</tr>";
			  $sHeadline.="</table>";	
			}
			$objAstcc->closeDb();
break;
			

default:

$iRecords_per_page = 100; $iOffset_record = $iPage * $iRecords_per_page;	$iPages_per_pageList = 100;
 
$sCdrsql = "SELECT id, callerid, cardnum, callednum, disposition, billseconds, billcost, datecall as callstart FROM ".ASTCC.".cdrs ORDER BY id DESC LIMIT ".$iOffset_record.", ".$iRecords_per_page;
			
$sCountQuery = "SELECT id, callerid, cardnum, callednum, disposition, billseconds, billcost, datecall as callstart FROM ".ASTCC.".cdrs ORDER BY id DESC";
			
$objAstcc = new DB(); $objAstcc->connect(ASTCC); $aPager = $objAstcc->pager($iPage, $iRecords_per_page, $iPages_per_pageList, $sCdrsql, $sCountQuery);
			
if($aPager->total_pages!=1)
			{
			  $sHeadline.="<table border='0' cellspacing='0' cellpadding='0' align='center'>";
			  $sHeadline.="<tr>";
			  if($aPager->current_page>3) $sHeadline.="<td><a href=\"all_calls.php?iPage=0\" class='pager'><img cardnum='../imgs/pager/pagerBack2.gif' border='0'></a></td>";
if($aPager->pageList_preceding) $sHeadline.="<td><a href=\"all_calls.php?iPage="
				.(($aPager->last_page_in_pageList)-20)."\" class='pager'><img cardnum='../imgs/pager/pagerBack1.gif' border='0'></a></td>";
			  
for($i=$aPager->offset_page;$i<$aPager->last_page_in_pageList;$i++)
			  {
				if($iPage==$i)
				{
				  $sHeadline.="<td background='../imgs/pager/pagerCurrent.gif' width='20' height='20' align='center' class='pager'>".($i+1)."</td> ";
				}
				else
				{
				  $sHeadline.="<td background='../imgs/pager/pager.gif' width='20' height='20' align='center'>
					<a href=\"all_calls.php?iPage=$i\" class='pager'>".($i+1)."</a></td> ";
				}
			  }
					
			  if($aPager->pageList_subsequent) $sHeadline.="<td align='center' width='20' height='20'>
				<a href=\"all_calls.php?iPage=".(($aPager->last_page_in_pageList))."\" class='pager'>
				<img cardnum='../imgs/pager/pagerFor1.gif' border='0'></a></td>";
					  
			  if($aPager->total_pages>=10 && $aPager->last_page_in_pageList!=$aPager->total_pages) $sHeadline.="<td align='center' width='20' height='20'>
				<a href=\"all_calls.php?iPage=".($aPager->total_pages-1)."\" class='pager'>
				<img cardnum='../imgs/pager/pagerFor2.gif' border='0'></a></td>";
			  
			  $sHeadline.="</tr>";
			  $sHeadline.="</table>";	
			}
			
$sLimitsql = "SELECT id, callerid, cardnum, callednum, disposition, billseconds, billcost, datecall as callstart FROM ".ASTCC.".cdrs ORDER BY id DESC LIMIT " . $iOffset_record . "," . $iRecords_per_page;
				
			$objAstcc->closeDb();
	# End switch
	}
			
############################################ general display for datas		
$objAstcc = new DB(); $objAstcc->connect(ASTCC); $aCustomer = $objAstcc->select("SELECT number as account, nomcab FROM ".ASTCC.".cards ORDER BY number");
?>
<div class="headline_global"><?=translate("linkallcalls"); ?></div><div class="boldblack"><div><center>
<? ######################################## The select form ################## ?>
<form name='search_calls_frm' action="<?php echo $PHP_SELF; ?>" method='POST'>
<?=translate("callerid"); ?>: <select name='sipnummer' onchange="forms.search_calls_frm.submit()" >
<option value="" ><?=translate("adminshowall"); ?></option> 
					<?
					foreach((array)$aCustomer as $key=>$val)
					{
						echo "<option value=\"".$val['account']."\" ".(($val['account']==$_VARS['sipnummer'])?"selected":"").">".$val['nomcab']."</option>";
					}
					?>
				</select>&nbsp;
				<input type="hidden" name="action" value="select_sipnumber">
				<input type="hidden" name="iPage" value="0">
			</form>
<? ################################## The display Table ##################### ?>
		</center>
		<div class="boldblack"><?=translate("adminsum"); ?>: <?=$aPager->total_records ;?> <?=translate("admincalls"); ?></div>
		<table class="callisttbl" align="center">
			<tr>
				<th class="callist_th"><?=translate("date"); ?></th>
				<th class="callist_th"><?=translate("callerid"); ?></th>
				<th class="callist_th"><?=translate("destination"); ?></th>
				<th class="callist_th"><?=translate("state"); ?></th>
				<th class="callist_th"><?=translate("duration"); ?></th>
				<th class="callist_th"><?=translate("provider"); ?></th>
			</tr>
	  
		<?php
		$gesamtkosten=0;
$objAstcc = new DB(); $objAstcc->connect(ASTCC); $aLimit = $objAstcc -> select($sLimitsql);
		$i = 0;
		while (@extract($aLimit[$i])) {
?>
<tr id="tr_<?=$i;?>" onmouseout="showRow(<?=$i;?>,0)" onmousemove="showRow(<?=$i;?>,1);">
<td class="callist_td"><?=$callstart;?></td>
<?

$idx = mysql_fetch_array(mysql_query("SELECT nomcab FROM ".ASTCC.".cards WHERE number='".$callerid."'"));
?>
<td class="callist_td"><?=$idx['nomcab'];?></td><td class="callist_td"><?=$callednum;?></td><td class="callist_td">
<?php
if ($disposition=="ANSWER") { echo translate("answered"); }
				else if ($disposition=="BUSY") { echo translate("busy"); }
				else if ($disposition=="CANCEL") { echo translate("cancel"); }
				else if ($disposition=="NO ANSWER") { echo translate("noanswer"); }
				else if ($disposition=="CONGESTION") { echo translate("congestion"); }
				else if ($disposition=="FAILED") { echo translate("cancel"); }
				else if ($disposition=="CHANUNAVAIL") { echo 'bad number'; }
								else if ($disposition=="ÿ€¿¿¿¿¿¿¿¿¿¿") { echo 'Provider fail'; }
				else echo "Incomplet";
				$provider=substr($billcost, 4, 10);

				if (stristr($billcost, "qsc")) { $provider="QSC"; }
				else $provider="ank. / int. / unbek.";

				?>
				</td>
				<td class="callist_td"><?=$billseconds;?></td>
				<td class="callist_td"><?=$provider;?></td>
			</tr>
			<?php
			$gesamtkosten = 0;
			$i++;
			}
			?>
		</table>
		<br />
		<?=$sHeadline;?>
		<br />
		<?php
		if ($aPager->total_records < 1) 
		{ 
		?>
	
		<br /><div class="boldred"><?=translate("nocalldata"); ?></div>
	
		<?php
		}
		$objAstcc->closeDb();
}
else
{
?>
<div class="headline_global"><?=translate("callist"); ?></div><br />
<div class="boldred"><?=translate("loginfailed"); ?></div><br />
<?php
}
require("../inc/php/admin_footer.inc.php");
?>
