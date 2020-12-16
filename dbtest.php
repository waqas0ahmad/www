<?
$protocol = current(explode('/',$_SERVER['SERVER_PROTOCOL']));
echo current(explode('/',$_SERVER['SERVER_PROTOCOL']))."://".$_SERVER['SERVER_NAME'];
?>