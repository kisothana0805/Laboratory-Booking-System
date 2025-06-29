<?php
include 'db.php';
session_start();

// Session check for instructor
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'instructor') {
    header("Location: index.php");
    exit;
}

// Fetch instructor name
$name = $_SESSION['user']; // fallback
if (!empty($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT Instruc_name FROM Instructor WHERE Instruc_ID = ?");
    if ($stmt) {
        $stmt->bind_param("s", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!empty($result['Instruc_name'])) {
            $name = $result['Instruc_name'];
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Instructor Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background: url('portrait-engineers-work-hours-job-site.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.6); /* darken for readability */
            min-height: 100vh;
            padding: 0;
            margin: 0;
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
            background-color: #e3e3e3;
        }

        .container {
            display: flex;
            justify-content: center;
            padding: 80px 20px;
        }

        .grid {
            background: rgba(255, 255, 255, 0.9);
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
            background-color: #cfe0fc;
            border: 2px solid #3a68d8;
            border-radius: 12px;
            color: #1a1a1a;
            font-weight: bold;
            font-size: 16px;
            text-decoration: none;
            transition: 0.3s;
        }

        .grid a:hover {
            background-color: #3a68d8;
            color: white;
            transform: scale(1.03);
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
            <a href="laboratory_booking.php">Laboratory Booking</a>
            <a href="upcoming_labs.php">Upcoming Lab Details</a>
            <a href="lab_to_info.php">Lab TO – Labs & Equipment</a>
            <a href="manage.php">Manage</a>
            <a href="labusage_log.php">Laboratory Usage Log</a>
        </div>
    </div>
</div>
</body>
</html>
