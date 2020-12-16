<?
###############  Comdif Telecom Billing software  ###############
							$adminver= 01;
###############  Christian Zeler  Comdif Telecom  ###############
		$objAsterisk = new DB();
		$objAsterisk->connect(ASTERISK);
		$objAstcc = new DB();
		$objAstcc->connect(ASTCC);
		$befins = $_GET['sipnr'];
		$testpre = mysql_query("select * FROM ".$bdd.".prepaid WHERE number='" .$befins. "' AND state='no'");
		$restest = mysql_fetch_row($testpre);
		if ($restest[0] != '')
			{
			echo'<div align="center">!!This customer have a pending invoice, please change state to paid = yes before deleting !!</div>';
			}
		else
			{
			$iDelSipfriends = $objAsterisk->query("DELETE FROM asterisk.sipfriends WHERE name='" .$befins. "' LIMIT 1");
			$iDelWebuser = $objAsterisk->query("DELETE FROM ".$bdd.".webuser WHERE account='" .$befins. "' LIMIT 1");
			$iDelDialplan = $objAsterisk->query("DELETE FROM asterisk.dialplan WHERE exten='" .$befins. "'");
			$iDelCards = $objAstcc->query("DELETE FROM ".$bdd.".cards WHERE number='" .$befins. "' LIMIT 1");
			$iDelrec = $objAstcc->query("DELETE FROM ".$bdd.".prepaid WHERE number='" .$befins. "'");
			$iAddNumber = $objAsterisk->query("INSERT INTO ".$bdd.".numberpool SET extnumber='" .$befins. "', carrier=''");
			echo "<SCRIPT LANGUAGE='JavaScript'>"; echo "window.location.replace('show_customer.php')"; echo "</script>";
			}
		$objAsterisk->closeDb(); $objAstcc->closeDb();
?>