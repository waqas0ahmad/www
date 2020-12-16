<?
require('header.php');

echo'<br />CREATION COMPTE CALL-SHOP<br /><br /><br />';
######################### FORM ****************************************************************************
echo'<form action="'.$_SERVER['PHP_SELF'].'" method="get">
	<p>'.$Nom.'<br /><input type="text" name="name"/><br />
	<br />'.$Prenom.'<br /><input type="text" name="surname"/><br />
	<br />'.$Adresse.'<br /><input type="text" name="address"/><br />
	<br /><input type="hidden" name="vat" value="1">';
echo''.$Twen.'<br />';
$result = mysqli_query($ladmin,"SELECT * FROM cabpool ORDER BY firstcab");
echo "<select name=\"starcabine\">";
while($select = mysqli_fetch_row($result))
	{
	echo "<option value=\"".$select[0]."\">".$select[0]."</option>";
	}
echo'</select><br />
	<br />'.$Utilisateur.'<br /><input type="text" name="user" value=""/><br />
	<br />PASSWORD<br /><input type="text" name="password" value="'.randnum().''.randnum().''.randnum().'"/><br />';
echo'<br />Marge boutique par default (+X cents)<br />
	<select name="marge">
	<option value="500">5 cents/minute</option>
	<option value="1000">10 cents/minute</option>
	<option value="1500">15 cents/minute</option>
	<option value="2000">20 cents/minute</option>
	<option value="2500">25 cents/minute</option>
	</select><br />	
	<p><input type="submit" name="OK" value="CREER LE COMPTE"/></p></form><p>';

######################### ACTION ****************************************************************************
if (isset($_GET['user']) && isset($_GET['password']) && isset($_GET['name']) && isset($_GET['starcabine']))
	{
	$name = $_GET['name']; $surname = $_GET['surname']; $address = $_GET['address']; $user = $_GET['user']; $login = $_GET['user']; $password = $_GET['password'];
	$starcabine = $_GET['starcabine']; $vat = $_GET['vat']; $marge = $_GET['marge'];
	###### check if user already exist ######
	$lolo= mysqli_query($ladmin,"select * from custom where user='$user'"); $lola= mysqli_fetch_row($lolo); if ($lola[0] !=''){echo 'ALERT USER '.$lola[5].' ALREADY EXIST !'; exit;}
	
	###### double check if this dir exist ######
	$REP = "/var/www/".$login.""; if(is_dir($REP)){echo 'ALERT THIS USER '.$lola[5].' IS RESERVED BY SYSTEM !';	exit;}
	
	////create user in admin customer database
	$endcabine = $starcabine + 19; $cabdialplan = floor($starcabine / 10); $cabdialplan2 = floor($endcabine / 10);
	mysqli_query($ladmin,"INSERT INTO custom (name , surname , address , user , login , password , starcabine, soldeht, vat, soldettc, email)  VALUE 
	('$name' , '$surname' , '$address' , '$user' , '$login' , '$password' , '$starcabine', '0' , '$vat', '0', '1' )");
	
	////remove this booth pool from cabpool database
	mysqli_query($ladmin,"DELETE FROM cabpool WHERE firstcab = '$starcabine'");
	
	////create user directory
	shell_exec("echo |cp -R /var/www/".$admindir."/admin/userdir /var/www/".$login."");

	########################## write the user conf file ##########################
	$confile = "/var/www/".$user."/inc/php/constants.inc.php";				   ###
	$fhd = fopen($confile, 'a+');											   ###
	$data = "\n"; fwrite($fhd, $data);										   ###
	$data = "define (\"ASTCC\", \"astcc_".$user."\");\n"; fwrite($fhd, $data); ###
	$data = "\$starcabine = ".(($starcabine)-1).";\n"; 	fwrite($fhd, $data);   ###
	$data = "\$startcabine = ".(($starcabine)-1).";\n"; fwrite($fhd, $data);   ###
	$data = "\$endcabine = ".$endcabine.";\n"; fwrite($fhd, $data);			   ###
	$data = "\$context = \"sippool_".$user."\";\n"; fwrite($fhd, $data);	   ###
	$data = "\$tva = \"".$vat."\";\n"; fwrite($fhd, $data);					   ###
	$data = "\$bdd = \"astcc_".$user."\";\n"; fwrite($fhd, $data);			   ###
	$data = "?>\n"; fwrite($fhd, $data);									   ###
	fclose($fhd);															   ###
	##############################################################################

	////create astcc-customer database
	$newdb = "astcc_".$user."";
	mysqli_query($ladmin,"CREATE DATABASE ".$newdb."");
	system('mysql -u'.$loginconf.' -p'.$passwordconf.' -h localhost -D'.$newdb.'  < /var/www/'.$admindir.'/admin/astcc-ht.sql');

	////create customer extension conf
	$extconf = "/var/www/ext-register/sippoll_".$user."";
	$exten = fopen($extconf, 'w+');
	$data = "[sippool_".$user."]\n"; fwrite($exten, $data);
	$data = "switch => Realtime/@sippool_".$user."\n"; fwrite($exten, $data);
	$data = "include => parkedcalls\n"; fwrite($exten, $data);
	$data = "\n"; fwrite($exten, $data);
							#*********** LOCAL CALL ***********#
	$data = "exten => _0ZX.,1,MYSQL(Connect connid ".$hostconf." ".$loginconf." ".$passwordconf." ".$dbadminconf.")\n"; fwrite($exten, $data);
	$data = "exten => _0ZX.,2,MYSQL(Query resultid \${connid} SELECT soldettc FROM custom where user='".$user."' )\n"; fwrite($exten, $data);
	$data = "exten => _0ZX.,3,MYSQL(Fetch foundRow \${resultid} soldettc )\n"; fwrite($exten, $data);
	$data = "exten => _0ZX.,4,MYSQL(Clear \${resultid})\n"; fwrite($exten, $data);
	$data = "exten => _0ZX.,5,MYSQL(Disconnect \${connid})\n"; fwrite($exten, $data);
	$data = "exten => _0ZX.,6,GotoIf($[\"\${soldettc}\" > \"0\"]?7:9)\n"; fwrite($exten, $data);
	$data = "exten => _0ZX.,7,DeadAGI(astcc_".$user.".agi,\${CDR(accountcode)},33\${EXTEN:1},4)\n"; fwrite($exten, $data);
	$data = "exten => _0ZX.,8,Hangup()\n"; fwrite($exten, $data); $data = "exten => _0ZX.,9,Playback(not-enough-credit)\n"; fwrite($exten, $data);
	$data = "exten => _0ZX.,10,Hangup()\n"; fwrite($exten, $data); 
	$data = "\n"; fwrite($exten, $data);	
							#*********** SHORT NUMBERS ***********#
	$data = "exten => _[13][01269]XX,1,MYSQL(Connect connid ".$hostconf." ".$loginconf." ".$passwordconf." ".$dbadminconf.")\n"; fwrite($exten, $data);
	$data = "exten => _[13][01269]XX,2,MYSQL(Query resultid \${connid} SELECT soldettc FROM custom where user='".$user."' )\n"; fwrite($exten, $data);
	$data = "exten => _[13][01269]XX,3,MYSQL(Fetch foundRow \${resultid} soldettc )\n"; fwrite($exten, $data);
	$data = "exten => _[13][01269]XX,4,MYSQL(Clear \${resultid})\n"; fwrite($exten, $data);
	$data = "exten => _[13][01269]XX,5,MYSQL(Disconnect \${connid})\n"; fwrite($exten, $data);
	$data = "exten => _[13][01269]XX,6,GotoIf($[\"\${soldettc}\" > \"0\"]?7:9)\n"; fwrite($exten, $data);
	$data = "exten => _[13][01269]XX,7,DeadAGI(astcc_".$user.".agi,\${CDR(accountcode)},33000\${EXTEN},4)\n"; fwrite($exten, $data);
	$data = "exten => _[13][01269]XX,8,Hangup()\n"; fwrite($exten, $data);
	$data = "exten => _[13][01269]XX,9,Playback(not-enough-credit)\n"; fwrite($exten, $data);
	$data = "exten => _[13][01269]XX,10,Hangup()\n"; fwrite($exten, $data);
	$data = "\n"; fwrite($exten, $data);
							#*********** 118 NUMBERS ***********#
	$data = "exten => _118XXX,1,MYSQL(Connect connid ".$hostconf." ".$loginconf." ".$passwordconf." ".$dbadminconf.")\n"; fwrite($exten, $data);
	$data = "exten => _118XXX,2,MYSQL(Query resultid \${connid} SELECT soldettc FROM custom where user='".$user."' )\n"; fwrite($exten, $data);
	$data = "exten => _118XXX,3,MYSQL(Fetch foundRow \${resultid} soldettc )\n"; fwrite($exten, $data);
	$data = "exten => _118XXX,4,MYSQL(Clear \${resultid})\n"; fwrite($exten, $data);
	$data = "exten => _118XXX,5,MYSQL(Disconnect \${connid})\n"; fwrite($exten, $data);
	$data = "exten => _118XXX,6,GotoIf($[\"\${soldettc}\" > \"0\"]?7:9)\n"; fwrite($exten, $data);
	$data = "exten => _118XXX,7,DeadAGI(astcc_".$user.".agi,\${CDR(accountcode)},33000\${EXTEN},4)\n"; fwrite($exten, $data);
	$data = "exten => _118XXX,8,Hangup()\n"; fwrite($exten, $data);
	$data = "exten => _118XXX,9,Playback(not-enough-credit)\n"; fwrite($exten, $data);
	$data = "exten => _118XXX,10,Hangup()\n"; fwrite($exten, $data);
	$data = "\n"; fwrite($exten, $data);	
	
							#*********** ALL OTHER CALL ***********#
	$data = "exten => _XXXXXX.,1,MYSQL(Connect connid ".$hostconf." ".$loginconf." ".$passwordconf." ".$dbadminconf.")\n"; fwrite($exten, $data);
	$data = "exten => _XXXXXX.,2,MYSQL(Query resultid \${connid} SELECT soldettc FROM custom where user='".$user."' )\n"; fwrite($exten, $data);
	$data = "exten => _XXXXXX.,3,MYSQL(Fetch foundRow \${resultid} soldettc )\n"; fwrite($exten, $data);
	$data = "exten => _XXXXXX.,4,MYSQL(Clear \${resultid})\n"; fwrite($exten, $data);
	$data = "exten => _XXXXXX.,5,MYSQL(Disconnect \${connid})\n"; fwrite($exten, $data);
	$data = "exten => _XXXXXX.,6,GotoIf($[\"\${soldettc}\" > \"0\"]?7:9)\n"; fwrite($exten, $data);
	$data = "exten => _XXXXXX.,7,DeadAGI(astcc_".$user.".agi,\${CDR(accountcode)},\${EXTEN},4)\n"; fwrite($exten, $data);
	$data = "exten => _XXXXXX.,8,Hangup()\n"; fwrite($exten, $data);
	$data = "exten => _XXXXXX.,9,Playback(not-enough-credit)\n"; fwrite($exten, $data);
	$data = "exten => _XXXXXX.,10,Hangup()\n"; fwrite($exten, $data);
	$data = "\n"; fwrite($exten, $data);
							#*********** LONG DISTANCE CALL ***********#
	$data = "exten => _00Z.,1,MYSQL(Connect connid ".$hostconf." ".$loginconf." ".$passwordconf." ".$dbadminconf.")\n"; fwrite($exten, $data);
	$data = "exten => _00Z.,2,MYSQL(Query resultid \${connid} SELECT soldettc FROM custom where user='".$user."' )\n"; fwrite($exten, $data);
	$data = "exten => _00Z.,3,MYSQL(Fetch foundRow \${resultid} soldettc )\n"; fwrite($exten, $data);
	$data = "exten => _00Z.,4,MYSQL(Clear \${resultid})\n"; fwrite($exten, $data);
	$data = "exten => _00Z.,5,MYSQL(Disconnect \${connid})\n"; fwrite($exten, $data);
	$data = "exten => _00Z.,6,GotoIf($[\"\${soldettc}\" > \"0\"]?7:9)\n"; fwrite($exten, $data);
	$data = "exten => _00Z.,7,DeadAGI(astcc_".$user.".agi,\${CDR(accountcode)},\${EXTEN:2},4)\n"; fwrite($exten, $data);
	$data = "exten => _00Z.,8,Hangup()\n"; fwrite($exten, $data);
	$data = "exten => _00Z.,9,Playback(not-enough-credit)\n"; fwrite($exten, $data);
	$data = "exten => _00Z.,10,Hangup()\n"; fwrite($exten, $data);
	$data = "\n"; fwrite($exten, $data);
							#*********** INTERNAL CALL ***********#
	$data = "exten => h,1,Hangup()\n"; fwrite($exten, $data);
	$data = "exten => _".$cabdialplan.".,1,Dial(SIP/\${EXTEN})\n"; fwrite($exten, $data);
	$data = "exten => _".$cabdialplan.".,2,Hangup()\n"; fwrite($exten, $data);
	$data = "exten => _".$cabdialplan2.".,1,Dial(SIP/\${EXTEN})\n"; fwrite($exten, $data);
	$data = "exten => _".$cabdialplan2.".,2,Hangup()\n"; fwrite($exten, $data);
							#*********** MISC RULES ***********#
	$data = "exten => h,1,Hangup()\n"; fwrite($exten, $data);
	$data = "exten => t,1,Hangup()\n"; fwrite($exten, $data);
	$data = "exten => i,1,Congestion()\n"; fwrite($exten, $data);
	fclose($exten);

	################################################ Create user log file ################################################
	shell_exec("sudo /bin/cp -p /var/www/".$admindir."/admin/userdir/log/log /var/www/".$user."/log/astcc_".$user.".txt");  ##
	######################################################################################################################

	////Create custom AGI script
	shell_exec("sudo /bin/cp -p /var/www/".$admindir."/admin/astcc /var/lib/asterisk/agi-bin/astcc_".$user.".agi");
	$agi = "/var/lib/asterisk/agi-bin/astcc_".$user.".agi";
	$agibin = fopen($agi, 'r+');
	$data = "#!/usr/bin/perl\n"; fwrite($agibin, $data);
	$data = "#\n"; fwrite($agibin, $data);
	$data = "my \$logfile =\"/var/www/".$user."/log/astcc_".$user.".txt\";\n"; fwrite($agibin, $data);
	$data = "open STDERR, \">>\$logfile\";\n"; fwrite($agibin, $data);
	$data = "use POSIX qw(strftime ceil floor);\n"; fwrite($agibin, $data);
	$data = "sub timestamp()\n"; fwrite($agibin, $data);
	$data = "	{\n"; fwrite($agibin, $data);
	$data = "	my \$now = strftime \"%Y%m%d%H%M%S\", localtime;\n"; fwrite($agibin, $data);
	$data = "return \$now;\n"; fwrite($agibin, $data);
	$data = "	}\n"; fwrite($agibin, $data);
	$data = "\$datecall = timestamp();\n"; fwrite($agibin, $data);
	$data = "\$SIG{HUP}  = 'ignore_hup';\n"; fwrite($agibin, $data);
	$data = "sub ignore_hup\n"; fwrite($agibin, $data);
	$data = "	{\n"; fwrite($agibin, $data);
	$data = "\n"; fwrite($agibin, $data);
	$data = "	}\n"; fwrite($agibin, $data);
	$data = "use DBI;\n"; fwrite($agibin, $data);
	$data = "use Asterisk::AGI;\n"; fwrite($agibin, $data);
	$data = "sub load_config()\n"; fwrite($agibin, $data);
	$data = "	{\n"; fwrite($agibin, $data);
	$data = "	open(CFG, \"</var/lib/astcc/astcc_".$user."-config.conf\");\n"; fwrite($agibin, $data);
	$data = "	while(<CFG>)\n"; fwrite($agibin, $data);
	$data = "		{\n"; fwrite($agibin, $data);
	$data = "		chomp;\n"; fwrite($agibin, $data);
	$data = "		my (\$var, \$val) = split(/\\s*\\=\\s*/);\n"; fwrite($agibin, $data);
	$data = "		\$config{\$var} = \$val;\n"; fwrite($agibin, $data);
	$data = "		}\n"; fwrite($agibin, $data);
	$data = "	close(CFG);\n"; fwrite($agibin, $data);
	$data = "	}\n"; fwrite($agibin, $data);
	$data = "require '/var/lib/asterisk/agi-bin/callshop.agi';\n"; fwrite($agibin, $data);
	fclose($agibin);

	######################################## Create astcc_user-config file ########################################
	shell_exec("echo |cp -p /var/www/".$admindir."/admin/astccconf /var/lib/astcc/astcc_".$user."-config.conf"); ##
	$cconf = "/var/lib/astcc/astcc_".$user."-config.conf";														 ##
	$astcconf = fopen($cconf, 'a+');																			 ##
	$data = "dbname = astcc_".$user."\n"; fwrite($astcconf, $data);												 ##
	$data = "pathc = ".$user."\n"; fwrite($astcconf, $data);													 ##
	$data = "tva = ".$vat."\n"; fwrite($astcconf, $data);														 ##
	fclose($astcconf);																							 ##
	###############################################################################################################

	////insert range cabines in asterisk numberpool table for this user
	$i = 0;
	while ($i <= 19)
		{
		mysqli_query($ladmin,"INSERT INTO asterisk.numberpool (extnumber) VALUE ('$starcabine' + '$i')"); $i++;
		}
	////create user login and password in astcc database
	$astbase= 'astcc_'.$user.''; $to = date('Y-m-d'); $cpas = md5($password); $cryptpass = crypt($password);
	mysqli_query($ladmin,"INSERT INTO astcc_".$user.".webadmins (admin_username,admin_password,admin_status,admin_vorname,admin_nachname,created) 
	VALUE ('$user','$cpas','0','$user','$user','$to')");
	/*
	mysqli_query($ladmin,"INSERT INTO astcc_".$user.".webadmins (admin_username,admin_password,admin_status,admin_vorname,admin_nachname,created) 
	VALUE ('$user','$cpas','0','$user','$user','$to')");
	*/
	$ou= mysqli_query($ladmin,"SELECT * FROM admin.master");
	while($z = mysqli_fetch_array($ou))
		{
		$cost= (round(($z['ek'] + $marge) / 100) * 100);
		mysqli_query($ladmin,"INSERT INTO astcc_".$user.".routes (pattern,comment,trunks,connectcost,includedseconds,ek,cost,opcc,opsecinc,oppal) VALUE 
		('".$z['pattern']."','".$z['comment']."','".$z['trunks']."','0','0','".$z['ek']."','".$cost."','".$z[4]."','".$z[5]."','".$z[6]."')");
		}
	////Reload asterisk dialplan
	shell_exec("sudo /usr/sbin/asterisk -rx 'dialplan reload'");
	////Go back now
	echo "<SCRIPT LANGUAGE='JavaScript'>window.location.replace('customnew.php')</script>";
	###########################create all###########################
	}
require('footer.php');
?>