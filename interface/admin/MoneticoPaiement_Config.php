<?php
/***************************************************************************************
* Warning !! MoneticoPaiement_Config contains the key, you have to protect this file with all     *   
* the mechanism available in your development environment.                             *
* You may for instance put this file in another directory and/or change its name       *
***************************************************************************************/

define ("MONETICOPAIEMENT_KEY", "714A6D2E3B72B0CFBF776BAA3F1B9FE3E7631398");
define ("MONETICOPAIEMENT_EPTNUMBER", "6021539");
define ("MONETICOPAIEMENT_VERSION", "3.0");
define ("MONETICOPAIEMENT_URLSERVER", "https://p.monetico-services.com/");
define ("MONETICOPAIEMENT_COMPANYCODE", "jkcall");
define ("MONETICOPAIEMENT_URLOK", "http://www.jkcall.fr/interface/admin/Phase2Back.php");
define ("MONETICOPAIEMENT_URLKO", "http://www.jkcall.fr/interface/admin/Phase2Back.php");

define ("MONETICOPAIEMENT_CTLHMAC","V4.0.sha1.php--[CtlHmac%s%s]-%s");
define ("MONETICOPAIEMENT_CTLHMACSTR", "CtlHmac%s%s");
define ("MONETICOPAIEMENT_PHASE2BACK_RECEIPT","version=2\ncdr=%s");
define ("MONETICOPAIEMENT_PHASE2BACK_MACOK","0");
define ("MONETICOPAIEMENT_PHASE2BACK_MACNOTOK","1\n");
define ("MONETICOPAIEMENT_PHASE2BACK_FIELDS", "%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*");
define ("MONETICOPAIEMENT_PHASE1GO_FIELDS", "%s*%s*%s%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s");
define ("MONETICOPAIEMENT_URLPAYMENT", "paiement.cgi");
?>
