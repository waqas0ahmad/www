<?
###############  Comdif Telecom Billing software  ###############
							$adminver= 01;
###############  Christian Zeler  Comdif Telecom  ###############
if ($_GET["webuser"] !='' &&  $_GET["webpw"] !='')
{ echo '<meta http-equiv="refresh" content="0;URL=callshop.php?webuser='.$_GET["webuser"].'&webpw='.$_GET["webpw"].'" />'; }
else
{ echo '<meta http-equiv="refresh" content="0;URL=show_customer.php" />'; }
?>