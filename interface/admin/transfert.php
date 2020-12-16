<?
require ("../inc/php/admin_init.inc.php");
$objAstcc = new DB(); $objAstcc->connect(ASTCC);
echo '<head><link rel="stylesheet" type="text/css" href="../inc/css/main.css">
<title>Cybercallshop billing system</title></head>';
$myex= $_GET['cab']; $cabineID = round(exp($myex/99999991234),0);

echo '<br/><div align="center"><table border="0" cellpadding="0" cellspacing="0" width="200"><tr><td class="cab_tds" align="center" bgcolor="#DDE3FF">';
echo '<form action="#SELF" method="get"><div align="center">';

$result = mysql_query("SELECT * FROM cards WHERE number !='$cabineID' ORDER BY number");
echo '<select name="transfert">';
while($select = mysql_fetch_row($result)){
echo '<option value="'.$select[0].'">'.$select[13].'</option>';
}
echo '</select>';
echo '<input type="hidden" name="cabina" value="'.$cabineID.'" /><input type="submit" value="Transfert" /></from></td></tr></table>';


if ($_GET['transfert'] !='')
{
$transfert = $_GET['transfert']; $cabina = $_GET['cabina'];
$result = mysql_query("SELECT * FROM cdrs WHERE cardnum = '$cabina'")or die('Erreur SQL !'.$sql.'<br>'.mysql_error());

echo '<table border="1" align="center">';
while ($row = mysql_fetch_row($result) )
{

mysql_query("INSERT INTO cdrs (cardnum , callerid , callednum , trunk , disposition , billseconds ,  billcost , callstart , datecall , includedseconds , routecost , comment , opcost ) VALUE ( '$transfert' , '$transfert' , '$row[3]' , '$row[4]' , '$row[5]' , '$row[6]' , '$row[7]' , '$row[8]' , '$row[9]' , '$row[10]' , '$row[11]' , '$row[12]' , '$row[13]') ") or die ('Erreur SQL !'.$sql.'<br>'.mysql_error());

mysql_query("DELETE FROM cdrs WHERE id=".$row[0]."")or die('Erreur SQL !'.$sql.'<br>'.mysql_error());
}
mysql_query("DELETE FROM cumul WHERE cardnum=".$_GET['cabina']."")or die('Erreur SQL !'.$sql.'<br>'.mysql_error());

$saledb = mysql_query("SELECT * FROM mysale WHERE cabine='".$_GET['cabina']."'");
while ($pr = mysql_fetch_row($saledb))
{
mysql_query("UPDATE mysale SET cabine='".$_GET['transfert']."' WHERE cabine='".$_GET['cabina']."'");
}


$objAstcc->closeDb();

echo "<SCRIPT LANGUAGE='JavaScript'>window.open('close.html', '_self');</script>";
}
echo '</div></tr></td></table>';
?>