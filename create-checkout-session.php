<?php

require 'vendor/autoload.php';
\Stripe\Stripe::setApiKey('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'); // Secret Key

header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://localhost:5500/';

$checkout_session = \Stripe\Checkout\Session::create([
  'payment_method_types' => ['card'],
  'line_items' => [[
    'price_data' => [
      'currency' => 'usd',
      'unit_amount' => 100,
      'product_data' => [
        'name' => 'Man Beind the March Book',
        'images' => ["https://i.imgur.com/IunDNun.jpg"],
      ],
    ],
    'quantity' => 1,
  ]],
  'mode' => 'payment',
  'success_url' => $YOUR_DOMAIN . '/success.html',
  'cancel_url' => 'https://man-behind-march-app.herokuapp.com/',
]);

echo json_encode(['id' => $checkout_session->id]);