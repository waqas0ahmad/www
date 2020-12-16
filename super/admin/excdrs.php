<?
function exportation($TableExport,$Param)
	{
	require('../../../dbadmin.php');
	mysqli_select_db($dbadminconf, $link);
	$qColumnNames = mysql_query("SHOW COLUMNS FROM ".$TableExport) or die("mysql error");
	$numColumns = mysql_num_rows($qColumnNames);
	$x = 0;
	while ($x < $numColumns)
		{
		$colname = mysql_fetch_row($qColumnNames);
		$csv.=$colname[0].";";
		$col[$x] = $colname[0];
		$x++;
	}
	$csv.="\n";
	$query_RsTable = "SELECT * FROM ".$TableExport." WHERE ".$Param."";
	$RsTable = mysql_query($query_RsTable) or die(mysql_error());
	$row_RsTable = mysql_fetch_assoc($RsTable);
do {
foreach($col as $Champ){
$Contenu=$row_RsTable[$Champ];
$Contenu=str_replace(";","~",$Contenu);
$Contenu=str_replace("\r\n","\\r\\n",$Contenu);
$csv .= $Contenu.";";
}
$csv.="\n";
} while ($row_RsTable = mysql_fetch_assoc($RsTable));
header("Content-type: application/vnd.ms-excel");
header("Content-disposition:attachment; filename=file.csv");
print($csv);
exit;
@mysql_free_result($RsTable);
}
$where= $_GET['where'];
exportation("cdrs",$where);

?>