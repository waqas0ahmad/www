<?php

$temp_secret= $_VARS['input_webpw'];

# Insert user into asterisk database
$link=mysql_connect("localhost", DBUSER, DBPASSWORD) or die("Could not connect to database<br>");
$result=mysql_query("insert into asterisk.sipfriends set name='$input_account',accountcode='$input_account',callerid='$input_vorname $input_nachname <$input_account>',canreinvite='no',context='sippool',dtmfmode='rfc2833',host='dynamic',secret='$temp_secret',type='friend',username='$input_account',allow='alaw;ulaw;g729;ilbc;gsm;h263;h263p'") or die ("DB-Error Include SIP-Account set up");

# Create entry in dialplan
$result=mysql_query("insert into asterisk.dialplan set context='sippool',exten='$input_account',priority='1',app='Dial',appdata='SIP/\${EXTEN}|90'") or die ("DB-Error set up Dialplan");

mysql_close($link);
?>
