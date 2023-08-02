<?php
session_start();

// Include the database configuration file
require_once 'config.php';

// Check if the user is logged in as a student or admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

// Redirect to the appropriate dashboard based on the user role
if ($_SESSION['role'] === 'student') {
    header("Location: student_dashboard.php");
    exit();
} elseif ($_SESSION['role'] === 'admin') {
    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome to the Dashboard</h2>
    <ul>
        <li><a href="internships.php">Internship List</a></li>
        <!-- Add more links for other dashboard functionalities -->
        <!-- Example: <li><a href="profile.php">Profile</a></li> -->
    </ul>
    <br>
    <a href="logout.php">Logout</a>
</body>
</html>