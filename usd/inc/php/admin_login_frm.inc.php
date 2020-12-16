<?php
if ($angemeldet == 0) {
?>
<form name="formSaisie" action="<?=$PHP_SELF;?>" method="post">
<table class="login_tbl"><tr>
<td class="login_td"><?=translate("webuser"); ?></td></tr>
<tr><td class="login_td"><input type=text size=15 maxlength=20 name="webuser" value="<?=$webuserhint;?>"></td></tr>
<tr><td class="login_td"><?=translate("admincustformtext2"); ?></td></tr>
<tr><td class="login_td"><input type=password size=15 maxlength=20 name="webpw"></td></tr>
<tr><td class="login_td"><input type="button"  class="back_button" value="Login" OnClick="document.formSaisie.submit()"></td>

</tr>
</table>
</form>
<?php
} else {
  if($aAdmin[0]['admin_status'] == 1)
{
echo "<div style='color:green;'>&nbsp;&nbsp;&nbsp;&nbsp;".translate("masteradmin")."</div><br /><div style='color:green;'>&nbsp;&nbsp;&nbsp;&nbsp;".translate("loginsuccess")."</div><br />";
}else{
echo "<div style='color:green;'>&nbsp;&nbsp;&nbsp;&nbsp;".translate("regularadmin")."</div><br /><div style='color:green;'>&nbsp;&nbsp;&nbsp;&nbsp;".translate("loginsuccess")."</div><br />";
}
echo '<div><form><input type="button"  class="logof" value="&nbsp;&nbsp;&nbsp;&nbsp;" OnClick="window.location.href=\''.$PHP_SELF.'?logout=1\'"></form></div>';
}
?>
