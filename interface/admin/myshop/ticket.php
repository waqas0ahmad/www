<?
require ("../../inc/php/admin_init.inc.php");

$objAstcc = new DB(); $objAstcc->connect(ASTCC);

$Myprod = $_GET['ref']; $Uid= $_GET['refo'];
////////////// CASE ADD PRODUCT ////////////////////////////////////
if ($Myprod !='')
{
$scan = mysql_query("SELECT * from mystock WHERE nom ='$Myprod'");
$in = mysql_fetch_row($scan);
$date= date('Y-m-d H:i:s');
mysql_query("INSERT INTO mysale (unid, nom, achat, vente, cat, date) VALUE ( '$Uid', '$in[1]', '$in[2]', '$in[3]', '$in[4]', '$date')");
unset ($Myprod);
}
////////////// CASE DELETE PRODUCT ////////////////////////////////////
if ($_GET['idelete'] !='' && $_GET['stockup'] !='')
{
mysql_query("DELETE FROM mysale WHERE id='".$_GET['idelete']."'");
unset ($_GET['stockup'], $_GET['idelete']);
echo "<SCRIPT LANGUAGE='JavaScript'>window.location.replace('".$PHP_SELF."?refo=".$_GET['refo']."')</script>";
}
////////////// DEFAULT DISPLAY ////////////////////////////////////////
echo '<table align="center">';
$saledb = mysql_query("SELECT * FROM mysale WHERE unid='".$_GET['refo']."'");
$sum = mysql_query("SELECT SUM(vente) as mytotal FROM mysale WHERE unid='".$_GET['refo']."'");
$Total = mysql_fetch_assoc($sum);
while ($pr = mysql_fetch_row($saledb))
{
echo '<tr align="center"><td>'.$pr[1].'</td><td>'.$pr[3].'</td><td>'.$pr[4].'</td><td>'.$pr[5].'
</td><td>
   <a href="javascript:void(0);" onclick="window.location.replace(\''.$PHP_SELF.'?idelete='. $pr[0].'&refo='.$_GET['refo'].'&stockup='.$pr[1].'\');" target="tic">
'.translate("effacer").'</a></td></tr>';
}
echo '</table><br/>';
if ($Total['mytotal'] > 0)
{ echo '<table align="center"><tr>
<td>';
//////Cyber select
$query = "SELECT * FROM cyber_network WHERE state ='1' AND start !='' ORDER BY name "; $result = mysql_query($query);
echo '<form action="'.$PHP_SELF.'" methode="GET"><select name="Cyber">';
while($select = mysql_fetch_row($result)){ echo '<option value="'.$select[0].'">'.$select[0].'</option>'; }
echo '</select>';
echo '<input type="hidden" name="gocyber" value="yes" />
<input type="hidden" name="refo" value="'.$_GET['refo'].'" />
<input type="submit" value="Transfert" /></form>';
echo '</td><td>';

//////Callshop select
$quercab = "SELECT a.cardnum, b.number, b.nomcab FROM cumul a, cards b WHERE a.cardnum = b.number"; $resultcab = mysql_query($quercab);
echo '<form action="'.$PHP_SELF.'" methode="GET"><select name="Cab">';
while($selectcab = mysql_fetch_row($resultcab)){ echo '<option value="'.$selectcab[1].'">Cab '.$selectcab[2].'</option>'; }
echo '</select>';
echo '<input type="hidden" name="gocab" value="yes" />
<input type="hidden" name="refo" value="'.$_GET['refo'].'" />
<input type="submit" value="Transfert" /></form>';
echo '</td>


<td width="100" align="center"><strong><font color="red" size="5">Total: '.$Total['mytotal'].'</font></strong></td>
<td width="100" align="center"><a href="javascript:void(0);" onclick="window.location.replace(\''.$PHP_SELF.'?Cash=cash&refo='.$_GET['refo'].'\');" target="tic">'.translate("billcab").'</a></td>
</tr></table>'; }
/////////////////////////////////////////// CASH ///////////////////////////////////////
if($_GET['Cash'] == 'cash')
{
$saledproduct = mysql_query("SELECT * FROM mysale WHERE unid='".$_GET['refo']."'");
while ($product = mysql_fetch_row($saledproduct))
{
$scanstock = mysql_query("SELECT * from mystock WHERE nom ='".$product[1]."'"); $qty = mysql_fetch_row($scanstock);
mysql_query("UPDATE mystock SET stock='".($qty[5] -1)."' WHERE nom='".$product[1]."'");
mysql_query("INSERT INTO mysale_buff (unid, nom, achat, vente, cat, date) VALUE ( '$Uid', '$product[1]', '$product[2]', '$product[3]', '$product[4]', '$date')");
mysql_query("DELETE FROM mysale WHERE id='".$product[0]."'");
}
echo "<SCRIPT LANGUAGE='JavaScript'>window.open('close.html', 'windowname10');</script>";
}
////////////////////////////////// TRANSFERT TO A CYBERCAFE CUSTOMER  ////////////////
if($_GET['Cyber'] != '' && $_GET['gocyber'] == 'yes')
{
$Mycyber = $_GET['Cyber'];
$saledproduct = mysql_query("SELECT * FROM mysale WHERE unid='".$_GET['refo']."'");
while ($product = mysql_fetch_row($saledproduct))
{
$scanstock = mysql_query("SELECT * from mystock WHERE nom ='".$product[1]."'"); $qty = mysql_fetch_row($scanstock);
mysql_query("UPDATE mysale SET cyber='".$Mycyber."' WHERE unid='".$Uid."'");
}
echo "<SCRIPT LANGUAGE='JavaScript'>window.open('close.html', 'windowname10');</script>";
}
////////////////////////////////// TRANSFERT TO A CALLSHOP CUSTOMER  ////////////////
if($_GET['Cab'] != '' && $_GET['gocab'] == 'yes')
{
$Mycab = $_GET['Cab'];
$saledproduct = mysql_query("SELECT * FROM mysale WHERE unid='".$_GET['refo']."'");
while ($product = mysql_fetch_row($saledproduct))
{
$scanstock = mysql_query("SELECT * from mystock WHERE nom ='".$product[1]."'"); $qty = mysql_fetch_row($scanstock);
mysql_query("UPDATE mysale SET cabine='".$Mycab."' WHERE unid='".$Uid."'");
}
echo "<SCRIPT LANGUAGE='JavaScript'>window.open('close.html', 'windowname10');</script>";
}
///////////////////////////////////////////////////////////////////////////////////////
?>