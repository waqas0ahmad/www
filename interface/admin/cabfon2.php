<?php
############################
### 2018 MYSQLI SUPPORT ###
############################
echo'<div align="center">'.$a.' '.$devise.'<br>';
mysqli_free_result($somme);
$toto = mysqli_query($ladmin,"SELECT COUNT(*) as titi FROM cumul WHERE cardnum='$cab'")or die(mysqli_error($ladmin));
$tata = mysqli_fetch_array($toto);
echo translate("calls");
echo': '.$tata['titi'].'</div></td></tr><tr><td background="'.$bgcel.'"><div align="center">&nbsp;</div>';
mysqli_free_result($toto);
?>