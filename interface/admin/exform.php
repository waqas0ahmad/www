<?
require ("../inc/php/constants.inc.php");
$link=mysql_connect($hosto,$dblog,$dbpass);
$yo=mysql_query("SHOW TABLES IN $bdd LIKE '%_buff'");
echo '<form method="POST" action="exportex.php">
<select name="table">';

while($yia=mysql_fetch_row($yo)){ echo '<option value="'.$yia[0].'">'.$yia[0].'</option>'; }

echo '</select>
<input type="hidden" name="dbase" value="'.$bdd.'" />
<input type="submit" value="OK" />
</form>';
mysql_close($link);
?>
