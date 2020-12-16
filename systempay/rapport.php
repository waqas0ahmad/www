<?php




$i=0;

$bd = mysql_connect("localhost", "123bailamariA", "123bailamariA");
mysql_select_db("admin", $bd);


$yo=mysql_query("select ctx_mode,trans_status,admin.cb_retour2.trans_id as trans_id,amount,sName from admin.cb_retour2 left join admin.cb_sent on cb_sent.trans_date=cb_retour2.trans_date");
echo'<html><head>
    <link rel="stylesheet" type="text/css" href="jquery.dataTables.min.css">
    <style> a{ text-decoration:none; } img { border: 0; } </style>
    <script src="jquery-3.3.1.js"></script>
    <script src="jquery.dataTables.min.js"></script></head>
<body color="999999">';

echo '<table id="example" class="display" width="100%"></table>';

echo '<table>
  <caption style="caption-side:top">Rapport CB</caption>
  <tr>
    <th width:"5%">MODE</th><th width:"25%">STATUS</th><th width:"10%">ID</th><th width:"10%">MONTANT</th><th width:"50%">NOM</th>
  </tr>';


while($pre=mysql_fetch_array($yo))
{
   echo '<tr><td>'.$pre['ctx_mode'].'</td><td>'.$pre['trans_status'].'</td><td>'.$pre['trans_id'].'</td><td>'.$pre['amount'].'</td><td>'.$pre['sName'].'</td></tr>';
}

echo '</table>';

echo '</body></html>';
?>
