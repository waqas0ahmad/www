<?
require('header.php');

	if(isset($_POST['rm']) && isset($_POST['rxuser']))
		{
		echo $_POST['rm'].' - '.$_POST['rxuser'];
		}	
echo'<br/><br/><br/><table>
	<tr>
	<th>CODE CLIENT</th>
	<th>PASSWD CLIENT</th>
	<th>NOM BOUTIQUE</th>
	<th>NOM CONTACT</th>
	<th>VILLE</th>
	<th>CABINE DEPART</th>
	<th>CABINE FIN</th>
	<th>URL</th>
	<th>NEGATIF</th>
	<th>EFFACER</th>
	</tr>';

// On liste les autres clients sauf ceux dans le rouge avec la table custom
$listClientNotRed = mysqli_query($ladmin,"select * from custom order by user");

$pp=1;
while($clientNotRed = mysqli_fetch_row($listClientNotRed))
	{
	echo'<tr title="Solde: '.($clientNotRed[10] / 10000).'">
	<td class="tdblue"><a href="state.php?user='.$clientNotRed[5].'">'.$clientNotRed[5].'</a></td>
	<td class="tdblue">'.$clientNotRed[6].'</td>
	<td class="tdblue">'.$clientNotRed[1].'</td>
	<td class="tdblue">'.$clientNotRed[2].'</td>
	<td class="tdblue">'.$clientNotRed[3].'</td>
	<td class="tdblue">'.($clientNotRed[7]).'</td>
	<td class="tdblue">'.($clientNotRed[7] + 19).'</td>
	<td class="tdred"><a href="http://'.$_SERVER['SERVER_ADDR'].'/'.$clientNotRed[5].'" target="_new">Cabines Client</a></td>
	<td class="tdred">';
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	echo'
		<form name="sel'.$pp.'" action="'.$_SERVER['PHP_SELF'].'" method="POST"> 
		<select name="rm" style="width:100px;" onchange="forms.sel'.$pp.'.submit()">
		<OPTION VALUE="">Select</OPTION>
		<OPTION SELECTED VALUE="'.$clientNotRed[12].'">'.($clientNotRed[12] / 10000).'</OPTION>';
	$v = 0;
	while($v <= 30000000)
		{
		echo '<OPTION VALUE="'.$v.'">'.($v / 10000).'</OPTION>'; $v=($v+500000);
		}
	echo'</select>
		<input type="hidden" name="rxuser" value="'.$clientNotRed[5].'">
		<input type="hidden" name="decouvert" value="decouvert">
		</form>';
	if(isset($_POST['rxuser']) && isset($_POST['decouvert']) && isset($_POST['rm']))
		{
		mysqli_query($ladmin,"UPDATE admin.custom SET negatif='".$_POST['rm']."' WHERE user='".$_POST['rxuser']."'");
		echo"<SCRIPT LANGUAGE='JavaScript'>window.location.replace('customnew.php')</script>";
		}

////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	echo'</td>
	<td class="tdred"><a href="del.php?user='.$clientNotRed[5].'&startcabine='.$clientNotRed[7].'&login='.$clientNotRed[5].'">Effacer</a></td>
	</tr>';
	$pp=($pp + 1);
	}
/*	
$zcust = mysqli_query($ladmin,"select * from custom order by user");
while($query = mysqli_fetch_row($zcust))
	{
	$user = $query[4];
	$extconf = "/var/www/ext-register/sippoll_".$user."";
	$exten = fopen($extconf, 'w+');
	$data = "[sippool_".$user."]\n"; fwrite($exten, $data);
	$data = "switch => Realtime/@sippool_".$user."\n"; fwrite($exten, $data);
	$data = "include => parkedcalls\n"; fwrite($exten, $data);
	$data = "\n"; fwrite($exten, $data);
							#*********** LOCAL CALL ***********#
	$data = "exten => _0ZX.,1,MYSQL(Connect connid ".$hostconf." ".$loginconf." ".$passwordconf." ".$dbadminconf.")\n"; fwrite($exten, $data);
	$data = "exten => _0ZX.,n,MYSQL(Query resultid \${connid} SELECT SUM(soldettc + negatif) AS total FROM custom where user='".$user."' )\n"; fwrite($exten, $data);
	$data = "exten => _0ZX.,n,MYSQL(Fetch foundRow \${resultid} total )\n"; fwrite($exten, $data);
	$data = "exten => _0ZX.,n,MYSQL(Clear \${resultid})\n"; fwrite($exten, $data);
	$data = "exten => _0ZX.,n,MYSQL(Disconnect \${connid})\n"; fwrite($exten, $data);
	$data = "exten => _0ZX.,n,GotoIf($[\"\${total}\" > \"0\"]?ok:bad)\n"; fwrite($exten, $data);
	$data = "exten => _0ZX.,n(ok),DeadAGI(astcc_".$user.".agi,\${CDR(accountcode)},33\${EXTEN:1},4)\n"; fwrite($exten, $data);
	$data = "exten => _0ZX.,n,Hangup()\n"; fwrite($exten, $data);
	$data = "exten => _0ZX.,n(bad)),Playback(not-enough-credit)\n"; fwrite($exten, $data);
	$data = "exten => _0ZX.,n,Hangup()\n"; fwrite($exten, $data); 
	$data = "\n"; fwrite($exten, $data);
		
							#*********** SHORT NUMBERS ***********#
	$data = "exten => _[13][01269]XX,1,MYSQL(Connect connid ".$hostconf." ".$loginconf." ".$passwordconf." ".$dbadminconf.")\n"; fwrite($exten, $data);
	$data = "exten => _[13][01269]XX,n,MYSQL(Query resultid \${connid} SELECT SUM(soldettc + negatif) AS total FROM custom where user='".$user."' )\n"; fwrite($exten, $data);
	$data = "exten => _[13][01269]XX,n,MYSQL(Fetch foundRow \${resultid} total )\n"; fwrite($exten, $data);
	$data = "exten => _[13][01269]XX,n,MYSQL(Clear \${resultid})\n"; fwrite($exten, $data);
	$data = "exten => _[13][01269]XX,n,MYSQL(Disconnect \${connid})\n"; fwrite($exten, $data);
	$data = "exten => _[13][01269]XX,n,GotoIf($[\"\${total}\" > \"0\"]?ok:bad)\n"; fwrite($exten, $data);
	$data = "exten => _[13][01269]XX,n(ok),DeadAGI(astcc_".$user.".agi,\${CDR(accountcode)},33000\${EXTEN},4)\n"; fwrite($exten, $data);
	$data = "exten => _[13][01269]XX,n,Hangup()\n"; fwrite($exten, $data);
	$data = "exten => _[13][01269]XX,n(bad),Playback(not-enough-credit)\n"; fwrite($exten, $data);
	$data = "exten => _[13][01269]XX,n,Hangup()\n"; fwrite($exten, $data); 
	$data = "\n"; fwrite($exten, $data);

							#*********** 118 NUMBERS ***********#
	$data = "exten => _118XXX,1,MYSQL(Connect connid ".$hostconf." ".$loginconf." ".$passwordconf." ".$dbadminconf.")\n"; fwrite($exten, $data);
	$data = "exten => _118XXX,n,MYSQL(Query resultid \${connid} SELECT SUM(soldettc + negatif) AS total FROM custom where user='".$user."' )\n"; fwrite($exten, $data);
	$data = "exten => _118XXX,n,MYSQL(Fetch foundRow \${resultid} total )\n"; fwrite($exten, $data);
	$data = "exten => _118XXX,n,MYSQL(Clear \${resultid})\n"; fwrite($exten, $data);
	$data = "exten => _118XXX,n,MYSQL(Disconnect \${connid})\n"; fwrite($exten, $data);
	$data = "exten => _118XXX,n,GotoIf($[\"\${total}\" > \"0\"]?ok:bad)\n"; fwrite($exten, $data);
	$data = "exten => _118XXX,n(ok),DeadAGI(astcc_".$user.".agi,\${CDR(accountcode)},33000\${EXTEN},4)\n"; fwrite($exten, $data);
	$data = "exten => _118XXX,n,Hangup()\n"; fwrite($exten, $data);
	$data = "exten => _118XXX,n(bad),Playback(not-enough-credit)\n"; fwrite($exten, $data);
	$data = "exten => _118XXX,n,Hangup()\n"; fwrite($exten, $data); 
	$data = "\n"; fwrite($exten, $data);
	
							#*********** ALL OTHER CALL ***********#
	$data = "exten => _XXXXXX.,1,MYSQL(Connect connid ".$hostconf." ".$loginconf." ".$passwordconf." ".$dbadminconf.")\n"; fwrite($exten, $data);
	$data = "exten => _XXXXXX.,n,MYSQL(Query resultid \${connid} SELECT SUM(soldettc + negatif) AS total FROM custom where user='".$user."' )\n"; fwrite($exten, $data);
	$data = "exten => _XXXXXX.,n,MYSQL(Fetch foundRow \${resultid} total )\n"; fwrite($exten, $data);
	$data = "exten => _XXXXXX.,n,MYSQL(Clear \${resultid})\n"; fwrite($exten, $data);
	$data = "exten => _XXXXXX.,n,MYSQL(Disconnect \${connid})\n"; fwrite($exten, $data);
	$data = "exten => _XXXXXX.,n,GotoIf($[\"\${total}\" > \"0\"]?ok:bad)\n"; fwrite($exten, $data);
	$data = "exten => _XXXXXX.,n(ok),DeadAGI(astcc_".$user.".agi,\${CDR(accountcode)},\${EXTEN},4)\n"; fwrite($exten, $data);
	$data = "exten => _XXXXXX.,n,Hangup()\n"; fwrite($exten, $data);
	$data = "exten => _XXXXXX.,n(bad),Playback(not-enough-credit)\n"; fwrite($exten, $data);
	$data = "exten => _XXXXXX.,n,Hangup()\n"; fwrite($exten, $data); 
	$data = "\n"; fwrite($exten, $data);

							#*********** LONG DISTANCE CALL ***********#
	$data = "exten => _00Z.,1,MYSQL(Connect connid ".$hostconf." ".$loginconf." ".$passwordconf." ".$dbadminconf.")\n"; fwrite($exten, $data);
	$data = "exten => _00Z.,n,MYSQL(Query resultid \${connid} SELECT SUM(soldettc + negatif) AS total FROM custom where user='".$user."' )\n"; fwrite($exten, $data);
	$data = "exten => _00Z.,n,MYSQL(Fetch foundRow \${resultid} total )\n"; fwrite($exten, $data);
	$data = "exten => _00Z.,n,MYSQL(Clear \${resultid})\n"; fwrite($exten, $data);
	$data = "exten => _00Z.,n,MYSQL(Disconnect \${connid})\n"; fwrite($exten, $data);
	$data = "exten => _00Z.,n,GotoIf($[\"\${total}\" > \"0\"]?ok:bad)\n"; fwrite($exten, $data);
	$data = "exten => _00Z.,n(ok),DeadAGI(astcc_".$user.".agi,\${CDR(accountcode)},\${EXTEN:2},4)\n"; fwrite($exten, $data);
	$data = "exten => _00Z.,n,Hangup()\n"; fwrite($exten, $data);
	$data = "exten => _00Z.,n(bad),Playback(not-enough-credit)\n"; fwrite($exten, $data);
	$data = "exten => _00Z.,n,Hangup()\n"; fwrite($exten, $data); 
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
	}
*/	
	
	
echo "</table></div><br/>";
require('footer.php');
?>