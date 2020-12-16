<?php
require './vendor/autoload.php';

use Stripe\Stripe;

$amount =floatval($_GET["amount"])*100;
try {
  \Stripe\Stripe::setApiKey('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');
  $unid = md5(uniqid(rand(), true));
  $session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
      'price_data' => [
        'currency' => 'EUR',
        'product_data' => [
          'name' => "RECHARGE",
        ],
        'unit_amount' => $amount,
      ],
      'quantity' => 1,
    ]],

    'mode' => 'payment',
    'success_url' => 'https://www.jkcall.fr/stripe/success.php?uid=' . $_GET['u'] . '&amt=' . ($amount/100) . '&sid=' . $unid,
    'cancel_url' => 'https://www.jkcall.fr/stripe/cancel.php',
  ]);
  require_once "./dbadmin.php";
  //save $session->payment_intent; to database;
  $db = new mysqli($hostconf, $loginconf, $passwordconf, $dbadminconf);
  $db->query("insert into waqastestdb.stripe_payment(payment_intent,userid,UniqueId)values('" . $session->payment_intent . "','" . $_GET['u'] . "','" . $unid . "')");
} catch (\Throwable $th) {
  header('Content-Type: application/json;charset=utf-8');
  echo $th;
}
header('Content-Type: application/json;charset=utf-8');
echo json_encode(array("id" => $session->id));
// });
