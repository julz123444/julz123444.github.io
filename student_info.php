<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection
include('db.php');

// If the user is an admin, show data for all students
if ($_SESSION['role'] === 'admin') {
    // Get selected academic year from the URL query parameter
    $academic_year = isset($_GET['academic_year']) ? $_GET['academic_year'] : '2024-2025';  // Default to 2024-2025

    // Fetch student information for the selected academic year
    $sql = "SELECT * FROM students WHERE academic_year = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL preparation failed: " . $conn->error);  // Show preparation error if the query fails
    }
    $stmt->bind_param('s', $academic_year); // Bind academic year as a parameter to the query
    $stmt->execute();
    $result = $stmt->get_result();  // Get result from the executed query

    if (!$result) {
        die("Query execution failed: " . $stmt->error); // Show error if the execution fails
    }

    // Admin will see this title
    $header_text = "All Students Information - $academic_year";
} else {
    // If the user is a student, show only their information
    $user_id = $_SESSION['user_id'];

    // Get selected academic year from the URL query parameter
    $academic_year = isset($_GET['academic_year']) ? $_GET['academic_year'] : '2024-2025';  // Default to 2024-2025

    // Fetch student information for the logged-in student
    $sql = "SELECT * FROM students WHERE user_id = ? AND academic_year = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL preparation failed: " . $conn->error);  // Show preparation error if the query fails
    }
    $stmt->bind_param('is', $user_id, $academic_year); // Bind user_id and academic_year as parameters
    $stmt->execute();
    $result = $stmt->get_result();  // Get result from the executed query

    if (!$result) {
        die("Query execution failed: " . $stmt->error); // Show error if the execution fails
    }

    // Student will see this title
    $header_text = "Your Information - $academic_year";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: skyblue;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 30px;
        }
        table {
            background-color: white;
        }
        .btn-container {
            margin-bottom: 20px;
        }
        .action-btns {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center"><?php echo htmlspecialchars($header_text); ?></h2>

    <div class="btn-container">
        <!-- If the user is an admin, they will see the option to go back to the dashboard -->
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="admin_dashboard.php" class="btn btn-primary">Go Back to Dashboard</a>
            <a href="#" data-toggle="modal" data-target="#addStudentModal" class="btn btn-success">Add New Student</a>
        <?php endif; ?>

        <!-- Log Out Button -->
        <a href="logout.php" class="btn btn-danger">Log Out</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Email</th>
                <th>Attendance</th>
                <th>User ID</th>
                <th>Serial Number</th>
                <th>Final Score</th>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <th>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['Name']); ?></td>
                    <td><?php echo htmlspecialchars($row['Address']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['Attendance']); ?></td>
                    <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['serial_number']); ?></td>
                    <td><?php echo htmlspecialchars($row['Final_Score']); ?></td>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <td>
                            <a href="edit_student.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_student.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal for Adding a New Student -->
<div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="add_student.php" method="POST">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="attendance">Attendance</label>
                        <input type="number" class="form-control" id="attendance" name="attendance" required>
                    </div>
                    <div class="form-group">
                        <label for="serial_number">Serial Number</label>
                        <input type="text" class="form-control" id="serial_number" name="serial_number" required>
                    </div>
                    <div class="form-group">
                        <label for="final_score">Final Score</label>
                        <input type="number" class="form-control" id="final_score" name="final_score" required>
                    </div>
                    <div class="form-group">
                        <label for="academic_year">Academic Year</label>
                        <input type="text" class="form-control" id="academic_year" name="academic_year" value="<?php echo htmlspecialchars($academic_year); ?>" readonly>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Student</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
$stmt->close();  // Close the prepared statement
$conn->close();  // Close the database connection
?>
