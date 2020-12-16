<?php
require ("inc/php/header.inc.php");

$objCustomer = new DB(); $objCustomer -> connect(ASTERISK);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<link rel="stylesheet" type="text/css" href="inc/css/main.css">
<script type="text/javascript" language="JavaScript" src="inc/js/highlite_trs.js"></script>
</head>
<body>

<?
echo '<div align="center">'.translate("Q").'<br/>';
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

require("inc/php/footer.inc.php");
?>
