<?
require ("../inc/php/admin_init.inc.php");
echo '<head><link rel="stylesheet" type="text/css" href="../inc/css/main.css"></head>';

$myex= $_GET['cabineID']; $cabineID = round(exp($myex/99999991234),0);
$confirm = $_GET['confirm'];

echo '<br/><div align="center"><table border="0" cellpadding="0" cellspacing="0" width="450"><tr><td class="cab_tds" align="center" bgcolor="#DDE3FF">';
if( $cabineID !='' && $confirm =='confirm')
{

$back=`/usr/sbin/asterisk -rx "show channels"`;
$subject = $back;
$pattern = '/SIP\/'.$cabineID.'-[A-Za-z0-9]+/';
preg_match($pattern, $subject , $matches);
$back=`/usr/sbin/asterisk -rx "soft hangup "$matches[0]""`;
$objAstcc = new DB(); $objAstcc->connect(ASTCC); mysql_query("UPDATE cards SET inuse='0' WHERE number='$cabineID'"); $objAstcc->closeDb();
echo "<SCRIPT LANGUAGE='JavaScript'>window.open('close.html', '_self');</script>";
}else{
?>
<br/><form action="hangup.php" method="get"><? echo "CONFIRMATION";?><br/><br/> 
<input type="hidden" name="confirm" value="confirm"/>
<input type="hidden" name="cabineID" value="<? echo $myex ?>" />
<input type="submit" value="<? echo translate("hangup")?>" /></form>
<?
}
echo '<br/><br/><a href="javascript:window.close()"><img src="../imgs/gimmics/del.gif" alt="'.translate("close").'" /> '.translate("close").' <img src="../imgs/gimmics/del.gif" alt="'.translate("close").'" /></a></div></tr></td></table>';
?>

