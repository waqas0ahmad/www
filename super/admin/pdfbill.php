<?php
require('/home/dbadmin.php');
//// $cabineID $montant $daty
?>
<style type="text/css">
table {
  -moz-border-radius:10px;
  -webkit-border-radius:10px;
  border-radius:10px
  }
  td {
  -moz-border-radius:10px;
  -webkit-border-radius:10px;
  border-radius:10px
  }
  th {
  -moz-border-radius:10px;
  -webkit-border-radius:10px;
  border-radius:10px
  }
  
  </style>
<?
$cabineID = $_GET['cabineID'];
///// MAKE THE HEADER

echo   '<table align="center" border ="0" ><tr><td width="700" align="center"><img src="logo_bill.gif"/></td></tr></table><br /><br /><br />
		<table align="center" border ="0" ><tr>
		<td width="300" align="left"><br /><br />Emetteur FACTURE</td>
		<td width="100"></td>
		<td width="300" align="left" valign="top"><font style="font-size:28px">FACTURE RECHARGEMENT</font></td>
		</tr></table>
		
		<table align="center" border ="0" ><tr><td width="300" align="left" valign="top" bgcolor="#EEEEEE" style="padding: 15px; background-color: "#EEEEEE";">
		<font style=" font-size:16px; "Times New Roman", Times, serif;" >JK CONSULTING<br />
		9 AV MICHELET <br>93400&nbsp;SAINT OUEN<br /><br />
		Tel: 06 15 45 70 00&nbsp;<br />
		Email:  ipdemat@gmail.com</font></td><td width="100"></td>';

$nomclient = mysql_fetch_array(mysql_query("SELECT * FROM admin.custom WHERE user='".$cabineID."'")); 
$custo= $nomclient['name'];
$custo= $adre['address'];
$custo= $surn['surname'];

///// $idcli = explode(' ', $custo);
$ww = mysql_query("SELECT numbert from admin.prepaid where cashtype='' order by numbert"); $xx = mysql_fetch_row($ww); $numfacture = $xx{0} + 1;
$zz = explode("-",$daty);

echo   '<td width="300" align="left" valign="top">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nom Client:&nbsp;&nbsp;'.$custo.'<br />
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:&nbsp;&nbsp;'.$daty.'<br />
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Facture Numero:&nbsp;&nbsp;M'.$zz{0}.'-'.$numfacture.'</td>
		</tr></table><br />';

/////// PHONE

echo   '<table align="center" border="1" width="700"><tr>
		<td align="center" width="480" style="border-width: 0px; border-style:none; border:none; text-align:center;">Designation</td>
		<td align="center" width="250" style="border-width: 0px; border-style:none; border:none; text-align:center;">Prix TTC</td>
</tr></table>';

echo    '<table border="0" align="center" width="700"><tr>
		<td align="center" width="480">Recharge compte prepaye '.$cabineID.'</td>
		<td align="center" width="250">'.$montant.'</td></tr></table>';

echo   '';
mysql_free_result($result);

//TOTAL Price
echo'
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>';
$a = $montant; $vatphone = round((($a) - ($a/1.196)),2); $aht = round(($a/1.196),2);
echo   '<br /><strong><table border="1" align="center" width="700"><tr>
<td align="center" width="250" style="border-width: 0px; border-style:none; border:none; text-align:center;">TOTAL FACTURE</td>
<td align="center" width="150" style="border-width: 0px; border-style:none; border:none; text-align:center;">HT '.$aht.' &euro;</td>
<td align="center" width="150" style="border-width: 0px; border-style:none; border:none; text-align:center;">Dont TVA '.$vatphone.' &euro;</td>
<td align="center" width="150" style="border-width: 0px; border-style:none; border:none; text-align:center;">TTC '.$a.' &euro;</td>
		</tr></table></strong>';
###########################################################################################
echo   '<br/><br/><table width="700" align="center" bgcolor="#F8F8F8" style="padding: 5px; background-color:#F8F8F8"><tr>
		<td align="center" width=700"><em><font style="font-size:10px; color:#666666">JK CONSULTING SAS au Capital de 10 000 &euro; RCS de BOBIGNY 840 054 670<br />
		<br />Numero TVA: FR38 840054670</font></em></td>
		</tr></table>';
mysql_query("UPDATE admin.prepaid set numbert='".$numfacture."' where id='".$unicid."'");		
mysql_close($link);
?>