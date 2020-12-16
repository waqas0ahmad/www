<?
require ("../../inc/php/admin_init.inc.php");
echo '<head><link rel="stylesheet" type="text/css" href="../../inc/css/main.css">
<title>Cybercallshop billing system</title></head>';

$myex= $_GET['cabineID']; $cabineID = round(exp($myex/99999991234),0);
$objAstcc = new DB(); $objAstcc->connect(ASTCC);
echo '<br/><div align="center"><table border="0" cellpadding="0" cellspacing="0" width="500"><tr><td class="cab_tds" align="center" bgcolor="#DDE3FF">';

if ($_GET['cabineID'] != '' && $_GET['prepaid'] != '')
{ 
if ($_GET['prepaid'] != '5000')
{ 
$prep = $_GET['prepaid'];
$xx = preg_replace('/\./',',',$prep);
$ase=explode(',',$xx);
$use = '0.'.$ase[1].'';
$resultat = (($ase[0] * 10000) + ($use * 10000));

$result = mysql_query("UPDATE cards SET facevalue='".$resultat."', brand='".(($resultat)/(10000))."' WHERE number='".$cabineID."' ");
echo "<SCRIPT LANGUAGE='JavaScript'>window.open('close.html', '_self');</script>";
}else{
$result = mysql_query("UPDATE cards SET facevalue='".($_GET['prepaid'] * 10000)."', brand='pp' WHERE number='".$cabineID."' "); }
echo "<SCRIPT LANGUAGE='JavaScript'>window.open('close.html', '_self');</script>";
 }
 /////////////////THE FORM///////////////////////////////////////////////
echo '<br/><div align="center">
<form action="#SELF" method="get"><input type="texte" name="prepaid"><br/><br/>
NO LIMIT <input name="prepaid" type="checkbox" value="5000" />';
echo '<input type="hidden" name="cabineID" value="'.(log($cabineID)*99999991234).'" />
<br/><br/><input type="submit" /></form></div>';

$aaa = mysql_query("SELECT facevalue FROM cards WHERE number='".$cabineID."'")  or die(mysql_error());
$somme = mysql_fetch_array($aaa);
if ($somme[0] != '50000000' )
{ echo '<br/><div align="center"><strong>CREDIT CABINE: <font color=red size=5>'.(($somme[0])/(10000)).'</font> '.$devise.'</strong></div>'; }


echo '<br/><br/><div align="center"><a href="javascript:window.close()">'.translate("close").'</a></div><br/>';

?>

