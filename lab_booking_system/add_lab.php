<?php
// --- add_lab.php ---
include 'db.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'labto') {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lab_id = $_POST['lab_id'];
    $lab_name = $_POST['lab_name'];
    $capacity = $_POST['capacity'];
    $location = $_POST['location'];
    $to_id = $_SESSION['user_id'];

    $conn->query("INSERT INTO laboratory (Lab_ID, Lab_name, Capacity, TO_ID) VALUES ('$lab_id', '$lab_name', '$capacity', '$to_id')");
    $conn->query("INSERT INTO laboratory_location (Lab_ID, Location) VALUES ('$lab_id', '$location')");
    header("Location: lab_details.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Laboratory</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f8ff;
            padding: 40px;
        }
        .form-box {
            background: white;
            max-width: 500px;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            background-color: #4ca1af;
            color: white;
            padding: 10px 18px;
            text-decoration: none;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn:hover {
            background-color: #007b8a;
        }
        .top-actions {
            text-align: right;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="top-actions">
        <a href="lab_details.php" class="btn">Back to Laboratory Details</a>
    </div>
    <div class="form-box">
        <h2>Add New Laboratory</h2>
        <form method="POST">
            <label>Lab ID:</label>
            <input type="text" name="lab_id" required>
            <label>Lab Name:</label>
            <input type="text" name="lab_name" required>
            <label>Capacity:</label>
            <input type="number" name="capacity" required>
            <label>Location:</label>
            <input type="text" name="location" required>
            <button type="submit" class="btn">Add Lab</button>
        </form>
    </div>
</body>
</html>

<!-- Repeat a similar layout in edit_lab.php with prefilled values -->
