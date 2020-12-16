<?php 
include ("/home/dbadmin.php");
if($_POST["table"]!='' && $_POST["dbase"]!='')
	{ 
	$resQuery = mysqli_query($ladmin,"SELECT * FROM ".$_POST["dbase"].".".$_POST["table"]."");
	header("Content-Type: text/csv-tab-delimited-table");
	header("Content-Disposition: attachment; filename=datas.csv");
	while ($row = mysqli_fetch_row($resQuery))
		{
		$str2 = $row[2];
		$str2 = str_replace("&nbsp;", "", $str2);
		$str2 = str_replace("&shy;", "", $str2);
		$str2 = str_replace("&lrm;", "", $str2);
		$str2 = str_replace("&rlm;", "", $str2);
		$str2 = str_replace("&zwnj;", "", $str2);
		$str2 = str_replace("&zwj;", "", $str2);
		$str2 = str_replace(":::::", "", $str2);
		$str2 = str_replace("::::", "", $str2);
		$str2 = str_replace(":::", "", $str2);
		$str2 = str_replace("::", "", $str2);
		$str2 = str_replace(":;", ";", $str2);
		$str2 = str_replace("\r\n", "", $str2);
		$str2 = str_replace("-:;", "-;", $str2);
		$chain = $row[0].';'.$row[1].';'.$str2.';'.$row[3].';'.$row[4].';'.$row[5].';'.$row[6].';'.$row[7].';'.$row[8].';'.$row[9];
		echo $chain;
		echo"\n";
		}
	}
?>