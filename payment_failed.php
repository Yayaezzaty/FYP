<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Payment Failed</title>
</head>
<body>
    <?php include 'navigation.php'; ?>

    <div class="error-container">
        <h2>Payment Failed</h2>
        <p><?= $_GET['error'] ?? 'Your payment could not be processed.' ?></p>
        <a href="checkout.php" class="retry-btn">Try Again</a>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>