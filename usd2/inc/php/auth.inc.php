<?php
$angemeldet=0;
session_start();
$my_session=$_COOKIE['PHPSESSID']; $webuser=strtr($webuser, "", ""); $webpw=strtr($webpw, "", "");
if ($webuser && $webpw) {

 	$link=mysql_connect("localhost", DBUSER, DBPASSWORD) or die(mysql_error());
 	$result=mysql_query("select account from ".ASTCC.".webuser where webuser='$webuser' and webpw='$webpw'") or die(mysql_error());
 	@extract(mysql_fetch_array($result));
 	$global_rows=mysql_num_rows($result);
 	mysql_close($link);
 	if ($global_rows==1) {
  		$angemeldet=1;
  		$anmeldestatus=$callerid;
  		SetCookie("webuserhint", "$webuser", time()+86400*365, "/");

  		$link=mysql_connect("localhost", DBUSER, DBPASSWORD)or die(mysql_error());
  		$result=mysql_query("update ".ASTCC.".webuser set websession='$my_session', lastlogin=NOW() where webuser='$webuser' and webpw='$webpw'")or die(mysql_error());
  		mysql_close($link);
 	}
}

# User is already logged in
if (isset($my_session)) {
 	$link=mysql_connect("localhost", DBUSER, DBPASSWORD)or die(mysql_error());
	$result=mysql_query("select * from ".ASTCC.".webuser where websession='$my_session'")or die(mysql_error());
 	@extract(mysql_fetch_array($result));
 	$global_rows=mysql_num_rows($result);
 	mysql_close($link);
 	if ($global_rows==1) {
  		$angemeldet=1;
  		$anmeldestatus="$webuser ($account)";
  		# In the main system we use $sipnummer instead of $account
  		$sipnummer=$account;
 	}
}

# Logout
# SessionID hast to be present only once!
if ($logout == 1 || $global_rows>1) {
 	# Delete sessionvariable from database
 	$link=mysql_connect("localhost", DBUSER, DBPASSWORD)or die(mysql_error());
 	$result=mysql_query("update ".ASTCC.".webuser set websession='' where websession='$my_session' and account='$sipnummer'")or die(mysql_error());
 	mysql_close($link);

 	# Destroy session
 	SetCookie("webuserhint", "", time()+2, "/");
 	SetCookie("session", "", time()+2, "/");
 	SetCookie(session_name(), '', time()-42000, '/');
 	session_destroy();
 
 	# If logged out, point so index and give up
 	header ("Location: index.php");
	exit;
}

?>
