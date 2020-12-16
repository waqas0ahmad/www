<?
require ("../inc/php/admin_init.inc.php");
  $objAstcc = new DB(); $objAstcc->connect(ASTCC);
  
$cabineID = $_GET['cabineID'];
if($cabineID != '' && $_GET['conf'] != 'raz')
{

$dquery = mysql_query("SELECT * FROM cumul WHERE cardnum = '$cabineID'");

mysql_query("DELETE FROM cdrs_last WHERE cardnum = '$cabineID'");
  while($darray = mysql_fetch_array($dquery))
  {
    if($darray[5] == 'ANSWER')
	 {
mysql_query("INSERT INTO cdrs_buff (id,cardnum,callerid,callednum,trunk,disposition,billseconds,billcost,callstart,datecall,comment,opcost )
 VALUES ( '$darray[0]' , '$darray[1]' , '$darray[2]' , '$darray[3]' , '$darray[4]' , '$darray[5]' , '$darray[6]' ,'$darray[7]', '$darray[8]' , '$darray[9]', '$darray[10]','$darray[11]')");
///////////////////////////////// new last call from cabine insert in temp table //////////////// 	  
mysql_query("INSERT INTO cdrs_last (id,cardnum,callerid,callednum,trunk,disposition,billseconds,billcost,callstart,datecall,comment,opcost )
 VALUES ( '$darray[0]' , '$darray[1]' , '$darray[2]' , '$darray[3]' , '$darray[4]' , '$darray[5]' , '$darray[6]' ,'$darray[7]', '$darray[8]' , '$darray[9]', '$darray[10]','$darray[11]')");
    }
  }
  mysql_query("UPDATE cards SET facevalue='5000000', used='0', brand='pp' WHERE number='$cabineID'");
  mysql_query("DELETE FROM cdrs WHERE cardnum = '$cabineID' && disposition = 'ANSWER' ");
  mysql_query("DELETE FROM cumul WHERE cardnum = '$cabineID'");
  
  //////////////////////////////UPDATE STOCK AND BILL  OTHER PRODUCTS ///////////////////////////////////
$saledproduct = mysql_query("SELECT * FROM mysale WHERE cabine='".$cabineID."'");
while ($product = mysql_fetch_row($saledproduct))
{
$scanstock = mysql_query("SELECT * from mystock WHERE nom ='".$product[1]."'"); $qty = mysql_fetch_row($scanstock);
mysql_query("UPDATE mystock SET stock='".($qty[5] -1)."' WHERE nom='".$product[1]."'");
mysql_query("INSERT INTO mysale_buff (unid, nom, achat, vente, cat, date) VALUE ( '$product[6]', '$product[1]', '$product[2]', '$product[3]', '$product[4]', '$product[5]')");
mysql_query("DELETE FROM mysale WHERE id='".$product[0]."' LIMIT 1");
}
  
  
  $objAstcc->closeDb();
echo "<SCRIPT LANGUAGE='JavaScript'>window.open('close.html', '_self');</script>";
 }
 
 if($cabineID != '' && $_GET['conf'] == 'raz')
 {
 $myex= $_GET['cabineID']; $cabineID = round(exp($myex/99999991234),0);
 $saledb = mysql_query("SELECT * FROM mysale WHERE cabine='".$cabineID."'");
$pr = mysql_fetch_row($saledb);
if ($pr[1] != '')
{ echo '<br/><div align="center">'.translate("noraz").'</div>'; exit;}
 
 $dquery = mysql_query("SELECT * FROM cumul WHERE cardnum = '$cabineID'");
///////////////////////////////// last call from cabine delete in temp table ////////////////////



	  
mysql_query("DELETE FROM cdrs_last WHERE cardnum = '$cabineID'");
  while($darray = mysql_fetch_array($dquery))
  {
    if($darray[5] == 'ANSWER')
	 {
mysql_query("INSERT INTO cdrs_buff (id,cardnum,callerid,callednum,trunk,disposition,billseconds,billcost,callstart,datecall,comment,opcost )
 VALUES ( '$darray[0]' , '$darray[1]' , '$darray[2]' , '$darray[3]' , '$darray[4]' , '$darray[5]' , '$darray[6]' ,'$darray[7]', '$darray[8]' , '$darray[9]', '$darray[10]','$darray[11]')");
///////////////////////////////// new last call from cabine insert in temp table //////////////// 	  
mysql_query("INSERT INTO cdrs_last (id,cardnum,callerid,callednum,trunk,disposition,billseconds,billcost,callstart,datecall,comment,opcost )
 VALUES ( '$darray[0]' , '$darray[1]' , '$darray[2]' , '$darray[3]' , '$darray[4]' , '$darray[5]' , '$darray[6]' ,'$darray[7]', '$darray[8]' , '$darray[9]', '$darray[10]','$darray[11]')");
    }
  }
	
  mysql_query("UPDATE cards SET facevalue='5000000', used='0', brand='pp' WHERE number='$cabineID'");
  mysql_query("DELETE FROM cdrs WHERE cardnum = '$cabineID' && disposition = 'ANSWER'");
  mysql_query("DELETE FROM cumul WHERE cardnum = '$cabineID'");
  $objAstcc->closeDb();
echo "<SCRIPT LANGUAGE='JavaScript'>window.open('close.html', '_self');</script>";
 }

?>