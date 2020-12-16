<?php

$link=mysql_connect("localhost", DBUSER, DBPASSWORD) or die("Could not connect to database<br>");
$result=mysql_query("select facevalue,used from ".ASTCC.".cards where number='$sipnummer'") or die ("DB-Error..");
@extract(mysql_fetch_array($result));
setlocale(LC_MONETARY, 'fr_FR');
$solde= round(($facevalue-$used)/10000,3);
$guthabeneuro=money_format('%.2n', (($facevalue-$used)/10000));
?>
