<?php
include 'db.php';
session_start();

// Fetch labs for dropdown
$labs = $conn->query("SELECT Lab_ID, Lab_name FROM laboratory");

// Handle filtering
$filter = "";
if (!empty($_GET['lab_id'])) {
    $lab_id = $_GET['lab_id'];
    $filter = "WHERE le.Lab_ID = '$lab_id'";
}

// Final query
$sql = "
SELECT 
    le.Equip_ID,
    le.Equip_name,
    le.Quantity,
    le.Lab_ID,
    l.Lab_name,
    le.Available
FROM lab_equipment le
LEFT JOIN laboratory l ON le.Lab_ID = l.Lab_ID
$filter
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Equipment Checking</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #e0f7fa;
            padding: 40px;
        }
        h2 {
            text-align: center;
        }
        form {
            text-align: center;
            margin-bottom: 20px;
        }
        select, input[type="text"], input[type="number"] {
            padding: 8px;
            font-size: 16px;
            margin: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
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
        .add-form {
            margin-top: 30px;
            text-align: center;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .add-form h3 {
            margin-bottom: 10px;
        }
        .add-form input[type="submit"] {
            background-color: #4ca1af;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .add-form input[type="submit"]:hover {
            background-color: #007b8a;
        }
        .back-btn {
            text-align: right;
            margin-bottom: 20px;
        }
        .back-btn a {
            padding: 10px 18px;
            background-color: #4ca1af;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }
        .back-btn a:hover {
            background-color: #007b8a;
        }
    </style>
</head>
<body>
    <div class="back-btn">
        <a href="labto_dashboard.php">Back to Dashboard</a>
    </div>

    <h2>Equipment Checking - Availability Status</h2>

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
            <th>Equipment ID</th>
            <th>Equipment Name</th>
            <th>Quantity</th>
            <th>Lab ID</th>
            <th>Lab Name</th>
            <th>Available</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['Equip_ID']) ?></td>
                <td><?= htmlspecialchars($row['Equip_name']) ?></td>
                <td><?= htmlspecialchars($row['Quantity']) ?></td>
                <td><?= htmlspecialchars($row['Lab_ID']) ?></td>
                <td><?= htmlspecialchars($row['Lab_name']) ?></td>
                <td><?= htmlspecialchars($row['Available'] ?? 'Unknown') ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <div class="add-form">
        <h3>Add New Equipment</h3>
        <form method="post" action="add_equipment.php">
            <input type="text" name="equip_id" placeholder="Equipment ID" required>
            <input type="text" name="equip_name" placeholder="Equipment Name" required>
            <input type="number" name="quantity" placeholder="Quantity" required>
            <select name="lab_id" required>
                <option value="">Select Lab</option>
                <?php
                $labs = $conn->query("SELECT Lab_ID, Lab_name FROM laboratory");
                while ($lab = $labs->fetch_assoc()): ?>
                    <option value="<?= $lab['Lab_ID'] ?>"><?= $lab['Lab_name'] ?> (<?= $lab['Lab_ID'] ?>)</option>
                <?php endwhile; ?>
            </select>
            <select name="available" required>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
            <br><br>
            <input type="submit" value="Add Equipment">
        </form>
    </div>
</body>
</html>
