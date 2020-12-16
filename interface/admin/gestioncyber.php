<?php
require ("../inc/php/admin_header.inc.php");
if($angemeldet == 1)
{
$objAstcc = new DB(); $objAstcc->connect(ASTCC);
switch ($_VARS['action']) {
/////////////////////////////////////////////////////////////
case "abonnes":
echo '<table align="center" border="0"><tr><td width="50%">';
////////////////////// subscriber form /////////////////////
$query = "SELECT * FROM cyber_tarif WHERE pal3d !=''"; $result = mysql_query($query);
echo '<div align="center">'; echo translate("newab");

echo '<form name="forCUS" action="'.$PHP_SELF.'" method="post">
<table width="303" border="0"><tr>';
echo '<td width="169"><select name="comp" style="width: 122px">'; 
while($select = mysql_fetch_row($result)){ echo "<option value=\"".$select[7]."-".$select[8]."-".$select[9]."\">".$select[9]."</option>"; }
echo '</select></td><td>&nbsp;</td></tr>'; 
mysql_free_result($result);

echo'
<td width="169"><input name="client" type="text" /></td>
<td width="124">'.translate("myinputfirstname").'</td>
</tr><tr>
<td><input name="login" type="text" /></td>
<td>'.translate("myinputwebuser").'</td>
</tr><tr>
<td><input type="text" name="pass" /></td>
<td>'.translate("myinputwebpw").'</td>
</tr><tr>
<input type="hidden" name="action" value="abonnes" />
<input type="hidden" name="what" value="newab" />
<td align="center"><input type="button"  value="OK" OnClick="document.forCUS.submit()">
</form></td>
<td>&nbsp;</td>
</tr></table>
</form>';
///////////////////////////////////////////////////////////////
echo '</td><td align="center">';
////////////////////// rates form /////////////////////////////
$dur = explode('/', translate("duration"));

echo '<strong>'.translate("price").'</strong>';
echo '<table align="center" border="1">';
$tarifa = mysql_query("SELECT * FROM cyber_tarif WHERE pal3t !=''");
echo "<tr><td>".translate("price")."</td><td>".$dur[0]."</td><td>".translate("myinputfirstname")."</td><td>Action</td>";      
while($select = mysql_fetch_row($tarifa)){

echo '
<form name="forM'.$select[7].'" action="'.$PHP_SELF.'" method="post"><tr>
<td><input type="text" style="width: 40px;" name="ta" value="'.$select[7].'"> '.$devise.'</td>
<td><input type="text" style="width: 40px;" name="du" value="'.(($select[8]/60)/60).'"> H</td>
<td><input type="text" style="width: 60px;" name="nomabo" value="'.$select[9].'"></td><td>
<input type="hidden" name="action" value="abonnes" />
<input type="hidden" name="what" value="'.$select[9].'" />
<li><input type="button" class="butlink" value="'.translate("admincustchangesubmit").'" OnClick="document.forM'.$select[7].'.submit()">
</form></li>

<form name="forD'.$select[7].'" action="'.$PHP_SELF.'" method="post">
<input type="hidden" name="action" value="abonnes" />
<input type="hidden" name="what" value="'.$select[9].'" />
<input type="hidden" name="ta" value="0" />
<input type="hidden" name="du" value="0" />
<input type="hidden" name="nomabo" value="'.$select[9].'" />
<li><input type="button" class="butlink" value="'.translate("effacer").'" OnClick="document.forD'.$select[7].'.submit()">
</form></li></td></tr>';
}
echo'<tr><td>

<form name="forMo" action="'.$PHP_SELF.'" method="post"><tr>
<td><input type="text" style="width: 40px;" name="ta" value=""> '.$devise.'</td>
<td><input type="text" style="width: 40px;" name="du" value=""> H</td>
<td><input type="text" style="width: 60px;" name="nomabo" value=""></td><td>
<input type="hidden" name="action" value="abonnes" />
<input type="hidden" name="what" value="ntarif" />
<li><input type="button" class="butlink" value="'.translate("adminratescreatenew").'" OnClick="document.forMo.submit()">
</form></li></td></tr>';
mysql_free_result($tarifa); echo '</table>';
///////////////////////////////////////////////////////////////
echo '</td><tr>'; echo '<td colspan="2" align="center">';
////////////////////// subscriber display /////////////////////
echo'<table width="100%" border="1"><tr>
    <td>'.translate("myinputfirstname").'</td>
    <td>'.translate("myinputwebuser").'</td>
    <td>'.translate("myinputwebpw").'</td>
    <td>'.translate("durationmin").'</td>
    <td>'.translate("cybabo").'</td>
    <td>'.translate("effacer").'</td>
	</tr>';
$display = "SELECT * FROM cyber_custom ORDER BY client"; $cust = mysql_query($display);
while($cu = mysql_fetch_row($cust)){
echo '<tr><td>'.$cu[8].'</td><td>'.$cu[1].'</td><td>'.$cu[2].'</td><td>'.(round((($cu[3]/60)),0)).'</td><td>'.$cu[7].'</td><td>';

echo '<form name="delo'.$cu[1].'" action="'.$PHP_SELF.'" method="post">
	<input type="hidden" name="action" value="abonnes" />
	<input type="hidden" name="delme" value="delme" />
	<input type="hidden" name="login" value="'.$cu[1].'" />
	<input type="button" class="butlink" value="'.translate("effacer").'" OnClick="document.delo'.$cu[1].'.submit()">
	</form>';
	
echo'</td></tr>';
}
echo "</table>";
mysql_free_result($cust);
echo "</td></tr></table>";
####################################################change customers##
##delete customer##
if($_POST['login'] !='' && $_POST['delme'] =='delme')
{ 
 mysql_query("DELETE FROM cyber_custom WHERE login='".$_POST['login']."'");
 echo '<SCRIPT LANGUAGE=\'JavaScript\'>window.history.back()</script>';
 }
##new customer##
if($_POST['client'] !='' && $_POST['login'] !='' && $_POST['pass'] !='' && $_POST['what'] == 'newab')
{
$Login = clean($_POST['login']);
$Pass = clean($_POST['pass']);
$data = explode('-', $_POST['comp']);
$Test = mysql_query("SELECT * FROM cyber_custom WHERE login='".$Login."' OR client='".$_POST['client']."'");
$Testing = mysql_fetch_array($Test);
if($Testing ==''){
mysql_query("INSERT INTO cyber_custom (login,pass,typabo,client,time) VALUE ( '".$Login."','".$Pass."','".$data[2]."' ,'".$_POST['client']."',
'".$data[1]."')")or die(mysql_error());
$date=date("Y-m-d h:i:s");
mysql_query("INSERT INTO mysale_buff (nom,achat,vente,date) VALUE ( 'Cyber-".$data[2]."','0','".$data[0]."' ,'".$date."')");
echo '<SCRIPT LANGUAGE=\'JavaScript\'>window.history.back()</script>'; }else{ echo 'Client / User already exist !'; }
}

######################################################change tarif##
if($_POST['ta'] !='' && $_POST['du'] !='' && $_POST['nomabo'] !='')
{
if($_POST['what'] =='ntarif')
{ $rdu= ($_POST['du'] * 60 * 60); mysql_query("INSERT INTO cyber_tarif (pal3p,pal3t,pal3d) VALUE ('".$_POST['ta']."', '".$rdu."', '".$_POST['nomabo']."')"); }
else
{ $rdu= ($_POST['du'] * 60 * 60); mysql_query("UPDATE cyber_tarif SET pal3p='".$_POST['ta']."', pal3t='".$rdu."', pal3d='".$_POST['nomabo']."' WHERE pal3d='".$_POST['what']."'"); }
if($_POST['ta'] =='0' && $_POST['du'] =='0' && $_POST['nomabo'] == $_POST['what'])
{ mysql_query("DELETE FROM cyber_tarif WHERE pal3d='".$_POST['what']."'"); }
echo '<SCRIPT LANGUAGE=\'JavaScript\'>window.history.back()</script>';
}
####################################################################

break;
//////////////////////////////////////////////////
case "tarifs":
$op=mysql_fetch_array(mysql_query("SELECT * FROM cyber_tarif"));
$pal1p = $op["pal1p"]; $pal1t = $op["pal1t"]; $pal1d = $op["pal1d"]; $pal2p = $op["pal2p"]; $pal2t = $op["pal2t"]; $pal1d = $op["pal2d"];

echo '<form name="Mytarif" method="POST" action="'.$PHP_SELF.'">
<input type="hidden" value="tarifs" name="action">
<table align="center"><tr><td>';
echo '
		<strong>MINIMUM '.translate("linkrates").' </strong></td><td><input type="texte" name="pal1p" value="'.$pal1p.'"> '.$devise.'</td><td></td><td></td></tr><td>
		<strong>'.translate("linkrates").' H</strong></td><td><input type="texte" name="pal2p" value="'.($pal2p * 60).'"> '.$devise.'</td><td></td><td></td></tr><tr><td></td><td></td><td></td><td><input type="button" class="back_button" value="Change" OnClick="document.Mytarif.submit()"></td></tr></table></form>';

if ( $_POST['pal1p'] != '' && $_POST['pal2p'] != '' )
{
$tH = ($_POST['pal2p'] / 60);
$pT = ($_POST['pal1p'] / $_POST['pal2p'])*60;
mysql_query("UPDATE cyber_tarif SET pal1p='".$_POST['pal1p']."' , pal1t='".$pT."' , pal1d='".$pT."' , pal2p='".$tH."' , pal2t='1' WHERE pal1p!=''");
echo "<SCRIPT LANGUAGE='JavaScript'>window.location.replace('".$PHP_SELF."?action=tarifs')</script>";
} 
	  
break;
//////////////////////////////////////////////////
case "postes":
$query = "SELECT * FROM cyber_network"; $result = mysql_query($query);
echo '<div align="center">'.translate("newcyber").'</div>';
##### THE FORM #####
echo '<form name="Myform" action="'.$PHP_SELF.'?action=postes" method="post">';
echo '<div align="center"><table><tr><td><input name="poste" type="text" /></td><td align="center">'.translate("firstname").'</td></tr><tr><td><input name="ip" type="text" /></td><td align="center">ID</td></tr></table>
<div align="center"><input type="button" class="back_button" value="OK" OnClick="document.Myform.submit()"></form></div>';

##### THE DEFAULT DISPLAY #####
echo '<table width="700" border="1" align="center"><tr><td>'.translate("firstname").'</td><td>ID</td><td>'.translate("effacer").'</td></tr>';
$display = "SELECT * FROM cyber_network ORDER BY id"; $cust = mysql_query($display);
while($cu = mysql_fetch_row($cust)){
echo "<tr><td>".$cu[0]."</td><td>".$cu[1]."</td><td>";
echo '<form><input type="button"  class="butlink" value="'.translate("effacer").'" OnClick="window.location.href=\''.$PHP_SELF.'?action=postes&delcyber='.$cu[1].'\'"></form></td></tr>';

}
echo "</table>";
##### ADD COMPUTER #####
$poste = ($_POST['poste']); $ip = ($_POST['ip']);
if ( $poste != '' & $ip != '')
{
mysql_query("INSERT INTO cyber_network (name, ip, state, cron) VALUE ('$poste' , '$ip' ,  '0' , '0' )");
mysql_close($link);
echo "<SCRIPT LANGUAGE='JavaScript'>window.location.replace('".$PHP_SELF."?action=postes')</script>";
}
##### DELETE COMPUTER #####
$delcyber = ($_GET['delcyber']);
if ( $delcyber != '')
{
mysql_query("DELETE FROM cyber_network WHERE ip='$delcyber'");
mysql_close($link);
echo "<SCRIPT LANGUAGE='JavaScript'>window.location.replace('".$PHP_SELF."?action=postes')</script>";
}
break;
//////////////////////////////////////////////////
default:
echo '<table align="center"><tr>

<td width="165" height="128" background="../imgs/abo.png" align="center"><br/><form><input type="button"  class="butlink" value="'.translate("cybabo").'" OnClick="window.location.href=\''.$PHP_SELF.'?action=abonnes\'"></form></td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td width="165" height="128" background="../imgs/computer.png" align="center"><form><input type="button"  class="butlink" value="CYBER" OnClick="window.location.href=\''.$PHP_SELF.'?action=postes\'"></form></td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td width="150" height="128" background="../imgs/dollar.png" align="center"><form><input type="button"  class="butlink" value="'.translate("price").'" OnClick="window.location.href=\''.$PHP_SELF.'?action=tarifs\'"></form></td>


</tr></table>';
?>
<table width="800" border="0" align="center">
  <tr>
    <td width="545" align="center">
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p><strong>Mycyber</strong></p>
      <p><?=translate("inscyber")?></td>
    <td width="245" align="center"><p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p><br />
        <?=translate("admsoft")?><br />
        <a href="<? echo $_SERVER['SERVER_ADDRESS'];?>/PC_admin.zip"><img src="../imgs/soft.png" alt="Admin Software" width="50" height="50" /></a></p>
      <p><?=translate("clisoft")?><br />
      <a href="<? echo $_SERVER['SERVER_ADDRESS'];?>/Cyber_client.zip"><img src="../imgs/soft.png" alt="Admin Software" width="50" height="50" /></p></td>
  </tr>
</table>

<?

///////////////END SWITCH ACTION /////////////////
}
//////////////////////////////////////////////////
}else{ echo 'ONLY ADMIN CAN SEE THIS PAGE'; }

require("../inc/php/admin_footer.inc.php");

?>
