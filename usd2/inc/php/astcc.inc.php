<?php
require ("constants.inc.php");
$link = mysql_connect($hosto , $dblog , $dbpass) or die(mysql_error());
mysql_select_db($bdd , $link) or die(mysql_error());
?>

