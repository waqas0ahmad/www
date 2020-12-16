<? require ("../../inc/php/admin_init.inc.php");
echo '<head><link rel="stylesheet" type="text/css" href="../../inc/css/main.css">
<title>Cybercallshop billing system</title></head>';

$poste = $_GET['poste'];
$split=explode("_", $_GET['transfert']);
$transfert = $split[1] ; $oldposte = $_GET['oldposte']; $newone = $split[0];
$objAstcc = new DB(); $objAstcc->connect(ASTCC);

echo '<br/><div align="center"><table border="0" cellpadding="0" cellspacing="0" width="200"><tr><td class="cab_tds" align="center" bgcolor="#DDE3FF">';
echo '<form action="#SELF" method="get"><div align="center">';

$query = "SELECT * FROM cyber_network WHERE ip!='".$poste."' AND state!='1' ORDER BY name ";
$result = mysql_query($query);
echo '<select name="transfert">';
while($select = mysql_fetch_row($result)){
echo '<option value="'.$select[0].'_'.$select[1].'">'.$select[0].'</option>';
}
echo '</select>';
echo '<input type="hidden" name="oldposte" value="'.$poste.'" />';
echo '<input type="submit" value="Transfert" /></from></td></tr></table>';

if ($transfert =='')
{ }else{
$result = mysql_query("SELECT * FROM cyber_network WHERE ip='".$oldposte."'");
echo '<table border="1" align="center">';
if ($oldposte !='')
{
while ($row = mysql_fetch_array($result) )
{
$saledb = mysql_query("SELECT * FROM mysale WHERE cyber='".$row[0]."'");
while ($pr = mysql_fetch_row($saledb))
{
mysql_query("UPDATE mysale SET cyber='".$newone."' WHERE cyber='".$row[0]."'");
}

mysql_query("UPDATE cyber_network SET state='$row[2]' , start='$row[3]' , cron='$row[5]' , remaintime='$row[7]' , ping ='$row[8]' WHERE ip='".$transfert."'");
mysql_query("UPDATE cyber_network SET state='0' , start='' , cron='0' , ping ='0' , remaintime ='' WHERE ip='".$oldposte."'");
mysql_query("UPDATE cyber_custom SET ip='".$transfert."' WHERE ip='".$oldposte."'");

$pattern = '/^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+/'; preg_match($pattern, $oldposte, $matches);
if ($matches[0] !='')
					{
$myremoteip = $_SERVER["REMOTE_ADDR"]; $myport = '8080';

$command = 'nmap -T5 '.$myremoteip.' -p '.$myport.''; $r = exec($command); $pat = '/\(1/'; preg_match($pat, $r, $caroule);


$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); socket_connect($socket, $myremoteip, $myport); socket_write($socket, $oldposte); socket_write($socket, "_"); socket_write($socket, "off_"); socket_close($socket);
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); socket_connect($socket, $myremoteip, $myport); socket_write($socket, $transfert); socket_write($socket, "_"); socket_write($socket, "on_"); socket_close($socket);
					}


}
}
mysql_free_result($result); $objAstcc->closeDb();
echo "<SCRIPT LANGUAGE='JavaScript'>window.open('close.html', '_self');</script>";
}
?>
</div>
