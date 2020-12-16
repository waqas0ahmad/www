<?php
require ("../inc/php/admin_header.inc.php");

if($angemeldet == 1 )
{
echo "<SCRIPT LANGUAGE='JavaScript'>window.location.replace('new_rates.php')</script>";
}
else
{
echo '<div class="headline_global">'.translate("adminratesheadline").'/div><div class="boldred">'.translate("loginfailed").'</div>';
}

require("../inc/php/admin_footer.inc.php");
?>
