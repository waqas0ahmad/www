<?php
session_start();
if ( isset($_SESSION['login']) && isset($_SESSION['session']))
	{
	require('/home/dbadmin.php');
	$user = $_GET['user']; $login = $_GET['login']; $startcabine = $_GET['startcabine']; $endcab = ($startcabine + 19);
	
	echo'<br/><center><strong>Etes vous sur de vouloir effacer Utilisateur '.$_GET['user'].' avec le login '.$_GET['login'].'<br/>
		première cabine : '.$startcabine.' dernière cabine '.$endcab.' ?</center></strong>
		<br/><div align="center"><form action="'.$_SERVER['PHP_SELF'].'" method="get">';

	echo'<input type="hidden" name="user" value="'.$_GET['user'].'" />
		<input type="hidden" name="login" value="'.$_GET['login'].'" />
		<input type="hidden" name="startcabine" value="'.$startcabine.'" />
		<input type="hidden" name="endcab" value="'.$endcab.'" />
		<input type="hidden" name="confirm" value="confirm" />
		<input type="submit" value="CONFIRMATION DELETE"  />
		</form></div>';
	if (!empty($_GET['confirm']))
		{
		if ( $_GET['confirm'] == 'confirm' )
			{
			$endcab = $_GET['endcab']; $startcabine = $_GET['startcabine']; $login = $_GET['login']; $user = $_GET['user'];
			//////restore cabine pool for new customer////////////////
			mysqli_query($ladmin,"INSERT INTO admin.cabpool (firstcab,lastcab) VALUES ('".$startcabine."','".$endcab."')"); 
			////////////////////////delete customer//////////////////
			mysqli_query($ladmin,"DELETE FROM admin.custom WHERE login='".$login."'");
			////////////////////////delete user directory##################################
			shell_exec("echo |sudo rm -rf /var/www/'$login'");
			////////////////////////delete astcc-customer database///////////////////////
			$newdb = "astcc_".$user."";
			mysqli_query($ladmin,"DROP DATABASE ".$newdb.""); 
			////////////////////////Delete customer extension conf//////////////////////
			$extconf = "/var/www/ext-register/sippoll_".$user."";
			shell_exec("echo |sudo rm -f ".$extconf."");
			////////////////////////Delete custom AGI script //////////////////////////
			$agi = "/var/lib/asterisk/agi-bin/astcc_".$user.".agi";
			shell_exec("echo |sudo rm -f ".$agi."");
			////////////////////////Delete astcc_user-config file ////////////////
			$cconf = "/var/lib/astcc/astcc_".$user."-config.conf";
			shell_exec("echo |sudo rm -f ".$cconf."");
			/////////////////////////////////////////remove user cabines /////////////////////////////
			mysqli_query($ladmin,"DELETE FROM asterisk.sipfriends WHERE context= 'sippool_".$user."'");
			/////////////////////////////////////////insert range cabines for this user/////////////////////////////
			for($z=$startcabine;$z<=$endcab;$z++)
				{
				mysqli_query($ladmin,"DELETE FROM asterisk.numberpool WHERE extnumber=".$z."");
				mysqli_query($ladmin,"DELETE FROM asterisk.webuser WHERE webuser=".$z."");
				mysqli_query($ladmin,"DELETE FROM asterisk.dialplan WHERE exten=".$z."");
				}
			////////////////////////////////RESTART SERVERS ////////////////////////////////////////////////////////
			$reboot=`/usr/sbin/asterisk -rx 'restart now'`;
			echo "$reboot";
			$back=`/usr/sbin/asterisk -rx 'reload'`;
			echo "$back";
			///////////////////////////////GO BACK//////////////////////////////////////////////////////////////////
			echo "<SCRIPT LANGUAGE='JavaScript'>window.location.replace('custom.php')</script>";
			////////////////////////////////////////////////////////////////////////////END delete ALL//////////////
			}
		}
	}
?>