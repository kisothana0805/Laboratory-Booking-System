<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'labto') {
    header("Location: index.php");
    exit;
}

$query = "SELECT Instruc_ID, Instruc_name, Department, Instruc_Email, Subject_ID FROM instructor";
$instructors = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Instructor Details</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f4f8;
            padding: 40px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background-color: #4ca1af;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

<div class="top-actions">
    <a href="labto_dashboard.php">Back to Dashboard</a>
</div>

<h2>Instructor Details</h2>

<table>
    <tr>
        <th>Instructor ID</th>
        <th>Name</th>
        <th>Department</th>
        <th>Email</th>
        <th>Subject ID</th>
    </tr>
    <?php while ($row = $instructors->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['Instruc_ID']) ?></td>
            <td><?= htmlspecialchars($row['Instruc_name']) ?></td>
            <td><?= htmlspecialchars($row['Department']) ?></td>
            <td><?= htmlspecialchars($row['Instruc_Email']) ?></td>
            <td><?= htmlspecialchars($row['Subject_ID']) ?></td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
