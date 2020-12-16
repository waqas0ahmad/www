<?
require_once("../inc/php/admin_header.inc.php");
require_once("../inc/php/astcc.inc.php");
//print_r($_COOKIE);
if($angemeldet == 1)
{
require_once("../admin/include/tabcab.inc.php");
}
else
{ echo 'please login'; }
require_once("../inc/php/admin_footer.inc.php");
?>