<?php
session_start();
if (empty($_SESSION['login']) || empty($_SESSION['session']) ) {
echo 'Vous devez etre administrateur pour utiliser cette page';
 header("Location: index.php");
exit;
}
include ("/home/dbadmin.php");
require('lang.php');
require('variables.php');
require('function.php');

echo'<html><head><link rel="stylesheet" type="text/css" href="main.css">
	<style> a{ text-decoration:none; } img { border: 0; } </style>
	</head>
	<body color="999999">';

echo'<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%"><tr>
	<td valign="bottom" colspan="2">
	<table width="100%" border="0"><tr>
	<td width="550" height="100"></td>
	<td>';
echo'<div align="center"></strong><font color="#FF0033" size="+1"><a href="logout.php">'.$_SESSION['login'].' - '.$logout.'</a></font></div>
	</td><td><div align="center"><br/>';
$timestamp=date("j F Y",time());

echo'</div></td></tr></table>
	</td></tr>
	<td  colspan="2" >';
?>
<table align="center" border="0" vspace="0"><tr>
<td><form><input type="button" class="yo" value="Liste Clients" OnClick="window.location.href='customnew.php'"></form></td>

<td><form><input type="button" class="yo" value="Recharges" OnClick="window.location.href='prepaid.php'"></form></td>

<td><form><input type="button" class="yo" value="Creation Client" OnClick="window.location.href='custom.php'"></form></td>

<td><form><input type="button" class="yo" value="Tarif-routage import" OnClick="window.location.href='plist.php'"></form></td>

<td><form><input type="button" class="yo" value="Databases export" OnClick="window.location.href='exform.php'"></form></td>

<td><form><input type="button" class="yo" value="Lignes" OnClick="window.location.href='carrier.php'"></form></td>

<td><form><input type="button" class="yo" value="Routage" OnClick="window.location.href='routage.php'"></form></td>

<td><form><input type="button" class="yo" value="Reporting" OnClick="window.location.href='report.php'"></form></td>

<td><form><input type="button" class="yo" value="Hit destinations" OnClick="window.location.href='hitp.php'"></form></td>

</tr></table>
<?

////insert some functions
	function randlet( $chrs = "") {
		if( $chrs == "" ) $chrs = 6;
		$chaine = ""; 
		$list = "abcdefghijklmnopqrstuvwxyz";
		mt_srand((double)microtime()*1000000);
		$newstring="";
			while( strlen( $newstring )< $chrs )
								{
								$newstring .= $list[mt_rand(0, strlen($list)-1)];
								}
		return $newstring;
	}
	
	function randnum( $chrs = "") {
		if( $chrs == "" ) $chrs = 2;
		$chaine = ""; 
		$list = "12345678";
		mt_srand((double)microtime()*1000000);
		$newstring="";
			while( strlen( $newstring )< $chrs )
								{
								$newstring .= $list[mt_rand(0, strlen($list)-1)];
								}
		return $newstring;
	}
echo'</td></tr><tr ><td>';
echo '</td><td width="100%" align="center">';
?>