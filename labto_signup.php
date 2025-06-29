<?php
include 'db.php';
session_start();

$name = $_POST['TO_name'];
$email = $_POST['TO_Email'];
$password = $_POST['password'];

// Validate email format (should contain 'to')
if (strpos($email, 'to') === false) {
    header("Location: labto_auth.php?error=Email must contain 'to'");
    exit;
}

// Validate password length
if (strlen($password) < 6) {
    header("Location: labto_auth.php?error=Password must be at least 6 characters");
    exit;
}

// Check if user already exists
$check = $conn->prepare("SELECT id FROM users WHERE username = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    header("Location: labto_auth.php?error=Account already exists. Please login.");
    exit;
}

// Generate unique TO_ID
$to_id = uniqid("TO");

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert into users table
$stmt1 = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt1->bind_param("ss", $email, $hashed_password);
$stmt1->execute();

// Insert into Lab_TO table
$stmt2 = $conn->prepare("INSERT INTO Lab_TO (TO_ID, TO_name, TO_Email, Instruc_ID) VALUES (?, ?, ?, NULL)");
$stmt2->bind_param("sss", $to_id, $name, $email);
$stmt2->execute();

// Set session
$_SESSION['username'] = $email;
$_SESSION['role'] = 'labto';
$_SESSION['user_id'] = $to_id;

// Redirect to dashboard
header("Location: labto_dashboard.php");
exit;
?>
