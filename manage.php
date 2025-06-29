<?php
include 'db.php';
session_start();

// Ensure only instructors access
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'instructor') {
    header("Location: index.php");
    exit;
}

$instruc_id = $_SESSION['user_id'];

// Handle delete
if (isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM lab_booking WHERE Booking_ID = ? AND Instruc_ID = ?");
    $stmt->bind_param("ss", $deleteId, $instruc_id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage.php");
    exit;
}

// Fetch bookings for the logged-in instructor
$query = $conn->prepare("SELECT lb.Booking_ID, l.Lab_name, lb.Usage_date, lb.Start_time, lb.End_time, lb.Status
                        FROM lab_booking lb
                        JOIN laboratory l ON lb.Lab_ID = l.Lab_ID
                        WHERE lb.Instruc_ID = ?
                        ORDER BY lb.Usage_date, lb.Start_time");
$query->bind_param("s", $instruc_id);
$query->execute();
$result = $query->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Bookings</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f7f9fb;
            padding: 40px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 16px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #6c83ff;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .action-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }
        .edit {
            background-color: #ff40aa;
            color: white;
        }
        .delete {
            background-color: #00b7dd;
            color: white;
        }
        .back-btn {
            display: inline-block;
            margin-top: 25px;
            background-color: #6c83ff;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Manage Lab Bookings</h2>

    <table>
        <tr>
            <th>Lab Name</th>
            <th>Schedule Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['Lab_name']) ?></td>
                <td><?= $row['Usage_date'] ?></td>
                <td><?= $row['Start_time'] ?></td>
                <td><?= $row['End_time'] ?></td>
                <td><?= $row['Status'] ?></td>
                <td>
                    <a class="action-btn edit" href="edit_booking.php?id=<?= $row['Booking_ID'] ?>">Edit</a>
                    <a class="action-btn delete" href="manage.php?delete=<?= $row['Booking_ID'] ?>" onclick="return confirm('Are you sure you want to delete this booking?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <a class="back-btn" href="instructor_dashboard.php">← Back to Dashboard</a>
</body>
</html>
