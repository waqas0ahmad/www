<?php
require ("../inc/php/admin_header.inc.php");
###############  Comdif Telecom Billing software  ###############
							$adminver= 01;
###############  Christian Zeler  Comdif Telecom  ###############
if($angemeldet == 1)
	{
	$objAstcc = new DB(); $objAstcc->connect(ASTCC);
	echo'<br/><table align="center" class="ar"><tr>';
	//------------- Selection de la date d'un jour rx 
	echo'<td><form name="selday" action="'.$_SERVER['PHP_SELF'].'" method="POST">'.translate("day").'<select name="rx" onchange="forms.selday.submit()">';
			if($_POST['rx'] !='')
			{
			$disday= date("Y-m-d", strtotime ("-".$_POST['rx']." day"));
			echo'<OPTION VALUE="">Select</OPTION>
				<OPTION SELECTED VALUE="'.$_POST['rx'].'">'.$disday.'</OPTION>'; 
			}
			else
			{
			echo'<OPTION VALUE="">Select</OPTION>';
			}
			$u = 0;
				while($u < 366)
				{
				echo '<OPTION VALUE="'.$u.'">'.date( "Y-m-d", strtotime ("-".$u." day" ) ).'</OPTION>'; $u++;
				}
	echo'</select>
		<input type="hidden" name="sipnummer" value="'.$_POST['sipnummer'].'">
		<input type="hidden" name="rm" value="">
		</form></td>';
		
	//------------- Selection de un mois de l'ann�e rm
	echo'<td>
		<form name="selmonth" action="'.$_SERVER['PHP_SELF'].'" method="POST">'.translate("month").' 
		<select name="rm" onchange="forms.selmonth.submit()">';
			if($_POST['rm'] !='')
			{
			$dismonth= date("Y-m", strtotime ("-".$_POST['rm']." month"));
			echo'<OPTION VALUE="">Select</OPTION>
				<OPTION SELECTED VALUE="'.$_POST['rm'].'">'.$dismonth.'</OPTION>';
			}
			else
			{
			echo'<OPTION SELECTED VALUE="">Select</OPTION>';
			}
			$v = 0;
				while($v < 25)
				{
				if ( date("d") > 28 ) {$corts = ( strtotime ("-".$v." month" ) - 345600 );} else { $corts = strtotime ("-".$v." month" ); }
				echo '<OPTION VALUE="'.$v.'">'.date( "Y-m", $corts ).'</OPTION>'; $v++;
				}
	echo'</select>
		<input type="hidden" name="sipnummer" value="'.$_POST['sipnummer'].'">
		<input type="hidden" name="rx" value="">
		</form></td>';
		
	//Selection du compte
	$aCustomer = mysql_query("SELECT number, nomcab FROM ".ASTCC.".cards");
	echo'<td>
		<form name="search_calls_frm" action="'.$_SERVER['PHP_SELF'].'" method="POST">Account: 
		<select name="sipnummer" onchange="forms.search_calls_frm.submit()" >';

			if($_POST['sipnummer'] !='')
			{
			echo'<OPTION VALUE="" >'.translate("adminshowall").'</option>';
			echo'<OPTION SELECTED VALUE="'.$_POST['sipnummer'].'" >'.$_POST['sipnummer'].'</option>';
			}
			else
			{
			echo'<OPTION VALUE="" >'.translate("adminshowall").'</option>';
			}
				while($val=mysql_fetch_array($aCustomer))
				{
				echo '<option value="'.$val['number'].'">'.$val['nomcab'].'-'.$val['number'].'</option>';
				}
	echo'</select>
		<input type="hidden" name="rm" value="'.$_POST['rm'].'">
		<input type="hidden" name="rx" value="'.$_POST['rx'].'">
		</form>
		</td></tr></table>';
	//Fin du header de selection

	//Requete sur un mois
	if( $_POST['rm'] !='' && $_POST['sipnummer'] =='')
		{
		$mes= date( "Y-m", strtotime ("-".$_POST['rm']." month" ) );
		$cond="disposition='ANSWER' AND datecall LIKE '$mes%'";
		}
		if( $_POST['rm'] !='' && $_POST['sipnummer'] !='')
		{
		$poste=$_VARS['sipnummer'];
		$mes= date( "Y-m", strtotime ("-".$_POST['rm']." month" ) );
		$cond="disposition='ANSWER' AND datecall LIKE '$mes%' AND cardnum='$poste' OR callednum='$poste'";
		}
	//Requete sur un jour
	if( $_POST['rx'] !='' && $_POST['sipnummer'] =='')
		{
		$today = date( "Y-m-d", strtotime ("-".$_POST['rx']." day" ) );
		$cond="disposition='ANSWER' AND datecall LIKE '$today%'";
		}
		if( $_POST['rx'] !='' && $_POST['sipnummer'] !='')
		{
		$poste=$_VARS['sipnummer'];
		$today = date( "Y-m-d", strtotime ("-".$_POST['rx']." day" ) );
		$cond="disposition='ANSWER' AND datecall LIKE '$today%' AND cardnum='$poste' OR callednum='$poste'";
		}
	//Requete sur un numero de compte
	if ($_POST['sipnummer'] !='' && $_POST['rm'] =='' && $_POST['rx'] =='')
  		{
		$poste=$_VARS['sipnummer'];
		$cond= "disposition='ANSWER' AND cardnum='$poste' OR callednum='$poste'";
		}
	//Traitement requete sans aucun filtre nous utilisons quand m�me un filtre jour pour sauver des ressource
	if (empty($_POST['sipnummer']) && empty($_POST['rx']) && $_POST['rm'] =='')
  		{
		$today = date( "Y-m-d");
		$cond="disposition='ANSWER' AND datecall LIKE '$today%'";
		}
	$sCountQuery= "SELECT callerid FROM ".ASTCC.".cdrs ".$cond." ";
	$sLimitsql= "SELECT callerid,callednum,trunk,billseconds,billcost,callstart,cardnum,comment FROM ".ASTCC.".cdrs WHERE ".$cond." ORDER BY id DESC";
		$ss= mysql_query("SELECT SUM(billseconds) as secondes FROM ".ASTCC.".cdrs WHERE ".$cond." ");
	$detail= mysql_fetch_assoc($ss); $secs=(($detail['secondes']) % 60); $tim=floor((($detail['secondes'])/60)); $sTime= ''.$tim.' : '.$secs.'';
	
	//	Display result
		$calls = mysql_num_rows(mysql_query($sLimitsql));
		echo'<div class="boldblack">'.translate("sum").' '.$calls.' '.translate("calls").' MINUTES '.$sTime.'</div>';
		echo'<table class="callisttbl" align="center">
			<tr>
				<th class="callist_th">'.translate("date").'</th>
				<th class="callist_th">'.translate("callerid").'</th>
				<th class="callist_th">Id</th>
				<th class="callist_th">'.translate("destination").'</th>
				<th class="callist_th">Num</th>
				<th class="callist_th">Trunk</th>
				<th class="callist_th">'.translate("duration").'</th>
				<th class="callist_th">'.translate("cost").'</th>
			</tr>';
		$objAstcc = new DB(); $objAstcc->connect(ASTCC); $aLimit = $objAstcc -> select($sLimitsql);
		$boucle=0; $i = 0;
		while (@extract($aLimit[$i]))
			{
			$abo= mysql_fetch_array(mysql_query("SELECT vorname FROM ".ASTCC.".webuser WHERE webuser = '".$cardnum."' "));
			$trunk = substr($trunk, 0, 20);
			echo'<tr id="tr_'.$i.'" onmouseout="showRow('.$i.',0)" onmousemove="showRow('.$i.',1);">
				<td class="callist_td">'.date("d.m.Y H:i",$callstart).'</td>
				<td class="callist_td">'.$cardnum.'</td>
				<td class="callist_td">'.$abo['vorname'].'</td>
				<td class="callist_td">'.$comment.'</td>
				<td class="callist_td">'.$callednum.'</td>
				<td class="callist_td">'.$trunk.'</td>
				<td class="callist_td">'.$billseconds.'</td>
				<td class="callist_td">'.number_format((round($billcost/10000,3)), 3, ',', '.').'</td>
			</tr>';
			$boucle = $boucle + $billcost;
			$i++;
			}
			
		echo'</table><br />
		<div class="boldlightgreen">'.translate("total_amount").' '.number_format(($boucle/10000), 3, ',', '.').' '.$devise.'</div><br />';
		$objAstcc->closeDb();
	}
	else
	{
	echo'<div class="headline_global">'.translate("adminbillheadline").'</div><br />
	<div class="boldred">'.translate("loginfailed").'</div><br />';
	}
require("../inc/php/admin_footer.inc.php");
?>
