<?
require ("../../inc/php/admin_init.inc.php");
echo '<body BACKGROUND="../../imgs/shopicon/fnd.jpg">';
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

//////////request to add new product
if ($_POST[action] = 'ajpro' && $_POST[nom] != '' && $_POST[achat] != '' && $_POST[vente] != '' && $_POST[cat] != '' && $_POST[stock] != '')
{ 
mysql_query("INSERT INTO mystock ( nom, achat, vente, cat, stock, color )  VALUES ('".$_POST[nom]."','".$_POST[achat]."', '".$_POST[vente]."', '".$_POST[cat]."' , '".$_POST[stock]."', '".$_POST[color]."')");
unset ($_POST[action], $_POST[nom], $_POST[achat], $_POST[vente], $_POST[cat], $_POST[stock]);
echo "<SCRIPT LANGUAGE='JavaScript'>window.open('stock.php', '_self');</script>";
 }
//////////request to add new product end

echo '<div align="center"><font size="4"><strong>Stock Admin</strong></font></div><br/>';

echo '<table align="center"><tr><td><form><input type="button"  class="butlink" value="Categories" OnClick="window.location.href=\'stocklist.php\'"></form>
</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><form><input type="button"  class="butlink" value="Stock" OnClick="window.location.href=\'stock.php\'"></form>
</td></tr></table>';

echo'<table align="center"> 
<form action="#SELF" method="post">
<tr><td><input type="text" name="nom" /></td><td>'.translate("firstname").'</td></tr>
<tr><td><input type="text" name="achat" /></td><td>'.translate("adminratesrateek2").' '.translate("ttc").'</td></tr>
<tr><td><input type="text" name="vente" /></td><td>'.translate("adminratesratevk2").' '.translate("ttc").'</td></tr>
<tr><td><input type="text" name="stock" /></td><td>Stock</td></tr>';
///////// SELECT COLOR
echo '<tr><td><select name="color">';
echo '<option value="#5EAEFF" style="background-color:#5EAEFF"> SELECT </option>';
echo '<option value="#FFFF66" style="background-color:#FFFF66"> SELECT </option>';
echo '<option value="#FFEA95" style="background-color:#FFEA95"> SELECT </option>';
echo '<option value="#FFDDDD" style="background-color:#FFDDDD"> SELECT </option>';
echo '<option value="#FF6C6C" style="background-color:#FF6C6C"> SELECT </option>';
echo '<option value="#F0F0F0" style="background-color:#F0F0F0"> SELECT </option>';
echo '<option value="#CECEFF" style="background-color:#CECEFF"> SELECT </option>';
echo '<option value="#CCFFFF" style="background-color:#CCFFFF"> SELECT </option>';
echo '<option value="#E1FFC4" style="background-color:#E1FFC4"> SELECT </option>';
echo '</select></td><td>Color</td></tr>';
///////// SELECT COLOR end
///////// SELECT CAT
echo '<tr><td><select name="cat">'; $stocka = mysql_query("SELECT * FROM mycat ORDER BY id");
while ($stock = mysql_fetch_row($stocka))
{
echo '<option value="'.$stock[1].'">'.$stock[1].'</option>';
}
echo '</select></td><td>Categorie</td></tr>';
///////// SELECT CAT end
echo '<input type="hidden" name="action" value="ajpro" />
<tr><td></td><td><input type="submit" value="Confirm" /></td></tr>
</form>
</table>';


//////////display product list
echo '<br/><br/><table align="center" border="1" width="100%"><tr align="center">
<td>Nom</td>
<td>Achat</td>
<td>Vente</td>
<td>Catégorie</td>
<td>Stock</td>
<td>Couleur</td>
<td>Effacer</td>
<td>Modifier</td>
</tr>';
$proa = mysql_query("SELECT * FROM mystock ORDER BY cat ASC, nom ASC");
while ($pro = mysql_fetch_row($proa))
{
echo '<tr align="center"><td>'.$pro[1].'</td><td>'.$pro[2].'</td><td>'.$pro[3].'</td><td>'.$pro[4].'</td><td>'.$pro[5].'</td><td bgcolor="'.$pro[6].'">
</td><td><a href="javascript: void(0)" onclick="window.open(\'delpro.php?id='. $pro[0].'\', \'windowname1\', 
  \'width=100, height=100, directories=no, location=no, menubar=no, resizable=no, scrollbars=0, status=no, toolbar=no\'); 
   return false;">Effacer</td><td><a href="javascript: void(0)" onclick="window.open(\'editpro.php?id='. $pro[0].'\', \'windowname2\', 
  \'width=400, height=600, directories=no, location=no, menubar=no, resizable=no, scrollbars=0, status=no, toolbar=no\'); 
   return false;">Modifier</td></tr>';
}
echo '</table>';
//////////display product list end


$objAstcc->closeDb();
?>
