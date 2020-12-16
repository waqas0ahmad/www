<head></head>
<body onLoad="document.form1.submit();">
<?
$repertoire = explode("/", $_SERVER["PHP_SELF"]); 
$Tuser = $repertoire[1];
echo "<form  name='form1' id='form1' action='../interface/index.php' method='POST'>";   	
echo "<input type='hidden' name='Tuser' value='$Tuser'>";
echo "<input type='hidden' name='userlogin' value='Connexion' size='1'/>";      
echo "</form>";
?>
</body>