<?php
//import cvs to mysql for cybercallshop
require ("../inc/php/admin_header.inc.php");

if($angemeldet == 1 && $statadmin['admin_status'] > 0 || $statadmin1['admin_status'] > 0)
	{
	$objAstcc = new DB(); $objAstcc->connect(ASTCC);
	?>
	<form method="post" enctype="multipart/form-data" action="importsql.php"> 
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#eeeeee"> 
	<tr> 
	<td width="500"><font size=3><b>File.csv  format: (pattern;name;trunk:trunk2;connectcost;includedsec;purchase;sale;opconnectcost;opincludesec;;)</b></font></td> 
	<td width="244" align="center"><input type="file" name="userfile" value="userfile"></td> 
	<td width="137" align="center"> 
	<input type="submit" value="Send" name="envoyer"> 
	</td> 
	</tr> 
	</table> 
</form>
<table width="644" border="1" align="center" cellpadding="2" cellspacing="0" bgcolor="#eeeeee">
<tr>
  <td></td>
  <td>Prefix</td>
  <td>Name</td>
  <td>Trunk</td>
  <td>Connect cost</td>
  <td>Included seconds</td>
  <td>Purchase price</td>
  <td>Sale price</td>
  <td>Op connect cost</td>
   <td>Op included seconds</td>
   <td>N/A</td>
 </tr>
<?php
$fichier=$_FILES["userfile"]["name"];
if ($fichier !='')
	{
	$fp = fopen ($_FILES["userfile"]["tmp_name"], "r");
	$empty = "TRUNCATE TABLE `routes`";
	$done = mysql_query($empty);
	}
else
	{
	exit();
	}
$cpt=0;
echo "<p align=\"center\">Successful</p>";

while (!feof($fp))
{
$ligne = fgets($fp,4096);
$liste = explode(";",$ligne);
$liste[0] = ( isset($liste[0]) ) ? $liste[0] : Null;
$liste[1] = ( isset($liste[1]) ) ? $liste[1] : Null;
$liste[2] = ( isset($liste[2]) ) ? $liste[2] : Null;
$liste[3] = ( isset($liste[3]) ) ? $liste[3] : Null;
$liste[4] = ( isset($liste[4]) ) ? $liste[4] : Null;
$liste[5] = ( isset($liste[5]) ) ? $liste[5] : Null;
$liste[6] = ( isset($liste[6]) ) ? $liste[6] : Null;
$liste[7] = ( isset($liste[7]) ) ? $liste[7] : Null;
$liste[8] = ( isset($liste[8]) ) ? $liste[8] : Null;
$liste[9] = ( isset($liste[9]) ) ? $liste[9] : Null;
$champs0=$liste[0]; // Prefix
$champs1=$liste[1]; // Name
$champs2=$liste[2]; // Trunks
$champs3=$liste[3]; // Concost
$champs4=$liste[4]; // Incsec
$champs5=$liste[5]; // Purchase
$champs6=$liste[6]; // Sale
$champs7=$liste[7]; // connect price operator
$champs8=$liste[8]; // time included
$champs9=$liste[9]; // futur use

if ($champs0!='' && $champs1!='')
{
$cpt++;

	
$sql= "INSERT INTO routes (pattern,comment,trunks,connectcost,includedseconds,ek,cost,opcc,opsecinc,oppal)
		VALUES('$champs0','$champs1','$champs2','$champs3','$champs4','$champs5','$champs6','$champs7','$champs8','$champs9') ";
  $requete = mysql_query($sql);
  
?>
<tr>
<td>El�ments import�s :</td>
<td width="50"><?php echo $champs0;?></td>
<td width="50"><?php echo $champs1;?></td>
<td width="80"><?php echo $champs2;?></td>
<td width="50"><?php echo $champs3;?></td>
<td width="50"><?php echo $champs4;?></td>
<td width="50"><?php echo $champs5;?></td>
<td width="50"><?php echo $champs6;?></td>
<td width="50"><?php echo $champs7;?></td>
<td width="50"><?php echo $champs8;?></td>
<td width="50"><?php echo $champs9;?></td>
</tr>

<?php
}
}
fclose($fp);
unset($fichier);
echo "</table>";
}
else
{
?>
<div class="headline_global"><?=translate("adminstatistics"); ?></div><br />
<div class="boldred"><?=translate("loginfailed"); ?></div><br />
<?php
}
require("../inc/php/admin_footer.inc.php");
?>