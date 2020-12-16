<?php
require("../inc/php/admin_header.inc.php");
require("../inc/php/astcc.inc.php");
if ($angemeldet == 1) {
    $objAstcc = new DB();
    $objAstcc->connect(ASTCC);
    $Us = explode("_", $bdd);

    echo '<table border="0" align="center" width="600" ><tr>
	<td colspan="2">';


    echo '<table border="0" align="center" width="600"><tr>';
    echo '<td align="center">

                    <div>
                    <a href="paycreditproceed2.php?amount=50" target="_blank"><img src="http://www.jkcall.fr/interface/admin/img/50EUROS.png" alt="Recharge 50€" /></a>
                    <a href="paycreditproceed2.php?amount=100" target="_blank"><img src="http://www.jkcall.fr/interface/admin/img/100EUROS.png" alt="Recharge 100€" /></a>
                    <a href="paycreditproceed2.php?amount=150" target="_blank"><img src="http://www.jkcall.fr/interface/admin/img/150EUROS.png" alt="Recharge 150€" /></a>               
                    </div>
                    <div>
                    <a href="paycreditproceed2.php?amount=200" target="_blank"><img src="http://www.jkcall.fr/interface/admin/img/200EUROS.png" alt="Recharge 200€" /></a>
                    <a href="paycreditproceed2.php?amount=300" target="_blank"><img src="http://www.jkcall.fr/interface/admin/img/300EUROS.png" alt="Recharge 300€" /></a>
                    <a href="paycreditproceed2.php?amount=500" target="_blank"><img src="http://www.jkcall.fr/interface/admin/img/500EUROS.png" alt="Recharge 500€" /></a>
                    </div>

                    <div class="span8">
                        <form action="paycreditproceed2.php" method="post">
                                <div class="row-fluid" ;padding: 10px;">
                                    <div class="span4" style="margin: 10px;">
                                        <div class="span12" style="margin-left: 0px !important;">
                                            <input id="theAmount" name="theAmount"  style="font-weight: bolder;font-size: 14px !important;height: 45px !important;text-align: center;" type="text" value="" placeholder="Montant a Recharger" />
                                        </div>
                                        </br>
                                        <div class="span12" style="margin-left: 0px !important;">
                                            <button type="submit">RECHARGER</button>
                                        </div>
                                    </div>

                                </div>
                        </form>
                    </div></td>';

    echo '</tr></table></td></tr>';


    echo '</table>';

    if ($_GET["log"] != '') {
        echo '<br/><table border="1" align="center" width="600">';
        $UseR = split('_', $bdd);
        $Ho = (mysql_query("SELECT * FROM admin.sessions WHERE user='" . $UseR[1] . "' LIMIT 30"));
        while ($Hi = mysql_fetch_row($Ho)) {
            echo '<tr><td class="callist_td" width="200">' . $Hi[1] . '</td>';
            if ($Hi[4] != '0000-00-00 00:00:00') {
                echo '<td class="callist_td" width="200"><font color="red" size="2">' . $Hi[4] . '</font></td>';
            } else {
                echo '<td class="callist_td" width="200"><font color="green" size="2">' . $Hi[3] . '</font></td>';
            }
            echo '<td class="callist_td" width="200">' . $Hi[5] . '</td></tr>';
        }
    }
    $objAstcc->closeDb();
} else {
    echo 'please login';
}
require("../inc/php/admin_footer.inc.php");
?>
