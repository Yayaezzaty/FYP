<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "ride_db";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check for connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure all form fields are set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['service'], $_POST['booking_date'], $_POST['booking_time'])) {
    
    // Get user input & sanitize
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $service = trim($_POST['service']);
    $booking_date = $_POST['booking_date'];
    $booking_time = $_POST['booking_time'];

    // Prepare SQL statement (prevents SQL injection)
    $stmt = $conn->prepare("INSERT INTO bookings (name, email, phone, service, booking_date, booking_time) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $phone, $service, $booking_date, $booking_time);

    if ($stmt->execute()) {
        echo "<script>alert('Booking Successful!'); window.location.href='booking.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close(); // Close statement
} else {
    echo "Error: Missing required fields!";
}

$conn->close(); // Close connection
?>
