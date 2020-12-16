<?
$Tuser = $_POST['Tuser'];
if(!empty($Tuser))
{
setcookie("workdir", "$Tuser", time()+86400*365);
echo"<SCRIPT LANGUAGE='JavaScript'>window.location.replace('admin/index.php')</script>";
}else{
echo'Please use your personal login account to connect first ! <br/>
http//'.$_SERVER['HTTP_HOST'].'/login or use the login box on http://'.$_SERVER['HTTP_HOST'].'';
}
?>