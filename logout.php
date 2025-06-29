<?php
session_start();

// Store the role before destroying session
$redirectPage = "index.php"; // fallback
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'instructor') {
        $redirectPage = "instructor_auth.php";
    } elseif ($_SESSION['role'] === 'labto') {
        $redirectPage = "labto_auth.php";
    }
}

// Clear session and cookies
session_unset();
session_destroy();

if (isset($_COOKIE['remember_me'])) {
    setcookie('remember_me', '', time() - 3600, "/");
}

// Redirect based on role
header("Location: $redirectPage");
exit;
?>
