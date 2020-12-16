<?
require_once("../inc/php/cyber.inc.php");

$query = mysql_query("SELECT * FROM cyber_network order by name");
$k=$mep; $i = 1 ;
echo '<table align="center"><tr>';

while ($cab1=mysql_fetch_assoc($query))
{
echo '<td><table width="220" height="116" border="0" cellpadding="0" cellspacing="0" background="../imgs/fndo.gif">
<tr  style="line-height: 1px"><td width="7" height="7"><img src="../imgs/angleHGs.gif" width="7" height="7" /></td>
<td width="100" bgcolor="#114694" height="7">&nbsp;</td><td bgcolor="#114694">&nbsp;</td>
<td width="7"><img src="../imgs/angleHDs.gif" width="7" height="7" /></td></tr>
<td height="100" rowspan="2" bgcolor="#114694"></td><td rowspan="2"><center>';
$cab= $cab1['id']; $rowa = mysql_query("SELECT * FROM cyber_network WHERE id ='".$cab1['id']."'"); $row = mysql_fetch_array($rowa);
/////////COMPUTER OFF////////////////////////////////////////////////////////////////////////////////////////////////////
if ($row[state]==0)
{
//POSTE ON ET LIBRE*************************************************************************
$pattern = '/^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+/'; preg_match($pattern, $row['ip'], $matches);

if (!empty($matches[0]))
	{
	echo'<a href="javascript: void(0)" onclick="window.open(\'cyber/flock.php?ip='. $row['ip'].'\', \'windowname19\',\'width=100, height=100, directories=no, location=yes, menubar=no, resizable=no, scrollbars=0, status=no, toolbar=no\'); return false;">
<img src="../imgs/pc_off.png" title="'.translate("lockc").'" /></a></td><td>'; echo '<p align="center"><strong>'.$row['name'].'</strong></br>';
	}
	else
	{
	echo '<img src="../imgs/pc_off.png" /></td><td>'; echo '<p align="center"><strong>'.$row['name'].'</strong></br>';
	}
echo '<font  class="a">
<a href="javascript: void(0)" onclick="window.open(\'cyber/on.php?ip='. $row['ip'].'\', \'windowname1\',\'width=100, height=100, directories=no, location=yes, menubar=yes, resizable=yes, scrollbars=1, status=no, toolbar=no\'); return false;"><strong>'.translate("louer").'</strong></a><br/><br/>

<a href="javascript: void(0)" onclick="window.open(\'cyber/onabo.php?ip='. $row['ip'].'\', \'windowname19\',\'width=100, height=100, directories=no, location=yes, menubar=yes, resizable=yes, scrollbars=1, status=no, toolbar=no\'); return false;"><strong>'.translate("cybabo").'</strong></font></a>
';
   
 echo '<td rowspan="2" bgcolor="#114694">&nbsp;</td></tr><tr><td height="19">';

} else {

//si l'etat est Occupe*****************************************************************************
$w = (ceil((time()- $row[start])/60)); $ws = (ceil((time()- $row[start]))); $colo='<font color="red">'.$w.' Min'; $im='<img src="../imgs/pc_on.png" />';
if ($row[remaintime]!='')
{
$w = round((($row[remaintime] - $ws) / 60),0);
$colo='<font color="green">* '.$w.' Min *';
if ( $w <='0'){ $im='<img src="../imgs/pc_alert.gif" />'; }
}

echo $im.'</td><td>'; echo '<p align="center"><strong>'.$row['name'].'</strong></br>';
echo '<font  class="a"><a href="javascript: void(0)" onclick="window.open(\'cyber/transcyber.php?poste='.$row['ip'].'\', \'windowname6\', 
  \'width=200, height=80, directories=no, location=no, menubar=no, resizable=no, scrollbars=no, status=no, toolbar=no\'); 
   return false;">Transfert</a></font>'; echo '<br/>'.$colo.'</font><br/><font class="a">
   
   <a href="javascript: void(0)" onclick="window.open(\'cyber/off.php?ip='.$row['ip'].'&postecyber='.$row['name'].'\', \'windowname7\', 
  \'width=700, height=400, directories=no, location=no, menubar=no, resizable=yes, scrollbars=yes, status=no, toolbar=no\'); 
   return false;"><strong>Stop</strong></a><td rowspan="2" bgcolor="#114694">&nbsp;</td></tr><tr><td height="19">';

}

echo '</td></tr><tr  style="line-height: 1px"><td height="7"><img src="../imgs/angleBGs.gif" width="7" height="7" /></td>
<td bordercolor="#FFFFFF" bgcolor="#114694">&nbsp;</td><td bgcolor="#114694">&nbsp;</td>
<td><img src="../imgs/angleBDs.gif" width="7" height="7" /></td></tr></table></td>';
if ($i == $k) {echo '</tr><tr>'; $i = 1;}else {$i= $i + 1;}
}
echo '</table>';
?>
