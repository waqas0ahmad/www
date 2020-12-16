<?php

  ob_start();
    $hostconf = "localhost";
    $loginconf = "admin";
    $passwordconf = "admin";
    $dbadminconf = "admin";
    $dbasteriskconf = "asterisk";
    $ladmin = mysqli_connect($hostconf, $loginconf, $passwordconf,$dbadminconf);
    $aAdmin = mysqli_query($ladmin,"SELECT * FROM admin.prepaid WHERE id='".$_GET['id']."' LIMIT 1");
    $statadmin = mysqli_fetch_array($aAdmin); 
    $cabineID= $statadmin['client']; 
    $montant= $statadmin['montant']/10000; 
    $daty = $statadmin['date']; 
    $unicid = $_GET['id'];
 	include('pdfbill.php');
        
	$content = ob_get_clean();
	require_once('/var/www/super/admin/html2pdf/html2pdf.class.php');
	try
	{
		$html2pdf = new HTML2PDF('P','A4', 'fr', false, 'ISO-8859-15');
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output(''.$daty.'_'.$cabineID.'.pdf');
	}
	catch(HTML2PDF_exception $e) { echo $e; }
?>