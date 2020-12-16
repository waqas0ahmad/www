<?php
require('/home/dbadmin.php');
session_start();
$loginOK = false;
?>
<html><head><link rel="stylesheet" type="text/css" href="main.css"><style> a{ text-decoration:none; } img { border: 0; } </style></head>
		<table width="100%" border="0"><tr>
     		<td></td>
    		<td> </td>
     		<td><div align="center"><br/>
			<br/>ADMINISTRATION</div><br/><br/>
			</td>
		</tr></table>
<?
if ( isset($_POST) && (!empty($_POST['login'])) && (!empty($_POST['password'])) )
	{
	extract($_POST);
	$sql = "SELECT login, password, session FROM admin WHERE login = '".addslashes($login)."'";
	$req = mysqli_query($ladmin,$sql);
	if (mysqli_num_rows($req) > 0)
		{
		$data = mysqli_fetch_assoc($req);
			if (md5($password) == $data['password'])
				{
				$loginOK = true;
				}
  			}
		}
	if ($loginOK)
		{
		$_SESSION['login'] = $data['login'];   $_SESSION['session'] = $data['session'];
		echo "<SCRIPT LANGUAGE='JavaScript'>";
		echo "window.location.replace('customnew.php')";
		echo "</script>";
		}
	else
	{
	echo '
	<html>
	<head>
	<title>Connexion</title>
	</head>
	<body><br/>
	<form method="post" action="'.$_SERVER['PHP_SELF'].'">
	<table border="0" width="400" align="center">
	<tr>
	 <td width="200"><b>Login</b></td>
	 <td width="200">
	  <input type="text" name="login">
	 </td>
	</tr>
	<tr>
	 <td width="200"><b>Password<b></td>
	 <td width="200">
	  <input type="password" name="password">
	 </td>
	</tr>
	<tr>
	 <td colspan="2">
	  <input type="submit" name="submit" value="login">
	 </td>
	</tr> 
	</table>
	</form>
	</body>
	</html>'; 
	}
?>