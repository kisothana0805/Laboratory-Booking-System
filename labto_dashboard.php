<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'labto') {
    header("Location: index.php");
    exit;
}

$name = $_SESSION['user'];
if (!empty($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT TO_name FROM Lab_TO WHERE TO_ID = ?");
    $stmt->bind_param("s", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    if (!empty($result['TO_name'])) {
        $name = $result['TO_name'];
    }
    $stmt->close();
}

$pendingCount = 0;
$result = $conn->query("SELECT COUNT(*) AS total FROM lab_booking WHERE Status = 'Pending'");
if ($row = $result->fetch_assoc()) {
    $pendingCount = $row['total'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lab TO Dashboard</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('imgbg_labto.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.6);
            min-height: 100vh;
        }

        .topbar {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar h2 {
            margin: 0;
            font-size: 22px;
        }

        .topbar a {
            background-color: white;
            color: #333;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .topbar a:hover {
            background-color:rgb(227, 227, 227);
        }

        .container {
            display: flex;
            justify-content: center;
            padding: 80px 20px;
        }

        .grid {
            background: rgb(255, 255, 255);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            display: grid;
            grid-template-columns: repeat(3, 220px);
            gap: 30px;
        }

        .grid a {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 80px;
            background-color: #e0f7fa; /* Light cyan background */
            border: 2px solid #2e8a99;  /* Teal border */
            border-radius: 12px;
            color: #004d40; /* Dark teal text */
            font-weight: bold;
            font-size: 16px;
            text-decoration: none;
            transition: 0.3s;
            position: relative;
        }

        .grid a:hover {
            background-color: #2e8a99;
            color: white;
            transform: scale(1.03);
        }

        .notification {
            position: absolute;
            top: 5px;
            right: 12px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 5px 10px;
            font-size: 13px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="overlay">
    <div class="topbar">
        <h2>WELCOME <?php echo htmlspecialchars($name); ?></h2>
        <a href="logout.php">Logout</a>
    </div>

    <div class="container">
        <div class="grid">
            <a href="index.php">Home</a>
            <a href="lab_details.php">Laboratory Details</a>
            <a href="booking_requests.php">
                Booking Requests
                <?php if ($pendingCount > 0): ?>
                    <span class="notification"><?php echo $pendingCount; ?></span>
                <?php endif; ?>
            </a>
            <a href="instructor_details.php">Instructor Details</a>
            <a href="equipment_checking.php">Equipment Checking</a>
            <a href="lab_usage_log.php">Lab Usage Log</a>
        </div>
    </div>
</div>
</body>
</html>
