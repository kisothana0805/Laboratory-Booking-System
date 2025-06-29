<?php

session_start();

if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'instructor') {
        header("Location: instructor_dashboard.php");
        exit();
    } elseif ($_SESSION['role'] === 'labto') {
        header("Location: labto_dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laboratory Booking System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Mobile-friendly -->
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: url('research-innovation-items-world-science-day-celebration.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: white;
        }
        .overlay {
            background-color: rgba(0, 0, 0, 0.6);
            min-height: 100vh;
            padding: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header img {
            height: 80px;
        }
        .title {
            font-size: 36px;
            font-weight: bold;
            margin-top: 10px;
        }
        .subtitle {
            font-size: 20px;
        }
        .signup-section {
            background-color: rgba(255, 255, 255, 0.9);
            color: black;
            max-width: 400px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        .signup-section h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .signup-buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .signup-buttons a {
            background-color: #007BFF;
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            transition: background-color 0.3s;
        }
        .signup-buttons a:hover {
            background-color: #0056b3;
        }
        @media (max-width: 600px) {
            .title {
                font-size: 28px;
            }
            .subtitle {
                font-size: 16px;
            }
            .signup-section {
                padding: 20px;
                max-width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="overlay">
        <div class="header">
            <img src="university-logo.png" alt="University of Jaffna Logo">
            <div class="title">LABORATORY BOOKING SYSTEM</div>
            <div class="subtitle">FACULTY OF ENGINEERING, UNIVERSITY OF JAFFNA</div>
        </div>

        <div class="signup-section">
            <h2>Sign Up / Login here!</h2>
            <div class="signup-buttons">
                <a href="instructor_auth.php">Instructor</a>
                <a href="labto_auth.php">Laboratory Technical Officer</a>
            </div>
        </div>
    </div>
</body>
</html>
