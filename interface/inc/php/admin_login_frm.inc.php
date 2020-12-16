<?php
if ($angemeldet == 0)
	{
	?>
	</br><br/></br><br/></br>
	<form name="formSaisie" action="<?=$_SERVER['PHP_SELF'];?>" method="post">
	<table class="login_tbl">
	<tr><td class="login_td"><input type=text size=15 maxlength=20 name="webuser"></td><td class="login_td">Login</td></tr>
	<tr><td class="login_td"><input type=password size=15 maxlength=20 name="webpw"></td><td class="login_td">Password</td></tr>
	<tr><td class="login_td"><input type="button"  class="back_button" value="Login" OnClick="document.formSaisie.submit()"></td>
	</tr>
	</table>
	</form>
	<?php
	}

?>