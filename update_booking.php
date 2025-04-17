<?php
include 'db_connection.php';
session_start();



// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['booking_id'];
    $status = $_POST['status'];

    // Update the booking status
    $stmt = $conn->prepare("UPDATE bookings SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $booking_id);
    
    if ($stmt->execute()) {
        // Success - redirect back with success message
        $_SESSION['message'] = "Booking status updated successfully!";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        // Error - redirect back with error message
        $_SESSION['error'] = "Error updating booking status: " . $stmt->error;
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
    
    $stmt->close();
} else {
    // If not POST request, redirect back
    header("Location: booking_admin.php");
    exit();
}

$conn->close();
?>