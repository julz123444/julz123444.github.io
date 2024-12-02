<?php
include('db.php');

// Start session and check if the user is an admin
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch filter values
$selected_year = $_GET['academic_year'] ?? '';
$selected_semester = $_GET['semester'] ?? '';

// Default semesters
$semesters = ['1st Semester', '2nd Semester'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: skyblue; /* Set the background to sky blue */
            font-family: Arial, sans-serif;
        }
        .sidebar {
            height: 100vh;
            background-color: #003366; /* Dark blue for contrast */
            color: white;
            padding-top: 20px;
            position: relative;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            margin-bottom: 5px;
            background-color: rgba(0, 0, 0, 0.5); /* Slight transparency */
            border-radius: 5px;
        }
        .sidebar a:hover {
            background-color: rgba(0, 0, 0, 0.7);
            text-decoration: none;
        }
        .image-container {
            position: absolute;
            bottom: 20px; /* Place image near the bottom */
            width: 100%;
            text-align: center;
        }
        .image-container img {
            max-width: 80%; /* Small size for the image */
            height: auto;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
        .filter-section {
            margin-bottom: 20px;
        }
        h2 {
            color: #003366; /* Text color to complement background */
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar">
            <h5 class="text-center text-white">Admin Panel</h5>
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="attendance.php">Manage Attendance</a>
            <a href="logout.php">Logout</a>
            <!-- Image Section -->
            <div class="image-container">
                <img src="bg.png" alt="Admin Image">
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-10">
            <h2 class="mt-4">Good afternoon, Admin!</h2>

            <!-- Filters Section -->
            <div class="filter-section">
                <form method="GET" action="student_info.php" class="form-inline">
                    <label for="academic_year" class="mr-2">Acad Year:</label>
                    <select name="academic_year" id="academic_year" class="form-control mr-3">
                        <option value="2025-2026">2025-2026</option>
                        <option value="2024-2025">2024-2025</option>
                    </select>

                    <label for="semester" class="mr-2">Semester:</label>
                    <select name="semester" id="semester" class="form-control mr-3">
                        <option value="1st Semester">1st Semester</option>
                        <option value="2nd Semester">2nd Semester</option>
                    </select>

                    <button type="submit" class="btn btn-primary">Go!</button>
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
