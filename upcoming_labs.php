<?php
include 'db.php';
session_start();

// Ensure only instructors can access
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'instructor') {
    header("Location: index.php");
    exit;
}

$instruc_id = $_SESSION['user_id'];

// Fetch upcoming lab bookings for the instructor
$stmt = $conn->prepare("
    SELECT lb.Booking_ID, lb.Usage_date, lb.Start_time, lb.End_time,
           l.Lab_name, i.Instruc_name, i.Department, i.Subject_ID
    FROM lab_booking lb
    JOIN laboratory l ON lb.Lab_ID = l.Lab_ID
    JOIN instructor i ON lb.Instruc_ID = i.Instruc_ID
    WHERE lb.Instruc_ID = ?
    ORDER BY lb.Usage_date ASC
");
$stmt->bind_param("s", $instruc_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Upcoming Labs</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            padding: 40px;
            background-color: #f4f4f4;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
        }
        th, td {
            padding: 14px 20px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #667eea;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: white;
            background-color: #667eea;
            padding: 10px 20px;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <h2>Upcoming Lab details</h2>
    <table>
        <tr>
            <th>Department</th>
            <th>Subject ID</th>
            <th>Lecturer</th>
            <th>Lab Name</th>
            <th>Schedule Date</th>
            <th>Start Time</th>
            <th>End Time</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['Department']) ?></td>
            <td><?= htmlspecialchars($row['Subject_ID']) ?></td>
            <td><?= htmlspecialchars($row['Instruc_name']) ?></td>
            <td><?= htmlspecialchars($row['Lab_name']) ?></td>
            <td><?= htmlspecialchars($row['Usage_date']) ?></td>
            <td><?= htmlspecialchars($row['Start_time']) ?></td>
            <td><?= htmlspecialchars($row['End_time']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a class="back-btn" href="instructor_dashboard.php">← Back to Dashboard</a>
</body>
</html>
