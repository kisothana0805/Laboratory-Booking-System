<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['TO_Email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            // ✅ Set session
            $_SESSION['user'] = $email;
            $_SESSION['role'] = 'labto';

            // Optionally fetch TO_ID from Lab_TO table
            $stmt2 = $conn->prepare("SELECT TO_ID FROM Lab_TO WHERE TO_Email = ?");
            $stmt2->bind_param("s", $email);
            $stmt2->execute();
            $res2 = $stmt2->get_result();
            if ($row2 = $res2->fetch_assoc()) {
                $_SESSION['user_id'] = $row2['TO_ID'];
            }

            // ✅ Handle "Remember Me"
            if (!empty($_POST['remember_me'])) {
                $token = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', strtotime('+7 days'));
                $stmt3 = $conn->prepare("INSERT INTO user_tokens (user_id, token, expires_at) VALUES (?, ?, ?)");
                $stmt3->bind_param("iss", $user['id'], $token, $expires);
                $stmt3->execute();
                setcookie('remember_me', $token, time() + (86400 * 7), "/");
            }

            // ✅ Redirect to dashboard
            header("Location: labto_dashboard.php");
            exit;
        }
    }

    // ❌ Invalid login
    header("Location: labto_auth.php?error=Invalid credentials");
    exit;
}
?>
