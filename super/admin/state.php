<?php
require('header.php');
if(!empty($_GET['user']))
	{
	$user = $_GET['user'];
	$lolo= mysqli_fetch_array(mysqli_query($ladmin,"select email from admin.custom where user='".$user."'"));
	echo $lolo['email'];
	echo'<form action="'.$_SERVER['PHP_SELF'].'" method="POST">
	<select name="actif">
	<option value="2">Innactif-2</option>
	<option value="1">Actif-1</option>
	</select>
	<input type="hidden" name="client" value="'.$user.'" />
	<input type="submit" name="OK" value="CHANGER" />
	</form>';
	}
if(!empty($_POST['client']))
	{
	echo $_POST['actif'].' - '.$_POST['client'];
	mysqli_query($ladmin,"UPDATE admin.custom SET email = '".$_POST['actif']."' WHERE user='".$_POST['client']."'");
	echo"<SCRIPT LANGUAGE='JavaScript'>window.location.replace('customnew.php')</script>";
	}
require('footer.php');
?>