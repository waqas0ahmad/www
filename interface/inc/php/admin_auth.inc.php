<?php
############################
### 2018 MYSQLI SUPPORT ###
############################
$angemeldet=0; session_start(); $my_session=$_COOKIE['PHPSESSID'];
if (!empty($_POST['webuser']) && !empty($_POST['webpw']))
	{
	$webuser = $_POST['webuser']; $webpw = $_POST['webpw']; $webpw=md5($webpw);
	$castcc = mysqli_connect($hosto,$dblog,$dbpass,$bdd);
	$result = $castcc->query("SELECT admin_id from ".ASTCC.".webadmins where admin_username='$webuser' and admin_password='$webpw'"); @extract(mysqli_fetch_array($result)); 
	$global_rows=mysqli_num_rows($result);
	$resulto = $castcc->query("SELECT admin_id from asterisk.webadmins where admin_username='$webuser' and admin_password='$webpw'"); @extract(mysqli_fetch_array($resulto)); 
	$globalo_rows=mysqli_num_rows($resulto);
	
	if ($global_rows==1)
		{
		$angemeldet=1; $anmeldestatus=$callerid;
		SetCookie("webuser", "$webuser", time()+86400*365, "/");
		$result = $castcc->query("UPDATE ".ASTCC.".webadmins set websession='$my_session', lastlogin=NOW(), admin_ip='".$_SERVER["REMOTE_ADDR"]."' WHERE 
		admin_username='$webuser' AND admin_password='$webpw'");
		}
	elseif ($globalo_rows==1)
		{
		$angemeldet=1; $anmeldestatus=$callerid;
		SetCookie("webuser", "$webuser", time()+86400*365, "/");
		$result = $castcc->query("UPDATE asterisk.webadmins set websession='$my_session', lastlogin=NOW(), admin_ip='".$_SERVER["REMOTE_ADDR"]."' WHERE 
		admin_username='$webuser' AND admin_password='$webpw'");
		}
	mysqli_close($castcc);
	}
	
// CASE User is already logged in
if (isset($my_session))
	{
	$castcc = mysqli_connect($hosto,$dblog,$dbpass,$bdd);
	
	$result = $castcc->query("select * from ".ASTCC.".webadmins where websession='$my_session'");
	@extract(mysqli_fetch_array($result)); $global_rows=mysqli_num_rows($result);
	$resulto = $castcc->query("select * from asterisk.webadmins where websession='$my_session'");
	@extract(mysqli_fetch_array($resulto)); $globalo_rows=mysqli_num_rows($resulto);
	if ($global_rows==1)
		{
  		$angemeldet=1; $iId=$admin_id;
		}
	if ($globalo_rows==1)
		{
  		$angemeldet=1; $iId=$admin_id;
		}
	mysqli_close($castcc);
	}
// CASE Logout
if ((!empty($logout) && $logout == 1) || $global_rows>1)
	{
	$castcc = mysqli_connect($hosto,$dblog,$dbpass,$bdd);
 	$result = $castcc->query("update ".ASTCC.".webadmins set websession='' where websession='$my_session' and admin_id='$iId'");
	SetCookie("webuser", "", time()+2, "/");
 	SetCookie("session", "", time()+2, "/");
 	SetCookie(session_name(), '', time()-42000, '/');
 	session_destroy();
	mysqli_close($castcc);
 	header ("Location: index.php");
	exit;
	}
?>