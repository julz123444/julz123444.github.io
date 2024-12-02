<?php
// Include the database connection
include('db.php');

// Start session
session_start();

// Check if the form is submitted
if (isset($_POST['register'])) {
    // Form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $course = $_POST['course'];
    $role = 'student';
    $academic_year = $_POST['academic_year']; // Get the academic year selected by the student

    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into users table
        $sql = "INSERT INTO users (email, password, role) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param('sss', $email, $hashed_password, $role);

        if ($stmt->execute()) {
            $user_id = $stmt->insert_id;

            // Insert into students table with the academic year
            $sql_student = "INSERT INTO students (user_id, email, Name, Address, Course, academic_year) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_student = $conn->prepare($sql_student);

            if ($stmt_student) {
                $stmt_student->bind_param('isssss', $user_id, $email, $name, $address, $course, $academic_year);
                if ($stmt_student->execute()) {
                    echo "<div class='alert alert-success'>Student registered successfully!</div>";
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Error preparing statement: " . $conn->error . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: skyblue;
        }
        .register-container {
            margin-top: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .register-card {
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            width: 100%;
            max-width: 600px;
            display: flex;
            align-items: center;
            padding-left: 20px;
        }
        .register-card img {
            width: 100%;
            max-width: 150px;
            height: auto;
            object-fit: cover;
            margin-right: 20px;
        }
        .form-container {
            width: 100%;
        }
        .form-group input {
            height: 45px;
        }
        .btn {
            width: 100%;
            padding: 10px;
        }
    </style>
</head>
<body>

<div class="container register-container">
    <div class="register-card">
        <!-- Image on the left side -->
        <img src="assets/bg.png" alt="Register Image">

        <!-- Form on the right side -->
        <div class="form-container">
            <h3>Register</h3>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="register.php">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                </div>
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                </div>
                <div class="form-group">
                    <input type="text" name="address" class="form-control" placeholder="Address" required>
                </div>
                <div class="form-group">
                    <label for="course">Course:</label>
                    <select name="course" id="course" class="form-control" required>
                        <option value="">-- Select Course --</option>
                        <option value="BSCS">BSCS (Bachelor of Science in Computer Science)</option>
                        <option value="BSIT">BSIT (Bachelor of Science in Information Technology)</option>
                        <option value="CCJE">CCJE (Criminal Justice Education)</option>
                        <option value="DDAT">DDAT (Diploma in Digital Animation Technology)</option>
                        <option value="DSET">DSET (Diploma in Software Engineering Technology)</option>
                        <option value="BSBA-MM">BSBA-MM (Bachelor of Science in Business Administration - Marketing Management)</option>
                        <option value="BSBA-FM">BSBA-FM (Bachelor of Science in Business Administration - Financial Management)</option>
                    </select>
                </div>

                <!-- Academic Year -->
                <div class="form-group">
                    <label for="academic_year">Academic Year:</label>
                    <select name="academic_year" id="academic_year" class="form-control" required>
                        <option value="2024-2025">2024-2025</option>
                        <option value="2025-2026">2025-2026</option>
                    </select>
                </div>

                <button type="submit" name="register" class="btn btn-primary">Register</button>
                
            </form>

            <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
