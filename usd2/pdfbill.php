<?php
// Cyber-switch
// http://www.comdif.com
// Copyright (C) 2011 - Christian Zéler Comdif-Telecom
// krys3d@free.fr

require ("inc/php/aaa_init.inc.php");
require ("inc/php/astcc.inc.php");
?>
<style type="text/css">
table {
  -moz-border-radius:10px;
  -webkit-border-radius:10px;
  border-radius:10px
  }
  td {
  -moz-border-radius:10px;
  -webkit-border-radius:10px;
  border-radius:10px
  }
  th {
  -moz-border-radius:10px;
  -webkit-border-radius:10px;
  border-radius:10px
  }
  
  </style>
<?
    $objAstcc = new DB(); $objAstcc->connect(ASTCC);
$sCdrsql = "SELECT callerid, callednum, disposition, billseconds, billcost, callstart FROM cdrs WHERE callstart<>'' 
		AND disposition='ANSWER' AND (callstart BETWEEN $startDate AND $endDate) 
		AND cardnum='".$cabineID."' OR callednum='".$cabineID."' ORDER BY id ASC ";
		
$total = mysql_query("SELECT SUM(billcost) as masomme FROM cdrs WHERE callstart<>'' 
		AND disposition='ANSWER' AND (callstart BETWEEN $startDate AND $endDate) 
		AND cardnum='".$cabineID."' OR callednum='".$cabineID."' ");
$detail = mysql_fetch_assoc($total);


$sCountQuery = "SELECT callerid, callednum, disposition, billseconds, billcost, callstart FROM cdrs WHERE callstart<>'' 
		AND (callstart BETWEEN $startDate AND $endDate) 
		AND cardnum='".$cabineID."' OR callednum='".$cabineID."' ORDER BY id DESC"; 

///// MAKE THE HEADER

?>
<table align="center">
	<tr>
		<td><img src="imgs/comdif_logo.png"></td>
	</tr>
</table>
	<br/>
	<table align="center">
	  <tr>
		<th width="130" style="border-width: 0px; border-style:none; border:none; text-align:center;"><?=translate("date"); ?></th>
		<th width="100" style="border-width: 0px; border-style:none; border:none; text-align:center;"><?=translate("callerid"); ?></th>
		<th width="100" style="border-width: 0px; border-style:none; border:none; text-align:center;"><?=translate("destination"); ?></th>
		<th width="100" style="border-width: 0px; border-style:none; border:none; text-align:center;"><?=translate("state"); ?></th>
		<th width="70" style="border-width: 0px; border-style:none; border:none; text-align:center;"><?=translate("duration"); ?></th>
		<th width="100" style="border-width: 0px; border-style:none; border:none; text-align:center;"><?=translate("cost"); ?></th>
	  </tr></table>
	  
	<?php
	  $aCdrs = $objAstcc->select($sCdrsql);
	  for($j = 0; $j < count($aCdrs); $j++)
	  {
	?>
	  <table border="1" align="center"><tr>
		<td width="130" style="border-width: 0px; border-style:none; border:none; text-align:center;"><?=date("d.m.Y H:i", $aCdrs[$j]['callstart']);?></td>
		<td width="100" style="border-width: 0px; border-style:none; border:none; text-align:center;"><?=$aCdrs[$j]['callerid'];?></td>
		<td width="100" style="border-width: 0px; border-style:none; border:none; text-align:center;"><?=$aCdrs[$j]['callednum'];?></td>
		<td width="100" style="border-width: 0px; border-style:none; border:none; text-align:center;">
		<?php
		  if ($aCdrs[$j]['disposition'] == "ANSWER") { echo translate("answered"); }
		  else if ($aCdrs[$j]['disposition'] == "BUSY") { echo translate("busy"); }
		  else if ($aCdrs[$j]['disposition'] == "CANCEL") { echo translate("cancel"); }
		  else if ($aCdrs[$j]['disposition'] == "NO ANSWER") { echo translate("noanswer"); }
		  else if ($aCdrs[$j]['disposition'] == "CONGESTION") { echo translate("congestion"); }
		  else {echo $aCdrs[$j]['disposition'] . "(new)";}
		?>
		</td>
		<td width="70" style="border-width: 0px; border-style:none; border:none; text-align:center;"><?=$aCdrs[$j]['billseconds'];?></td>
		<td width="100" style="border-width: 0px; border-style:none; border:none; text-align:center;"><?=number_format((round($aCdrs[$j]['billcost']/10000,4)), 4, ',', '.');?></td>
	  </tr></table>

<?php
		}
	?>
	<br/>
	<table align="center"><tr>
		<td bgcolor="#99FFFF" width="320" style="border-width: 0px; border-style:none; border:none; text-align:left;">TOTAL <?=$devise ?> HT</td>
		<td width="20" style="border-width: 0px; border-style:none; border:none; text-align:center;"></td>
		<td width="20" style="border-width: 0px; border-style:none; border:none; text-align:center;"></td>
		<td width="20" style="border-width: 0px; border-style:none; border:none; text-align:center;"></td>
		<td width="20" style="border-width: 0px; border-style:none; border:none; text-align:center;"></td>
		<td width="200" bgcolor="#99FFFF" style="border-width: 0px; border-style:none; border:none; text-align:right;"><? echo $detail['masomme']/10000; ?></td>
	</tr>
	<tr>
		<td width="320"><br/><?=FIRMENNAME?><br/><?=FIRMENSTRASSE?> <?=PLZ?> <?=ORT?> <?=LAND?><br/><?=translate("vat"); ?>  <?=UMSATZSTEUERNR?>		</td>
		<td></td>
		<td></td>
		<td></td>
		<td align="right"><?=translate("vat"); ?> <? echo ''.$devise.''; ?> <br/>TTC <? echo ''.$devise.''; ?> </td>
		<td align="right"><? echo ($detail['masomme']/10000*$tva)-($detail['masomme']/10000); ?><br/><? echo round($detail['masomme']/10000*$tva,3); ?></td>
	</tr>
	</table>
	<br />
<?
	$sHeadline;
?>
