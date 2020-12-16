<?
require ("../inc/php/admin_header.inc.php");

if ($_GET["number"] !='')
{
$number=$_GET["number"];
$objAstcc = new DB(); $objAstcc->connect(ASTCC);
$US=mysql_query("SELECT * FROM routes WHERE '".$number."' LIKE CONCAT(pattern,'%') ORDER BY LENGTH(pattern) DESC" )or die(mysql_error());
$AS=mysql_fetch_array($US);
echo $AS["pattern"]; echo ' - '.$AS["comment"]; echo ' - '.$AS["ek"]; echo ' - '.$AS["cost"];
$objAstcc->closeDb();
}
?>

<form method="get" action="#SELF">
<input type="text" value="" name="number" /> NUMBER
<input type="submit" />
</form>
<? require("../inc/php/admin_footer.inc.php"); ?>