<?php
require_once("MoneticoPaiement_Config.php");
require_once("MoneticoPaiement_Ept.inc.php");


$MoneticoPaiement_bruteVars = getMethode();

// TPE init variables
$oEpt = new MoneticoPaiement_Ept();
$oHmac = new MoneticoPaiement_Hmac($oEpt);

// Message Authentication
$phase2back_fields = sprintf(MONETICOPAIEMENT_PHASE2BACK_FIELDS, $oEpt->sNumero,
                        $MoneticoPaiement_bruteVars["date"],
                        $MoneticoPaiement_bruteVars['montant'],
                        $MoneticoPaiement_bruteVars['reference'],
                        $MoneticoPaiement_bruteVars['texte-libre'],
                        $oEpt->sVersion,
                        $MoneticoPaiement_bruteVars['code-retour'],
                        $MoneticoPaiement_bruteVars['cvx'],
                        $MoneticoPaiement_bruteVars['vld'],
                        $MoneticoPaiement_bruteVars['brand'],
                        $MoneticoPaiement_bruteVars['status3ds'],
                        $MoneticoPaiement_bruteVars['numauto'],
                        $MoneticoPaiement_bruteVars['motifrefus'],
                        $MoneticoPaiement_bruteVars['originecb'],
                        $MoneticoPaiement_bruteVars['bincb'],
                        $MoneticoPaiement_bruteVars['hpancb'],
                        $MoneticoPaiement_bruteVars['ipclient'],
                        $MoneticoPaiement_bruteVars['originetr'],
                        $MoneticoPaiement_bruteVars['veres'],
                        $MoneticoPaiement_bruteVars['pares']
					);





$fp = fopen('/var/log/cartebleu/data.log', 'a');
fwrite($fp, date("d/m/Y:H:i:s").'-');
fwrite($fp, $phase2back_fields.'\r\n');

$hostconf = "localhost";
$loginconf = "123bailamariA";
$passwordconf = "123bailamariA";
$dbadminconf = "admin";
$dbasteriskconf = "asterisk";
$ladmin = mysqli_connect($hostconf, $loginconf, $passwordconf,$dbadminconf);
mysqli_query($ladmin,"INSERT INTO admin.cb_retour(date,montant,reference,textlibre,coderetour,cvx,vld,brand,status3ds,numauto,motifrefus,originecb,bincb,hpancb,ipclient,originetr,veres,pares)
        VALUES('".$MoneticoPaiement_bruteVars["date"]."','".$MoneticoPaiement_bruteVars["montant"]."','".$MoneticoPaiement_bruteVars["reference"]."','".$MoneticoPaiement_bruteVars["texte-libre"]."'
,'".$MoneticoPaiement_bruteVars["code-retour"]."','".$MoneticoPaiement_bruteVars["cvx"]."','".$MoneticoPaiement_bruteVars["vld"]."','".$MoneticoPaiement_bruteVars["brand"]."'
,'".$MoneticoPaiement_bruteVars["status3ds"]."','".$MoneticoPaiement_bruteVars["numauto"]."','".$MoneticoPaiement_bruteVars["motifrefus"]."','".$MoneticoPaiement_bruteVars["originecb"]."'
,'".$MoneticoPaiement_bruteVars["bincb"]."','".$MoneticoPaiement_bruteVars["hpancb"]."','".$MoneticoPaiement_bruteVars["ipclient"]."','".$MoneticoPaiement_bruteVars["originetr"]."'
,'".$MoneticoPaiement_bruteVars["veres"]."','".$MoneticoPaiement_bruteVars["pares"]."')")or die(mysqli_error($ladmin));
$ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP']){
    $ipaddress = $_SERVER['HTTP_CLIENT_IP'];}
    else if($_SERVER['HTTP_X_FORWARDED_FOR']){
    $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];}
    else if($_SERVER['HTTP_X_FORWARDED']){
    $ipaddress = $_SERVER['HTTP_X_FORWARDED'];}
    else if($_SERVER['HTTP_FORWARDED_FOR']){
    $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];}
    else if($_SERVER['HTTP_FORWARDED']){
    $ipaddress = $_SERVER['HTTP_FORWARDED'];}
    else if($_SERVER['REMOTE_ADDR']){
    $ipaddress = $_SERVER['REMOTE_ADDR'];}
    else{
        $ipaddress = 'UNKNOWN';
    }
fwrite($fp,'==============>'.substr($ipaddress,0,7).'<=====\r\n');


if (substr($ipaddress,0,7)=="145.226"){
if ($oHmac->computeHmac($phase2back_fields) == strtolower($MoneticoPaiement_bruteVars['MAC']))
	{
// =============================================================================================================================================================
// FIN SECTION CODE
//
// END CODE SECTION 
// =============================================================================================================================================================

// =============================================================================================================================================================
// SECTION IMPLEMENTATION : Vous devez modifier ce code afin d'y mettre votre propre logique métier
// 
// IMPLEMENTATION SECTION : You must adapt this code with your own application logic.
// =============================================================================================================================================================
    
	switch($MoneticoPaiement_bruteVars['code-retour']) {

		case "Annulation" :
			// Paiement refusé
			// Insérez votre code ici (envoi d'email / mise à jour base de données)
			// Attention : une autorisation peut toujours être délivrée pour ce paiement
			//
                        //
                        //
                        mysqli_query($ladmin,"INSERT INTO admin.prepaid(client,date,montant,vat,reason,paydate,paid,numbert)
                                SELECT user,now(),round(".str_replace("EUR","",$MoneticoPaiement_bruteVars["montant"])."*10000),1,'CB ".$MoneticoPaiement_bruteVars["code-retour"]."',now(),'non','".$MoneticoPaiement_bruteVars["reference"]."' FROM admin.custom where NAME='".$MoneticoPaiement_bruteVars["texte-libre"]."' LIMIT 1");

                        //
			// Payment has been refused
			// put your code here (email sending / Database update)
			// Attention : an authorization may still be delivered for this payment
			break;

		case "payetest":
		    // Paiement accepté sur le serveur de test
			// Insérez votre code ici (envoi d'email / mise à jour base de données)
			//
                        //
                        fwrite($fp, "UN PAIEMENT REUSSI.\r\n");
                        fwrite($fp, "UPDATE admin.custom SET soldettc=soldettc+(".str_replace("EUR","",$MoneticoPaiement_bruteVars["montant"])."*10000) where NAME='".$MoneticoPaiement_bruteVars["texte-libre"]."'");
                        mysqli_query($ladmin,"UPDATE admin.custom SET soldettc=soldettc+(".str_replace("EUR","",$MoneticoPaiement_bruteVars["montant"])."*10000) where NAME='".$MoneticoPaiement_bruteVars["texte-libre"]."'");
                        fwrite($fp, "\r\n");
                        fwrite($fp, "INSERT INTO admin.prepaid(client,date,montant,vat,reason,paydate,paid,numbert)
                                SELECT user,now(),".str_replace("EUR","",$MoneticoPaiement_bruteVars["montant"])."*10000,1,'Paiement CB Accepte',now(),'oui','".$MoneticoPaiement_bruteVars["reference"]."' FROM admin.custom where NAME='".$MoneticoPaiement_bruteVars["texte-libre"]."' LIMIT 1");
                        
                        mysqli_query($ladmin,"INSERT INTO admin.prepaid(client,date,montant,vat,reason,paydate,paid,numbert)
                                SELECT user,now(),round(".str_replace("EUR","",$MoneticoPaiement_bruteVars["montant"])."*10000),1,'Paiement CB Accepte',now(),'oui','".$MoneticoPaiement_bruteVars["reference"]."' FROM admin.custom where NAME='".$MoneticoPaiement_bruteVars["texte-libre"]."' LIMIT 1");
			// Payment has been accepted on the test server
			// put your code here (email sending / Database update)
			break;

		case "paiement":
			// Paiement accepté sur le serveur de production
			// Insérez votre code ici (envoi d'email / mise à jour base de données)
			//
                        fwrite($fp, "UN PAIEMENT REUSSI.\r\n");
                        fwrite($fp, "UPDATE admin.custom SET soldettc=soldettc+(".str_replace("EUR","",$MoneticoPaiement_bruteVars["montant"])."*10000) where NAME='".$MoneticoPaiement_bruteVars["texte-libre"]."'");
                        mysqli_query($ladmin,"UPDATE admin.custom SET soldettc=soldettc+(".str_replace("EUR","",$MoneticoPaiement_bruteVars["montant"])."*10000) where NAME='".$MoneticoPaiement_bruteVars["texte-libre"]."'");
                        fwrite($fp, "\r\n");
                        fwrite($fp, "INSERT INTO admin.prepaid(client,date,montant,vat,reason,paydate,paid,numbert)
                                SELECT user,now(),".str_replace("EUR","",$MoneticoPaiement_bruteVars["montant"])."*10000,1,'Paiement CB Accepte',now(),'oui','".$MoneticoPaiement_bruteVars["reference"]."' FROM admin.custom where NAME='".$MoneticoPaiement_bruteVars["texte-libre"]."' LIMIT 1");
                        
                        mysqli_query($ladmin,"INSERT INTO admin.prepaid(client,date,montant,vat,reason,paydate,paid,numbert)
                                SELECT user,now(),round(".str_replace("EUR","",$MoneticoPaiement_bruteVars["montant"])."*10000),1,'Paiement CB Accepte',now(),'oui','".$MoneticoPaiement_bruteVars["reference"]."' FROM admin.custom where NAME='".$MoneticoPaiement_bruteVars["texte-libre"]."' LIMIT 1");

                        // 			// Payment has been accepted on the productive server
			// put your code here (email sending / Database update)
			break;

		
		/*** SEULEMENT POUR LES PAIEMENTS FRACTIONNES ***/
		/***              ONLY FOR MULTIPART PAYMENT              ***/
		case "paiement_pf2":
		case "paiement_pf3":
		case "paiement_pf4":
			// Paiement accepté sur le serveur de production pour l'échéance #N
			// Le code de retour est du type paiement_pf[#N]
			// Insérez votre code ici (envoi d'email / mise à jour base de données)
			// Le montant du paiement pour cette échéance se trouve dans $MoneticoPaiement_bruteVars['montantech']
			//
			// Payment has been accepted on the productive server for the part #N
			// return code is like paiement_pf[#N]
			// put your code here (email sending / Database update)
			// You have the amount of the payment part in $MoneticoPaiement_bruteVars['montantech']
			break;

		case "Annulation_pf2":
		case "Annulation_pf3":
		case "Annulation_pf4":
		    // Paiement refusé sur le serveur de production pour l'échéance #N
			// Le code de retour est du type Annulation_pf[#N]
			// Insérez votre code ici (envoi d'email / mise à jour base de données)
			// Le montant du paiement pour cette échéance se trouve dans $MoneticoPaiement_bruteVars['montantech']
			//
			// Payment has been refused on the productive server for the part #N
			// return code is like Annulation_pf[#N]
			// put your code here (email sending / Database update)
			// You have the amount of the payment part in $MoneticoPaiement_bruteVars['montantech']
			break;
	}

// =============================================================================================================================================================
// FIN SECTION IMPLEMENTATION
// 
// END IMPLEMENTATION SECTION
// =============================================================================================================================================================

// =============================================================================================================================================================
// SECTION CODE 2 : Cette section ne doit pas être modifiée
// 
// CODE SECTION 2 : This section must not be modified
// =============================================================================================================================================================

    echo "version=2\ncdr=0\n";
    fwrite($fp, "===============>");
    fwrite($fp, "version=2\ncdr=0\n");
}
else
{
	// traitement en cas de HMAC incorrect
	// your code if the HMAC doesn't match
    echo "version=2\ncdr=1\n";
    fwrite($fp, "===============>");
    fwrite($fp, "version=2\ncdr=0\n");
}
}
else{
    fwrite($fp, substr($_SERVER['HTTP_CLIENT_IP'],0,7).'\r\n');
    echo '<meta http-equiv="refresh" content="0;URL=http://151.80.45.192/interface/admin/callshop.php" />';
}
fclose($fp);

?> 



