<?
# REQUIRED: constants.inc.php
# Output: $name, $accountcode, $callerid, $canreinvite, $context, $dtmfmode, $host, $secret, $type, $username, $allow

# Get sipdata for user with account $sipnummer
$link=mysql_connect("localhost", DBUSER, DBPASSWORD) or die("Could not connect to database<br>");
$result=mysql_query("select * from asterisk.sipfriends where accountcode='$sipnummer'") or die ("DB-Error Include SIP-Account");
@extract(mysql_fetch_array($result));
mysql_close($link);

$link=mysql_connect("localhost", DBUSER, DBPASSWORD) or die("Could not connect to database<br>");
$result=mysql_query("select * from asterisk.webuser where account='$sipnummer'") or die ("DB-Error 2 Include SIP-Account");
@extract(mysql_fetch_array($result));
mysql_close($link);
$telefonangemeldet=$regseconds-date(U);
?>
