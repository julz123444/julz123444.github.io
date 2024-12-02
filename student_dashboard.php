<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

include('db.php');

// Fetch user role and user_id
$user_role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// Fetch student data for current user (if student)
if ($user_role == 'student') {
    $sql = "SELECT * FROM students WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $student = $stmt->get_result()->fetch_assoc();
}

// Admin can modify attendance
if ($user_role == 'admin') {
    // Fetch all students for the admin to modify attendance
    $sql = "SELECT * FROM students";
    $students_result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #333;
            color: white;
        }
        .container {
            display: flex;
            margin-top: 50px;
        }
        .side-panel {
            width: 250px;
            background-color: #444;
            padding: 20px;
            height: 100vh;
            position: fixed;
        }
        .side-panel a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 0;
            font-size: 18px;
        }
        .side-panel a:hover {
            background-color: #555;
        }
        .content {
            margin-left: 270px;
            width: 100%;
        }
        .attendance-table {
            background-color: white;
            color: black;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .profile-info {
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-top: 20px;
        }
        .profile-info h2 {
            text-align: center;
        }
        .attendance-table select, .attendance-table button {
            margin-bottom: 10px;
        }
        .attendance-table th, .attendance-table td {
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Side Panel (only visible to admin) -->
    <?php if ($user_role == 'admin'): ?>
        <div class="side-panel">
            <h3>Admin Panel</h3>
            <a href="#">Modify Attendance</a>
            <a href="#">View Students</a>
            <a href="logout.php">Logout</a>
        </div>
    <?php endif; ?>

    <!-- Content Area -->
    <div class="content">
        <!-- Profile Info (for students) -->
        <?php if ($user_role == 'student'): ?>
            <div class="profile-info">
                <h2>Student Dashboard</h2>
                <table class="table table-bordered">
                    <tr>
                        <th>Name</th>
                        <td><?php echo htmlspecialchars($student['Name']); ?></td>
                    </tr>
                    <tr>
                        <th>Course</th>
                        <td><?php echo htmlspecialchars($student['Course']); ?></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td><?php echo htmlspecialchars($student['Address']); ?></td>
                    </tr>
                </table>
            </div>
        <?php endif; ?>

        <!-- Attendance Table (for admin) -->
        <?php if ($user_role == 'admin'): ?>
            <div class="attendance-table">
                <h2>Modify Attendance</h2>
                <form method="POST" action="attendance_update.php">
                    <div class="form-group">
                        <label for="student">Select Student</label>
                        <select name="student_id" id="student" class="form-control" required>
                            <option value="">Select a student</option>
                            <?php while ($student_data = $students_result->fetch_assoc()): ?>
                                <option value="<?php echo $student_data['user_id']; ?>"><?php echo $student_data['Name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="attendance_date">Select Sunday Date</label>
                        <input type="date" name="attendance_date" id="attendance_date" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="attendance_status">Attendance Status</label>
                        <select name="attendance_status" id="attendance_status" class="form-control" required>
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                        </select>
                    </div>

                    <button type="submit" name="update_attendance" class="btn btn-primary">Update Attendance</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
