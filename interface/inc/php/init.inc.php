<?php

ini_set("display_errors","On");

# Includes all the stuff needed for VoIPonCD
require ("systemconfig.inc.php");
require ("constants.inc.php");
require ("errormessages.inc.php");
require ("functions/functions.inc.php");
require ("functions/dateutils.inc.php");
require ("auth.inc.php");
require ("classes/db.php");

# Chooses the language (not needed in this version)
$sAction   = $_VARS['action'];
$sLang  = $_VARS['lang'];

if($sAction == "lang") $_SESSION["language"] = $sLang;
	 
$sLanguage = $_SESSION["language"];
if (DEFAULTLANG == "") {
    set_default($sLanguage, "FR");
} else {
    set_default($sLanguage, DEFAULTLANG);
}
include "dictionary_".$sLanguage.".inc.php";
?>
