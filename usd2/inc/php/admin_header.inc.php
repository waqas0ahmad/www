<?php
require ("admin_init.inc.php"); 
if ($angemeldet == 1)
	{
	$objAdmin = new DB(); 	$objAdmin->connect(ASTCC);
	$aAdmin = $objAdmin-> select("SELECT * FROM ".ASTCC.".webadmins WHERE websession='" . $my_session . "' LIMIT 1"); $objAdmin->closeDb();
	}
$MyExplode = explode("_",$context); $MyUsername = $MyExplode[1];
$endcabine = ''.$MyUsername.'*'.$endcabine.''; $starcabine = ''.$MyUsername.'*'.$starcabine.'';
?>
<html>
	<head>
	<link rel="stylesheet" type="text/css" href="../inc/css/main.css">
	<script type="text/javascript" language="JavaScript" src="../inc/js/highlite_trs.js"></script>
	<style>
td.bigtbl_td
		{
		border-bottom-style:solid;
		border-bottom-width:1px;
		border-bottom-color:#6D6049;
		font-size:11px;
		font-weight:normal;
		font-family:Tahoma,Arial,Helvetica;
		text-align:center;
		padding:3px;
    	}
.butlink
		{
		border-size: 0px; border-style: none; background: inherit;
		text-align:left;
		font-weight: bold; font-size: 12px; font-family: Arial, Helvetica, sans-serif;
		cursor: hand; cursor: pointer; adding: 0px;
		}
	</style>
	</head>
<body>

<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
<tr>
<td align="center"  height="12" colspan="2">
<table>
<tr>
<td><form><img src="../imgs/gimmics/flag_fr.png" width="12" height="9" border="0" /> <input type="button"  class="butlink" value="Francais" OnClick="window.location.href='<? $PHP_SELF; ?>?action=lang&lang=FR'"></form></td>
<td><form><img src="../imgs/gimmics/flag_us.png" width="12" height="9" border="0" /> <input type="button"  class="butlink" value="English" OnClick="window.location.href='<? $PHP_SELF; ?>?action=lang&lang=EN'"></form></td>
<td><form><img src="../imgs/gimmics/flag_es.jpg" width="12" height="9" border="0" /> <input type="button"  class="butlink" value="Espanol" OnClick="window.location.href='<? $PHP_SELF; ?>?action=lang&lang=ES'"></form></td>
<td><form><img src="../imgs/gimmics/flag_ro.jpg" width="12" height="9" border="0" /> <input type="button"  class="butlink" value="Romana" OnClick="window.location.href='<? $PHP_SELF; ?>?action=lang&lang=RO'"></form></td>
</tr>
</table>

</td>
</tr>
<tr>
<td width="150" align="center" height="109">&nbsp;&nbsp;<img src="../imgs/logo.png" width="150" height="109" /></td>
<td>		
<!-- star login box table -->
		<table width="200" cellpadding="0" cellspacing="0" border="0" align="center">
      	<tr><td colspan="3"><img src="../imgs/onlinestatus/OhneTitel-1_01.gif" width="200" height="12" /></td></tr>
      	<tr><td><img src="../imgs/onlinestatus/OhneTitel-1_02.gif" width="12" height="34" /></td>
      	<td width="174" >
<?php
          if ($angemeldet == 1)
          {
            echo '<div class="boldlightgreen">'. translate("regularadmin") .'<br />'.translate("loginsuccess").'</div>';
          }else{
            echo'<div class="boldred">'.translate("loginfailed").'</div>';
          }
          ?>
</td><td><img src="../imgs/onlinestatus/OhneTitel-1_04.gif" width="14" height="34" /></td></tr>
<tr><td colspan="3"><img src="../imgs/onlinestatus/OhneTitel-1_05.gif" width="200" height="14" /></td></tr></table>
<!-- end login box table -->

</td></tr>


<td align="center" class="nav"><strong><font color="15035c"><?=$timestamp=date("j F Y",time());?></font></strong></td>

<td background="../imgs/ltop1.jpg"></td>
</tr><tr >
<td class="navibackground">
<?php
    if ($angemeldet == 1)
    {
//MENU ADMINISTRATEUR de BAS NIVEAU ------------------------------
?>

<p class="navigation"><form><input type="button" class="butlink" value="-<?=translate("linkcust"); ?>" OnClick="window.location.href='../admin/show_customer.php'"></form></a></p>
<p class="navigation"><form><input type="button" class="butlink" value="-<?=translate("summary"); ?>" OnClick="window.location.href='../admin/billedcalls.php'"></form></a></p>
<p class="navigation"><form><input type="button" class="butlink" value="-<?=translate("linkadm3"); ?>" OnClick="window.location.href='../admin/rates_sorted.php'"></form></a></p>
<p class="navigation"><form><input type="button" class="butlink" value="-<?=translate("linkallcalls"); ?>" OnClick="window.location.href='../admin/all_calls.php'"></form></a></p>
<?php
	if ($aAdmin[0]['admin_status'] == 1)
	{
//MENU ADMINISTRATEUR de HAUT NIVEAU ------------------------------
?>
<p class="navigation"><form><input type="button" class="butlink" value="-<?=translate("linkadm1"); ?>" OnClick="window.location.href='../admin/show_admins.php'"></form></a></p>
<p class="navigation"><form><input type="button" class="butlink" value="-<?=translate("linkadm5"); ?>" OnClick="window.location.href='../admin/new_carrier.php'"></form></a></p>
<p class="navigation"><form><input type="button" class="butlink" value="-<?=translate("linkadm6"); ?>" OnClick="window.location.href='../admin/systemconfig.php'"></form></a></p>
<p class="navigation"><form><input type="button" class="butlink" value="-Synchro Tarifs" OnClick=
"window.location.href='../admin/syncrates.php'"></form></a></p>
<?
      		}
			
echo'&nbsp;&nbsp;&nbsp;&nbsp;<strong><font color="#0000FF">Admin-Login&nbsp;&nbsp;&nbsp;&nbsp;</font></strong><br/><br/></div><br/>';
    if(!@include ("admin_login_frm.inc.php") )
    { echo'<b class="boldred">'.translate("includeloginboxfailed").'</b>'; }
	
			} else {
////////////// not loged user ////////
echo'</div><br/>';
    if(!@include ("admin_login_frm.inc.php") )
    {
    echo'<b class="boldred">'.translate("includeloginboxfailed").'</b>';
    }
	echo '<p class="navigation">'.translate("defaultusertext").'</p>';	
	}
     echo '</td><td width="800">';
?>