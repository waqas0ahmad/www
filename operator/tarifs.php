<?php
require ("./inc/php/init.inc.php");
###############  Comdif Telecom Billing software  ###############
							$userver= 01;
###############  Christian Zeler  Comdif Telecom  ###############
$objCustomer = new DB(); $objCustomer -> connect(ASTERISK);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<link rel="stylesheet" type="text/css" href="inc/css/main.css">
<link rel="stylesheet" type="text/css" href="main.css">
<script type="text/javascript" language="JavaScript" src="inc/js/highlite_trs.js"></script>
</head>
<body>
<div align="center">
	<a href="<? $PHP_SELF; ?>?action=lang&lang=FR" class="big_links">Francais&nbsp;
	<img src="imgs/gimmics/flag_fr.png" width="12" height="9" border="0" /></a>&nbsp;|&nbsp;
	<a href="<? $PHP_SELF; ?>?action=lang&lang=EN" class="big_links">english&nbsp;
	<img src="imgs/gimmics/flag_us.png" width="12" height="9" border="0" /></a>&nbsp;|&nbsp;
	<a href="<? $PHP_SELF; ?>?action=lang&lang=ES" class="big_links">Espanol&nbsp;
	<img src="imgs/gimmics/flag_es.jpg" width="12" height="9" border="0" /></a>
</div>

<?
echo '<div align="center">'.translate("Q").' | <a href="index.php">'.translate("linkmyaccount").'</a> | 
<a href="contact.php">'.translate("mycreateaccount").'</a><br/>';
################### select form ###########################		
echo '<form name="Myselect" action="'.$_SERVER['PHP_SELF'].'?sort=" method="get">';
$sel = mysql_query("SELECT comment , pattern FROM ".ASTCC.".routes");
echo ''.translate("firstname").'/Prefix <input type="texte" name="letter" />';
echo '<input type="button" class="back_button" value="Ok" OnClick="document.Myselect.submit()"></form></div/>';
################### /select form ##########################

$letter = $_GET['letter'];
if ($letter =='')
{
$iRecords_per_page = 20; $iOffset_record = $iPage * $iRecords_per_page; $iPages_per_pageList = 10;
$sCdrsql = "SELECT comment, cost, pattern FROM routes ORDER BY comment LIMIT ".$iOffset_record.", ".$iRecords_per_page;
$sCountQuery = "SELECT comment, cost, pattern FROM routes ORDER BY comment";
$objAstcc = new DB(); $objAstcc->connect(ASTCC);
$aRates = $objAstcc->select($sCdrsql);
?>

  <table class="bigtbl" align="center">
    <tr>
      <th colspan="3" class="headline"><?=translate("linkrates"); ?></th>
    </tr><tr>
      <th class="small_headline"><?=translate("destination"); ?></th>
	  <th class="small_headline"><?=translate("adminratesldcall"); ?></th>
      <th class="small_headline"><?=translate("price"); ?></th>
    </tr>
    <?php
    for($i = 0; $i < count($aRates); $i++)
    {
      @extract($aRates[$i]);
      $iRate = number_format($cost/100, 2, ",", ".");
      echo'<tr id="tr_'.$i.'" onmouseout="showRow('.$i.',0)" onmousemove="showRow('.$i.',1);">
		<td class="border_tds">'.$comment.'</td>
		<td class="border_tds">'.$pattern.'</td>
        <td class="border_tds">'.$iRate.'&nbsp;'.translate("centperminute").'</td>
      </tr>';
    }
 echo'</table><br><div class="boldblack"'.translate("superrates").'</div>'.$sHeadline.'';
 
  }else{
		$sCdrsql = "SELECT comment, trunks, ek, cost, connectcost, includedseconds, pattern FROM routes WHERE comment LIKE 
		'".$letter."%' || pattern LIKE '".$letter."%' ORDER BY comment";
		$sCountQuery = "SELECT comment, cost, pattern FROM routes ORDER BY comment";
		$objAstcc = new DB(); $objAstcc->connect(ASTCC);
		$aRates = $objAstcc->select($sCdrsql);
		
		echo '<table class="bigtbl" align="center"><tr><th colspan="3" class="headline">'.translate("linkrates").'</th></tr>
		<tr><th class="small_headline">'.translate("destination").'</th>
		<th class="small_headline">'.translate("adminratesldcall").'</th>
		<th class="small_headline">'.translate("price").'</th></tr>';
		for($i = 0; $i < count($aRates); $i++)
			{
			@extract($aRates[$i]);
			$iRate = number_format($cost/100, 2, ",", ".");
			echo'<tr id="tr_'.$i.'" onmouseout="showRow('.$i.',0)" onmousemove="showRow('.$i.',1);">
        	<td class="border_tds">'.$comment.'</td>
			<td class="border_tds">'.$pattern.'</td>';
			echo'<td class="border_tds">'.$iRate.'&nbsp;'.translate("centperminute").'</td>
			</tr>';
			}
		echo'</table>
		<br>
		<div class="boldblack">'.translate("superrates").'</div>';
		}

?>
