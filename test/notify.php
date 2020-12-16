<?php
	if ($_SERVER['REQUEST_METHOD'] != 'POST') {
		header('Location: index.php');
		exit();
	}

	// $ch = curl_init();
	// curl_setopt($ch, CURLOPT_URL, 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr');
	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	// curl_setopt($ch, CURLOPT_POST, 1);
	// curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=_notify-validate&" . http_build_query($_POST));
	// $response = curl_exec($ch);
	// curl_close($ch);

	// if ($response == "VERIFIED" && $_POST['receiver_email'] == "your-email@hotmail.com") {
		// $cEmail = $_POST['payer_email'];
		// $name = $_POST['first_name'] . " " . $_POST['last_name'];

		$price = $_POST['mc_gross'];
		$currency = $_POST['mc_currency'];
		$item = $_POST['item_number'];
		$paymentStatus = $_POST['payment_status'];
		$txn_id=$_POST['txn_id'];
		$item_name=$_POST['item_name'];
		// if ($paymentStatus == "Completed") {
		
		include("DBController.php");
		$db = new DBController();
	
	    $param_type = "sssdss";
	    $param_value_array = array($item, $item_name, $paymentStatus, $price*10000, $currency, $txn_id);
	    $payment_id = $db->insert("INSERT INTO payment(item_number, item_name, payment_status, payment_amount, payment_currency, txn_id) 
		VALUES(?, ?, ?, ?, ?, ?)", $param_type, $param_value_array);
	if($paymentStatus=="Completed"){
		$db->runQuery("update admin.custom set  soldettc=soldettc+".($price*10000)." where user='$item';","bind_param",array());
		$db->runQuery("insert into admin.prepaid(client,date,montant,reason,paid) values('" . $item . "',now()," . ($price * 10000) . ",'CB recharge','oui');","bind_param",array());
	}
		// }
	// }
// 	
?>
