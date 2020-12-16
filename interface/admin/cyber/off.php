<? require ("../../inc/php/admin_init.inc.php");
echo '<head><link rel="stylesheet" type="text/css" href="../../inc/css/main.css"><title>Cybercallshop billing system</title></head>';

$titre= ($_GET['postecyber']); $ip= ($_GET['ip']); $time = time();

$objAstcc = new DB(); $objAstcc->connect(ASTCC);
$abo=mysql_fetch_row(mysql_query("SELECT * FROM cyber_network WHERE ip='$ip'"));
 
if($abo[7] !='')
				################## case subscriber/////////////////////////////////////////////////////////////
				{
				$online= time() - $abo[3]; $remain= $abo[7] - $online;
				mysql_query("UPDATE cyber_custom SET time='$remain' , start='' , ip= '' WHERE ip='$ip'");
				mysql_query("UPDATE cyber_network SET state=0 , cron=0 , start='' , remaintime='' WHERE ip='".$_GET['ip']."'");
				$pattern = '/^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+/'; preg_match($pattern, $ip, $matches);
				if ($matches[0] !='')
									{
									$myremoteip = $_SERVER["REMOTE_ADDR"]; $myport = '8080';
									
									$Ping = exec('ping -c1 -w3 -T '.$myremoteip.':'.$myport.'');
							
											if($Ping='')
							{ echo  $myremoteip.' is not responding '.$Ping; }
												else
							{
							$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); socket_connect($socket, $myremoteip, $myport);
							socket_write($socket, $ip); socket_write($socket, "_"); socket_write($socket, "off_"); socket_close($socket);
							}
									
									
									}
				$objAstcc->closeDb();
				echo "<SCRIPT LANGUAGE='JavaScript'>window.open('close.html', '_self');</script>";

				}
				else
				{
				################## case simple lease///////////////////////////////////////////////////////////
				$op=mysql_fetch_row(mysql_query("SELECT * FROM cyber_tarif"));
				$pal1p = $op[1]; $pal1t = $op[2]; $pal1d = $op[3]; $pal2p = $op[4]; $pal2t = $op[5]; $pal1d = $op[6];
				$query = mysql_query("SELECT start FROM ".ASTCC.".cyber_network WHERE ip='".$ip."'");
				$row=mysql_fetch_row($query);
				if ($row[0] =='')
					{
					echo "START DATE IS EMPTY, PLEASE TRY AGAIN (error 10)";
					exit;
					}
				//echo $time; echo ' - '.$row[0].'<br/>'; 
				$bouba =($time - $row[0]);
				$temps = ceil($bouba/60); 
				// time is <= first step
						if ($temps <= $pal1t)
											{
											$price = ($pal1p);
											}
				// time is upper first step
						else if ($temps > $pal1t)
											{
											$test = round(($temps*$pal2p),1);
													if ($test >= $pal1p)
																		{
																		$price = $test;}
												 	else
												 						{
																		$price = $pal1p;
																		}
											}

###################################### DISPLAY DATA ##################################
	$date = (date('Y-m-d'));
	echo '<br/>
	<table bgcolor="#DDE3FF" align="center" width=600, height=300 border="0"><tr>
	<td class="cab_tds"><strong><p align="center">'.$titre.'</p></strong>
		<div align="center">'.translate("durationmin").' <font size="5" color="red"><strong> '.$temps.' </strong>
		</font> '.translate("linkrates").' '.($pal2p*60).' '.$devise.' / H
		<font size="5" color="red"><strong> '.$price.' '.$devise.'</strong></font><br/><br/>
		<div align="center"> '.translate("opro").' </div>
				<table align="center">';
				$saledb = mysql_query("SELECT * FROM mysale WHERE cyber='".$titre."'");
				$sum = mysql_query("SELECT SUM(vente) as mytotal FROM mysale WHERE cyber='".$titre."'");
				$Total = mysql_fetch_assoc($sum);
				while ($pr = mysql_fetch_row($saledb))
						{
						echo '<tr align="center"><td width="100">'.$pr[1].'</td><td width="100">'.$pr[3].' '.$devise.'</td></tr>';
						}
				echo '</table><br/>';
if ($Total['mytotal'] > 0)
{ echo '<div align="center"><strong><font color="red" size="5">Total : '.($Total['mytotal'] + $price).' '.$devise.'</font></strong></div>'; }

####################################### pour ceux qui savent pas compter
echo '<form action="'.$PHP_SELF.'" method="get">'.translate("cashed").'&nbsp;&nbsp; 
<input type="text" name="cash" value="'.$cash.'"/>
<input type="hidden" name="postecyber" value="'.$titre.'" />
<input type="hidden" name="ip" value="'.$ip.'" />
<input type="submit" value="OK" />';
$rendre = (($cash) - (($Total['mytotal'] + $price)));
if ($rendre >='0')
{ echo '</p><p align="center">'.translate("monnaie").' : '.$rendre.''; }
#####################################fin pour ceux qui savent pas compter
echo '<br/><br/><br/>
<table align="center"><tr><td><form><input type="button"  class="butlink" value="'.translate("billcab").'" OnClick="window.location.href=\''.$PHP_SELF.'?time='.$temps.'&price='.$price.'&ip='.$ip.'&postecyber='.$titre.'&date='.$date.'\'"></form></td><td width="120">&nbsp;</td><td>
<form><input type="button"  class="butlink" value="'.translate("print").'" OnClick="window.print()"></form></td></tr></table>';
echo '</td></tr></table>'; mysql_free_result($query);
$objAstcc->closeDb();

##################################### BILL AND CLOSE ###################################
if ( $_GET['time'] !='' && $_GET['price'] !='' && $_GET['ip']!='' && $_GET['date']!='')
{
$objAstcc = new DB(); $objAstcc->connect(ASTCC);
mysql_query("UPDATE cyber_network SET state=0 , cron=0 WHERE ip='".$_GET['ip']."'");
mysql_query("INSERT INTO cyber_compta(time,price,ip,date) VALUES('".$_GET['time']."','".$_GET['price']."','".$_GET['ip']."','".$_GET['date']."')"); 
mysql_query("UPDATE cyber_network SET start='' WHERE ip='".$_GET['ip']."'");
//////////////////////////////UPDATE STOCK AND BILL  OTHER PRODUCTS ///////////////////////////////////
$saledproduct = mysql_query("SELECT * FROM mysale WHERE cyber='".$titre."'");
while ($product = mysql_fetch_row($saledproduct))
{
$scanstock = mysql_query("SELECT * from mystock WHERE nom ='".$product[1]."'"); $qty = mysql_fetch_row($scanstock);
mysql_query("UPDATE mystock SET stock='".($qty[5] -1)."' WHERE nom='".$product[1]."'");
mysql_query("INSERT INTO mysale_buff (unid, nom, achat, vente, cat, date) VALUE ( '$Uid', '$product[1]', '$product[2]', '$product[3]', '$product[4]', '$date')");
mysql_query("DELETE FROM mysale WHERE id='".$product[0]."' LIMIT 1");
}

$objAstcc->closeDb();

///////////////////// CLOSE COMPUTER OVER THE NETWORK ////////////////////////////
$pattern = '/^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+/'; preg_match($pattern, $_GET['ip'], $matches);
if ($matches[0] !='')
					{
					$myremoteip = $_SERVER["REMOTE_ADDR"]; $myport = '8080';

							$Ping = exec('ping -c1 -w3 -T '.$myremoteip.':'.$myport.'');
							
							if($Ping='')
							{ echo  $myremoteip.' is not responding '.$Ping; }
												else
							{
							$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); socket_connect($socket, $myremoteip, $myport);
							socket_write($socket, $ip); socket_write($socket, "_"); socket_write($socket, "off_"); socket_close($socket);
							}

					}
echo "<SCRIPT LANGUAGE='JavaScript'>window.open('close.html', '_self');</script>";
}
}

?>