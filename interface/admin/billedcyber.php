<?php
require ("../inc/php/admin_header.inc.php");

if($angemeldet == 1)
{ 
$objAstcc = new DB(); $objAstcc->connect(ASTCC);
echo '<table align="center" width="500"><tr><td width="160">';

if ($_POST["date"] != '') {
$starti = ''.$_POST["date"].' 00:00:00'; $endi = ''.$_POST["date2"].' 23:59:59';
echo ''.$starti.'</td><td width="180">'.$endi.'</td><td width="180"></td></table>';
$count = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM ".ASTCC.".cyber_compta WHERE date >= '$starti' AND date <= '$endi' "));
$yes = mysql_query("SELECT * FROM ".ASTCC.".cyber_compta WHERE date >= '$starti' AND date <= '$endi' ORDER BY id DESC");
$detail = mysql_fetch_assoc(mysql_query("SELECT SUM(time) as secondes, SUM(price) as vente FROM cyber_compta WHERE date >= '$starti' AND date <= '$endi'"));
$secs = (($detail['secondes']) % 60); $tim = floor ((($detail['secondes'])/60));  $sTime = ''.$tim.' : '.$secs.'';
}
else
{
if( $_GET["per"] == month )
{$curd = date("Y-m");}else{$curd = date("Y-m-d");}
echo '</td><td width="180"> &nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp '.$curd.'</td><td width="180"></td></table>';
$count = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM ".ASTCC.".cyber_compta  WHERE date LIKE '".$curd."%' "));
$yes = mysql_query("SELECT time, price, ip, date FROM ".ASTCC.".cyber_compta WHERE date LIKE '".$curd."%' ORDER BY id DESC");
$detail = mysql_fetch_assoc(mysql_query("SELECT SUM(time) as secondes, SUM(price) as vente FROM cyber_compta WHERE date LIKE '".$curd."%'"));
$secs = (($detail['secondes']) % 60); $tim = floor ((($detail['secondes'])/60));  $sTime = ''.$tim.' : '.$secs.'';
}

				

############################################ general display for datas
echo '<table align="center"><tr><td>';
include ("report/calendar.php");
echo '</td><td><form>&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="butlink" value="'.translate("month").'" OnClick="window.location.href=\''.$PHP_SELF.'?per=month\'"></form></td>
<td><form>&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;<input type="button" class="butlink" value="'.translate("day").'" OnClick="window.location.href=\''.$PHP_SELF.'?per=day\'"></form></td>
</tr></table>';

echo '<table align="center"><tr>
<td><form><input type="button" class="butlink" value="'.translate("adminbillheadline").'" OnClick="window.location.href=\'billedcalls.php\'"></form></td>
<td><form><input type="button" class="butlink" value="'.translate("summary").' Cybercafe" OnClick="window.location.href=\'billedcyber.php\'"></form></td>
<td><form><input type="button" class="butlink" value="'.translate("summary").' '.translate("Boutique").'" OnClick="window.location.href=\'billedshop.php\'"></form></td>
</tr></table>';

echo '<div class="boldblack">'.translate("sum").' '.$count[0].'&nbsp;&nbsp;&nbsp;&nbsp; MINUTES '.$sTime.'</div><br />

	<table width="700" align="center"><tr>
	<td width="100%" class="boldlightgreen">'.translate("adminratesratevk2").' : '.round(($detail['vente']),3).'</td></tr></table>';
		
?>
<table class="callisttbl" align="center">
				<tr>
				<th class="callist_th" width="50"><?=translate("date"); ?></th>
				<th class="callist_th"><?=translate("callerid"); ?></th>
				<th class="callist_th"><?=translate("durationmin"); ?></th>
				<th class="callist_th"><? echo ''.$dictionary["adminratesratevk2"].''; ?></th>
				</tr>
<?php

while ( $co = mysql_fetch_array($yes))
{
$idx = mysql_fetch_array(mysql_query("SELECT name FROM ".$bdd.".cyber_network WHERE ip='".$co["ip"]."'"))or die("MySQL ERROR: ".mysql_error());
echo '<td class="callist_td">'.$co["date"].'</td>
	  <td class="callist_td">'.$idx["name"].'</td>
	  <td class="callist_td">'.$co["time"].'</td>
	  <td class="callist_td">'.$co["price"].'</td></tr>';
}
echo '</table><br />'; 	$objAstcc->closeDb();
}
else
{ echo '<div class="headline_global">'.translate("adminbillheadline").'</div><br /><div class="boldred">'.translate("loginfailed").'</div><br />'; }

require("../inc/php/admin_footer.inc.php");
?>
