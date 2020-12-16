<?php
if ($angemeldet == 0) {
?>
<form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
<table class="login_tbl">
  <tr>
    <td class="login_td">Webuser </td>
    <td class="login_td"><input type=text size=15 maxlength=20 name="webuser" value="<?=$webuserhint;?>"> </td>
    <td class="login_td"> Password </td>
    <td class="login_td"><input type=password size=15 maxlength=20 name="webpw"> </td>
    <td class="login_td"><input type="submit" value="Login"></td>
  </tr>
</table>
</form>
<?php
} else {
require("guthaben.inc.php");
 echo "<div class='lightgreen' style='text-align:center;'>$anmeldestatus</div><br />";
//echo "<div class='lightgreen' style='text-align:center;'>". translate("balance") . ": " . translate("currency") . " $guthabeneuro</div><br />";
 echo "<div class='lightgreen' style='text-align:center;'>". translate("balance") . ": " . translate("currency") . " ".$solde."</div><br />";
?>

<div style="text-align:center;"><a class="big_links" href="<?=$_SERVER['PHP_SELF'];?>?logout=1"><img src="imgs/gimmics/logout.png" width="30" height="30" border="0" alt="Logout" title="Logout" /></a></div>
<?php
}
?>
