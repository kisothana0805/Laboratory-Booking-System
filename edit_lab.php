<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'labto') {
    header("Location: index.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: lab_details.php");
    exit;
}

$lab_id = $_GET['id'];

// Fetch lab and location details
$query = "SELECT l.Lab_ID, l.Lab_name, l.Capacity, ll.Location FROM laboratory l LEFT JOIN laboratory_location ll ON l.Lab_ID = ll.Lab_ID WHERE l.Lab_ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $lab_id);
$stmt->execute();
$result = $stmt->get_result();
$lab = $result->fetch_assoc();
$stmt->close();

if (!$lab) {
    echo "Lab not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $capacity = $_POST['capacity'];
    $location = $_POST['location'];

    // Update laboratory
    $update_lab = $conn->prepare("UPDATE laboratory SET Lab_name = ?, Capacity = ? WHERE Lab_ID = ?");
    $update_lab->bind_param("sis", $name, $capacity, $lab_id);
    $update_lab->execute();

    // Update or insert location
    $check_location = $conn->prepare("SELECT * FROM laboratory_location WHERE Lab_ID = ?");
    $check_location->bind_param("s", $lab_id);
    $check_location->execute();
    $check_location_result = $check_location->get_result();

    if ($check_location_result->num_rows > 0) {
        $update_location = $conn->prepare("UPDATE laboratory_location SET Location = ? WHERE Lab_ID = ?");
        $update_location->bind_param("ss", $location, $lab_id);
        $update_location->execute();
    } else {
        $insert_location = $conn->prepare("INSERT INTO laboratory_location (Lab_ID, Location) VALUES (?, ?)");
        $insert_location->bind_param("ss", $lab_id, $location);
        $insert_location->execute();
    }

    header("Location: lab_details.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Laboratory</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f2f9fb;
            padding: 40px;
        }
        .form-container {
            max-width: 500px;
            margin: auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #2c7da0;
        }
        label {
            display: block;
            margin-top: 20px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            margin-top: 25px;
            width: 100%;
            padding: 12px;
            background-color: #2c7da0;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        button:hover {
            background-color: #155d74;
        }
        .back {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #2c7da0;
            font-weight: bold;
        }
        .back:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Laboratory</h2>
        <form method="POST">
            <label>Lab Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($lab['Lab_name']) ?>" required>

            <label>Capacity:</label>
            <input type="number" name="capacity" value="<?= htmlspecialchars($lab['Capacity']) ?>" required>

            <label>Location:</label>
            <input type="text" name="location" value="<?= htmlspecialchars($lab['Location']) ?>" required>

            <button type="submit">Update Lab</button>
        </form>
        <a href="lab_details.php" class="back">Back to Laboratory Details</a>
    </div>
</body>
</html>
