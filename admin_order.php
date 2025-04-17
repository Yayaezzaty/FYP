<?php
include 'db_connection.php';
session_start();

// Fetch all orders from the database
$sql = "SELECT o.order_id, u.name AS customer_name, u.email, u.phone, 
        o.total_amount, o.payment_method, o.status, 
        o.order_date AS order_created_at
        FROM `orders` o
        JOIN `users` u ON o.user_id = u.user_id
        ORDER BY o.order_date DESC";

$result = $conn->query($sql);

// Debug: Check what's being fetched
/*
echo "<pre>";
print_r($result->fetch_assoc());
$result->data_seek(0); // Reset pointer
echo "</pre>";
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders - Jenny Ride Care</title>
    <link rel="stylesheet" href="AdOrders.css?v=<?php echo time(); ?>">
    <style>
        .missing-data {
            color: #ff6b6b;
            font-style: italic;
        }
        /* Add your other styles here */
    </style>
</head>
<body>
<?php include 'admin_navigation.php'; ?>

<div class="container" id="mainContent">
    <h2>Orders Management</h2>
    
    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Total Price</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Order Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row["order_id"] ?></td>
                    <td><?= htmlspecialchars($row["customer_name"]) ?></td>
                    <td><?= htmlspecialchars($row["email"]) ?></td>
                    <td><?= htmlspecialchars($row["phone"]) ?></td>
                    <td>RM <?= number_format($row["total_amount"], 2) ?></td>
                    <td>
                        <?php 
                        // Properly display payment method with fallback
                        $payment_methods = ['Bank Transfer', 'Touch \'n Go eWallet', 'Shopee Pay', 'Cash On Delivery'];
                        
                        if (!empty($row['payment_method']) && in_array($row['payment_method'], $payment_methods)) {
                            echo htmlspecialchars($row['payment_method']);
                        } else {
                            // Check if it's NULL or empty
                            if ($row['payment_method'] === NULL) {
                                echo '<span class="missing-data">NULL in DB</span>';
                            } elseif (empty($row['payment_method'])) {
                                echo '<span class="missing-data">Empty in DB</span>';
                            } else {
                                echo '<span class="missing-data">Invalid: ' . htmlspecialchars($row['payment_method']) . '</span>';
                            }
                        }
                        ?>
                    </td>
                    <td>
                        <form action="update_order_status.php" method="POST">
                            <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                            <select name="status" onchange="this.form.submit()">
                                <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="Shipped" <?= $row['status'] == 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                                <option value="Delivered" <?= $row['status'] == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                                <option value="Canceled" <?= $row['status'] == 'Canceled' ? 'selected' : '' ?>>Canceled</option>
                            </select>
                        </form>
                    </td>
                    <td><?= date('d M Y', strtotime($row["order_created_at"])) ?></td>
                    <td><a href="view_order_details.php?id=<?= $row['order_id'] ?>">View Details</a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>
</div>
</body>
</html>