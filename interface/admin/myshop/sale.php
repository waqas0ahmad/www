<?
require ("../../inc/php/admin_init.inc.php");
?>
<style type="text/css">
<!--
.butlink {
border-size: 0px; border-style: none; background: inherit;
text-align:left;
font-weight: bold; font-size: 12px; font-family: Arial, Helvetica, sans-serif; color: blue;
cursor: hand; cursor: pointer; adding: 0px;
}
</style>
<?
echo '<body BACKGROUND="../../imgs/navig/fnd.jpg">';
echo '<table width="100%"><tr><td width="50%">
</td><td align="right"><form><input type="button"  class="butlink" value="Stock Admin" OnClick="parent.location.href=\'stock.php\'"></form></td></tr></table>';
$objAstcc = new DB(); $objAstcc->connect(ASTCC);
settype($_GET['refo'], "string"); $newval = $_GET['refo'];
?>
<table align="center"><tr><td>
<?
$stockb = mysql_query("SELECT * FROM mycat ORDER BY id");
while ($stock = mysql_fetch_row($stockb))
{
echo '<td align="center"><input type="button" value="'.$stock[1].'" OnClick="window.location.href=\''.$PHP_SELF.'?categ='.$stock[1].'&refo='.$_GET['refo'].'\'"></form></td>';
}
echo '</tr></table>';

if ($_GET[categ] != '')

						{
echo '<table align="center" border="1" ><tr>';
$proa = mysql_query("SELECT * FROM mystock WHERE cat='".$_GET[categ]."'");
$i=1; $z=8;
while ($pro = mysql_fetch_row($proa))
{

echo '<td bgcolor="'.$pro[6].'" align="center" width="100" height="100"  
OnClick="parent.tic.location.href=\'ticket.php?ref='.$pro[1].'&refo='.$_GET['refo'].'\'" onMouseover="this.bgColor=\'#CCCCEF\'" onMouseout="this.bgColor=\''.$pro[6].'\'" >'.$pro[1].'<br/>'.$pro[3].'</td>';


if ($i == $z) {echo '</tr><tr>'; $i = 1;}else {$i= $i + 1;}
}
echo '</tr></table>';
						}

?>