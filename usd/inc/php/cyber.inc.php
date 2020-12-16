<?php
require ("constants.inc.php");
$link = mysql_connect($cyberhost, $dblog , $dbpass) or die(mysql_error());
mysql_select_db("".ASTCC."", $link) or die(mysql_error());
?>