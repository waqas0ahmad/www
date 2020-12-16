<?php
############################
### 2018 MYSQLI SUPPORT ###
############################
echo'<a href="javascript: void(0)" title="'.translate("checkout").'" onclick="window.open(\'bill.php?cabineID='.(log($cab)*99999991234).'\', 
	\'windowname1\', \'width=700, height=600, directories=no, location=no, menubar=no, resizable=yes, scrollbars=1, status=no, toolbar=no\'); 
	return false;">';
$abcd = arrondi($a, 2, "sup");
echo'<div align="center"><font color="red" size="5">';
echo " ".$abcd." ".$devise."<br></font><font color=\"red\">";
mysqli_free_result($somme);
$toto = mysqli_query($ladmin,"SELECT COUNT(*) as titi FROM cumul WHERE cardnum='$cab'")or die(mysqli_error($ladmin));
$tata = mysqli_fetch_array($toto);
echo translate("calls");
echo': '.$tata['titi'].'</a></font><div/></td></tr><tr><td background="'.$bgcel.'">';
echo '<div align="center"><a href="javascript: void(0)" title="Razer" onclick="window.open(\'del.php?cabineID='.(log($cab)*99999991234).'&conf=raz\', 
	\'windowname1\', \'width=700, height=600, directories=no, location=no, menubar=no, resizable=yes, scrollbars=1, status=no, toolbar=no\'); 
		return false;">Razer</div>';
mysqli_free_result($toto);
?>