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
	############# Déclaration et mise en forme de quelques variables utiles pour manipuler les dates#############
	// mise en variable des valeurs de la date courrante, année mois jour heure minute seconde
	$Y=date("Y"); $m=date("m"); $d=date("d"); $h=date("h"); $i=date("i"); $s=date("s");
	// transforme la date début du jour et fin du jour en timestamp unix
	$mksta=mktime(0,0,0,$m,$d,$Y); $mkend=mktime(24,0,0,$m,$d,$Y);
	##############################################################################################################

// Rien n'est posté en sélection de jour
if(empty($_POST['whatday']))
	{
		// Peut être une sélection mois a été demandée, on test
		if(!empty($_POST['whatmonth']))
			{
			// on récupère le post whatmonth sous forme année-jour
			$split=explode("-",$_POST['whatmonth']);
			// on récupère l'année et le jour sous deux variables différentes grace à explode qui coupe année-jour au tiret
			$nbjour = date('t',mktime(0, 0, 0, $split[1], 1, $split[0]));
			// on compte combien il y a de jours dans le mois demandé
			$startDate=mktime(0,0,0,$split[1],1,$split[0]); $endDate=mktime(24,0,0,$split[1],$nbjour,$split[0]);
			// on transforme en timestamp le premier jour du mois à 0H00 et le dernier à 24H00 et on le charge en variable début et fin
			$head='<div align="center">FROM: '.date("Y-m-d",$startDate).' - TO: '.date("Y-m-d",($endDate - 1)).'</div>';
			// on fabrique l'entête du: au:
			}
		else
			{
			// Rien n'a été posté donc on affiche par défaut la journée en cours
			$startDate=$mksta;
			$endDate=$mkend;
			$jour=date("Y-m-d");
			$head='<div align="center">Date: '.$jour.'</div>';
			// on fabrique l'entête Date:
			}
	}
else
	{
	// Une demande sur un jour a été postée
	$startDate=($mksta - $_POST['whatday']);
	$endDate=($mkend-$_POST['whatday']);
	$jour=date("Y-m-d",($mksta - $_POST['whatday']));
	$head='<div align="center">Date: '.$jour.'</div>';
	// on fabrique l'entête Date:
	}

//////////////////////////////////////////////// REQUETES MYSQL
	$objAstcc = new DB(); $objAstcc->connect(ASTCC);
	$sCdrsql= "SELECT * FROM cdrs WHERE callstart<>'' AND disposition='ANSWER' 
	AND (callstart BETWEEN $startDate AND $endDate) AND (cardnum='".$sipnummer."' OR callednum='".$sipnummer."') ORDER BY id ASC ";
	$total= mysql_query("SELECT SUM(billcost) as masomme FROM cdrs WHERE callstart<>'' AND disposition='ANSWER' AND (callstart BETWEEN $startDate AND $endDate) 
	AND (cardnum='".$sipnummer."' OR callednum='".$sipnummer."') ");
	$detail = mysql_fetch_assoc($total);
	$sCountQuery= "SELECT callerid, callednum, disposition, billseconds, billcost, callstart FROM cdrs WHERE disposition='ANSWER' AND callstart<>'' 
	AND (callstart BETWEEN $startDate AND $endDate) AND (cardnum='".$sipnummer."' OR callednum='".$sipnummer."') ORDER BY id DESC";
	$iNumber = count($objAstcc->select($sCountQuery));
///////////////////////////////////////////////////////////////
echo $head.'<div class="boldblack">'.translate("choosedate").'</div><center>
	<table><tr>
	<td colspan="2">
	<form name="time" action="'.$_SERVER['PHP_SELF'].'" method="POST">
	<select name="whatday" onchange="forms.time.submit()">
	<OPTION VALUE="'.$startDate.'">'.date("Y-m-d",$startDate).'</OPTION>';
for($a=0;$a<31622401;$a = $a + 86400)
	{
	echo'<OPTION VALUE="'.$a.'">'.date("Y-m-d",($mksta - $a)).'</OPTION>';
	}
echo'</SELECT></form></td>';
		//////////////////////////////SELECTION DU MOIS ///////////////////////////
		echo'<td colspan="2">
			<form name="month" action="'.$_SERVER['PHP_SELF'].'" method="POST">
			<select name="whatmonth" onchange="forms.month.submit()">
			<OPTION VALUE="'.$startDate.'">'.date("Y-m",$startDate).'</OPTION>';
		for($a=0;$a<13;$a = $a + 1)
			{
			$lemoiS = strtotime("-$a month"); $lemois= date("Y-m",$lemoiS);
			echo'<OPTION VALUE="'.$lemois.'">'.$lemois.'</OPTION>';
			}
		echo'</SELECT></form></td></tr></table>';
		//////////////////////////////////////////////////////////////////////////
		
echo'<div class="headline_global">'.translate("callist").'</div>
	<div class="boldblack">'.translate("sum").': '.$iNumber.' '.translate("calls").'</div>
	<table class="bigtbl" align="center">
	<tr>
	<th class="callist_th">'.translate("date").'</th>
	<th class="callist_th">'.translate("callerid").'</th>
	<th class="callist_th">'.translate("destination").'</th>
	<th class="callist_th">'.translate("destination").'</th>
	<th class="callist_th">'.translate("duration").'</th>
	<th class="callist_th">'.translate("cost").'</th>
	</tr>';
$aCdrs = $objAstcc->select($sCdrsql);
for($j = 0; $j < count($aCdrs); $j++)
	{
	echo'<tr id="tr_'.$j.'" onmouseout="showRow('.$j.',0)" onmousemove="showRow('.$j.',1);">
	<td class="callist_td">'.date("d.m.Y H:i", $aCdrs[$j]['callstart']).'</td>
	<td class="callist_td">'.$aCdrs[$j]['callerid'].'</td>
	<td class="callist_td">'.$aCdrs[$j]['callednum'].'</td>
	<td class="callist_td">'.$aCdrs[$j]['comment'].'</td>
	<td class="callist_td">'.$aCdrs[$j]['billseconds'].'</td>
	<td class="callist_td">'.number_format((round($aCdrs[$j]['billcost']/10000,4)), 4, ',', '.').'</td>
	</tr>';
	}
echo'<tr bgcolor="#99FFFF">
	<td align="center">TOTAL</td>
		<td colspan="4"></td>
			<td align="center">'.($detail['masomme']/10000).'</td>
				</tr></table><br />';
echo'<div align="center">
	<a href="print.php?startDate='.$startDate.'&endDate='.$endDate.'&cabineID='.$sipnummer.'" target="_new">PRINT REPORT / IMPRIMER RAPPORT</a>
	</div>';
if ($iNumber < 1) 
	{ 
	echo'<br /><div class="boldred">'.translate("nocalldata").'</div>';
	}
}
require("inc/php/footer.inc.php");
?>