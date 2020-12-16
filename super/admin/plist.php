<?php
require('header.php');
echo'<br/><form method="POST" enctype="multipart/form-data" action="'.$_SERVER['PHP_SELF'].'"> 
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#eeeeee">
	<tr><td width="500"> 
	<font size=3><b>File.csv  format: (pattern;name;trunks;purchase)</b></font>
	</td><td width="244" align="center">
	<input type="file" name="userfile" value="userfile" />
	<input type="hidden" name="hiphop" value="hiphop" />
	</td><td width="244" align="center">
	<input type="submit" value="Send" name="envoyer" />
	</td></tr>
	</table></form>';
if(!empty($_FILES['userfile']))
	{
	$fichier=$_FILES["userfile"]["name"];
	if ($fichier !='')
		{
		$fp = fopen ($_FILES["userfile"]["tmp_name"], "r");
		mysqli_query($ladmin,"TRUNCATE TABLE admin.master") or die(mysqli_error($ladmin));
		echo'TRUNCATE TABLE DONE !<br/>';
		echo'<table width="644" border="1" align="center" cellpadding="2" cellspacing="0" bgcolor="#eeeeee"><tr><td></td>
			<td>&nbsp;Prefix&nbsp;</td>
			<td>&nbsp;Name&nbsp;</td>
			<td>&nbsp;Trunks&nbsp;</td>
			<td>&nbsp;Price&nbsp;</td>
			</tr>';
		$cpt=0; echo "<p align=\"center\">Successful</p>";
		while (!feof($fp))
			{
			$ligne = fgets($fp,4096); $liste = explode(";",$ligne);
			$liste[0] = ( isset($liste[0]) ) ? $liste[0] : Null;
			$liste[1] = ( isset($liste[1]) ) ? $liste[1] : Null;
			$liste[2] = ( isset($liste[2]) ) ? $liste[2] : Null;
			$liste[3] = ( isset($liste[3]) ) ? $liste[3] : Null;
			$champs0=$liste[0]; $champs1=$liste[1]; $champs2=$liste[2]; $champs3=$liste[3];
			if ($champs1!='')
				{
				$cpt++;
				$requete = mysqli_query($ladmin,"INSERT INTO master (pattern,comment,trunks,ek) VALUES('$champs0','$champs1','$champs2','$champs3')");
				echo '<tr><td width="62">Eléments importés :</td>
				<td width="55">'.$champs0.'</td>
				<td width="55">'.$champs1.'</td>
				<td width="55">'.$champs2.'</td>
				<td width="55">'.$champs3.'</td>
				</tr>';
				}
			}
		fclose($fp);
		unset($fichier);
		echo "</table><SCRIPT LANGUAGE='JavaScript'>window.location.replace('plist.php')</script>";
		}
	}
else
	{ 
	echo'<a href="javascript: void(0)" title="Syncro" onclick="window.open(\'sync.php\', \'windowname1\', 
	\'width=900, height=800, directories=no, location=no, menubar=no, resizable=yes, scrollbars=yes, status=no, toolbar=no\'); 
	return false;">SYNCRONISATION</div></a>';
	$yoyo = mysqli_query($ladmin,"SELECT * FROM admin.master");
	echo '<table align="center"><tr>
		  <td align="center">Prefix</td>
		  <td align="center">Name</td>
		  <td align="center">Trunks</td>
		  <td width="100" align="center">Sale price</td>
		  </tr>';
	while($yiyi = mysqli_fetch_row($yoyo))
		{
		echo'<tr>
		<td align="center">'.$yiyi[0].'</td>
		<td align="center">'.$yiyi[1].'</td>
		<td align="center">'.$yiyi[2].'</td>
		<td align="center">'.$yiyi[3].'</td></tr>';
		}
	echo '</table>';
	}
require('footer.php');
?>