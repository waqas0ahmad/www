<?php
try {  
require_once './config.php'; 
$payment_id = $statusMsg = ''; 
$ordStatus = 'error'; 
// if(!empty($_POST['stripeToken'])){ 
     
    // Retrieve stripe token, card and user info from the submitted form data 
    $token  = $_POST['stripeToken']; 
    $name = $_POST['name']; 
    $email = $_POST['email']; 
     
    // Include Stripe PHP library 
    require_once './stripe-lib/init.php'; 
    
    // Set API key 
    \Stripe\Stripe::setApiKey($STRIPE_API_KEY);      
    require_once "./stripe-lib/lib/ApiOperations/Create.php";
    // Add customer to stripe 
    echo \Stripe\Customer::create();
    // try {  

    //     $customer = \Stripe\Customer::create(array( 
    //         'email' => $email, 
    //         'source'  => $token 
    //     )); 
        
    // }catch(Exception $e) {  
    //     $api_error = $e->getMessage();         
         
    // } 
     
    // if(empty($api_error) && $customer){  
         
    //     // Convert price to cents 
    //     $itemPriceCents = ($itemPrice*100); 
         
    //     // Charge a credit or a debit card 
    //     try {  
    //         $charge = \Stripe\Charge::create(array( 
    //             'customer' => $customer->id, 
    //             'amount'   => $itemPriceCents, 
    //             'currency' => $currency, 
    //             'description' => $itemName 
    //         )); 
    //     }catch(Exception $e) {  
    //         $api_error = $e->getMessage();  
    //         echo $api_error;
    //     } 
         
    //     if(empty($api_error) && $charge){ 
         
    //         // Retrieve charge details 
    //         $chargeJson = $charge->jsonSerialize(); 
         
    //         // Check whether the charge is successful 
    //         if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){ 
    //             // Transaction details  
    //             $transactionID = $chargeJson['balance_transaction']; 
    //             $paidAmount = $chargeJson['amount']; 
    //             $paidAmount = ($paidAmount/100); 
    //             $paidCurrency = $chargeJson['currency']; 
    //             $payment_status = $chargeJson['status']; 
                 
    //             // Include database connection file  
    //             include_once './dbadmin.php'; 
    //             $db = new mysqli($hostconf, $loginconf, $passwordconf,$dbadminconf);
                 
    //             // Insert tansaction data into the database 
    //             $sql = "INSERT INTO waqastestdb.orders(name,email,item_name,item_number,item_price,item_price_currency,paid_amount,paid_amount_currency,txn_id,payment_status,created,modified) VALUES('".$name."','".$email."','".$itemName."','".$itemNumber."','".$itemPrice."','".$currency."','".$paidAmount."','".$paidCurrency."','".$transactionID."','".$payment_status."',NOW(),NOW())"; 
    //             $insert = $db->query($sql); 
    //             $payment_id = $db->insert_id; 
    //             $_user = $_POST["usertoken"];
    //             // If the order is successful 
    //             if($payment_status == 'succeeded'){ 
    //                 $db->query("update admin.custom set  soldettc=soldettc+".($price*10000)." where user='$_user';","bind_param",array());
    //                 $ordStatus = 'success'; 
    //                 $statusMsg = 'Your Payment has been Successful!'; 
    //             }else{ 
    //                 $statusMsg = "Your Payment has Failed!"; 
    //             } 
    //         }else{ 
    //             $statusMsg = "Transaction has been failed!"; 
    //         } 
    //     }else{ 
    //         $statusMsg = "Charge creation failed! $api_error";  
    //     } 
    // }else{  
    //     $statusMsg = "Invalid card details! $api_error";  
    // } 
// }else{ 
//     $statusMsg = "Error on form submission."; 
// } 
} catch (\Throwable $th) {
    echo $th;
}
?>
<link href="http://demos.codexworld.com/includes/css/bootstrap.css" rel="stylesheet">
<link href="http://demos.codexworld.com/stripe-payment-gateway-integration-php/css/style.css" rel="stylesheet">

<div class="container">
    <div class="status">
    
        <?php if(!empty($payment_id)){ ?>
            <h1 class="<?php echo $ordStatus; ?>"> <?php echo $statusMsg; ?></h1>			
            <p><b>Payment Status:</b> <?php echo $payment_status; ?></p>
            <p><b>Price:</b> <?php echo $itemPrice.' '.$currency; ?></p>
        <?php }else{ ?>
            <?php echo $statusMsg; ?>        
        <?php } ?>
    </div>
    <a href="index.php" class="btn-link">Back to Payment Page</a>
</div>