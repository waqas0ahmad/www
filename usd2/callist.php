<?php
require ("inc/php/header.inc.php");
if ($sipnummer=='')
	{
	echo'<div class="bigboldred">'.translate("novalidsipaccount").'</div>
	<br>
	<div class="boldblack">'.translate("novalidsipaccount2").'</div>';
	}
	else
	{
	//START HERE

	$objAstcc = new DB(); $objAstcc->connect(ASTCC);	
	//Get first and last month of call detail records
	$currentMonth=date("m/Y");
	$mi = date( "m/Y", strtotime ("-".$mes." month" ) );
	$selectedMonth=$mi;
		if (!empty($_POST['mes']))
		{
		$selectedMonth = date( "m/Y", strtotime ("-".$_POST['mes']." month" ) );
		}
		else
		{	
		$selectedMonth = $currentMonth;
		}
	$dateArray=explode("/",$selectedMonth);
	$daysinmonth=daysinmonth($dateArray[0], $dateArray[1]);
	$startDate= mktime(0,0,0,$dateArray[0],1,$dateArray[1]);
	$endDate= mktime(23,59,59,$dateArray[0],$daysinmonth,$dateArray[1]);
	echo'<div align="center">From: '.date("d-m-Y" ,$startDate).' TO '.date("d-m-Y" ,$endDate).'</div>';
	$sCdrsql= "SELECT callerid, callednum, disposition, billseconds, billcost, callstart FROM cdrs WHERE callstart<>'' 
	AND disposition='ANSWER' AND (callstart BETWEEN $startDate AND $endDate) 
	AND (cardnum='".$sipnummer."' OR callednum='".$sipnummer."') ORDER BY id ASC ";
	
	$total= mysql_query("SELECT SUM(billcost) as masomme FROM cdrs WHERE callstart<>'' 
	AND disposition='ANSWER' AND (callstart BETWEEN $startDate AND $endDate) 
	AND (cardnum='".$sipnummer."' OR callednum='".$sipnummer."') ");
	
	$detail = mysql_fetch_assoc($total);
	$sCountQuery= "SELECT callerid, callednum, disposition, billseconds, billcost, callstart FROM cdrs WHERE disposition='ANSWER' 
	AND callstart<>'' AND (callstart BETWEEN $startDate AND $endDate) AND (cardnum='".$sipnummer."' OR callednum='".$sipnummer."') ORDER BY id DESC";
	 
	$iNumber = count($objAstcc->select($sCountQuery));
	echo'<div class="boldblack">'.translate("choosedate").'</div><center><table><tr><td></td><td>';

	echo'<form name="time" action="'.$_SERVER['PHP_SELF'].'" method="POST">';
	echo'<select name="mes" onchange="forms.time.submit()">';
	$v = 1;
	echo'<OPTION VALUE="">'.date("m/Y").'</OPTION>';
	if($_POST['mes'] !='')
	{
	echo'<OPTION SELECTED VALUE="'.$_POST['mes'].'">'.date( "m/Y", strtotime ("-".$_POST['mes']." month" ) ).'</OPTION>';
	}
		if( date("d") == 29 || date("d") == 30 | date("d") == 31)
		{
		while($v < 13)
			{
			echo'<OPTION VALUE="'.$v.'">'.date( "m/Y", strtotime ("-".$v." month" ) ).'</OPTION>'; $v++;
			}
		}
		else
		{
		while($v < 25)
			{
			echo'<OPTION VALUE="'.$v.'">'.date( "m/Y", strtotime ("-".$v." month" ) ).'</OPTION>'; $v++;
			}
		}
	echo '</SELECT></form></td></tr></table>';

?>	

	</center>
	<div class="headline_global"><?=translate("callist"); ?></div>
	<div class="boldblack"><?=translate("sum"); ?>: <?=$iNumber;?> <?=translate("calls"); ?></div>
	<table class="bigtbl" align="center">
	  <tr>
		<th class="callist_th"><?=translate("date"); ?></th>
		<th class="callist_th"><?=translate("callerid"); ?></th>
		<th class="callist_th"><?=translate("destination"); ?></th>
		<th class="callist_th"><?=translate("state"); ?></th>
		<th class="callist_th"><?=translate("duration"); ?></th>
		<th class="callist_th"><?=translate("cost"); ?></th>
	  </tr>
	  
	<?php
	  $aCdrs = $objAstcc->select($sCdrsql);
	  for($j = 0; $j < count($aCdrs); $j++)
	  {
	?>
	  <tr id="tr_<?=$j;?>" onmouseout="showRow(<?=$j;?>,0)" onmousemove="showRow(<?=$j;?>,1);">
		<td class="callist_td"><?=date("d.m.Y H:i", $aCdrs[$j]['callstart']);?></td>
		<td class="callist_td"><?=$aCdrs[$j]['callerid'];?></td>
		<td class="callist_td"><?=$aCdrs[$j]['callednum'];?></td>
		<td class="callist_td">
		<?php
		  if ($aCdrs[$j]['disposition'] == "ANSWER") { echo translate("answered"); }
		  else if ($aCdrs[$j]['disposition'] == "BUSY") { echo translate("busy"); }
		  else if ($aCdrs[$j]['disposition'] == "CANCEL") { echo translate("cancel"); }
		  else if ($aCdrs[$j]['disposition'] == "NO ANSWER") { echo translate("noanswer"); }
		  else if ($aCdrs[$j]['disposition'] == "CONGESTION") { echo translate("congestion"); }
		  else {echo $aCdrs[$j]['disposition'] . "(new)";}
		?>
		</td>
		<td class="callist_td"><?=$aCdrs[$j]['billseconds'];?></td>
		<td class="callist_td"><?=number_format((round($aCdrs[$j]['billcost']/10000,4)), 4, ',', '.');?></td>
	  </tr>

<?php
		}
	?>
		<tr bgcolor="#99FFFF"><td align="center">TOTAL</td><td></td><td></td><td></td><td></td><td align="center"><? echo $detail['masomme']/10000; ?></td></tr>
	</table>
	<br />
	<div align="center">
	<a href="print.php?startDate=<? echo $startDate.'&endDate='.$endDate.'&cabineID='.$sipnummer ; ?>" target="_new">
	PRINT REPORT / IMPRIMER RAPPORT</a></div>

	<?php
	  if ($iNumber < 1) 
	  { 
	?>
	<br /><div class="boldred"><?=translate("nocalldata"); ?></div>
	<?php
	  }
}
require("inc/php/footer.inc.php");
?>
