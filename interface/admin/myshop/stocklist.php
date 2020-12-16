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

$objAstcc = new DB(); $objAstcc->connect(ASTCC);
echo '<div align="center"><font size="4"><strong>Catégories</strong></font></div><br/>';
echo '<table align="center"><tr><td><form><input type="button"  class="butlink" value="Catégories" OnClick="window.location.href=\'stocklist.php\'"></form>
</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><form><input type="button"  class="butlink" value="Produits" OnClick="window.location.href=\'stock.php\'"></form>
</td></tr></table>';
//////////request to add new cat
if ($_POST[action] = 'ajcat' && $_POST[description] != '')
{ 
mysql_query("INSERT INTO mycat ( id, description , icone , dive )  VALUES ('".$_POST[id]."','".$_POST[description]."', '".$_POST[icone]."', '".$_POST[div]."')");
unset ($_POST[action], $_POST[description], $_POST[icone], $_POST[div]);
echo "<SCRIPT LANGUAGE='JavaScript'>window.open('stocklist.php', '_self');</script>";
 }
//////////request to add new cat end
//////////request to delete cat
if ($_GET[action] = 'delete' && $_GET[id] != '')
{ 
$fet= mysql_query("select * from mystock where cat='".$_GET[catname]."'");
$exist = mysql_fetch_row($fet);
if ($exist[0]=='')
{
echo 'ok la catégorie est bien vide';
mysql_query("DELETE FROM mycat WHERE id='".$_GET[id]."'") or die( mysql_error());
unset ( $_GET[action], $_GET[id], $_GET[catname]);
echo "<SCRIPT LANGUAGE='JavaScript'>window.open('stocklist.php', '_self');</script>";
}else{ echo '<div align="center"><font color="red" size="3">Impossible de détruire une catégorie avec des produits !!<br>Merci d\'effacer premierement les produits de cette catégorie</font></div>'; }
 }

//////////form for new cat
echo '<div align="center"><strong>Catégories</strong></div><br/>
<table align="center"> 
<form action="'.$PHP_SELF.'" method="post">
<tr><td><input type="text" name="description" /></td><td>Catégorie</td></tr>
<tr><td><input type="text" name="id" /></td><td>Id</td></tr>
<tr><td></td><td></td></tr>
<tr><td></td><td></td></tr>
<input type="hidden" name="action" value="ajcat" />
<tr><td></td><td><input type="submit" value="Confirm" /></td></tr>
</form>
</table>';
//////////display form for new cat end

//////////display cat list
echo '<br/><br/><table align="center" border="1"><tr align="center"><td>
ID</td><td>DESIGNATION</td></tr>';
$stockb = mysql_query("SELECT * FROM mycat ORDER BY description ASC");
while ($stock = mysql_fetch_row($stockb))
{
echo '<tr align="center"><td>'.$stock[0].'</td><td>'.$stock[1].'</td><td><a href="javascript: void(0)" onclick="window.location.href=\''.$PHP_SELF.'?id='.$stock[0].'&action=delete&catname='.$stock[1].'\'">Effacer</td></tr>';
}
echo '</table>';
//////////display cat list end


echo '</td></tr></table>';
$objAstcc->closeDb();
?>
