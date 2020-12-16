<?php
session_start ();
require ("systemconfig.inc.php");
require ("constants.inc.php");
require ("functions/functions.inc.php");
require ("classes/db.php"); 

$sAction   = $_VARS['action']; $sLang  = $_VARS['lang'];

if($sAction == "lang") $_SESSION["language"] = $sLang;

$sLanguage = $_SESSION["language"];
if (DEFAULTLANG == "") {
    set_default($sLanguage, "FR");
} else {
    set_default($sLanguage, DEFAULTLANG);
}
include "dictionary_".$sLanguage.".inc.php";
###############  Comdif Telecom Billing software  ###############
							$headeradminver= 01;
###############  Christian Zeler  Comdif Telecom  ###############
?>
