<?
require ("../../inc/php/admin_init.inc.php");
$objAstcc = new DB(); $objAstcc->connect(ASTCC);
if ($_GET[id] != '')
{
mysql_query("DELETE from mystock WHERE id='".$_GET[id]."'") or die( mysql_error());
}
$objAstcc->closeDb();
echo "<SCRIPT LANGUAGE='JavaScript'>window.open('../close.html', '_self');</script>";
?>