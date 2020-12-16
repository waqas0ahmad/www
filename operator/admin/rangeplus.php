<?
###############  Comdif Telecom Billing software  ###############
							$adminver= 01;
###############  Christian Zeler  Comdif Telecom  ###############
// uncomment to create range numbers in numberpool database
/* 
require ("../inc/php/astcc.inc.php");
for ($i = 1000; $i <= 9999; $i++)
{
$asc1 = rand(97,122); $L1 = chr($asc1); $asc2 = rand(65,90); $L2 = chr($asc2);
$extnumber= "11".$i."".$L1."".$L2;
mysql_query("INSERT into ".$bdd.".numberpool SET extnumber='".$extnumber."', carrier='free'") or die(mysql_error());
}
mysql_close($link);
*/
?>