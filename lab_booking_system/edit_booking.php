<?php
include 'db.php';
session_start();

// Ensure only instructors can access
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'instructor') {
    header("Location: index.php");
    exit;
}

$instruc_id = $_SESSION['user_id'];
$booking_id = $_GET['id'] ?? '';

if (!$booking_id) {
    echo "Booking ID missing.";
    exit;
}

// Fetch current booking details
$stmt = $conn->prepare("SELECT * FROM lab_booking WHERE Booking_ID = ? AND Instruc_ID = ?");
$stmt->bind_param("ss", $booking_id, $instruc_id);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$booking) {
    echo "Booking not found or access denied.";
    exit;
}

// Fetch labs
$labs = $conn->query("SELECT * FROM laboratory");

// Update booking if form is submitted
$successMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lab_id = $_POST['lab'];
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $stmt = $conn->prepare("UPDATE lab_booking SET Lab_ID = ?, Usage_date = ?, Start_time = ?, End_time = ? WHERE Booking_ID = ? AND Instruc_ID = ?");
    $stmt->bind_param("ssssss", $lab_id, $date, $start_time, $end_time, $booking_id, $instruc_id);
    if ($stmt->execute()) {
        $successMessage = "Booking updated successfully.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Booking</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            padding: 40px;
        }
        .container {
            background-color: white;
            max-width: 600px;
            margin: auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        label {
            display: block;
            margin-top: 20px;
        }
        select, input[type="date"], input[type="time"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            margin-top: 30px;
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
        }
        .success {
            color: green;
            text-align: center;
            margin-top: 20px;
        }
        .top-link {
            margin-bottom: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <a class="top-link" href="manage.php">&larr; Back to Manage Lab Bookings</a>
        <h2>Edit Booking</h2>

        <form method="post">
            <label>Laboratory</label>
            <select name="lab" required>
                <option value="">Select Laboratory</option>
                <?php while ($lab = $labs->fetch_assoc()): ?>
                    <option value="<?= $lab['Lab_ID'] ?>" <?= $lab['Lab_ID'] == $booking['Lab_ID'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($lab['Lab_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label>Date</label>
            <input type="date" name="date" value="<?= $booking['Usage_date'] ?>" required>

            <label>Start Time</label>
            <input type="time" name="start_time" value="<?= $booking['Start_time'] ?>" required>

            <label>End Time</label>
            <input type="time" name="end_time" value="<?= $booking['End_time'] ?>" required>

            <button type="submit">Update Booking</button>
            <?php if ($successMessage): ?>
                <div class="success"><?= $successMessage ?></div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
