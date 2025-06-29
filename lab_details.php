<?php
include 'db.php';
session_start();

// Ensure only Lab TO can access
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'labto') {
    header("Location: index.php");
    exit;
}

// Fetch all laboratories with Lab TO name and Location
$labs = $conn->query("
    SELECT l.*, t.TO_name, loc.Location 
    FROM laboratory l 
    LEFT JOIN lab_to t ON l.TO_ID = t.TO_ID 
    LEFT JOIN laboratory_location loc ON l.Lab_ID = loc.Lab_ID
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laboratory Details</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #e0f7fa;
            padding: 40px;
        }
        h2 {
            text-align: center;
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
            border: 1px solid #b0bec5;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #4ca1af;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f1f1f1;
        }
        .action-btns a {
            margin: 0 5px;
            padding: 6px 12px;
            background-color: #039be5;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .action-btns a.delete {
            background-color: #e53935;
        }
        .bottom-button {
            text-align: center;
            margin-top: 30px;
        }
        .bottom-button a {
            background-color: #4ca1af;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 8px;
        }
        .bottom-button a:hover {
            background-color: #007b8a;
        }
    </style>
</head>
<body>
    <div class="top-actions">
        <a href="labto_dashboard.php">Back to Dashboard</a>
    </div>

    <h2>Laboratory Details</h2>

    <table>
        <tr>
            <th>Lab ID</th>
            <th>Lab Name</th>
            <th>Capacity</th>
            <th>Managed By (Lab TO)</th>
            <th>Location</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $labs->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['Lab_ID']) ?></td>
                <td><?= htmlspecialchars($row['Lab_name']) ?></td>
                <td><?= htmlspecialchars($row['Capacity']) ?></td>
                <td><?= htmlspecialchars($row['TO_name'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($row['Location'] ?? 'Not Set') ?></td>
                <td class="action-btns">
                    <a href="edit_lab.php?id=<?= urlencode($row['Lab_ID']) ?>">Edit</a>
                    <a href="delete_lab.php?id=<?= urlencode($row['Lab_ID']) ?>" class="delete" onclick="return confirm('Are you sure you want to delete this lab?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <div class="bottom-button">
        <a href="add_lab.php">+ Add New Lab</a>
    </div>
</body>
</html>
