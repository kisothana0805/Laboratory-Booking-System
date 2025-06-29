<?php
include 'db.php';
session_start();

// Ensure only instructor access
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'instructor') {
    header("Location: index.php");
    exit;
}

// Get all lab names for the dropdown
$labList = $conn->query("SELECT Lab_ID, Lab_name FROM laboratory");

$usageLogs = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['lab_id'])) {
    $lab_id = $_POST['lab_id'];
    $stmt = $conn->prepare("
        SELECT l.Log_ID, l.TO_ID, l.Instruc_ID, l.Lab_ID, lab.Lab_name, l.Usage_date, l.Start_time, l.End_time
        FROM lab_usage_log l
        JOIN laboratory lab ON l.Lab_ID = lab.Lab_ID
        WHERE l.Lab_ID = ?
    ");
    $stmt->bind_param("s", $lab_id);
    $stmt->execute();
    $usageLogs = $stmt->get_result();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laboratory Usage Log</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
            padding: 40px;
        }

        .topbar {
            margin-bottom: 20px;
        }

        .topbar a {
            text-decoration: none;
            background-color: #637bff;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: bold;
        }

        .topbar a:hover {
            background-color: #495edb;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        form {
            max-width: 500px;
            margin: auto;
            display: flex;
            gap: 10px;
        }

        select {
            flex: 1;
            padding: 10px;
            border-radius: 6px;
        }

        button {
            background-color: #637bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #637bff;
            color: white;
        }
    </style>
</head>
<body>

<div class="topbar">
    <a href="instructor_dashboard.php">← Back to Dashboard</a>
</div>

<h2>Laboratory Usage Log</h2>

<form method="post">
    <select name="lab_id" required>
        <option value="">Select Lab</option>
        <?php while ($row = $labList->fetch_assoc()): ?>
            <option value="<?= $row['Lab_ID'] ?>" <?= (isset($_POST['lab_id']) && $_POST['lab_id'] == $row['Lab_ID']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($row['Lab_name']) ?>
            </option>
        <?php endwhile; ?>
    </select>
    <button type="submit">View</button>
</form>

<?php if (!empty($usageLogs) && $usageLogs->num_rows > 0): ?>
    <table>
        <tr>
            <th>Log ID</th>
            <th>Lab TO ID</th>
            <th>Instructor ID</th>
            <th>Lab ID</th>
            <th>Lab Name</th>
            <th>Usage Date</th>
            <th>Start Time</th>
            <th>End Time</th>
        </tr>
        <?php while ($row = $usageLogs->fetch_assoc()): ?>
            <tr>
                <td><?= $row['Log_ID'] ?></td>
                <td><?= $row['TO_ID'] ?></td>
                <td><?= $row['Instruc_ID'] ?></td>
                <td><?= $row['Lab_ID'] ?></td>
                <td><?= $row['Lab_name'] ?></td>
                <td><?= $row['Usage_date'] ?></td>
                <td><?= $row['Start_time'] ?></td>
                <td><?= $row['End_time'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <p style="text-align:center; color: red;">No usage logs found for this lab.</p>
<?php endif; ?>

</body>
</html>
