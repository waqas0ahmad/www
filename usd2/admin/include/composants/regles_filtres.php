<?
/* Midgar Web SDK                */
/* Page   : Filter_System.php    */ 
/* Auteur : Kaldorei             */
/* Année  : 2008                 */
/* Desc   : Contient toutes les  */
/*          règles de filtrage   */
/*          Antihack.            */ 


function verifier_uniquement_nombres($chaine)
{
  $taille=strlen($chaine);
  $authorise="0123456789";
  for($i=0;$i<$taille;$i++)if(!strstr($authorise,$chaine[$i]))return FALSE;
  return TRUE;
}

?>