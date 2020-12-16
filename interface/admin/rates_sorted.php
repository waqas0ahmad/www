<?php
require ("../inc/php/admin_header.inc.php");
if($angemeldet == 1 )
	{
	$objAstcc = new DB(); 	$objAstcc->connect(ASTCC);
		if ($angemeldet == 1 && $statadmin['admin_status'] == 1 || $statadmin1['admin_status'] == 1)
		{
		echo "<SCRIPT LANGUAGE='JavaScript'>window.location.replace('new_rates.php')</script>";
		}
	switch ($_VARS['action']) {


	case "edit":
	if($_VARS['button'] == "store")
		{
		$iEditRates = $objAstcc->query("UPDATE routes SET cost='".(Tarif($_VARS['input_cost']) * 10000) ."', 
		connectcost='".(Tarif($_VARS['input_connectcost']) * 10000)."',  includedseconds='". $_VARS['input_includedseconds'] ."' 
		WHERE pattern='" . $_VARS['pat'] ."' LIMIT 1");
		$sMessage = translate("adminrateschangesaved");
		echo "<SCRIPT LANGUAGE='JavaScript'>window.history.go(-2)</script>";
		}

	$iPattern = $_VARS['pat']; $aRate = $objAstcc->select("SELECT * FROM routes WHERE pattern='" . $iPattern . "' LIMIT 1");
	echo '<div class="headline_global">'.translate("adminratesheadline").'</div><br/>';
	echo '<p align="center"><font color="#330000" >'.translate("actrateis").' '.($aRate[0]['pattern']).' '.translate("to").' '.($aRate[0]['comment']).' 
	'.translate("is").':<br />'.translate("adminratesrateek2").': <font color="#0000FF"><strong>';
	echo (($aRate[0]['ek'])/100);
	echo '</font></strong> Cents, '.translate("adminratesratevk2").': <font color="#0000FF"><strong>'.(($aRate[0]['cost'])/100).'</font>
	</strong> Cents, '.translate("connectcost").': <font color="#0000FF"><strong>'.(($aRate[0]['connectcost'])/100).'</font>
	</strong> Cents, '.translate("includetime").': <font color="#0000FF"><strong>'.($aRate[0]['includedseconds']).'</font></strong> Seconds</font>';

	echo'<form name="new_rates_frm" action="'.$PHP_SELF.'" method="POST"><input type="hidden" name="button" value="store" />
	<table class="rates_tbl" align="center"><tr><td>';

	printFormText(translate("adminratesratevk2") ,"input_cost",($aRate[0]['cost'] / 10000));
	printFormText(translate("connectcost") ,"input_connectcost",($aRate[0]['connectcost'] / 10000));
	printFormText(translate("includetime") ,"input_includedseconds",$aRate[0]['includedseconds']);

	echo'</td><tr><td></td><td align="center">
	<input type="hidden" name="action" value="edit" />
	<input type="hidden" name="pat" value="'.$_VARS['pat'].'" />
	<input type="hidden" name="input_comment" value="'.($aRate[0]['comment']).'" />
	<input type="button" class="back_button" value="'.translate("admincustchangesubmit").'" OnClick="document.new_rates_frm.submit()">
	</td></tr></table></form>';
	echo'<div class="messages" >'.$sMessage.'</div>';
	break;

	default:

	echo '<form name="Myselect" action="'.$PHP_SELF.'?sort=" method="get">';
	$sel = mysql_query("SELECT comment , pattern FROM ".ASTCC.".routes");
	echo ''.translate("firstname").'/Prefix <input type="texte" name="letter" />';
	echo '<input type="button" class="back_button" value="Ok" OnClick="document.Myselect.submit()"></form>';

	if ($_GET['letter'] !='' || $_POST['letter'] !='')
	{
	if ($_GET['letter'] !=''){$letter = $_GET['letter']; }
	if ($_POST['letter'] !=''){$letter = $_POST['letter']; }
	
	///////////////////////////////////////////////////// MASS TARIF MODULE //////////////////////////////////////////	
	echo'<table width="800" align="center"><tr>
		<td colspan="7" align="center">'.translate("gentarif").'</td></tr><tr><form action="'.$PHP_SELF.'" method="post">
		<td>'.translate("adminratesratevk2").' : </td>
		<input type="hidden" name="letter" value="'.$letter.'" />
		<input type="hidden" name="update" value="update" />
		<td><input type="text" name="Sp" /></td>
		<td>'.translate("connectcost").' : </td>
		<td><input type="text" name="Cc" /></td>
		<td>'.translate("includetime").' : </td>
		<td><input type="text" name="It" /></td>
		<td><input type="submit" /></td></form></tr></table>';
	
		if ($_POST['letter'] !='' && $_POST['Sp'] !='' && $_POST['update'] =='update')
			{
			mysql_query("UPDATE routes SET cost='".(Tarif($_POST['Sp']) * 10000)."', connectcost='".(Tarif($_POST['Cc']) * 10000)."', 
			includedseconds='".$_POST['It']."' WHERE comment LIKE '".$letter."%' || pattern LIKE '".$letter."%'");
			}
	///////////////////////////////////////////////// END MASS TARIF MODULE //////////////////////////////////////////
	
	$sCdrsql = "SELECT comment, trunks, ek, cost, connectcost, includedseconds, pattern FROM routes WHERE comment 
	LIKE '".$letter."%' || pattern LIKE '".$letter."%' ORDER BY comment";
	$aRates = $objAstcc->select($sCdrsql);
	echo '<div class="headline_global">'.translate("adminratesheadline").'</div><table class="bigtbl" align="center"><tr>
	
	<th class="small_headline">'.translate("destination").'</th>';
	echo'<th class="small_headline">'.translate("adminratesldcall").'</th>';
	echo'<th class="small_headline">'.translate("adminratesrateek2").'</th>';
	echo'<th class="small_headline">'.translate("adminratesratevk2").'</th>';
	echo'<th class="small_headline">'.translate("connectcost").'</th>';
	echo'<th class="small_headline">'.translate("includetime").'</th>';
	echo'<th class="small_headline">Info/Edit</th></tr>';

		for($i = 0; $i < count($aRates); $i++)
		{
		@extract($aRates[$i]);
		echo '<tr id="tr_'.$i.'" onmouseout="showRow('.$i.',0)" onmousemove="showRow('.$i.',1);">';
		echo '<td class="border_tds">'.$comment.'</td>';
		echo '<td class="border_tds">'.$pattern.'</td>';
		echo '<td class="border_tds">'.round(( ($ek/10000)),3).'</td>';
		echo '<td class="border_tds">'.round(( ($cost/10000)),3).'</td>';
		echo '<td class="border_tds">'.round(( ($connectcost/10000)),3).'</td>';
		echo '<td class="border_tds">'.$includedseconds.' Seconds</td>';
		echo '<td class="border_tds" style="text-align:center;"><a class="big_links" 
		href="'.$PHP_SELF.'?action=edit&title='.translate("adminratesheadline").'&pat='.$pattern.'">
		<img src="../imgs/gimmics/info.gif" width="12" height="12" border="0" valign="absmiddle" alt="Info/Edit" title="Info/Edit" /></a></td></tr>';

		}
	}
echo '<tr></tr></table><br />';
	}

}
else
{
echo '<div class="headline_global">'.translate("adminratesheadline").'/div><div class="boldred">'.translate("loginfailed").'</div>';
}
require("../inc/php/admin_footer.inc.php");
?>
