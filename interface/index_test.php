<?
if(!empty($_POST['User']) && !empty($_POST['Password']))
	{
	echo'<head></head>';
	SetCookie("workdir", "".$_POST['User']."", time()+86400*365);
	//print_r($_COOKIE); echo $_POST['User'].' ---- '.$_POST['Password'] ;
	echo'<body onLoad="document.form1.submit();">';
	echo "<form  name='form1' id='form1' action='admin/callshop.php' method='POST'>";
	echo "<input type='hidden' name='webuser' value='".$_POST['User']."'>";
	echo "<input type='hidden' name='webpw' value='".$_POST['Password']."'>";
	echo "<input type='hidden' name='userlogin' value='Connexion' size='1'/>";
	echo "</form>";
	}
else
	{
	if(!empty($_POST['Tuser']))
		{
		SetCookie("workdir", "$Tuser", time()+86400*365);
		echo"<SCRIPT LANGUAGE='JavaScript'>window.location.replace('admin/index.php')</script>";
		}
	else
		{
		echo'Please use your personal login account to connect first ! <br/>http//'.$_SERVER['REMOTE_ADDR'].'/login or use the login boxx on http://'.$_SERVER['REMOTE_ADDR'].'';
		}
	}

?>