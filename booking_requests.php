<?php 
include 'db.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'labto') {
    header("Location: index.php");
    exit;
}

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'], $_POST['status'])) {
    $booking_id = $_POST['booking_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE lab_booking SET Status = ? WHERE Booking_ID = ?");
    $stmt->bind_param("si", $status, $booking_id);
    $stmt->execute();
    $stmt->close();
}

// Fetch bookings
$sql = "
SELECT b.Booking_ID, b.Usage_date, b.Start_time, b.End_time, b.Status,
       i.Instruc_name, l.Lab_name
FROM lab_booking b
JOIN instructor i ON b.Instruc_ID = i.Instruc_ID
JOIN laboratory l ON b.Lab_ID = l.Lab_ID
ORDER BY b.Usage_date DESC
";
$bookings = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking Requests</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #e0f7fa;
            padding: 40px;
            margin: 0;
        }
        .top-actions {
            text-align: right;
            margin-bottom: 20px;
        }
        .top-actions a {
            background-color: #4ca1af;
            color: white;
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 6px;
        }
        .top-actions a:hover {
            background-color: #007b8a;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            border: 1px solid #b0bec5;
            text-align: center;
        }
        th {
            background-color: #4ca1af;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f1f1f1;
        }
        form {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        select {
            padding: 6px 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            background-color: rgb(20, 112, 241);
            color: white;
            font-weight: bold;
            border: none;
            padding: 7px 12px;
            margin-left: 6px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #3b8990;
        }
    </style>
</head>
<body>

    <div class="top-actions">
        <a href="labto_dashboard.php">Back to Dashboard</a>
    </div>

    <h2>Booking Requests</h2>

    <table>
        <tr>
            <th>Booking ID</th>
            <th>Lab Name</th>
            <th>Instructor</th>
            <th>Date</th>
            <th>Start</th>
            <th>End</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $bookings->fetch_assoc()): ?>
        <tr>
            <td><?= $row['Booking_ID'] ?></td>
            <td><?= htmlspecialchars($row['Lab_name']) ?></td>
            <td><?= htmlspecialchars($row['Instruc_name']) ?></td>
            <td><?= $row['Usage_date'] ?></td>
            <td><?= $row['Start_time'] ?></td>
            <td><?= $row['End_time'] ?></td>
            <td><?= $row['Status'] ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="booking_id" value="<?= $row['Booking_ID'] ?>">
                    <select name="status">
                        <option value="Pending" <?= $row['Status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="Approved" <?= $row['Status'] === 'Approved' ? 'selected' : '' ?>>Approved</option>
                        <option value="Rejected" <?= $row['Status'] === 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                    </select>
                    <button type="submit">Update</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
