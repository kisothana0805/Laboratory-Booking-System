<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['Instruc_Email'];
    $password = $_POST['password'];

    // 1. Fetch user from `users` table
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // 2. Verify password
        if (password_verify($password, $user['password'])) {
            // 3. Fetch Instructor ID from instructor table
            $stmt2 = $conn->prepare("SELECT Instruc_ID FROM Instructor WHERE Instruc_Email = ?");
            $stmt2->bind_param("s", $email);
            $stmt2->execute();
            $result2 = $stmt2->get_result();

            if ($instruc = $result2->fetch_assoc()) {
                $_SESSION['user'] = $email;
                $_SESSION['user_id'] = $instruc['Instruc_ID'];
                $_SESSION['role'] = 'instructor'; // Important for role check

                // 4. Remember me option
                if (!empty($_POST['remember_me'])) {
                    $token = bin2hex(random_bytes(32));
                    $expires = date('Y-m-d H:i:s', strtotime('+7 days'));

                    $stmt3 = $conn->prepare("INSERT INTO user_tokens (user_id, token, expires_at) VALUES (?, ?, ?)");
                    $stmt3->bind_param("iss", $user['id'], $token, $expires);
                    $stmt3->execute();

                    setcookie("remember_me", $token, time() + (86400 * 7), "/");
                }

                // 5. Redirect to dashboard
                header("Location: instructor_dashboard.php");
                exit;
            } else {
                header("Location: instructor_auth.php?error=Instructor record not found");
                exit;
            }
        }
    }

    // 6. Login failed
    header("Location: instructor_auth.php?error=Invalid email or password");
    exit;
}
?>
