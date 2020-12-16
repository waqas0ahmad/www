<?
$lang = explode('-',$_SERVER['HTTP_ACCEPT_LANGUAGE']); 
if ($lang[0] == 'fr') {
///////////////////////////////////////FRENCH
$title= 'INTERFACE ADMINISTRATION';
$logout= 'LOGOUT';
$Nom= 'NOM BOUTIQUE';
$Prenom= 'NOM CONTACT';
$Adresse= 'VILLE';
$Ten='PREMIER NUMERO DE CABINE, une serie de 10 cabines est créée pour cet utilisateur';
$Twen='POOL CABINES';
$yo20 = 'Pour utilisateurs avec 20 Cabines cliquez ici';
$yo10 = 'Pour utilisateurs avec 10 Cabines cliquez ici';
$Utilisateur= 'CODE CLIENT';
$Tax= 'Utilisateur avec ou sans TVA standard Locale';
///////////////////////////////////////FRENCH
}
elseif ($lang[0] == 'es') {
///////////////////////////////////////ESPANOL
$tile= 'ADMINISTRACION';
$logout= 'Salir';
$Nom= 'NOMBRE';
$Prenom= 'APELLIDO';
$Adresse= 'DIRECCION';
$Ten='PRIMER NUMERO DE CAB, una serie de 10 cabinas se ha creado para ese usuario';
$Twen='PRIMER NUMERO DE CAB, una serie de 20 cabinas se ha creado para ese usuario';
$yo20 = 'para los usuarios con 20 cabinas, pulsa aquí';
$yo10 = 'para los usuarios con 10 cabinas, pulsa aquí';
$Utilisateur= 'NOMBRE UTILISATOR';
$Tax= 'Usario con standard impuesto IVA';
///////////////////////////////////////ESPANOL
}else{
///////////////////////////////////////ENGLISH
$title= 'ADMINISTARTION INTERFACE';
$logout= 'Logout';
$Nom= 'NAME';
$Prenom= 'SURNAME';
$Adresse= 'ADDRESS';
$Ten='FIRST CAB NUMBER, a series of 10 cabins is created for that user';
$Twen='FIRST CAB NUMBER, a series of 20 cabins is created for that user';
$yo20 = 'for users with 20 cabins click here';
$yo20 = 'for users with 10 cabins click here';
$Utilisateur= 'USER NAME';
$Tax= 'User with standard local VAT';
///////////////////////////////////////ENGLISH
}
?>