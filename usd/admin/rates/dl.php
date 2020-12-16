<?
require("../../inc/php/constants.inc.php");
$link = mysql_connect($hosto, $dblog, $dbpass);

//////////////////////////////////////////Sippath-premium
if(!empty($_GET['sippath-premium']))
	{
	$lines= file('dl/sippath-premium.csv');
	$z = count($lines); $i = 0 ;
	while($i < $z)
		{
		$Cut=explode(";", $lines[$i]);
		$price = ceil($Cut[2] * 0.8 * 10000);
		$comment = str_replace("'","", $Cut[1]);

	$test= mysql_fetch_row( mysql_query("SELECT comment FROM ".ASTCC.".plist WHERE pattern='".$Cut[0]."'"));
			if(!empty( $test[0]))
			{
			echo $test[0].' - update pattern existante '.$Cut[0].'<br/>';
			mysql_query("UPDATE ".ASTCC.".plist SET trunk3='sippath-premium' ,price3='".$price."' WHERE pattern='".$Cut[0]."'");
			}
			else
			{
			echo $test[0].' - New pattern '.$Cut[0].'<br/>';
			mysql_query("INSERT INTO ".ASTCC.".plist SET pattern='".$Cut[0]."',comment='".$comment."',trunk3='sippath-premium',	price3='".$price."'");
			}
		$i++;
		}
	}

//////////////////////////////////////////Voxbeam-premium
if(!empty($_GET['voxbeam-premium']))
	{
	//$lines = file('http://www.voxbeam.com/rates/premium.csv');
	$lines= file('dl/premium.csv');
	$z = count($lines); $i = 1 ;
	while($i < $z)
		{
		$Cut=explode("\"", $lines[$i]);
		$price = ceil($Cut[11] * 0.8 * 10000);
		//echo $Cut[5].';'.$Cut[1].';'.$price.'<br/>';
		$comment = str_replace("'","", $Cut[1]);
			$test= mysql_fetch_row( mysql_query("SELECT comment FROM ".ASTCC.".plist WHERE pattern='".$Cut[5]."'"));
			if(!empty( $test[0]))
			{
			echo $test[0].' - update pattern existante '.$Cut[5].'<br/>';
			mysql_query("UPDATE ".ASTCC.".plist SET trunk1='voxbeam-premium' ,price1='".$price."' WHERE pattern='".$Cut[5]."'");
			}
			else
			{
			echo $test[0].' - New pattern '.$Cut[5].'<br/>';
			mysql_query("INSERT INTO ".ASTCC.".plist SET pattern='".$Cut[5]."',comment='".$comment."',trunk1='voxbeam-premium',price1='".$price."'");
			}
		$i++;
		}
	}

//////////////////////////////////////////Voxbeam-standard
if(!empty($_GET['voxbeam-standard']))
	{
	$link = mysql_connect($hosto, $dblog, $dbpass);
	//$lines = file('http://www.voxbeam.com/rates/standard.csv');
	$lines= file('dl/standard.csv');
	$z = count($lines); $i = 1 ;
	while($i < $z)
		{
		$Cut=explode("\"", $lines[$i]);
		$price = ceil($Cut[11] * 0.8 * 10000);
		$comment = str_replace("'","", $Cut[1]); //now test if pattern exist
			$test= mysql_fetch_row( mysql_query("SELECT comment FROM ".ASTCC.".plist WHERE pattern='".$Cut[5]."'"));
			if(!empty($test[0]))
			{
			echo $test[0].' - update pattern existante '.$Cut[5].'<br/>';
			mysql_query("UPDATE ".ASTCC.".plist SET trunk2='voxbeam-standard' ,price2='".$price."' WHERE pattern='".$Cut[5]."'");
			}
			else
			{
			mysql_query("INSERT INTO ".ASTCC.".plist SET pattern='".$Cut[5]."',comment='".$comment."',trunk2='voxbeam-standard',price2='".$price."'");
			}
		$i++;
		}
	}
	
	
/*$bingo=mysql_query("SELECT pattern,price1,trunk1,price3,trunk3 FROM ".ASTCC.".plist");
while($pat=mysql_fetch_row($bingo))
{
	if($pat[1])=='')
	$ussa=mysql_query("SELECT price1,trunk1,price2,trunk2,price3,trunk3 FROM ".ASTCC.".plist WHERE ".$pat[0]." RLIKE concat('^', pattern)
	ORDER BY LENGTH(pattern) DESC");
			while(mysql_fetch_row($ussa))
			{
			
			
			mysql_query("INSERT INTO ".ASTCC.".plist SET pattern='".$Cut[0]."',comment='".$comment."',trunk3='sippath-premium',
			price3='".$price."',price1='".$uss[0]."',trunk1='".$uss[1]."',price2'".$uss[2]."',trunk2='".$uss[3]."'");
			}*/

mysql_close($link);
?>





		