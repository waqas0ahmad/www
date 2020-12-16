<?php
function clean_number($phone, $country_id="")
	{
    $prefix="33";
    if (substr($phone, 0,1)=="+") {$phone='00'.substr($phone,1,29);}
    if (substr($phone, 0,1)=="(0)") {$phone=''.substr($phone,1,29);}
    if (substr($phone, 0,1)=="0" && substr($phone, 0,2)!="00") {$phone=$prefix.substr($phone,1,29);}
    if (substr($phone, 0,1)=="+") {$phone='00'.substr($phone,1,29);}
	$phone = preg_replace('/\+/', "", $phone);
	$phone = preg_replace('/[^0-9]/', "", $phone);
    if (!is_numeric($phone) || strlen($phone)<7)
		{
		return FALSE; exit;
		}
	else
		{
		return $phone;
		}
	}
require ("../inc/php/admin_header.inc.php");
require ("../inc/php/astcc.inc.php");

if($angemeldet == 1)
	{
	switch ($_VARS['action'])
		{
		////////////////////////ADD////////////////////////
		case "add":
			require ("phones/add_customer.php");
   		break;
		////////////////////////ADD MULTI//////////////////	
		case "addmulti":
			require ("phones/add_multi.php");
   		break;
		////////////////////////DELETE////////////////////////
		case "del":
			require ("phones/del_customer.php");
   		break;
		////////////////////////DETAILS////////////////////////
		case "details":
			require ("phones/detail_customer.php");
		break;
		////////////////////////OVERVIEW////////////////////////
		default:
			require ("phones/overview_customer.php");	
		}
	}
else
	{
	echo '<div class="headline_global">'.translate("admincusttitle").'</div><div class="boldred">'.translate("loginfailed").'</div>';
	}
require("../inc/php/admin_footer.inc.php");
?>