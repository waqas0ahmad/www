<?php
require ("../inc/php/admin_header.inc.php");
###############  Comdif Telecom Billing software  ###############
							$adminver= 01;
###############  Christian Zeler  Comdif Telecom  ###############
if($angemeldet == 1)
	{ 
	$Tm = $_GET["mois"]; $Em = ($Tm + 1);
	$startTime = mktime(0, 0, 0, date('m')+ $Tm  , 1 , date('Y')); $endTime = mktime(0, 0, 0, date('m')+ $Em, 1, date('Y'));
	$START= date("Y-m", $startTime);
	echo '<form action="#SELF" method="get"><select name="mois"><option value=""></option>';
	echo'<option value="0">'.date("Y-m").'</option>';
	for($I=1;$I<13;$I++)
		{
		$Mo = date("Y-m", mktime(0, 0, 0, date("m")- $I, date("d"),   date("Y")));
		echo'<option value="-'.$I.'">'.$Mo.'</option>';
		}
	echo'</select>
		<input type="hidden" name="sipnummer" value="'.$_GET['sipnummer'].'" />
		<input type="hidden" name="name" value="'.$_GET['name'].'" />
		<input type="submit" />
		</form>';

	$sCdrsql = "SELECT callerid, callednum, trunk, billseconds, billcost, callstart FROM ".ASTCC.".cdrs WHERE datecall 
	LIKE'".$START."%' AND disposition='ANSWER' AND cardnum='".$_GET['sipnummer']."' OR callednum='".$_GET['sipnummer']."' ORDER BY id DESC";

	$sCountQuery = "SELECT callerid, callednum, trunk, billseconds, billcost, callstart FROM ".ASTCC.".cdrs WHERE datecall 
	LIKE'".$START."%' AND cardnum='".$_GET['sipnummer']."' OR callednum='".$_GET['sipnummer']."' ORDER BY id DESC";
					
	$sLimitsql = "SELECT callerid,callednum,trunk,billseconds,billcost,callstart FROM ".ASTCC.".cdrs WHERE datecall 
	LIKE'".$START."%' AND disposition='ANSWER' AND cardnum='".$_GET['sipnummer']."' OR callednum='".$_GET['$sipnummer']."' ORDER BY id DESC";

	echo'<div align="center">'.$_GET['name'].' - '.$_GET['sipnummer'].' ------- <strong>'.$START.'</strong></div><br/>';
 
	echo'<table class="callisttbl" align="center">
			<tr>
				<th class="callist_th">'.translate("date").'</th>
				<th class="callist_th">'.translate("callerid").'</th>
				<th class="callist_th">'.translate("destination").'></th>
				<th class="callist_th">Trunk</th>
				<th class="callist_th">'.translate("duration").'</th>
				<th class="callist_th">'.translate("cost").'</th>
			</tr>';
	  
	$objAstcc = new DB();
	$objAstcc->connect(ASTCC);
	$aLimit = $objAstcc -> select($sLimitsql);
	$boucle=0; $i = 0; $Tmp = 0;
		while (@extract($aLimit[$i]))
		{
			echo'<tr id="tr_'.$i.'" onmouseout="showRow('.$i.',0)" onmousemove="showRow('.$i.',1);">
				<td class="callist_td">'.date("d.m.Y H:i",$callstart).'</td>
				<td class="callist_td">'.$callerid.'</td>
				<td class="callist_td">'.$callednum.'</td>
				<td class="callist_td">'.$trunk.'</td>
				<td class="callist_td">'.$billseconds.'</td>
				<td class="callist_td">'.number_format((round($billcost/10000,4)), 4, ',', '.').'</td>
			</tr>';
			$boucle = $boucle + $billcost;
			$Tmp= $Tmp + $billseconds;
			$i++;
			}
	echo'</table>';
		
	echo'<div class="boldblack">'.translate("sum").' '.$i.' '.translate("calls").' 
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MINUTES '.($Tmp / 60).'</div>';
		
	echo'<br /><div class="boldlightgreen">'.translate("cost").' '.number_format(($boucle/10000), 4, ',', '.').'</div>';

	$objAstcc->closeDb();

	}
	else
	{
	echo'<div class="headline_global">'.translate("adminbillheadline").'</div><br />
	<div class="boldred">'.translate("loginfailed").'</div><br />';
	}
require("../inc/php/admin_footer.inc.php");
?>