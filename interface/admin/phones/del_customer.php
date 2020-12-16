<?
############################
### 2018 MYSQLI SUPPORT ###
############################
mysqli_query($ladmin,"DELETE FROM asterisk.sipfriends WHERE name='" . $_VARS['sipnr'] . "' LIMIT 1");
mysqli_query($ladmin,"DELETE FROM asterisk.dialplan WHERE exten='" . $_VARS['sipnr'] . "'");
mysqli_query($ladmin,"DELETE FROM ".$bdd.".cards WHERE number='" . $_VARS['sipnr'] . "' LIMIT 1");
mysqli_query($ladmin,"INSERT INTO asterisk.numberpool SET extnumber='" . $_VARS['sipnr']. "', carrier='free'");

echo "<SCRIPT LANGUAGE='JavaScript'>window.location.replace('show_customer.php')</script>";
?>