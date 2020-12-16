<?php
require ("../../inc/php/cyber.inc.php");



if (!empty($_GET['ip']))
		{
		$ip= ($_GET['ip']);
		$sela=mysql_query("SELECT * FROM cyber_custom");
		echo'<table border="0" align="center">
		<tr valign="middle">
		<td><form name="selabo" action="'.$PHP_SELF.'" method="post" >
		<select name="myab">';
/////////////////////////////////////////////////////////////////////////
		while($select = mysql_fetch_row($sela))
				//////////select from database
				{
				echo "<option value=\"".$select[1]."-".$select[2]."-".$select[3]."\">".$select[1]."-".$select[8]." </option>";
				}
				//////////
		echo'</select>
			</td>
			<td align="left"><br/><input type="button" style="width: 80px; height: 25px;"  value="OK" OnClick="document.selabo.submit()"></form>
			</td>
			</tr>
			</table>';

		if (!empty($_POST['myab']))
				///////////action after post
				{
				$lpt = explode('-', $_POST['myab']); 
				$x= time();
				$pattern = '/^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+/';
				preg_match($pattern, $_GET['ip'], $matches);
					
					if ($matches[0] !='')
					//////////real IP try to send socket
					{
					$myremoteip = $_SERVER["REMOTE_ADDR"]; $myport = '8080';
					$command = 'nmap -T5 '.$myremoteip.' -p '.$myport.'';
					$r = exec($command);
					$pat = '/\(1/';
					preg_match($pat, $r, $caroule);
					echo $caroule;
					
					/*$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
					socket_connect($socket, $myremoteip, $myport);
					socket_write($socket, $ip); socket_write($socket, "_");
					socket_write($socket, "on_"); socket_close($socket);*/
					}
					//////////
					mysql_query("UPDATE cyber_network SET start='$x' , state=1 , cron=1 , remaintime='".$lpt[2]."' WHERE ip='$ip'");
					mysql_query("UPDATE cyber_custom SET start='$x' , ip='$ip' WHERE login='".$lpt[0]."'");
					mysql_close($link);
					echo "<SCRIPT LANGUAGE='JavaScript'>window.open('close.html', '_self');</script>";
				//////////
				}
/////////////////////////////////////////////////////////////////////////
}

?>