<?php
require ("../inc/php/admin_header.inc.php");

if($angemeldet == 1)
{
$objAstcc = new DB(); $objAstcc->connect(ASTCC); $objAsterisk = new DB(); $objAsterisk->connect(ASTERISK);
switch ($_VARS['action'])
	{
//////////////////////////// REGISTER ///////////////////////////////////////////
		case "register":
		require ("carriers/new.php");	
		break;
//////////////////////////// EDIT ///////////////////////////////////////////		
		case "edit":
		require ("carriers/edit.php");
		break;
//////////////////////////// DELETE /////////////////////////////////////////
		case "del":
		require ("carriers/del.php");
		break;
////////////////////////END SWITCH ACTION////////////////////////////////////
	}
////////////////////////// DEFAULT DISPLAY //////////////////////////////////
		require ("carriers/default.php");
/////////////////////// NOT LOG IN //////////////////////////////////////////
} else { 
echo '<div class="headline_global">'.translate("admincarrierheadline").'</div><br />
<div class="boldred">'.translate("loginfailed").'</div><br />';
}
/////////////////////// INCLUDE FOOTER /////////////////////////////////////		
		require("../inc/php/admin_footer.inc.php");

?>
