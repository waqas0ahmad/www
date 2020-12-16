<?php
############################
### 2018 MYSQLI SUPPORT ###
############################
require_once ("admin_init.inc.php");
//print_r($_COOKIE);
if ($angemeldet == 1)
	{
	$aAdmin = mysqli_query($ladmin,"SELECT * FROM ".ASTCC.".webadmins WHERE websession='".$my_session."' LIMIT 1");
	$AAdmin = mysqli_query($ladmin,"SELECT * FROM asterisk.webadmins WHERE websession='".$my_session."' LIMIT 1");
	} 
$statadmin = mysqli_fetch_array($aAdmin); $statadmin1 = mysqli_fetch_array($AAdmin);
$emailadmin=$statadmin['admin_status'];
$emailadmin=$statadmin['admin_status'];
$ayes =mysqli_query($ladmin,"SELECT soldettc,name FROM admin.custom WHERE user='".$statadmin['admin_username']."'");
$yes = mysqli_fetch_array($ayes);
$Amountcredit=round(($yes['soldettc'] /10000),2);
$NomSociete=$yes['name'];

echo'<html><head>
    <link rel="stylesheet" type="text/css" href="https://www.jkcall.fr/interface/admin/jquery.dataTables.min.css">
    <style> a{ text-decoration:none; } img { border: 0; } </style>
    <script src="https://www.jkcall.fr/interface/admin/jquery-3.3.1.js"></script>
    <script src="https://www.jkcall.fr/interface/admin/jquery.dataTables.min.js"></script>
<style>
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #33F;
}

li {
  float: left;
}
.topnav-right {
  float: right;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover {
  background-color: #411;
}
</style>
<style type "text/css">
<!--
/* @group Blink */
.blink {
	-webkit-animation: blink .75s linear infinite;
	-moz-animation: blink .75s linear infinite;
	-ms-animation: blink .75s linear infinite;
	-o-animation: blink .75s linear infinite;
	 animation: blink .75s linear infinite;
}
@-webkit-keyframes blink {
	0% { opacity: 1; }
	50% { opacity: 1; }
	50.01% { opacity: 0; }
	100% { opacity: 0; }
}
@-moz-keyframes blink {
	0% { opacity: 1; }
	50% { opacity: 1; }
	50.01% { opacity: 0; }
	100% { opacity: 0; }
}
@-ms-keyframes blink {
	0% { opacity: 1; }
	50% { opacity: 1; }
	50.01% { opacity: 0; }
	100% { opacity: 0; }
}
@-o-keyframes blink {
	0% { opacity: 1; }
	50% { opacity: 1; }
	50.01% { opacity: 0; }
	100% { opacity: 0; }
}
@keyframes blink {
	0% { opacity: 1; }
	50% { opacity: 1; }
	50.01% { opacity: 0; }
	100% { opacity: 0; }
}
/* @end */
-->
</style>
	<link rel="stylesheet" type="text/css" href="../inc/css/new.css">
	<script type="text/javascript" language="JavaScript" src="../inc/js/highlite_trs.js"></script>
	<style> a{ text-decoration:none; } img { border: 0; } 
	.logof {
border-size: 0px; border-style: none; 	background: inherit;
background-image:url(../imgs/navig/stop.png);
font-weight: bold; font-size: 17px; font-family: Arial, Helvetica, sans-serif; color:white;
cursor: hand; cursor: pointer; adding: 0px; background-repeat:no-repeat; background-position:center;
}
.logofh {
border-size: 0px; border-style: none; 	background: inherit;
background-image:url(../imgs/navig/stoph.png);
font-weight: bold; font-size: 17px; font-family: Arial, Helvetica, sans-serif; color:white;
cursor: hand; cursor: pointer; adding: 0px; background-repeat:no-repeat; background-position:center;
}
.jMfHkK {
	position: fixed;
	bottom: 0;
	right: 0;
	height: 64px;
	box-shadow: rgba(0, 0, 0, 0.15) 0px 3px 12px;
	border-radius: 50%;
	display: flex;
	-webkit-box-pack: center;
	justify-content: center;
	-webkit-box-align: center;
	align-items: center;
	cursor: pointer;
	user-select: none;
	outline: transparent;
	background-color: rgb(255, 255, 255);
	margin-bottom: 20px;
	margin-right: 20px;
	margin-left: 20px;
	width: 64px;
}

.jMfHkK::before,
.jMfHkK::after {
	content: "";
	position: absolute;
	border: 1px solid rgb(79, 206, 93);
	left: -2px;
	right: -2px;
	top: -2px;
	bottom: -2px;
	border-radius: 500px;
	opacity: 0;
	z-index: 0;
}
	</style>
	</head>
	<body BACKGROUND="../imgs/fnd.jpg">
	<a role="button" tabindex="0" href="https://api.whatsapp.com/send?phone=33614147233" target="_blank" type="bubble" class="jMfHkK" download>
    <div class="hzZnJx">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/WhatsApp.svg/1200px-WhatsApp.svg.png" style="height:100px;width:100px";/>
    </div>
</a>
	<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%"><tr>
	<td valign="bottom" colspan="2">
	<table width="100%" border="0"><tr>
	<td><img src="../imgs/logojk.png" width="140" height="100" /></td>
	<td>';
	
require_once("admin_choice.php");

echo'</td>
	</tr>
	<td  colspan="2">';

if ($angemeldet == 1)
    {
    ?>
<ul>
<li><a href="#" onclick="window.location.href='../admin/callshop.php'"><?=translate("callshop")?></a></li>
 
<li><a href="#" onclick="window.location.href='../admin/billedcalls.php'"><?=translate("summary")?></a></li>
<li><a href="#" onclick="window.location.href='../admin/rates_sorted.php'"><?=translate("linkadm3")?></a></li>
<li><a href="#" onclick="window.location.href='../admin/all_calls.php'"><?=translate("linkallcalls")?></a></li>  
<li><a href="#" onclick="window.location.href='../admin/myaccount.php'">Facture</a></li>

<?php
	if ($statadmin['admin_status'] == 1 || $statadmin1['admin_status'] == 1) {?>
<li><a href="#" onclick="window.location.href='../admin/show_customer.php'"><?=translate("linkcust")?></a></li>
<li><a href="#" onclick="window.location.href='../admin/show_admins.php'"><?=translate("linkadm1")?></a></li>
        <?php } ?>
<li><a href="#" onclick="window.location.href='../admin/systemconfig.php'"><?=translate("linkadm6")?></a></li>
<li><a href="#" onclick="window.location.href='../admin/rechargecb.php'">Recharge CB</a></li>
<div class="topnav-right">
<li><a href="#" onclick="window.location.href='../admin/callshop.php?logout=1'">Deconnexion</a></li>

<?php
   }
   

?>
	</div>

</ul>

	<table align="center" border="0" vspace="0"><tr>
	

	<?php
    if ($angemeldet != 1)
		{
    	if(!@include ("admin_login_frm.inc.php") )
			{
			echo'<b class="boldred">'.translate("includeloginboxfailed").'</b>';
			}
		}
     echo '</td><td width="100%" align="center">';
?>
