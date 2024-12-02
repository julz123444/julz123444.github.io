<?php
// Start the session
session_start();

// Include the database connection
include('db.php');

// Check if the form is submitted
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to find the user by email
    $sql = "SELECT id, email, role, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists and password matches
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password using password_verify()
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_id'] = $user['id'];

            // Redirect to the correct dashboard based on role
            if ($user['role'] == 'student') {
                // Redirect student to their own page
                header("Location: student_info.php");
                exit();
            } else {
                // Redirect admin to the admin dashboard (you can change this if necessary)
                header("Location: admin_dashboard.php");
                exit();
            }
        } else {
            $error = "Invalid email or password";
        }
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: skyblue;
        }
        .login-container {
            margin-top: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-card {
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            width: 100%;
            max-width: 900px;
            display: flex;
            align-items: center;
            padding-left: 20px;
        }
        .login-card img {
            width: 50%; /* Image takes up half of the container */
            height: auto;
            object-fit: cover;
            margin-right: 20px;
        }
        .form-container {
            width: 50%; /* Form takes up the other half */
        }
        .form-group input {
            height: 45px;
        }
        .btn {
            width: 100%;
            padding: 10px;
        }
        .remember-me {
            display: flex;
            align-items: center;
        }
        .remember-me input {
            margin-right: 10px;
        }
    </style>
</head>
<body>

<div class="container login-container">
    <div class="login-card">
        <!-- Image on the left side -->
        <img src="assets/bg.png" alt="Login Image">

        <!-- Form on the right side -->
        <div class="form-container">
            <h2>Welcome Back!</h2>
            <h3>Login</h3>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <!-- Remember Me checkbox -->
                <div class="form-group remember-me">
                    <input type="checkbox" name="remember_me" id="remember_me">
                    <label for="remember_me">Remember me</label>
                </div>

                <button type="submit" name="login" class="btn btn-primary">Login</button>
            </form>

            <a href="register.php" class="btn btn-link">Don't have an account? Register here</a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
