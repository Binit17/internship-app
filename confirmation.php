<?php
session_start();

// Include the database configuration file
require_once 'config.php';

// Check if the user is logged in as a student
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

// Check if the internship_id is provided
if (!isset($_POST['internship_id'])) {
    header('Location: index.php');
    exit();
}

$student_id = $_SESSION['user_id'];
$internship_id = $_POST['internship_id'];
//$application_date = date("Y-m-d");
$status = "pending";

// Fetch internship details from the database
$sql = "SELECT * FROM internships WHERE internship_id = '$internship_id'";
$result = mysqli_query($conn, $sql);
$internship = mysqli_fetch_assoc($result);

// Store the application details in the session for final submission
$_SESSION['confirmation_details'] = [
    'student_id' => $student_id,
    'internship_id' => $internship_id,
    //'application_date' => $application_date,
    'status' => $status
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirmation Page</title>
</head>
<body>
    <h2>Confirmation Page</h2>
    <p>Details of the Applied Internship:</p>
    <ul>
        <li><strong>Student ID:</strong> <?php echo $student_id; ?></li>
        <li><strong>Internship ID:</strong> <?php echo $internship_id; ?></li>
        <!-- <li><strong>Application Date:</strong> <?php //echo $application_date; ?></li> -->
        <li><strong>Status:</strong> <?php echo $status; ?></li>
        <li><strong>Title:</strong> <?php echo $internship['title']; ?></li>
        <li><strong>Company Name:</strong> <?php echo $internship['company_name']; ?></li>
        <li><strong>Description:</strong> <?php echo $internship['description']; ?></li>
        <li><strong>Start Date:</strong> <?php echo $internship['start_date']; ?></li>
        <li><strong>End Date:</strong> <?php echo $internship['end_date']; ?></li>
        <li><strong>Duration:</strong> <?php echo $internship['duration']; ?></li>
        <li><strong>Salary:</strong> <?php echo $internship['salary']; ?></li>
        <li><strong>Location:</strong> <?php echo $internship['location']; ?></li>
    </ul>

    <p>Are you sure you want to apply for this internship?</p>
    <form method="POST" action="apply.php">
        <input type="hidden" name="internship_id" value="<?php echo $internship_id; ?>">
        <button type="submit">Confirm</button>
    </form>
    <br>
    <a href="index.php">Cancel</a>
</body>
</html>
