<?php

$link=mysql_connect("localhost", DBUSER, DBPASSWORD) or die("Could not connect to database<br>");
$result=mysql_query("select * from asterisk.sipfriends where accountcode='$sipnummer'");
@extract(mysql_fetch_array($result));
mysql_close($link);

$link=mysql_connect("localhost", DBUSER, DBPASSWORD) or die("Could not connect to database<br>");
$result=mysql_query("select * from ".ASTCC.".webuser where account='$sipnummer'");
@extract(mysql_fetch_array($result));
mysql_close($link);
$telefonangemeldet=$regseconds-date(U);
?>
