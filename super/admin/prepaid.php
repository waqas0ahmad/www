<?php
require('header.php'); echo '<br/>';
switch ($_GET['select']) 
	{
	///////////////////////////////////////////////////////////## RECHARGER ##
	case "cash":
	echo'<form>
		Montant :<input type="texte" name="montant" methode="GET" action="'.$_SERVER['PHP_SELF'].'" />
		Raison : <input type="texte" name="comment" methode="GET" action="'.$_SERVER['PHP_SELF'].'" />
		<input type="hidden" name="cuser" value="'.$_GET['cuser'].'" />
		<input type="hidden" name="select" value="'.$_GET['select'].'" />
		<input type="hidden" name="VT" value="'.$_GET['VT'].'" />
		<input type="hidden" name="balttc" value="'.$_GET['balttc'].'" />
		<input type="submit" value="confirm" />
		</form>';
	if (!empty($_GET['montant']) && isset($_GET['balttc']) && !empty($_GET['VT']) && !empty($_GET['select']) && !empty($_GET['cuser']))
		{
		$realmont = ($_GET['montant'] * 10000);
                $commentaire = $_GET['comment'] ;
		$nox = date("Y-m-d H:i:s");
		$Ttc = ($_GET['balttc'] / 10000);
		$soldeTtc= ($realmont + $_GET['balttc']);
		mysqli_query($ladmin,"INSERT INTO prepaid ( client, date, montant, vat,reason) VALUE ('".$_GET['cuser']."' , '".$nox."', '".$realmont."', '".$_GET['VT']."','".$commentaire."'  )") or die(mysqli_error($ladmin));
		mysqli_query($ladmin,"UPDATE custom SET soldettc='".$soldeTtc."' WHERE user='".$_GET['cuser']."'") or die(mysqli_error($ladmin));
		echo $_GET['montant']; echo' Montant recu<br/>';
		echo $Ttc; echo' Credit precedent<br/>';
		echo $Ttc + $_GET['montant']; echo' Nouveau solde<br/>';

// diff�rents cas pour l'envoi de mail
// trois destinataires possibles d�finis dans variables.php le destinataire principal �tant $TOO
//Si $COPY1 est vide on donne juste la valeur de $TOO � $to
if (empty($COPY1)){$to = $TOO;}
//Si $COPY1 n'est pas vide et $COPY2 est vide on d�finis le destinataire par $TOO;$COPY1
elseif (!empty($COPY1) && empty($COPY2)){$to = $TOO.', '.$COPY1 ;}
//Si $COPY2 n'est pas vide et $COPY1 est vide on d�finis le destinataire par $TOO;$COPY2
elseif (empty($COPY1) && !empty($COPY2)){$to = $TOO.', '.$COPY2 ;}
//Si $COPY1 et $COPY2 ne sont pas vides on d�finis le destinataire par $TOO;$COPY1;$COPY2
elseif (!empty($COPY1) && !empty($COPY2)){$to = $TOO.', '.$COPY1.', '.$COPY2 ;}
		 $subject = 'Rechargement manuel sur le compte: '.$_GET['cuser'].'';
		$message = 'Un rechargement de '.$_GET['montant'].' sur le compte: '.$_GET['cuser'].'
		� �t� r�alis� le: '.$nox.' son nouveau solde est de: '.($Ttc + $_GET['montant']).'
		Son solde pr�c�dent �tait de: '.$Ttc.'
		Cordialement,<br/>Cybercallshop';
		$headers = 'From: contact@comdif.com' . "\r\n" .
		'Reply-To: contact@comdif.com' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
		mail($to, $subject, $message, $headers);
		echo "<SCRIPT LANGUAGE='JavaScript'>setTimeout(\"window.location.replace('prepaid.php?select=hist&cuser=".$_GET['cuser']."')\",1000)</script>";
		}
	break;
	case "hist":
	// Paiement recu on met � jour le paiement et la date de paiement
	if(!empty($_POST['id']))
		{
		mysqli_query($ladmin,"UPDATE admin.prepaid SET paid='oui', paydate='".date("Y-m-d")."' WHERE id='".$_POST['id']."'");
		if(!empty($_POST['geta']))
			{
			echo"<SCRIPT LANGUAGE='JavaScript'>
			window.location.replace('print.php?numclient=".$_POST['leclient']."&montant=".$_POST['combien']."&daterec=".$_POST['daterec']."&unicid=".$_POST['unicid']."')
			</script>";
			}
		}
	// Appercu de l'historique d'un client 
	$Myquery = "SELECT * FROM prepaid WHERE client='".$_GET['cuser']."' ORDER BY date DESC ";
	$Myresult = mysqli_query($ladmin,$Myquery);
	echo '<table border="0"><tr align="center">
	<td>'.$Utilisateur.'</td>
	<td>Date</td>
	<td>Montant</td>
	<td>Montant HT</td>
	<td>Vat</td>
        <td>Commentaire</td>
	<td>Paye</td>
	<td>FA</td>
	</tr>';
	while($sel = mysqli_fetch_array($Myresult))
		{
		echo'<tr>
			<td class="tdblue">'.$sel["client"].'</td>
			<td class="tdblue">'.$sel["date"].'</td>
			<td class="tdblue">'.($sel["montant"]/10000).'</td>
			<td class="tdblue">'.($sel["montant"]/10000/$sel["vat"]).'</td>
			<td class="tdblue">'.$sel["vat"].'</td><td class="tdblue">'.$sel["reason"].'</td>';
			if( strcmp($sel['paid'], "non") == 0)
				{
				echo'<td class="tdred">
					<form action="'.$_SERVER['PHP_SELF'].'?select=hist&cuser='.$sel["client"].'&VT='.$sel["vat"].'" method="post" style="padding:12px 2px 0px;">
					<input type="hidden" name="id" value="'.$sel['id'].'" />
					<input type="hidden" name="select" value="hist" />
					<input type="hidden" name="combien" value="'.($sel["montant"]/10000).'" />
					<input type="hidden" name="daterec" value="'.$sel["date"].'" />
					<input type="hidden" name="unicid" value="'.$sel["id"].'" />
					<input type="hidden" name="leclient" value="'.$sel["client"].'" />
					<input type="submit" value="Non" />
					<td class="tdblue"><input type="checkbox" name="geta" value="oui" /></td>
					</form>
					</td>';
				}
			else
				{
				echo '<td class="tdblue">oui</td>';
				}
                                
			echo '</tr>';
			}
	echo '</table>';
	break;
	## Ajustement du cr�dit	
	case "ajust":
	if ($_GET['select']='ajust' && !empty($_GET['cuser']) && !empty($_GET['sold']))
		{
		echo'<div align="center">
			<font color="red">Le solde actuel est de '.($_GET['sold']/10000).'  Euros</font><br/>
			<strong">L\'ajustement est en centieme de cents, entrez 100 pour ajouter 1 cents, 1000 pour 10 etc..<br/>
			entrez -100 pour enlever 1 cents, -1000 pour enlever 10 etc..<br/>
			Exemple pour enlever 10 cents au solde actuel de '.($_GET['sold']/10000).' Euros, entrez  -1000</strong></div>';

		echo'<form methode="GET" action="'.$_SERVER['PHP_SELF'].'" />
			<input type="texte" name="cash">
			<input type="hidden" name="sold"  value="'.$_GET['sold'].'">
			<input type="hidden" name="cuser" value="'.$_GET['cuser'].'" />
			<input type="hidden" name="select" value="ajust" />
			<input type="submit" value="confirm" />
			</form>';
		if(!empty($_GET['cash']) && !empty($_GET['sold']) && !empty($_GET['cuser']))
			{
			mysqli_query($ladmin,"UPDATE custom SET soldettc='".($_GET['sold'] + $_GET['cash'])."' WHERE user='".$_GET['cuser']."'");
			echo "<SCRIPT LANGUAGE='JavaScript'>window.location.replace('prepaid.php')</script>";
			}
		}
	break;
	## Affichage par defaut
	default:
	$query = "SELECT * FROM admin.custom order by user";
	$result = mysqli_query($ladmin,$query);
	?>
	<table align="center"><tr>
	<td class="tdred"><a href="prepaid.php">&nbsp;&nbsp;Main menu&nbsp;&nbsp;</a></td>
	<td class="tdred"><a href="prepaid.php?overview=overview">&nbsp;&nbsp;Daily history&nbsp;&nbsp;</a></td>
	<td class="tdred"><a href="prepaid.php?overview=overview&filter=non">&nbsp;&nbsp;Impaye&nbsp;&nbsp;</a></td>
	</tr></table><br />
	<?php
	///////////////////////// Daily PREPAID OVERVIEW ///////////////////////////////
	if(!empty($_GET['overview']) && $_GET['overview']=='overview')
		{
		if(!empty($_GET['filter']) && $_GET['filter']!='')
			{
			$quer = "SELECT * FROM prepaid WHERE paid='non' order by date DESC LIMIT 500";
			}
		else
			{
			$quer = "SELECT * FROM prepaid order by date DESC LIMIT 500";
			}
		$resul = mysqli_query($ladmin,$quer);
		echo"<table border=\"0\"><tr>
			<td align='center'>".$Utilisateur."</td>
			<td align='center'>&nbsp;DATE&nbsp;</td>
			<td align='center'>&nbsp;MONTANT&nbsp;</td>
			<td align='center'>&nbsp;PAID&nbsp;</td>
			<td align='center'>&nbsp;PAID ON&nbsp;</td>
                        <td align='center'>COMMENTAIRES</td>
			</tr>";
		while($selec = mysqli_fetch_row($resul))
			{
			if ($selec[11] == 'non')
				{
				$style='tdor';
				}
			else
				{
				$style='tdblue';
				}
			echo'<tr>
			<td class="'.$style.'">'.$selec[1].'</td>
			<td class="'.$style.'">'.$selec[2].'</td>
			<td class="'.$style.'">'.($selec[3] /10000).'</td>
			<td class="'.$style.'">'.$selec[11].'</td>
			<td class="'.$style.'">'.$selec[10].'</td>
                        <td class="'.$style.'">'.strtoupper($selec[6]).'</td>    
			</tr>';
			}
		echo "</table>";
		exit();
		}
///////////////////////// Daily PREPAID OVERVIEW ///////////////////////////////
	echo"<table border=\"0\"><tr>
		<td align='center'>".$Utilisateur."</td>
		<td align='center'>".$Nom."</td>
		<td align='center'>".$Prenom."</td>
		<td align='center'>&nbsp;VAT&nbsp;</td>
		<td align='center'>&nbsp;Balance TTC&nbsp;</td>
		<td align='center'>&nbsp;Add credit&nbsp;</td>
		<td align='center'>&nbsp;&nbsp;History&nbsp;&nbsp;</td>
		<td align='center'>&nbsp;Ajust&nbsp;</td>
		</tr>";
	while($select = mysqli_fetch_row($result))
		{
		echo'<tr>
			<td class="tdblue">'.$select[5].'</td>
			<td class="tdblue">'.$select[1].'</td>
			<td class="tdblue">'.$select[2].'</td>
			<td class="tdblue">'.$select[9].'</td>
			<td class="tdblue">'.($select[10] /10000).'</td>
			<td class="tdred"><a href="'.$_SERVER['PHP_SELF'].'?select=cash&cuser='.$select[5].'&VT='.$select[9].'&balttc='.$select[10].'"\">Cash</a></td>
			<td class="tdred"><a href="'.$_SERVER['PHP_SELF'].'?select=hist&cuser='.$select[5].'&VT='.$select[9].'">History</a></td>
			<td class="tdred"><a href="'.$_SERVER['PHP_SELF'].'?select=ajust&cuser='.$select[5].'&sold='.$select[10].'"\">Ajust</a></td>
			</tr>';
		}
	echo "</table></div>";
	}
require('footer.php');
?>