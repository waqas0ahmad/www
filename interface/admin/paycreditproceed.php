<?php
require ("../inc/php/admin_header.inc.php");
require ("../inc/php/astcc.inc.php");
require_once("MoneticoPaiement_Config.php");
require_once("MoneticoPaiement_Ept.inc.php");

if($angemeldet == 1)
{
    IF ($_POST['theAmount']<50) {
        $_POST['theAmount']="50";
    }
    if ($_GET["amount"] !=''){
        $_POST['theAmount']=$_GET["amount"];
    }
    
    
echo'<table border="0" align="center"  class="callisttbl"><tr>';
// Reference: unique, alphaNum (A-Z a-z 0-9), 12 characters max
$sReference = "ref" . date("His");
$sMontant = $_POST['theAmount'];
$sDevise  = "EUR";
$sTexteLibre = $NomSociete;
$sDate = date("d/m/Y:H:i:s");
$sLangue = "FR";
$sEmail = $emailadmin;
$sNbrEch = "";
$sDateEcheance1 = "";
$sMontantEcheance1 = "";
$sDateEcheance2 = "";
$sMontantEcheance2 = "";
$sDateEcheance3 = "";
$sMontantEcheance3 = "";
$sDateEcheance4 = "";
$sMontantEcheance4 = "";
$oEpt = new MoneticoPaiement_Ept($sLangue);     		
$oHmac = new MoneticoPaiement_Hmac($oEpt);      	        

// Control String for support
$CtlHmac = sprintf(MONETICOPAIEMENT_CTLHMAC, $oEpt->sVersion, $oEpt->sNumero, $oHmac->computeHmac(sprintf(MONETICOPAIEMENT_CTLHMACSTR, $oEpt->sVersion, $oEpt->sNumero)));

// Data to certify
$phase1go_fields = sprintf(MONETICOPAIEMENT_PHASE1GO_FIELDS,     $oEpt->sNumero,
                                              $sDate,
                                              $sMontant,
                                              $sDevise,
                                              $sReference,
                                              $sTexteLibre,
                                              $oEpt->sVersion,
                                              $oEpt->sLangue,
                                              $oEpt->sCodeSociete, 
                                              $sEmail,
                                              $sNbrEch,
                                              $sDateEcheance1,
                                              $sMontantEcheance1,
                                              $sDateEcheance2,
                                              $sMontantEcheance2,
                                              $sDateEcheance3,
                                              $sMontantEcheance3,
                                              $sDateEcheance4,
                                              $sMontantEcheance4,
                                              $sOptions);
// MAC computation
$sMAC = $oHmac->computeHmac($phase1go_fields);

// =============================================================================================================================================================
// FIN SECTION CODE
//
// END CODE SECTION 
// =============================================================================================================================================================





?>

<form action="<?php echo $oEpt->sUrlPaiement;?>" method="post" id="PaymentRequest">
        <div class="row-fluid" style="padding: 10px;">
                                    
                                    <div class="span11" style="text-align: center;">
        <p>
	<input type="hidden" name="version"             id="version"        value="<?php echo $oEpt->sVersion;?>" />
	<input type="hidden" name="TPE"                 id="TPE"            value="<?php echo $oEpt->sNumero;?>" />
	<input type="hidden" name="date"                id="date"           value="<?php echo $sDate;?>" />
	<input type="hidden" name="montant"             id="montant"        value="<?php echo $sMontant . $sDevise;?>" />
	<input type="hidden" name="reference"           id="reference"      value="<?php echo $sReference;?>" />
	<input type="hidden" name="MAC"                 id="MAC"            value="<?php echo $sMAC;?>" />
	<input type="hidden" name="url_retour"          id="url_retour"     value="<?php echo $oEpt->sUrlKO;?>" />
	<input type="hidden" name="url_retour_ok"       id="url_retour_ok"  value="<?php echo $oEpt->sUrlOK;?>" />
	<input type="hidden" name="url_retour_err"      id="url_retour_err" value="<?php echo $oEpt->sUrlKO;?>" />
	<input type="hidden" name="lgue"                id="lgue"           value="<?php echo $oEpt->sLangue;?>" />
	<input type="hidden" name="societe"             id="societe"        value="<?php echo $oEpt->sCodeSociete;?>" />
	<input type="hidden" name="texte-libre"         id="texte-libre"    value="<?php echo HtmlEncode($sTexteLibre);?>" />
	<input type="hidden" name="mail"                id="mail"           value="<?php echo $sEmail;?>" />
	<!-------------------------------------------------------------------------------------------------------------------------------------------------------------
      SECTION PAIEMENT FRACTIONNE - Section spécifique au paiement fractionné
	  
	  INSTALLMENT PAYMENT SECTION - Section specific to the installment payment
	-------------------------------------------------------------------------------------------------------------------------------------------------------------->
	<input type="hidden" name="nbrech"              id="nbrech"         value="<?php echo $sNbrEch;?>" />
	<input type="hidden" name="dateech1"            id="dateech1"       value="<?php echo $sDateEcheance1;?>" />
	<input type="hidden" name="montantech1"         id="montantech1"    value="<?php echo $sMontantEcheance1;?>" />
	<input type="hidden" name="dateech2"            id="dateech2"       value="<?php echo $sDateEcheance2;?>" />
	<input type="hidden" name="montantech2"         id="montantech2"    value="<?php echo $sMontantEcheance2;?>" />
	<input type="hidden" name="dateech3"            id="dateech3"       value="<?php echo $sDateEcheance3;?>" />
	<input type="hidden" name="montantech3"         id="montantech3"    value="<?php echo $sMontantEcheance3;?>" />
	<input type="hidden" name="dateech4"            id="dateech4"       value="<?php echo $sDateEcheance4;?>" />
	<input type="hidden" name="montantech4"         id="montantech4"    value="<?php echo $sMontantEcheance4;?>" />
	<!-------------------------------------------------------------------------------------------------------------------------------------------------------------
      FIN SECTION PAIEMENT FRACTIONNE
	  
	  END INSTALLMENT PAYMENT SECTION
	-------------------------------------------------------------------------------------------------------------------------------------------------------------->
	
</p>
</div>
            <div class="span11" style="background-color:white;padding: 10px;border-radius: 10px;">
                <div class="span4"><img src="http://www.jkcall.fr/interface/admin/img/cic.jpg"  width="100"/>
                <img src="http://www.jkcall.fr/interface/admin/img/credit-mutuel.jpg"  width="100"/>
                <img src="http://www.jkcall.fr/interface/admin/img/monetico-paiement.jpg" width="100"></div>
            </div>
            <div class="span11" >
                    <button type="submit" style="width: 300px; height: 60px;">PAIEMENT CB <?php echo $_POST['theAmount'];?> EURO</button>
                </div>
            </div>

</form>
    <?php
	
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
