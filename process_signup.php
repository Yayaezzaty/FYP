<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'ride_db';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form data processing
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if ($password !== $confirm_password) {
        header("Location: signup.php?error=Passwords do not match");
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if the email already exists
    $check_email_query = "SELECT email FROM users WHERE email = ?";
    $stmt = $conn->prepare($check_email_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header("Location: signup.php?error=Email already registered");
        exit();
    }

    // Insert the new user into the database
    $insert_query = "INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("sss", $name, $email, $hashed_password);

    if ($stmt->execute()) {
        header("Location: signup.php?success=Account created successfully");
    } else {
        header("Location: signup.php?error=Failed to create account");
    }

    $stmt->close();
}

$conn->close();
?>
