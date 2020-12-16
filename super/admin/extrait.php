<?
include("header.php");

$titi = mysql_query("select * from admin.cdrs Where opcost='0' AND billseconds>'14' AND datecall>'2012-11-21 18:00:00' AND comment!='MOROCCO' AND comment!='Morocco Casblanca' AND comment!='Morocco Rabat' order by account")or die(mysql_error());
echo 'compte;secondes;date;destination;tarif;prix normal<br />';
while($toto = mysql_fetch_row($titi))
{
$pr = mysql_query("select ek from astcc_".$toto['2'].".routes Where comment='".$toto['9']."'")or die(mysql_error());

$pi=mysql_fetch_row($pr);
echo $toto['2'].';'.$toto['6'].';'.$toto['8'].';'.$toto['9'].';'.$pi['0'].';'.((($pi['0'] / 60) * $toto['6'])/10000).'<br />';

}

?>