<?php
session_start();
include 'db_connection.php';

$user_id = $_SESSION['user_id'];

$query = "SELECT orders.id, products.name, products.price, orders.order_date FROM orders 
          JOIN products ON orders.product_id = products.id 
          WHERE orders.user_id = ? ORDER BY orders.order_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>Purchase History</h2>";
while ($row = $result->fetch_assoc()) {
    echo "<p>{$row['order_date']} - {$row['name']} - $ {$row['price']}</p>";
}
?>
