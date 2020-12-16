<?php 
require ("../inc/php/constants.inc.php");
$link=mysql_connect($hosto,$dblog,$dbpass);

if($_POST["table"]!='' && $_POST["dbase"]!='')
{ 
header("Content-type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=datas.csv"); 
$sql = mysql_query("SELECT * FROM ".$_POST["dbase"].".".$_POST["table"]."") or die (mysql_error());
while ($data = mysql_fetch_row($sql)) 
{ $tbl = $tbl . "'" . $data[0] . ";"; $tbl = $tbl . "" . $data[1] . ";"; $tbl = $tbl . "" . $data[2] . ";"; $tbl = $tbl . "" . $data[3] . ";"; 
$tbl = $tbl . "" . $data[4] . ";"; $tbl = $tbl . "" . $data[5] . ";"; $tbl = $tbl . "" . $data[6] . ";";$tbl = $tbl . "" . $data[7] . ";";$tbl = $tbl . "" . $data[8] . ";";$tbl = $tbl . "" . $data[9] . ";";$tbl = $tbl . "" . $data[10] . ";"; $tbl = $tbl . "" . $data[11] . "\n"; } 
print $tbl ; }
mysql_close($link);
?>