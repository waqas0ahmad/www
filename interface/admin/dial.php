<?
//This line is just to include the basic cybercallshop global variables and functions
require ("../inc/php/admin_init.inc.php");
echo '<head><link rel="stylesheet" type="text/css" href="../inc/css/main.css">
<title>Cybercallshop billing system</title></head>';

//This popup is open with dial.php?cab=xxxxxxx  the xxxxx is coded as I don't whant to display sip number on interface and URL
//this line will translate the coded number into real sip number
$myex= $_GET['cab']; $cabineID = round(exp($myex/99999991234),0);

//OK now this code know the real sip number

//The form
echo'<div align="center">'.translate("myinputphoneno").'</div>
	<br/><form action="#SELF" method="post">
	<div align="center"><input type="texte" name="number"></div><br/>
	<input type="hidden" name="cabine" value="'.$cabineID.'" />
	<div align="center"><input type="submit" /></div></form>';
//End form

	//if submit with a number to dial $_POST['number'] and $_POST['cabine'] variables exist now and let's go on next step
	if($_POST['number'] !='' && $_POST['cabine'] !='')
	{
	//test the 2 first numbers
	$test = substr($_POST['number'], 0, 2);
	//if it's under 10 it does mean it's a local number 01 to 09 
	if ($test <= '9' && $test > '0')
	{
	//first remove the 0 with substr function
	$_POST['number']=substr($_POST['number'],1);
	//now add 33
	$_POST['number']='33'.$_POST['number'];
	}
	//if result is 00 it does mean international number with 00 prefix
	if ($test == '0')
	{
	//use the substr function to remove two digits
	$_POST['number']=substr($_POST['number'],2);
	}
	//Define now a file and path, the file name is not important I give a name cabine_astcc_xxx but it could be toto or other
	$file = "/var/spool/asterisk/outgoing/".$_POST['cabine']."_".$bdd."";
	//create the file and open it to write (w+)
	$exten = fopen($file, 'w+');
	//write now data line after line
	$data = "Channel: SIP/".$_POST['cabine']."\n";
	fwrite($exten, $data);
	$data = "MaxRetries: 0\n";
	fwrite($exten, $data);
	$data = "RetryTime: 15\n";
	fwrite($exten, $data);
	$data = "WaitTime: 25\n";
	fwrite($exten, $data);
	$data = "CallerID: ".$_POST['cabine']."\n";
	fwrite($exten, $data);
	$data = "Application: DEADAGI\n";
	fwrite($exten, $data);
	//Here you can see I use $bdd variable, this variable is globale on the interface and not defined here this var content is astcc_shop username
	$data = "Data: ".$bdd.".agi|".$_POST['cabine']."|".$_POST['number']."|4\n";
	fwrite($exten, $data);
	fclose($exten);
	//file is now in the spool with date = now so Asterisk will execute it now
	echo "<SCRIPT LANGUAGE='JavaScript'>window.open('close.html', '_self');</script>";
	}
?>