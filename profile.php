<?php
session_start();

// Include the database configuration file
require_once 'config.php';

// Check if the user is logged in as an admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

//check if the user is logged in as a student.
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

// Check if the student_id is provided
if (!isset($_GET['student_id'])) {
    header("Location: admin.php");
    exit();
}

$student_id = $_GET['student_id'];

// Fetch the student's profile from the database
$sql = "SELECT * FROM students WHERE student_id = '$student_id'";
$result = mysqli_query($conn, $sql);
$student = mysqli_fetch_assoc($result);

// Redirect to admin.php if the student profile is not found
if (!$student) {
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Profile</title>
</head>
<body>
    <h2>Student Profile</h2>
    <p><strong>Name:</strong> <?php echo $student['name']; ?></p>
    <p><strong>Email:</strong> <?php echo $student['email']; ?></p>
    <p><strong>Phone:</strong> <?php echo $student['phone']; ?></p>
    <p><strong>Gender:</strong> <?php echo $student['gender']; ?></p>
    <p><strong>Skills:</strong> <?php echo $student['skills']; ?></p>
    <p><strong>Department:</strong> <?php echo $student['department']; ?></p>
    <p><strong>Date of Birth:</strong> <?php echo $student['dob']; ?></p>
    <p><strong>Status:</strong> <?php echo $student['status']; ?></p>
    <p><strong>Year of Study:</strong> <?php echo $student['year_of_study']; ?></p>

    <br>
    <a href="admin.php">Back to Internship Applications</a>
</body>
</html>
