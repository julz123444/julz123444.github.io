<?php
// Start the session
session_start();

// Clear session variables
session_unset(); // Unset all session variables

// Destroy the session
session_destroy(); // Destroy the session data

// Redirect to the login page
header("Location: login.php");
exit();
?>
