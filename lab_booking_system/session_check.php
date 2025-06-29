<?php
session_start();
include 'db.php'; // Ensure DB is included only once if needed

// If user is already logged in, do not redirect again
if (isset($_SESSION['user']) && isset($_SESSION['role'])) {
    return; // Valid session, allow access
}

// Handle "remember me" token
if (isset($_COOKIE['remember_me'])) {
    $token = $_COOKIE['remember_me'];

    $stmt = $conn->prepare("SELECT user_id FROM user_tokens WHERE token = ? AND expires_at > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $user_id = $row['user_id'];

        // Get username and role from users table
        $stmt2 = $conn->prepare("SELECT username FROM users WHERE id = ?");
        $stmt2->bind_param("i", $user_id);
        $stmt2->execute();
        $userResult = $stmt2->get_result();

        if ($user = $userResult->fetch_assoc()) {
            $_SESSION['user'] = $user['username'];

            // Retrieve role from Instructor or Lab_TO table
            $checkInstructor = $conn->prepare("SELECT Instruc_ID FROM Instructor WHERE Instruc_Email = ?");
            $checkInstructor->bind_param("s", $_SESSION['user']);
            $checkInstructor->execute();
            $checkInstructor->store_result();

            if ($checkInstructor->num_rows > 0) {
                $_SESSION['role'] = 'instructor';
                $checkInstructor->bind_result($instruc_id);
                $checkInstructor->fetch();
                $_SESSION['user_id'] = $instruc_id;
            } else {
                $checkLabTo = $conn->prepare("SELECT TO_ID FROM Lab_TO WHERE TO_Email = ?");
                $checkLabTo->bind_param("s", $_SESSION['user']);
                $checkLabTo->execute();
                $checkLabTo->store_result();

                if ($checkLabTo->num_rows > 0) {
                    $_SESSION['role'] = 'labto';
                    $checkLabTo->bind_result($to_id);
                    $checkLabTo->fetch();
                    $_SESSION['user_id'] = $to_id;
                } else {
                    // Could not determine role; force login
                    header("Location: index.php");
                    exit;
                }
            }
            return;
        }
    }
}

// Still no session or valid cookie? Redirect to login page (index.php)
header("Location: index.php");
exit;
