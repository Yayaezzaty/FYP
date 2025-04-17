<?php
session_start();
include 'db_connection.php'; // make sure you have your DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO customer_messages (customer_email, customer_name, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $name, $message);

    if ($stmt->execute()) {
        $_SESSION['message_sent'] = "Your message has been sent successfully!";
        header("Location: contact.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
