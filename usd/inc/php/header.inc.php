<?php
require ("inc/php/init.inc.php");
$objCustomer = new DB(); $objCustomer -> connect(ASTERISK);
$aUser = $objCustomer -> select("SELECT * FROM ".ASTCC.".webuser WHERE websession='$my_session' LIMIT 1");

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<link rel="stylesheet" type="text/css" href="inc/css/main.css">
<link rel="stylesheet" type="text/css" href="main.css">
<script type="text/javascript" language="JavaScript" src="inc/js/highlite_trs.js"></script>
</head>
<body>

<table cellpadding="0" cellspacing="0" align="center" class="ar"><tr>
	<td><br/>&nbsp;&nbsp;&nbsp;
	<a href="<? $PHP_SELF; ?>?action=lang&lang=FR" class="big_links">Francais&nbsp;
	<img src="imgs/gimmics/flag_fr.png" width="12" height="9" border="0" /></a>&nbsp;|&nbsp;
	<a href="<? $PHP_SELF; ?>?action=lang&lang=EN" class="big_links">english&nbsp;
	<img src="imgs/gimmics/flag_us.png" width="12" height="9" border="0" /></a>&nbsp;|&nbsp;
	<a href="<? $PHP_SELF; ?>?action=lang&lang=ES" class="big_links">Espanol&nbsp;
	<img src="imgs/gimmics/flag_es.jpg" width="12" height="9" border="0" /></a>

<?php
            if ($angemeldet == 1)
            {
          ?>
            <div class='boldlightgreen'><?=$aUser[0]['webuser'] . "&nbsp;&nbsp;&nbsp;&nbsp;" . translate("loginsuccess");?></div>
					</td></tr>
			
					<tr><td align ="center">
					<table><tr><td align="left" class="arro">
			&nbsp;&nbsp;&nbsp;<?=$timestamp=date("j. F Y",time());?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
			| &nbsp;<a href="index.php" class="navi_links"><?=translate("linkhome"); ?></a>&nbsp;
			 | &nbsp;<a href="rates.php" class="navi_links"><?=translate("linkrates"); ?></a>&nbsp;
			  | &nbsp;<a href="myaccount.php" class="navi_links"><?=translate("linkmyaccount"); ?></a>&nbsp;
			   | &nbsp;<a href="callist.php?page=0" class="navi_links"><?=translate("linkcallist"); ?></a>&nbsp;
			    | &nbsp;<a href="prepaid.php" class="navi_links"><?=translate("bill"); ?></a>
				</td></tr></table>
			 </td></tr>
			 
			<tr>
		<td class="content_td" >
		<?
          }
          else
          {
            echo '<div class="boldred" align="center">'.translate("loginfailed").'</div>';
			?>
				</td></tr>
				<tr><td align ="center">
				<table ><tr><td align="left" class="arro">
			&nbsp;&nbsp;&nbsp;<?=$timestamp=date("j. F Y",time());?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			 | <a href="index.php" class="navi_links"><?=translate("linkhome"); ?></a>
			  | <a href="rates.php" class="navi_links"><?=translate("linkrates"); ?></a>
				</td></tr></table>
				</td></tr>
				<tr>
		<td class="content_td" align="center" >
		<?
          }
   
