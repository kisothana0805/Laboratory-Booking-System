<?php
include 'db.php';
session_start();

// Fetch labs for dropdown
$labs = $conn->query("SELECT Lab_ID, Lab_name FROM laboratory");

// Handle filter
$filter = "";
if (!empty($_GET['lab_id'])) {
    $lab_id = $_GET['lab_id'];
    $filter = "WHERE lul.Lab_ID = '$lab_id'";
}

// Usage log query
$sql = "
SELECT 
    lul.Log_ID,
    lul.TO_ID,
    lul.Instruc_ID,
    lul.Lab_ID,
    l.Lab_name,
    lul.Usage_date,
    lul.Start_time,
    lul.End_time
FROM lab_usage_log lul
JOIN laboratory l ON lul.Lab_ID = l.Lab_ID
$filter
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lab Usage Log</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #dff6f9;
            padding: 40px;
        }
        .top-bar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }
        .back-btn {
            padding: 10px 18px;
            background-color: #4ca1af;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }
        .back-btn:hover {
            background-color: #2c3e50;
        }
        h2 {
            text-align: center;
        }
        form {
            text-align: center;
            margin-bottom: 20px;
        }
        select {
            padding: 8px;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #b0bec5;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #4ca1af;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f1f1f1;
        }
        .bottom-button {
            margin-top: 30px;
            text-align: center;
        }
        .bottom-button a {
            padding: 12px 20px;
            background-color: #4ca1af;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }
        .bottom-button a:hover {
            background-color: #2c3e50;
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <a href="labto_dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>

    <h2>Lab Usage Log</h2>

    <form method="get">
        <label for="lab_id">Filter by Lab:</label>
        <select name="lab_id" onchange="this.form.submit()">
            <option value="">-- All Labs --</option>
            <?php while($lab = $labs->fetch_assoc()): ?>
                <option value="<?= $lab['Lab_ID'] ?>" <?= (isset($lab_id) && $lab_id == $lab['Lab_ID']) ? 'selected' : '' ?>>
                    <?= $lab['Lab_name'] ?> (<?= $lab['Lab_ID'] ?>)
                </option>
            <?php endwhile; ?>
        </select>
    </form>

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
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['Log_ID']) ?></td>
                <td><?= htmlspecialchars($row['TO_ID']) ?></td>
                <td><?= htmlspecialchars($row['Instruc_ID']) ?></td>
                <td><?= htmlspecialchars($row['Lab_ID']) ?></td>
                <td><?= htmlspecialchars($row['Lab_name']) ?></td>
                <td><?= htmlspecialchars($row['Usage_date']) ?></td>
                <td><?= htmlspecialchars($row['Start_time']) ?></td>
                <td><?= htmlspecialchars($row['End_time']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <div class="bottom-button">
        <a href="add_usage_log.php">Add Usage Entry</a>
    </div>
</body>
</html>
