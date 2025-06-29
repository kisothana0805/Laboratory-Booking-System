<?php
include 'db.php';
session_start();

$name = $_POST['Instruc_name'];
$email = $_POST['Instruc_Email'];
$password = $_POST['password'];
$department = "Computer Department"; // You can later add this to the form

// Optional fields (for now set to NULL or leave empty if unknown)
$to_id = null;
$lecturer_id = null;
$subject_id = null;

// Validate email
if (strpos($email, 'inst') === false) {
    header("Location: instructor_auth.php?error=Email must contain 'inst'");
    exit;
}

// Validate password length
if (strlen($password) < 6) {
    header("Location: instructor_auth.php?error=Password must be at least 6 characters");
    exit;
}

// Check if user already exists
$check = $conn->prepare("SELECT id FROM users WHERE username = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    header("Location: instructor_auth.php?error=Account already exists. Please login.");
    exit;
}

// Generate unique Instructor ID
$instruc_id = uniqid("INS");

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert into users table
$stmt1 = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt1->bind_param("ss", $email, $hashed_password);
$stmt1->execute();

// Insert into Instructor table
$stmt2 = $conn->prepare("INSERT INTO Instructor (Instruc_ID, Instruc_name, Instruc_Email, Department, TO_ID, Lecturer_ID, Subject_ID) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt2->bind_param("sssssss", $instruc_id, $name, $email, $department, $to_id, $lecturer_id, $subject_id);
$stmt2->execute();

// Set session
$_SESSION['username'] = $email;
$_SESSION['role'] = 'instructor';
$_SESSION['user_id'] = $instruc_id;

// Redirect to dashboard
header("Location: instructor_dashboard.php");
exit;
?>
