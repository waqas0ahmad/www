<?php
session_start();
if (empty($_SESSION['login']) || empty($_SESSION['session']) )
	{
	echo 'Vous devez etre administrateur pour utiliser cette page'; exit;
	}
require('/home/dbadmin.php');
$ty= mysqli_query($ladmin,"SELECT * FROM admin.custom order by user");
echo'<br/><form action="sync.php" method="post">
	<table border="1">
	<tr><td>
	<select name="CUst[]" size="30" style="width:8em" multiple>';
while($u = mysqli_fetch_array($ty))
	{
	echo'<option>'.$u["user"].'</option>';
	}
echo'</select>
	</td><td>
	<font color="red">Update TRUNKS :</font> <INPUT type=radio name="trunks" value="utrunks"><br /><br /><br /><br /><br />
	<font color="red">Update PRICES :</font> <INPUT type=radio name="prices" value="uprices"><br /><br /><br /><br /><br />
	</td></tr><tr><td colspan="2">
	<input type="submit" value="Sync selected customers" />
	</td></tr>
	</table></form>';

if(isset($_POST["CUst"]))
	{
	foreach($_POST["CUst"] as $user)
		{ 
		echo'Update '.$user.'<br/>';
		$bing = 'astcc_'.$user.'';
		$ou= mysqli_query($ladmin,"SELECT * FROM admin.master");
		while($z = mysqli_fetch_row($ou))
			{
			if($_POST["trunks"] =='' && $_POST["prices"] !='')
				{
				mysqli_query($ladmin,"UPDATE ".$bing.".routes SET comment='".$z[1]."', ek='".$z[3]."', opsecinc='' WHERE pattern='".$z[0]."'");
				}
			elseif($_POST["prices"] =='' && $_POST["trunks"] !='')
				{
				mysqli_query($ladmin,"UPDATE ".$bing.".routes SET comment='".$z[1]."', trunks='".$z[2]."', opsecinc='' WHERE pattern='".$z[0]."'");
				}
			elseif($_POST["prices"] !='' && $_POST["trunks"] !='')
				{
				mysqli_query($ladmin,"INSERT INTO ".$bing.".routes (pattern,comment,trunks,ek,opsecinc) VALUE ('".$z[0]."','".$z[1]."','".$z[2]."','".$z[3]."','0')") or die(mysqli_error($ladmin));
				//mysqli_query($ladmin,"UPDATE ".$bing.".routes SET comment='".$z[1]."', trunks='".$z[2]."', ek='".$z[3]."', opsecinc='0' WHERE pattern='".$z[0]."'");
				}
			elseif($_POST["prices"] =='' && $_POST["trunks"] =='')
				{
				echo'You have to select something to do !!';
				exit;
				}
			}
		
		} 
	}

//echo "<SCRIPT LANGUAGE='JavaScript'>window.location.replace('plist.php')</script>";
require('footer.php');
?>