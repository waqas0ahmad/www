<?php

echo'<title>Teleboutique Acces</title>
	<link rel="stylesheet" type="text/css" href="index.css" />
	</head>
	<br><br>
	<div align="center"><font style="font-family:Tahoma, Geneva, sans-serif" size="+2">
	</font></div><br><br>';

echo'<table class="table1" align="center" ><tr><td>
	<table class="table2" align="center">
	<tr><td>
	<form name="access" method="post" action="'.$_SERVER['PHP_SELF'].'">
	<input name="User" type="text" value="" size="15" /></td><td>
	<font style="font-family:Tahoma, Geneva, sans-serif" size="2">Votre IDENTIFIANT</font></td></tr>';
	/*
	echo'<tr><td><input name="Password" type="text" value="" size="15" /></td><td><font style="font-family:Tahoma, Geneva, sans-serif" size="2">Votre MOT DE PASSE</font>
	</td></tr>'*/
	echo'<tr><td><input name="Send" type="submit" /></td><td></td></tr></table>
	</td></tr></table>';


if (!empty($_POST['User']))
	{
	include ("/home/dbadmin.php");
	$no = mysqli_fetch_array($ladmin->query("SELECT login FROM admin.custom WHERE login='".$_POST['User']."'"));
	if ($no['login'] == $_POST['User'])
		{
		echo "<SCRIPT LANGUAGE='JavaScript'>window.location.replace('http://".$_SERVER['HTTP_HOST']."/".$_POST['User']."')</script>";
		}
	else
		{
		echo "<SCRIPT LANGUAGE='JavaScript'>window.location.replace('index.php)</script>";
		}
	mysqli_close($ladmin);	
	}
 ?>