<?php
session_start();
$_SESSION = array();
session_destroy();
echo "<SCRIPT LANGUAGE='JavaScript'>";
echo "window.location.replace('index.php')";
echo "</script>";
?>