<?php
require ("inc/php/init.inc.php");
if (PUBLICSERVER == 'no') {
    echo "<html>\n<head>\n<title>Telephone en ligne</title>\n";
	echo "<html>\n<head>\n<description>Telephone en ligne gratuit appel vers tout numero de fixe </description>\n";
	echo "<html>\n<head>\n<keywords>telephone, telephone en ligne, telephone gratuit, gratuit, free, call online, appel, phone, voip, call online</keywords>\n";
    echo "<meta http-equiv=refresh content=\"3; URL=" . LINK . "\">\n";
    echo "</head>\n<body>\n<center>\n";
    echo "<a href=\"" . LINK . "\">";
    echo "<img src=/imgs/logo.png border=0>";
    echo "</a>\n";
    echo "</center>\n</body>\n</html>";
    exit;
}

$objCustomer = new DB();
$objCustomer -> connect(ASTERISK);
$aUser = $objCustomer -> select("SELECT * FROM webuser WHERE websession='$my_session' LIMIT 1");

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?=FIRMENNAME; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="TITLE" CONTENT="ipbx on line voip.comdif.com">
<meta name="KEYWORDS" CONTENT="VoIP, operateur, free, appels, sip telephone, online">
<meta name="DESCRIPTION" CONTENT="demo free ipbx online avec systeme de carte prepayee">
<meta name="AUTHOR" CONTENT="Christian Zeler & Rowi.net">
<link rel="stylesheet" type="text/css" href="inc/css/main.css">
<script type="text/javascript" language="JavaScript" src="inc/js/highlite_trs.js"></script>
</head>
<body>
<a name="topofside"></a>
<table class="global" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td class="td1">&nbsp;</td>
		<td class="td2">&nbsp;</td>
		<td class="td3">&nbsp;</td>
		<td class="infolinks">
			<a href="<?$PHP_SELF;?>?action=lang&lang=FR" class="big_links">Francais&nbsp;<img src="imgs/gimmics/flag_fr.png" width="12" height="9" border="0" /></a>&nbsp;|&nbsp;
			<a href="<?$PHP_SELF;?>?action=lang&lang=EN" class="big_links">English&nbsp;<img src="imgs/gimmics/flag_us.png" width="12" height="9" border="0" /></a>&nbsp;|&nbsp;
			<a href="contact.php" class="big_links"><?=translate("contact"); ?></a> | <a href="impressum.php" class="big_links"><?=translate("impressum"); ?></a></td>
	</tr>
	<tr>
    	<td colspan="2"><img src="imgs/voiponcd_logo.png" width="201" height="74" alt="" /></td>
		<td class="td5" colspan="2">
    <!-- Online status viewer -->
      <table width="200" cellpadding="0" cellspacing="0" border="0" align="center">
      	<tr>
      		<td colspan="3">
      			<img src="imgs/onlinestatus/OhneTitel-1_01.gif" width="200" height="12" alt="" /></td>
      	</tr>
      	<tr>
      		<td>
      			<img src="imgs/onlinestatus/OhneTitel-1_02.gif" width="12" height="34" alt="" /></td>
      		<td width="174" height="34">
          <?php
	    if ($angemeldet == 1)
            {
          ?>

            <div class='boldlightgreen'><?=$aUser[0]['webuser'] . "<br /> " . translate("loginsuccess");?></div>
          
          <?php
          }
          else
          {
            echo "<div class='boldred'>" . translate("loginfailed") . "</div>";
          }
          ?>  
          </td>
      		<td>
      			<img src="imgs/onlinestatus/OhneTitel-1_04.gif" width="14" height="34" alt="" /></td>
      	</tr>
      	<tr>
      		<td colspan=3>
      			<img src="imgs/onlinestatus/OhneTitel-1_05.gif" width="200" height="14" alt="" /></td>
      	</tr>
      </table></td>
    <!-- End of online viewer -->
	</tr>
	<tr>
    <td class="header_tbl_navi"><?=$timestamp=date("j. F Y",time());?></td>
		<td rowspan="7">&nbsp;</td>
		<td class="header_tbl_content" colspan="2"><?php echo $_VARS['title']; ?></td>
	</tr>
  <tr>
    <td class="navibackground">
      <p class="navigation"><a href="index.php" class="navi_links">-&nbsp;<?=translate("linkhome"); ?></a></p>
      <p class="navigation"><a href="rates.php" class="navi_links">-&nbsp;<?=translate("linkrates"); ?></a></p>
      <p class="navigation"><a href="myaccount.php" class="navi_links">-&nbsp;<?=translate("linkmyaccount"); ?></a></p>
      <p class="navigation"><a href="phonebook.php" class="navi_links">-&nbsp;<?=translate("linkphonebook"); ?></a></p>
      <p class="navigation"><a href="callist.php?page=0" class="navi_links">-&nbsp;<?=translate("linkcallist"); ?></a></p>
<p class="navigation"><a href="webcall.php?page=0" class="navi_links">-&nbsp;<?=translate("linkwebcall"); ?></a></p>
      <p class="navigation"><a href="xlite.php" class="navi_links">-&nbsp;<a href="xlite.php" class="navi_links"><?=translate("linkxlite"); ?>
      </a></a></p></td>
    <td class="content_td" rowspan="5"colspan="2">
      <!-- Now let's show the body of this site -->
