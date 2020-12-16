
<?php
header('Content-Type: application/json;charset=utf-8');
require './vendor/autoload.php';
use Stripe\Stripe;
$amount = $_GET["amount"];

  \Stripe\Stripe::setApiKey('sk_test_51HJds8HonZAuahLJimGsqjwIQdCBEMXDjzSjGwK4rStYgssK8EDaJmXpoy4953o2bh9Eczrpg1lLh5BguDz0yhmk00f3miVK91');
  $unid = md5(uniqid(rand(), true));
  $session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
      'price_data' => [
        'currency' => 'EUR',
        'product_data' => [
          'name' => "RECHARGE",
        ],
        'unit_amount' => 60,
      ],
      'quantity' => 1,
    ]],
    
    'mode' => 'payment',
    'success_url' => 'http://localhost/stripe-new/success.php',
    'cancel_url' => 'http://localhost/stripe-new/cancel',
  ]);
var_dump($session);
?>