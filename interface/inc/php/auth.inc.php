<?php

$angemeldet=0;
session_start();
$my_session=$_COOKIE['PHPSESSID'];
$webuser=strtr($webuser, "'*/", "xxx");
$webpw=strtr($webpw, "'*/", "xxx");
if ($webuser && $webpw) {
	# Encrypt password
 	$webpw=md5($webpw);

	# Forgive me that's not oop
 	$link=mysql_connect("localhost", DBUSER, DBPASSWORD) or die("Could not connect to database<br>");
 	$result=mysql_query("select account from asterisk.webuser where webuser='$webuser' and webpw='$webpw'") or die ("Error in Userauth.");
 	@extract(mysql_fetch_array($result));
 	$global_rows=mysql_num_rows($result);
 	mysql_close($link);
 	if ($global_rows==1) {
  		$angemeldet=1;
  		$anmeldestatus=$callerid;
  		SetCookie("webuserhint", "$webuser", time()+86400*365, "/");

  		# Session in DB
  		$link=mysql_connect("localhost", DBUSER, DBPASSWORD) or die("Could not connect to database<br>");
  		$result=mysql_query("update asterisk.webuser set websession='$my_session', lastlogin=NOW() where webuser='$webuser' and webpw='$webpw'") or die ("Error in Userauth. (update sessionid)");
  		mysql_close($link);
 	}
}

# User is already logged in
if (isset($my_session)) {
 	$link=mysql_connect("localhost", DBUSER, DBPASSWORD) or die("Could not connect to database<br>");
	$result=mysql_query("select * from asterisk.webuser where websession='$my_session'") or die ("Error in Userauth. (get session)");
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
 	$link=mysql_connect("localhost", DBUSER, DBPASSWORD) or die("Could not connect to database<br>");
 	$result=mysql_query("update asterisk.webuser set websession='' where websession='$my_session' and account='$sipnummer'") or die ("Fehler in Userauth. (unset session)");
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
