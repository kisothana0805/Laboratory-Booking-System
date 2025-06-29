<?php
include 'db.php';
session_start();

// Fetch list of TOs
$tos = $conn->query("SELECT DISTINCT TO_ID FROM laboratory");

$selectedTo = isset($_POST['to_id']) ? $_POST['to_id'] : null;

$labs = [];
$equipment = [];

if ($selectedTo) {
    // Get labs managed by selected TO
    $stmt = $conn->prepare("SELECT * FROM laboratory WHERE TO_ID = ?");
    $stmt->bind_param("s", $selectedTo);
    $stmt->execute();
    $labsResult = $stmt->get_result();
    while ($row = $labsResult->fetch_assoc()) {
        $labs[] = $row;
    }

    // Get equipment in those labs
    $labIds = array_column($labs, 'Lab_ID');
    if (!empty($labIds)) {
        $inClause = implode("','", $labIds);
        $equipQuery = "SELECT * FROM lab_equipment WHERE Lab_ID IN ('$inClause')";
        $equipment = $conn->query($equipQuery)->fetch_all(MYSQLI_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lab TO - Labs & Equipment</title>
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
            background-color: #637cfb;
            color: white;
            padding: 10px 18px;
            border-radius: 6px;
            font-weight: bold;
        }

        .topbar a:hover {
            background-color: #5164cc;
        }

        .container {
            background-color: white;
            max-width: 900px;
            margin: auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        select, button {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            margin-bottom: 20px;
            border-radius: 6px;
            font-size: 16px;
        }

        button {
            background-color: #637cfb;
            color: white;
            border: none;
            font-weight: bold;
        }

        button:hover {
            background-color: #5164cc;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #637cfb;
            color: white;
        }

        .section-title {
            margin-top: 40px;
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>

<div class="topbar">
    <a href="instructor_dashboard.php">← Back to Dashboard</a>
</div>

<div class="container">
    <h2>Lab TO - Labs & Equipment</h2>

    <form method="post">
        <label>Select TO</label>
        <select name="to_id" required>
            <option value="">Select TO</option>
            <?php while ($row = $tos->fetch_assoc()): ?>
                <option value="<?= $row['TO_ID'] ?>" <?= ($selectedTo == $row['TO_ID']) ? 'selected' : '' ?>>
                    <?= $row['TO_ID'] ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit">View</button>
    </form>

    <?php if ($selectedTo): ?>
        <div class="section-title">Labs Managed</div>
        <table>
            <tr>
                <th>Lab ID</th>
                <th>Name</th>
                <th>Capacity</th>
                <th>Availability</th>
            </tr>
            <?php foreach ($labs as $lab): ?>
                <tr>
                    <td><?= $lab['Lab_ID'] ?></td>
                    <td><?= $lab['Lab_name'] ?></td>
                    <td><?= $lab['Capacity'] ?></td>
                    <td><?= $lab['Availability'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="section-title">Equipment Managed</div>
        <table>
            <tr>
                <th>Equipment ID</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Lab ID</th>
                <th>Available</th>
            </tr>
            <?php foreach ($equipment as $equip): ?>
                <tr>
                    <td><?= $equip['Equip_ID'] ?></td>
                    <td><?= $equip['Equip_name'] ?></td>
                    <td><?= $equip['Quantity'] ?></td>
                    <td><?= $equip['Lab_ID'] ?></td>
                    <td><?= $equip['Available'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
