<?php
require ("../inc/php/admin_header.inc.php");
if($angemeldet == 1 && $statadmin['admin_status'] > 0 || $angemeldet == 1 && $statadmin1['admin_status'] > 0)
	{
	$rule=mysqli_query($ladmin,"SELECT pattern,comment,ek,cost FROM ".ASTCC.".routes")or die(mysqli_error($ladmin));
	while($ro= mysqli_fetch_array($rule))
		{
		$mkpr = ceil(($ro['ek'] + 1500)/100); $mkpr = ceil($mkpr/5) * 5;
		mysqli_query($ladmin,"UPDATE ".ASTCC.".routes SET cost='".($mkpr * 100)."' WHERE pattern='".$ro['pattern']."' LIMIT 1") or die(mysqli_error($ladmin));
		echo $ro['comment'].' UPDATED SETING '.$ro['pattern'].' TO '.$mkpr.' CENTS/MIN<br/>';
		}
	}
else
	{
	echo'<div class="headline_global">'.translate("adminratesheadline").'</div>
		<div class="boldred">'.translate("loginfailed").'</div>';
	}
mysqli_close($ladmin);
require("../inc/php/admin_footer.inc.php");
?>