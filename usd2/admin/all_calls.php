<?php
require ("../inc/php/admin_header.inc.php");

if($angemeldet == 1)
{ 
			$objAstcc = new DB(); $objAstcc->connect(ASTCC);
			$sCountQuery = mysql_query("SELECT id, callerid, cardnum, callednum, disposition, billseconds, billcost, datecall FROM ".ASTCC.".cdrs 
			where disposition !='ANSWER' ORDER BY id DESC");
?>
<div class="headline_global"><?=translate("callist"); ?></div>

		
		<table class="callisttbl" align="center">
			<tr>
				<th class="callist_th"><?=translate("date"); ?></th>
				<th class="callist_th"><?=translate("callerid"); ?></th>
				<th class="callist_th"><?=translate("destination"); ?></th>
				<th class="callist_th"><?=translate("state"); ?></th>
				<th class="callist_th"><?=translate("duration"); ?></th>
			</tr>
	  
		<?php

		while ( $yo = mysql_fetch_row($sCountQuery)) {
			echo'<tr>
			
				<td class="callist_td">'.$yo[7].'</td>';
			$idx = mysql_fetch_array(mysql_query("SELECT nomcab FROM ".ASTCC.".cards WHERE number='".$yo[2]."'"));
			echo '
				<td class="callist_td">'.$idx['nomcab'].'</td><td class="callist_td">'.$yo[3].'</td><td class="callist_td">';

					if ($yo[4]=="ANSWER") { echo translate("answered"); }
					else if ($yo[4]=="BUSY") { echo translate("busy"); }
					else if ($yo[4]=="CANCEL") { echo translate("cancel"); }
					else if ($yo[4]=="NO ANSWER") { echo translate("noanswer"); }
					else if ($yo[4]=="CONGESTION") { echo translate("congestion"); }
					else if ($yo[4]=="FAILED") { echo translate("cancel"); }
					else if ($yo[4]=="CHANUNAVAIL") { echo translate("congestion"); }
					else if ($yo[4]=="ˇÄèøøøøøøøøøø") { echo 'Provider fail'; }
					else echo "Incomplet";
					echo'</td>
				<td class="callist_td">'.$yo[5].'</td>
			</tr>';

			}
		echo'</table><br />';
		
		$sHeadline;
		$objAstcc->closeDb();
}
else
{
?>
<div class="headline_global"><?=translate("callist"); ?></div><br />
<div class="boldred"><?=translate("loginfailed"); ?></div><br />
<?php
}
require("../inc/php/admin_footer.inc.php");
?>
