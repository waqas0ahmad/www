<?php
# Includes all the required stuff
require_once("/var/www/".$_COOKIE["workdir"]."/inc/php/systemconfig.inc.php");
require_once("/var/www/".$_COOKIE["workdir"]."/inc/php/constants.inc.php");
require_once("errormessages.inc.php");
require_once("functions/functions.inc.php");
require_once("functions/dateutils.inc.php");
require_once("admin_auth.inc.php");
require_once("dbconnect.php");
require_once("classes/db.php");

if(isset($_VARS['action'])) $sAction   = $_VARS['action'];
if(isset($_VARS['lang'])) $sLang  = $_VARS['lang'];
if(!empty($sAction) && $sAction == "lang") $_SESSION["language"] = $sLang;

if(isset($_SESSION["language"])) $sLanguage = $_SESSION["language"];
if (empty(DEFAULTLANG) || DEFAULTLANG == "")
	{
   set_default($sLanguage, "FR");
	}
else
	{
    set_default($sLanguage, DEFAULTLANG);
	}
include "dictionary_".$sLanguage.".inc.php";
?>