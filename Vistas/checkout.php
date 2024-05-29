<?php

// Recupera el valor de $total de los parámetros POST
$total = isset($_POST['total']) ? $_POST['total'] : 0;


require __DIR__ . "/vendor/autoload.php";

$stripe_pin = "sk_test_51Oux6DP2UwtG237DBYSa95L2Cxio1u1D19KHu95mBDvjohExkCf6WLFwTflIfmcC9ntS8S6tifgoHtyUS8DUASVD00lKhq5TZe";

\Stripe\Stripe::setApiKey($stripe_pin);

$checkout_session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => 'PLAYER PROFIT',
            ],
            'unit_amount' => $total * 100, // Utiliza el valor de $total como el unit_amount
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => 'http://localhost/Player-Profit-v.02/Vistas/Vista_GraciasxComprar.php',
    'cancel_url' => 'http://localhost/Player-Profit-v.02/Vistas/Vista_GraciasxComprar.php',
]);

http_response_code(400);
header("Location: " . $checkout_session->url);
?>
