<?php
include('db.php');

// Start session and check if the user is an admin
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php"); // Redirect to login if not admin
    exit();
}

// Handle the update of attendance status
if (isset($_POST['attendance_id']) && isset($_POST['status'])) {
    $attendance_id = $_POST['attendance_id'];
    $status = $_POST['status']; // 'present' or 'absent'

    // Update the attendance status in the database
    $sql = "UPDATE attendance SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $status, $attendance_id);

    if ($stmt->execute()) {
        header("Location: attendance.php?success=true"); // Redirect to attendance page with success message
    } else {
        echo "Error updating attendance: " . $conn->error;
    }
}
?>
