<?php
session_start();
require_once 'db_connection.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if order ID is provided
if (!isset($_GET['id'])) {
    header("Location: account.php");
    exit();
}

$order_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Fetch order details
$order_stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ? AND user_id = ?");
$order_stmt->bind_param("ii", $order_id, $user_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();

if ($order_result->num_rows === 0) {
    header("Location: account.php");
    exit();
}

$order = $order_result->fetch_assoc();

// Fetch order items
$items_stmt = $conn->prepare("
    SELECT od.*, p.name, p.image 
    FROM order_details od
    JOIN products p ON od.product_id = p.product_id
    WHERE od.order_id = ?
");
$items_stmt->bind_param("i", $order_id);
$items_stmt->execute();
$items = $items_stmt->get_result();

// Calculate total items
$total_items = 0;
$order_total = 0;
while ($item = $items->fetch_assoc()) {
    $total_items += $item['quantity'];
    $order_total += ($item['price'] * $item['quantity']);
}
$items->data_seek(0); // Reset pointer for later use
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Jenny Ride Care Center</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #1e3a5f;
            --primary-orange: #ff7f00;
            --light-gray: #f8f9fa;
        }
        
        body {
            background-color: var(--light-gray);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .order-details-container {
            max-width: 800px;
            margin: 30px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .order-header {
            background: var(--primary-blue);
            color: white;
            padding: 20px;
        }
        
        .order-summary {
            padding: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .order-items {
            padding: 20px;
        }
        
        .order-item {
            display: flex;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .order-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 15px;
        }
        
        .item-details {
            flex: 1;
        }
        
        .item-name {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .item-price {
            color: var(--primary-blue);
            font-weight: 600;
        }
        
        .order-total {
            padding: 20px;
            background: #f9f9f9;
            border-top: 2px solid var(--primary-orange);
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .btn-back {
            background: var(--primary-blue);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        
        .btn-back:hover {
            background: var(--primary-orange);
            transform: translateY(-2px);
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .info-label {
            font-weight: 600;
            color: var(--primary-blue);
        }
    </style>
</head>
<body>

<?php include 'navigation.php'; ?>

<div class="order-details-container">
    <div class="order-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3><i class="fas fa-receipt me-2"></i> Order #<?= $order['order_id'] ?></h3>
            <span class="status-badge bg-<?php 
                echo $order['status'] == 'Completed' ? 'success' : 
                     ($order['status'] == 'Processing' ? 'warning' : 'secondary'); 
            ?>">
                <?= $order['status'] ?>
            </span>
        </div>
    </div>
    
    <div class="order-summary">
        <div class="info-row">
            <span class="info-label">Order Date:</span>
            <span><?= date('F j, Y \a\t g:i A', strtotime($order['order_date'])) ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Payment Method:</span>
            <span><?= htmlspecialchars($order['payment_method']) ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Total Items:</span>
            <span><?= $total_items ?></span>
        </div>
    </div>
    
    <div class="order-items">
        <h5 class="mb-4">Order Items</h5>
        
        <?php while ($item = $items->fetch_assoc()): ?>
        <div class="order-item">
            <img src="images/products/<?= htmlspecialchars($item['image']) ?>" 
                 alt="<?= htmlspecialchars($item['name']) ?>" 
                 class="item-image">
            <div class="item-details">
                <div class="item-name"><?= htmlspecialchars($item['name']) ?></div>
                <div class="item-price">RM<?= number_format($item['price'], 2) ?></div>
                <div>Quantity: <?= $item['quantity'] ?></div>
                <div class="mt-2">Subtotal: RM<?= number_format($item['price'] * $item['quantity'], 2) ?></div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
    
    <div class="order-total">
        <div class="info-row">
            <span class="info-label">Subtotal:</span>
            <span>RM<?= number_format($order_total, 2) ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Shipping:</span>
            <span>FREE</span>
        </div>
        <div class="info-row">
            <span class="info-label">Tax:</span>
            <span>RM0.00</span>
        </div>
        <div class="info-row" style="font-size: 1.2rem;">
            <span class="info-label">Total:</span>
            <span class="fw-bold">RM<?= number_format($order['total_amount'], 2) ?></span>
        </div>
    </div>
    
    <div class="p-3 text-center">
        <a href="user_account.php" class="btn btn-back">
            <i class="fas fa-arrow-left me-2"></i> Back to My Account
        </a>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>