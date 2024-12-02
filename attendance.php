<?php
include('db.php');

// Check if student_id is passed in the URL
if (!isset($_GET['student_id']) || empty($_GET['student_id'])) {
    die("Student ID is required.");
}

$student_id = $_GET['student_id'];

// Fetch student data
$sql = "SELECT Name FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    die("Student not found.");
}

// Generate 15 Sundays starting from August 4, 2024
$sundays = [];
for ($i = 0; $i < 15; $i++) {
    $date = date("Y-m-d", strtotime("August 4, 2024 +$i weeks"));
    $sundays[] = $date;
}

// Fetch current attendance status for each Sunday
$attendance_status = [];
foreach ($sundays as $sunday) {
    $sql = "SELECT status FROM attendance WHERE student_id = ? AND sunday_date = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $student_id, $sunday);
    $stmt->execute();
    $result = $stmt->get_result();
    $attendance = $result->fetch_assoc();
    $attendance_status[$sunday] = $attendance ? $attendance['status'] : 'Absent';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f7fa;
        }
        .attendance-form {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container attendance-form">
        <h2>Attendance Details for <?php echo htmlspecialchars($student['Name']); ?></h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sunday Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sundays as $sunday): ?>
                    <tr>
                        <td><?php echo date("F j, Y", strtotime($sunday)); ?></td>
                        <td><?php echo $attendance_status[$sunday]; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="admin_dashboard.php" class="btn btn-primary">Back to Dashboard</a>
    </div>
</body>
</html>
