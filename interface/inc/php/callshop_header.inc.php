<?php
require_once("admin_init.inc.php"); 

if ($angemeldet == 1)
{
	# Create asterisk object
	$objAdmin = new DB();
	$objAdmin->connect(ASTERISK);
	# get userinfo by using sessionid
  	$aAdmin = $objAdmin-> select("SELECT * FROM ".ASTCC".webadmins WHERE websession='" . $my_session . "' LIMIT 1");
	$objAdmin->closeDb();
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Admin VOIP Server</title>
<meta name="TITLE" CONTENT="Admin VOIP Server">
<link rel="stylesheet" type="text/css" href="../inc/css/main.css">
<script type="text/javascript" language="JavaScript" src="../inc/js/highlite_trs.js"></script>
</head>
<body>
<a name="topofside"></a>
<table class="global" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td class="td1">&nbsp;</td>				  
		<td class="td2">&nbsp;</td>				  
		<td class="td3">&nbsp;</td>
	</tr>
	<tr>
    <td colspan="2"><img src="../imgs/voiponcd_logo.png" width="201" height="74" alt="" /></td>
		<td class="td5" colspan="2">
      <table width="200" cellpadding="0" cellspacing="0" border="0" align="center">
      	<tr>
      		<td colspan="3">
      			<img src="../imgs/onlinestatus/OhneTitel-1_01.gif" width="200" height="12" alt="" /></td>
      	</tr>
      	<tr>
      		<td>
      			<img src="../imgs/onlinestatus/OhneTitel-1_02.gif" width="12" height="34" alt="" /></td>
      		<td width="174" height="34">
          <?php
          if ($angemeldet == 1)
          {
          ?>

            <div class='boldlightgreen'><?=$aAdmin[0]['admin_vorname'] . " " . $aAdmin[0]['admin_nachname'] ;?><br /><?=translate("loginsuccess"); ?></div>

          <?php
          }
          else
          {
          ?>
            <div class='boldred'><?=translate("loginfailed"); ?></div>
          <?php
          }
          ?>  
          </td>
      		<td>
      			<img src="../imgs/onlinestatus/OhneTitel-1_04.gif" width="14" height="34" alt="" /></td>
      	</tr>
      	<tr>
      		<td colspan="3">
      			<img src="../imgs/onlinestatus/OhneTitel-1_05.gif" width="200" height="14" alt="" /></td>
      	</tr>
      </table></td>
	</tr>
	<tr>
    <td class="header_tbl_navi"><?=$timestamp=date("j. F Y",time());?></td>
		<td rowspan="7">&nbsp;</td>
		<td class="header_tbl_content" colspan="2">&nbsp;</td>
	</tr>
  <tr>
    <td class="navibackground">
<?php
    if ($angemeldet == 1)
    {
?>

<p class="navigation"><a href="index.php" class="navi_links">-Callshop</a></p>
<p class="navigation"><a href="rapport.php" class="navi_links">-Rapport</a></p>
<p class="navigation"><a href="blabla.php" class="navi_links">-Blabla</a></p>
<?php
			if ($aAdmin[0]['admin_status'] == 1)
			{
?>

<?php
      		}
	  }
	  else
	  {
	  ?>
	  	<p class="navigation"><?=translate("callshop"); ?></p>	
	  <?php
	  }
      ?></td>
    <td class="content_td" rowspan="5"colspan="2">
   
