<?php
$points_to_redeem = 50; // Example: User redeems 50 points

$query = "UPDATE loyalty_points SET total_points = total_points - ? 
          WHERE user_id = ? AND total_points >= ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("iii", $points_to_redeem, $user_id, $points_to_redeem);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Successfully redeemed $points_to_redeem points!";
} else {
    echo "Not enough points!";
}
$stmt->close();
?>
