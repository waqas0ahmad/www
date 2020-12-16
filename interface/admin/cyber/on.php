<?php
require ("../../inc/php/cyber.inc.php");
$ip= ($_GET['ip']);
#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/
if ($_GET['ip'] !='')
{
$x= time();
################################################################################################################
if ($x !='')
	{
	mysql_query("UPDATE ".ASTCC.".cyber_network SET start='$x' , state=1 , cron=2 WHERE ip='$ip'");
	$Ftest = mysql_query("SELECT start FROM ".ASTCC.".cyber_network WHERE ip='$ip'");
	$Rtest = mysql_fetch_row($Ftest);
	mysql_close($link);
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ($Rtest['0'] !='')
					{
					$pattern = '/^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+/'; preg_match($pattern, $_GET['ip'], $matches);
					############################################################################################
					if ($matches[0] !='')
							{
							//echo 'TIMESTAMP: '.$x.' ------ CONTROLE relecture: '.$Rtest['0'].' IP a BLOQUER: '.$_GET['ip'].''; 
							$myremoteip = $_SERVER["REMOTE_ADDR"]; $myport = '8080';

							$Ping = exec('ping -c1 -w3 -T '.$myremoteip.':'.$myport.'');
							
											if($Ping='')
							{
							echo  $myremoteip.' is not responding '.$Ping;
							echo "<SCRIPT LANGUAGE='JavaScript'>window.open('close.html', '_self');</script>";
							}
												else
							{
							$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
							socket_connect($socket, $myremoteip, $myport);
							socket_write($socket, $ip); socket_write($socket, "_");
							socket_write($socket, "on_"); socket_close($socket);
							echo "<SCRIPT LANGUAGE='JavaScript'>window.open('close.html', '_self');</script>";
							}
							

							}
							else
							{
							echo "<SCRIPT LANGUAGE='JavaScript'>window.open('close.html', '_self');</script>";
							}
					############################################################################################
						}
						else
						{
						echo "TEST RE-READ IS NULL ERROR, PLEASE TRY AGAIN (error 03)";
						}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////						
	}
	else
	{
	echo "GET DATE ERROR, PLEASE TRY AGAIN (error 02)";
	}
################################################################################################################					
}
else
{
echo "ERROR NO TARGET SPECIFIED (error 01)";
}
#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/#/
?>