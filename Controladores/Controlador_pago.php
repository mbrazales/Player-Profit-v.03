<?php

require __DIR__ . "/vendor/autoload.php";

$stripe_pin = "sk_test_51Oux6DP2UwtG237DBYSa95L2Cxio1u1D19KHu95mBDvjohExkCf6WLFwTflIfmcC9ntS8S6tifgoHtyUS8DUASVD00lKhq5TZe";

\Stripe\Stripe::setApiKey($stripe_pin);

$checkout_session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => 'Pc Gamer',
            ],
            'unit_amount' => 800000,
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => 'http://localhost/prueba25/success.php',
    'cancel_url' => 'https://example.com/cancel',
]);

http_response_code(400);
header("Location: " . $checkout_session->url);
?>