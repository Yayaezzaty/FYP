<?php
session_start();
include("db_connection.php");

// Verify order ID
if (!isset($_GET['order_id'])) {
    header("Location: cart.php");
    exit();
}

$order_id = $_GET['order_id'];
$user_id = $_SESSION['user_id'];

// Fetch order details
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ? AND user_id = ?");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    die("Order not found.");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
    <style>
        .success-container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            text-align: center;
            border: 1px solid #4CAF50;
            border-radius: 5px;
        }
        .success-icon {
            color: #4CAF50;
            font-size: 50px;
        }
    </style>
</head>
<body>
    <?php include 'navigation.php'; ?>

    <div class="success-container">
        <div class="success-icon">✓</div>
        <h2>Payment Successful!</h2>
        <p>Thank you for your purchase. Your order is confirmed.</p>
        
        <div class="order-details">
            <h3>Order #<?= $order['order_id'] ?></h3>
            <p>Date: <?= $order['order_date'] ?></p>
            <p>Total Paid: RM<?= number_format($order['total_amount'], 2) ?></p>
            <p>Payment Method: <?= $order['payment_method'] ?></p>
        </div>

        <a href="products.php" class="continue-btn">Continue Shopping</a>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>