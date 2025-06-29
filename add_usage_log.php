<?php
include 'db.php';
session_start();

// Ensure the user is a Lab TO and is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'labto') {
    header("Location: index.php");
    exit;
}

$to_id = $_SESSION['user_id'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $log_id = $_POST['log_id'];
    $lab_id = $_POST['lab_id'];
    $instructor_id = $_POST['instructor_id'];
    $usage_date = $_POST['usage_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $stmt = $conn->prepare("INSERT INTO lab_usage_log (Log_ID, Lab_ID, Usage_date, Start_time, End_time, Instruc_ID, TO_ID) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $log_id, $lab_id, $usage_date, $start_time, $end_time, $instructor_id, $to_id);

    if ($stmt->execute()) {
        header("Location: lab_usage_log.php?message=Entry added successfully");
        exit;
    } else {
        $error = "Failed to add usage entry: " . $stmt->error;
    }
}

// Fetch lab list
$lab_query = $conn->query("SELECT Lab_ID, Lab_name FROM laboratory");

// Fetch instructor list
$instructor_query = $conn->query("SELECT Instruc_ID, Instruc_Name FROM instructor");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Lab Usage Entry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f7fa;
            padding: 40px;
        }
        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #007b8a;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 12px;
            font-weight: bold;
        }
        input, select {
            padding: 8px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .submit-btn {
            margin-top: 20px;
            background-color: #4ca1af;
            color: white;
            border: none;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 6px;
        }
        .submit-btn:hover {
            background-color: #2c3e50;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Add Lab Usage Entry</h2>
    <?php if (isset($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="log_id">Log ID:</label>
        <input type="text" name="log_id" required>

        <label for="lab_id">Select Lab:</label>
        <select name="lab_id" required>
            <option value="">-- Select Lab --</option>
            <?php while($lab = $lab_query->fetch_assoc()): ?>
                <option value="<?= $lab['Lab_ID'] ?>"><?= $lab['Lab_name'] ?> (<?= $lab['Lab_ID'] ?>)</option>
            <?php endwhile; ?>
        </select>

        <label for="instructor_id">Select Instructor:</label>
        <select name="instructor_id" required>
            <option value="">-- Select Instructor --</option>
            <?php while($inst = $instructor_query->fetch_assoc()): ?>
                <option value="<?= $inst['Instruc_ID'] ?>"><?= $inst['Instruc_Name'] ?> (<?= $inst['Instruc_ID'] ?>)</option>
            <?php endwhile; ?>
        </select>

        <label for="usage_date">Usage Date:</label>
        <input type="date" name="usage_date" required>

        <label for="start_time">Start Time:</label>
        <input type="time" name="start_time" required>

        <label for="end_time">End Time:</label>
        <input type="time" name="end_time" required>

        <button class="submit-btn" type="submit">Add Usage Entry</button>
    </form>
    <div class="back-link">
        <a href="lab_usage_log.php">← Back to Usage Log</a>
    </div>
</div>
</body>
</html>
