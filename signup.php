<?php
include 'db_connection.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

$required = ["name", "email", "phone", "password", "role"];
foreach ($required as $field) {
    if (!isset($_POST[$field])) {
        echo json_encode(['success' => false, 'error' => "Missing required field: $field"]);
        exit;
    }
}

$name = trim($_POST["name"]);
$email = trim($_POST["email"]);
$phone = trim($_POST["phone"]);
$password = $_POST["password"];
$role = strtolower(trim($_POST["role"]));

if (empty($name) || empty($email) || empty($phone) || empty($password) || empty($role)) {
    echo json_encode(['success' => false, 'error' => "All fields are required"]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'error' => "Invalid email format"]);
    exit;
}

if (!preg_match('/^[0-9]{10,15}$/', $phone)) {
    echo json_encode(['success' => false, 'error' => "Phone number must be 10-15 digits"]);
    exit;
}

if (strlen($password) < 8) {
    echo json_encode(['success' => false, 'error' => "Password must be at least 8 characters"]);
    exit;
}

if (!in_array($role, ['admin', 'customer'])) {
    echo json_encode(['success' => false, 'error' => "Invalid role selected"]);
    exit;
}

$check_email = "SELECT email FROM users WHERE email = ? UNION SELECT email FROM admin WHERE email = ?";
$stmt_check = $conn->prepare($check_email);
$stmt_check->bind_param("ss", $email, $email);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows > 0) {
    echo json_encode(['success' => false, 'error' => "Email already exists"]);
    exit;
}
$stmt_check->close();

$password_hash = password_hash($password, PASSWORD_DEFAULT);

if ($role === 'admin') {
    $sql = "INSERT INTO admin (name, email, phone, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $phone, $password_hash);
} else {
    $sql = "INSERT INTO users (name, email, phone, password, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $phone, $password_hash, $role);
}

if ($stmt->execute()) {
    $user_id = $conn->insert_id;
    
    session_start();
    $_SESSION["user_id"] = $user_id;
    $_SESSION["name"] = $name;
    $_SESSION["role"] = $role;
    
    echo json_encode([
        'success' => true,
        'redirect' => ($role === 'admin') ? 'admin.php' : 'homepage.php'
    ]);
} else {
    echo json_encode(['success' => false, 'error' => "Database error"]);
}

$conn->close();
?>