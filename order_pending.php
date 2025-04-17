<?php
session_start();
$order_id = $_GET['order_id'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Payment Pending</title>
</head>
<body>
    <?php include 'navigation.php'; ?>

    <div class="pending-container">
        <h2>Order Received (#<?= $order_id ?>)</h2>
        <p>Please complete your payment via:</p>
        
        <?php if ($_GET['method'] === 'tng'): ?>
            <div class="tng-instructions">
                <p>1. Open Touch 'n Go eWallet</p>
                <p>2. Send RM<?= $_GET['amount'] ?> to:</p>
                <p><strong>012-3456789 (Jenny Ride Care Center)</strong></p>
                <p>3. Upload receipt <a href="#">here</a></p>
            </div>
        <?php endif; ?>

        <p>We'll notify you once payment is verified.</p>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>