<?php
require ("../inc/php/admin_header.inc.php");
require ("../inc/php/astcc.inc.php");
if($angemeldet == 1)
{
$objAstcc = new DB(); $objAstcc->connect(ASTCC);
$Us = explode("_", $bdd);

echo '<SCRIPT>var dataSet = [';
$i=0;
$yo = (mysql_query("SELECT * FROM admin.prepaid WHERE client='".$Us[1]."'"));
    $currentbase = current(explode('/',$_SERVER['SERVER_PROTOCOL']))."://".$_SERVER['SERVER_NAME'];
while($pre=mysql_fetch_row($yo))
{
    if ($i<>0){
        echo ',';
    }
    $i=$i+1;
    if (strcmp ( $pre[11] ,"oui" )==0 && ($pre[3]>100000)) {
    echo '[ "'.$pre[2].'", "'.($pre[3]/10000).'", "'.strtoupper($pre[6]).'", "'.strtoupper($$pre[9]).'","<a href=\''.$currentbase.'/interface/admin/invoice.php?id='.$pre[0].'\'  ><img src=\'http://www.jkcall.fr/interface/admin/img/invoice.png\' style=\'height:20px; width:20px\'></a>" ]';
    }
    else {
        echo '[ "'.$pre[2].'", "'.($pre[3]/10000).'", "'.strtoupper($pre[6]).'", "'.strtoupper($$pre[9]).'","" ]';   
    }
}
echo '];
    $(document).ready(function() {
    $(\'#example\').DataTable( {
        data: dataSet,
        paging:   false,
        columnDefs: [
                {className: "dt-body-right", "targets": [1]},
                {className: "dt-body-center", "targets": [0,2,3,4]}
               
],
        columns: [
            { title: "Date" ,width:"20%" },
            { title: "Montant",width:"5%" },
            { title: "Commentaire" ,width:"40%"},
            { title: "Reference",width:"30%" },
            { title: "Facture",width:"5%" }
        ]
    } );
} );</script>';

 
echo '<table id="example" class="display" width="100%"> <tfoot>
            <tr>
                <th class="text-center"></th>
                <th class="text-center"></th>
                <th class="text-center"></th>
                <th class="text-center"></th>
                <th class="text-center"></th>
            </tr>
        </tfoot></table>';


$yes = mysql_fetch_array(mysql_query("SELECT soldettc FROM admin.custom WHERE user='".$Us[1]."'"));
echo'<table border="0" align="center" width="600" ><tr>
	<td colspan="2">';


echo'<br/></td></tr>';




echo'</table>';
	
echo '<br/><form><input type="button" class="butlink" value="Login History" OnClick="window.location.href=\''.$PHP_SELF.'?log=log\'"></form>';
if($_GET["log"] != '')
{
echo '<br/><table border="1" align="center" width="600">';
$UseR= split('_',$bdd);
$Ho = (mysql_query("SELECT * FROM admin.sessions WHERE user='".$UseR[1]."' LIMIT 30"));
while($Hi=mysql_fetch_row($Ho))
							  {
echo '<tr><td class="callist_td" width="200">'.$Hi[1].'</td>';
if ($Hi[4] != '0000-00-00 00:00:00')
{echo '<td class="callist_td" width="200"><font color="red" size="2">'.$Hi[4].'</font></td>';}
else {echo '<td class="callist_td" width="200"><font color="green" size="2">'.$Hi[3].'</font></td>';}
echo '<td class="callist_td" width="200">'.$Hi[5].'</td></tr>';}
							  }
$objAstcc->closeDb();
}
else
{ echo 'please login'; }
require ("../inc/php/admin_footer.inc.php");
?>
