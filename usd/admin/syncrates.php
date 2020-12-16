<?php
require ("../inc/php/admin_header.inc.php");

if($angemeldet == 1)
	{
	require ("rates/index.php");
	}
	else
	{
	echo'<div class="headline_global">'.translate("adminbillheadline").'</div><br />
	<div class="boldred">'.translate("loginfailed").'</div><br />';
	}
require("../inc/php/admin_footer.inc.php");
?>	