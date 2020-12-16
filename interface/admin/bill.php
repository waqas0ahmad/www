<?
require ("../inc/php/admin_init.inc.php");
echo '<head><link rel="stylesheet" type="text/css" href="../inc/css/main.css">
<title>Cybercallshop billing system</title></head>';
$myex= $_GET['cabineID']; $cabineID = round(exp($myex/99999991234),0); $objAstcc = new DB(); $objAstcc->connect(ASTCC);
/////////////rappel champ trunk utilisé pour le temps réel online
$result = mysql_query("SELECT cardnum, callednum, disposition, billseconds, billcost, datecall, comment, id , trunk, opcost FROM cumul WHERE cardnum='$cabineID' ORDER BY callstart DESC ");
echo '<br/><div align="center"><table border="0" cellpadding="0" cellspacing="0" width="600"><tr><td class="cab_tds" align="center" bgcolor="#DDE3FF">';
echo '<br/><table border="0" align="center" >';
?>
<tr>
    <td class="cab_tds">&nbsp;&nbsp;&nbsp;<? echo translate("phoneno")?>&nbsp;&nbsp;&nbsp;</td>
    <td class="cab_tds">&nbsp;&nbsp;&nbsp;<? echo translate("durationmin")?>&nbsp;&nbsp;&nbsp;</td>
    <td class="cab_tds">&nbsp;&nbsp;&nbsp;<? echo translate("price")?>&nbsp;&nbsp;&nbsp;</td>
	<td class="cab_tds"><div align="center">Date</div></td>
    <td class="cab_tds">&nbsp;&nbsp;&nbsp;Destination&nbsp;&nbsp;&nbsp;</td>
</tr>
<?
while ($row = mysql_fetch_array($result) )
{
$b = $row["billcost"] / 10000;

$modulo = explode(".", $b); if( strlen($modulo[1]) == '1'){ $b = "".$b."0"; }

echo '<tr>
<td class="cab_tds"><div align="center">'.$row["callednum"].'</div></td>
<td class="cab_tds"><div align="center">'.((int)($row["trunk"]/60)).':'.($row["trunk"] % 60).'</div></td>
<td class="cab_tds"><div align="center">'.$b.'</div></td>
<td class="cab_tds"><div align="center">'.$row[5].'</div></td>
<td class="cab_tds"><div align="center">'.$row[6].'</div></td>
</tr>';
}
echo '</table>';
mysql_free_result($result);
//FIN AFFICHAGE tableau detail
###########################################################################################
//AFFICHAGE prix total
$somme = mysql_query("SELECT SUM(billcost) as total FROM cumul WHERE cardnum='$cabineID'"); 
$detail = mysql_fetch_assoc($somme) or die(mysql_error()); 
$a = $detail['total'] / 10000;
$a = arrondi($a, 2, "sup");
//////////////////////////////////////////////////////////////////////////////////////autres produits ##############
echo '<div align="center"> '.translate("opro").' </div><table align="center">';
$saledb = mysql_query("SELECT * FROM mysale WHERE cabine='".$cabineID."'");
$sum = mysql_query("SELECT SUM(vente) as mytotal FROM mysale WHERE cabine='".$cabineID."'");
$Total = mysql_fetch_assoc($sum);
while ($pr = mysql_fetch_row($saledb))
{
echo '<tr align="center"><td width="100">'.$pr[1].'</td><td width="100">'.$pr[3].' '.$devise.'</td></tr>';
}
echo '</table><br/>';
if ($Total['mytotal'] > 0)
{$a =($Total['mytotal'] + $a); }
echo '<br/><div align="center"><strong>TOTAL: <font color=red size=5>'.$a.'</font> '.$devise.'</strong>';
mysql_free_result($somme);
//FIN AFFICHAGE prix total
###########################################################################################
//bon pour ceux qui savent pas compter
?>
<form action="bill.php" method="get"><? echo translate("cashed")?>&nbsp;&nbsp; 
<input type="text" name="cash" value="<? echo $cash ?>"/>
<input type="hidden" name="cabineID" value="<? echo $_GET['cabineID']; ?>" />
<input type="submit" value="OK" /></form>
<?
$rendre = (($cash)- ($a));
if ($rendre >='0')
{
echo '<p align="center">'.translate("monnaie").' : '.$rendre.'';
}
//fin pour ceux qui savent pas compter
echo '<br/><br/><table><tr><td class="cab_tds"><a href="del.php?cabineID='.$cabineID.'">'.translate("billcab").'';
echo '</a></td><td width="250"></td><td class="cab_tds"><a href="javascript:window.print()">'.translate("print").'</a></td></tr></table></tr></td></table>';
$objAstcc->closeDb();
?>

