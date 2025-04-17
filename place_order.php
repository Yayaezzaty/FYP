<?php
session_start();
require_once __DIR__ . '/stripe-php/init.php';

// Database connection
$conn = new mysqli("localhost", "root", "", "ride_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

\Stripe\Stripe::setApiKey('your_secret_key_here'); // Replace with your Stripe Secret Key

// Check if cart is not empty
if (empty($_SESSION['cart'])) {
    die("Your cart is empty. Please add items to your cart before placing an order.");
}

// Simulating a logged-in user
$user_id = 1; 
$totalPrice = 50; // Replace this with your actual calculation from your database

// Insert order into `orders` table
$stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount) VALUES (?, ?)");
$stmt->bind_param("id", $user_id, $totalPrice);
$stmt->execute();
$order_id = $stmt->insert_id;
$stmt->close();

// Create a new Stripe Checkout Session
try {
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => 'RideCare Purchase',
                ],
                'unit_amount' => $totalPrice * 100, // Convert dollars to cents
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => 'http://localhost/ridecare/order_success.php?order_id=' . $order_id,
        'cancel_url' => 'http://localhost/ridecare/order_cancel.php',
    ]);

    // Redirect user to the Stripe payment page
    header("Location: " . $session->url);
    exit;
} catch (Exception $e) {
    echo 'Error creating Stripe session: ' . $e->getMessage();
    exit;
}
