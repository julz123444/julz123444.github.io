<?php
session_start();

// Ensure the user is logged in as admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Access denied.";
    exit();
}

// Include database connection
include('db.php');

// Check if the student ID is provided in the URL
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Fetch the student data from the database
    $sql = "SELECT * FROM students WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // If no data is found for the student ID
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "Student not found.";
        exit();
    }

    // Handle the form submission (update student data)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve updated data from the form
        $name = $_POST['name'];
        $address = $_POST['address'];
        $attendance = $_POST['attendance'];
        $final_score = $_POST['final_score'];
        $serial_number = $_POST['serial_number'];

        // Debugging: Output submitted data to check values
        var_dump($_POST); // This will show all the posted data

        // Check if all fields are filled in
        if (empty($name) || empty($address) || empty($attendance) || empty($final_score) || empty($serial_number)) {
            echo "All fields must be filled.";
            exit();
        }

        // Prepare the update query
        $update_sql = "UPDATE students SET Name = ?, Address = ?, Attendance = ?, Final_Score = ?, serial_number = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param('sssssi', $name, $address, $attendance, $final_score, $serial_number, $student_id);

        // Execute the update query
        $update_stmt->execute();

        // Check if the update was successful
        if ($update_stmt->affected_rows > 0) {
            // Redirect to the student table after saving changes
            header("Location: student_info.php");
            exit();
        } else {
            echo "No changes were made or update failed.";
        }
    }
} else {
    echo "No student ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Information</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: skyblue;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Edit Student Information</h2>

    <form method="POST" action="edit_student.php?id=<?php echo $student_id; ?>">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($student['Name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" class="form-control" value="<?php echo htmlspecialchars($student['Address']); ?>" required>
        </div>
        <div class="form-group">
            <label for="attendance">Attendance</label>
            <input type="text" id="attendance" name="attendance" class="form-control" value="<?php echo htmlspecialchars($student['Attendance']); ?>" required>
        </div>
        <div class="form-group">
            <label for="final_score">Final Score</label>
            <input type="text" id="final_score" name="final_score" class="form-control" value="<?php echo htmlspecialchars($student['Final_Score']); ?>" required>
        </div>
        <div class="form-group">
            <label for="serial_number">Serial Number</label>
            <input type="text" id="serial_number" name="serial_number" class="form-control" value="<?php echo htmlspecialchars($student['serial_number']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>

    <br>
    <!-- Go Back to Dashboard button now redirects to student_info.php -->
    <a href="student_info.php" class="btn btn-primary">Go Back to Student Table</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
