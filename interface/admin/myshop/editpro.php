<?
require ("../../inc/php/admin_init.inc.php");
$objAstcc = new DB(); $objAstcc->connect(ASTCC);

if ( $_POST[nom] != '' && $_POST[achat] != '' && $_POST[vente] != '' && $_POST[cat] != '' && $_POST[stock] != '')
{ 
mysql_query("UPDATE mystock SET nom='".$_POST[nom]."' , achat='".$_POST[achat]."' , vente='".$_POST[vente]."' , cat='".$_POST[cat]."' , stock='".$_POST[stock]."' , color='".$_POST[color]."' WHERE id='".$_POST[id]."'") or die( mysql_error());
unset ($_POST[action], $_POST[nom], $_POST[achat], $_POST[vente], $_POST[cat], $_POST[stock]);
echo "<SCRIPT LANGUAGE='JavaScript'>window.open('editpro.php?id=".$_POST[id]."', '_self');</script>";
 }

$select = mysql_query("SELECT * FROM mystock WHERE id='".$_GET[id]."'");
$row = mysql_fetch_row($select);
echo '<div align="center"><strong>Modifier</strong></div><br/>
<table align="center"> 
<form action="#SELF" method="post">
<tr><td><input type="text" name="nom" value="'.$row[1].'"/></td><td>Designation</td></tr>
<tr><td><input type="text" name="achat" value="'.$row[2].'"/></td><td>Achat</td></tr>
<tr><td><input type="text" name="vente" value="'.$row[3].'"/></td><td>Vente</td></tr>
<tr><td><input type="text" name="stock" value="'.$row[5].'"/></td><td>Stock</td></tr>
<input type="hidden" name="id" value="'.$_GET[id].'" />';
///////// SELECT COLOR
echo '<tr><td><select name="color">';
echo '<option selected value="'.$row[6].'" style="background-color:'.$row[6].'"> SELECT </option>';
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
echo '<tr><td><select name="cat">';
$stocka = mysql_query("SELECT * FROM mycat ORDER BY id");
while ($stock = mysql_fetch_row($stocka))
{
echo '<option value="'.$stock[1].'">'.$stock[1].'</option>';
}
echo '</select></td><td>Categorie</td></tr>';
///////// SELECT CAT end
echo '<tr><td></td><td><input type="submit" value="Confirm" /></td></tr></form></table>';





$objAstcc->closeDb();
?>