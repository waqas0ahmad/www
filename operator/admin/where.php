<?
require ("../inc/php/astcc.inc.php");
###############  Comdif Telecom Billing software  ###############
							$adminver= 01;
###############  Christian Zeler  Comdif Telecom  ###############
$route = $_GET['route'];
$road = mysql_query("SELECT comment FROM routes WHERE pattern=".$route."");
$st = mysql_fetch_row($road) or die(mysql_error());
echo $st[0]; mysql_free_result($road); mysql_close($link);
?>