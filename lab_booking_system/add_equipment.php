<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equip_id = $_POST['equip_id'];
    $equip_name = $_POST['equip_name'];
    $quantity = $_POST['quantity'];
    $lab_id = $_POST['lab_id'];
    $available = $_POST['available'];

    // Insert into lab_equipment table (which now includes 'Available')
    $stmt = $conn->prepare("INSERT INTO lab_equipment (Equip_ID, Equip_name, Quantity, Lab_ID, Available) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $equip_id, $equip_name, $quantity, $lab_id, $available);

    if ($stmt->execute()) {
        header("Location: equipment_checking.php?message=Equipment added successfully");
    } else {
        header("Location: equipment_checking.php?error=Failed to add equipment");
    }

    $stmt->close();
}
?>
