<?
if ($_GET['ip'] !='')
{

$ip= ($_GET['ip']);

							$myremoteip = $_SERVER["REMOTE_ADDR"]; $myport = '8080';
							$Ping = exec('ping -c1 -w3 -T '.$myremoteip.':'.$myport.'');
							
							if($Ping='')
							{ echo  $myremoteip.' is not responding '.$Ping;
				echo "<SCRIPT LANGUAGE='JavaScript'>window.open('close.html', '_self');</script>";
							 }
												else
							{
							$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); socket_connect($socket, $myremoteip, $myport);
							socket_write($socket, $ip); socket_write($socket, "_"); socket_write($socket, "off_"); socket_close($socket);
				echo "<SCRIPT LANGUAGE='JavaScript'>window.open('close.html', '_self');</script>";
							}
							
}							
?>