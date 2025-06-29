<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'instructor') {
    header("Location: index.php");
    exit;
}

$instructors = $conn->query("SELECT Instruc_ID, Instruc_name FROM instructor");
$labs = $conn->query("SELECT * FROM laboratory");

$successMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $instruc_id = $_POST['instructor'];
    $lab_id = $_POST['lab'];
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $stmt = $conn->prepare("INSERT INTO lab_booking (Instruc_ID, Lab_ID, Usage_date, Start_time, End_time, Status) VALUES (?, ?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("sssss", $instruc_id, $lab_id, $date, $start_time, $end_time);
    if ($stmt->execute()) {
        $successMessage = "Laboratory successfully booked.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Laboratory</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 40px;
        }

        .topbar {
            margin-bottom: 20px;
        }

        .topbar a {
            text-decoration: none;
            background-color: #667eff;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 500;
            display: inline-block;
        }

        .topbar a:hover {
            background-color: #4c65d4;
        }

        .container {
            background-color: white;
            max-width: 600px;
            margin: auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
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
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            margin-top: 30px;
            width: 100%;
            padding: 12px;
            background-color: #667eff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
        }

        button:hover {
            background-color: #4c65d4;
        }

        .success {
            margin-top: 20px;
            color: green;
            font-weight: bold;
            text-align: center;
        }

        .details-box {
            background: #f0f0f0;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 6px;
            margin-top: 10px;
            white-space: pre-line;
        }
    </style>
    <script>
        function updateInstructorName(sel) {
            const name = sel.options[sel.selectedIndex].getAttribute('data-name');
            document.getElementById("instruc_name_display").innerText = name ? 'Name: ' + name : '';
        }

        function updateLabDetails(sel) {
            const id = sel.options[sel.selectedIndex].value;
            const capacity = sel.options[sel.selectedIndex].getAttribute('data-capacity');
            const equipment = sel.options[sel.selectedIndex].getAttribute('data-equipment');
            const location = sel.options[sel.selectedIndex].getAttribute('data-location');

            let details = '';
            if (id) {
                details += 'Capacity: ' + capacity + '\n';
                details += 'Equipment: ' + equipment + '\n';
                details += 'Location: ' + location;
            }
            document.getElementById("lab_details_display").innerText = details;
        }
    </script>
</head>
<body>

<div class="topbar">
    <a href="instructor_dashboard.php">← Back to Dashboard</a>
</div>

<div class="container">
    <h2>Instructor - Book Laboratory</h2>

    <form method="post">
        <label>Instructor</label>
        <select name="instructor" onchange="updateInstructorName(this)" required>
            <option value="">Select Instructor</option>
            <?php while ($row = $instructors->fetch_assoc()): ?>
                <option value="<?= $row['Instruc_ID'] ?>" data-name="<?= htmlspecialchars($row['Instruc_name']) ?>">
                    <?= $row['Instruc_ID'] ?>
                </option>
            <?php endwhile; ?>
        </select>
        <div class="details-box" id="instruc_name_display"></div>

        <label>Laboratory</label>
        <select name="lab" onchange="updateLabDetails(this)" required>
            <option value="">Select Laboratory</option>
            <?php while ($row = $labs->fetch_assoc()): ?>
                <option value="<?= $row['Lab_ID'] ?>"
                        data-capacity="<?= $row['Capacity'] ?>"
                        data-equipment="<?= $row['Availability'] ?>"
                        data-location="<?= $row['Lab_name'] ?>">
                    <?= $row['Lab_name'] ?>
                </option>
            <?php endwhile; ?>
        </select>
        <div class="details-box" id="lab_details_display"></div>

        <label>Date</label>
        <input type="date" name="date" required>

        <label>Start Time</label>
        <input type="time" name="start_time" required>

        <label>End Time</label>
        <input type="time" name="end_time" required>

        <button type="submit">Book Laboratory</button>

        <?php if (!empty($successMessage)): ?>
            <div class="success"><?= $successMessage ?></div>
        <?php endif; ?>
    </form>
</div>
</body>
</html>
