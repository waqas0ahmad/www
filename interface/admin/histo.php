<?
require ("../inc/php/admin_init.inc.php");
echo '<head><link rel="stylesheet" type="text/css" href="../inc/css/main.css">
<title>Cybercallshop billing system</title></head>';
  $objAstcc = new DB();
  $objAstcc->connect(ASTCC);
$myex= $_GET['cabineID']; $cabineID = round(exp($myex/99999991234),0);
if ($_GET['type'] != 'day' )
{
$result = mysql_query("SELECT cardnum, callednum, disposition, billseconds, billcost, datecall, comment, id , trunk FROM cdrs_last WHERE cardnum='$cabineID' ORDER BY callstart DESC ");
}else{
$result = mysql_query("SELECT cardnum, callednum, disposition, billseconds, billcost, datecall, comment, id , trunk FROM cdrs_buff WHERE cardnum='$cabineID' AND datecall LIKE '".date('Y-m-d')."%' ORDER BY callstart DESC ");
}
echo '<br/><div align="center"><table border="0" cellpadding="0" cellspacing="0" width="600"><tr><td class="cab_tds" align="center" bgcolor="#DDE3FF">';
echo '<br/><table border="0" align="center">';
?>
<tr>
    <td class="cab_tds"><div align="center"><? echo translate("phoneno")?></div></td>
    <td class="cab_tds"><div align="center"><? echo translate("durationmin")?></div></td>
    <td class="cab_tds"><div align="center"><? echo translate("price")?></div></td>
	    <td class="cab_tds"><div align="center">Date</div></td>
    <td class="cab_tds"><div align="center">Destination</div></td>
</tr>
<?
while ($row = mysql_fetch_array($result) )
{
// minutes facturées   $zzz = (round(($row[3]/60),2));

$b = $row[4] / 10000;
echo '<tr>
<td class="cab_tds"><div align="center">'.$row[1].'</div></td>
<td class="cab_tds"><div align="center">'.((int)($row[8]/60)).':'.($row[8] % 60).'</div></td>
<td class="cab_tds"><div align="center">'.$b.'</div></td>
<td class="cab_tds"><div align="center">'.$row[5].'</div></td>
<td class="cab_tds"><div align="center">'.$row[6].'';

echo '</div></td></tr>';
}
echo '</table>';
mysql_free_result($result);
if ($_GET['type'] != 'day' )
{ $somme = mysql_query("SELECT SUM(billcost) as total FROM cdrs_last WHERE cardnum='$cabineID' "); }
else
{ $somme = mysql_query("SELECT SUM(billcost) as total FROM cdrs_buff WHERE cardnum='$cabineID' AND datecall LIKE '".date('Y-m-d')."%'"); }
$detail = mysql_fetch_assoc($somme) or die(mysql_error()); 
$a = $detail['total'] / 10000;
echo '<br/><div align="center"><strong>TOTAL: <font color=red size=5>'.$a.'</font> '.$devise.'</strong>';
mysql_free_result($somme);

echo '<br/><br/><table><tr><td class="cab_tds"><a href="javascript:window.close()"><img src="../imgs/gimmics/del.gif" alt="'.translate("close").'" /> '.translate("close").' <img src="../imgs/gimmics/del.gif" alt="'.translate("close").'" /></a></td></tr></table></td></tr></table>';
$objAstcc->closeDb();
?>
