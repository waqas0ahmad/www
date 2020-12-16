<?php
session_start ();
require_once("systemconfig.inc.php");
require_once("constants.inc.php");
require_once("functions/functions.inc.php");
require_once("classes/db.php"); 

$sAction   = $_VARS['action']; $sLang  = $_VARS['lang'];

if($sAction == "lang") $_SESSION["language"] = $sLang;

$sLanguage = $_SESSION["language"];
if (DEFAULTLANG == "") {
    set_default($sLanguage, "FR");
} else {
    set_default($sLanguage, DEFAULTLANG);
}
include "dictionary_".$sLanguage.".inc.php";
?>
