<?php
session_start();

// Include the database configuration file
require_once 'config.php';

// Check if the user is logged in as a student
if (!isset($_SESSION['student_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

// Fetch internships from the database
$sql = "SELECT * FROM internships WHERE status = 'open'";
$result = mysqli_query($conn, $sql);
$internships = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Fetch applications of the current student from the database
$student_id = $_SESSION['student_id'];
$sql = "SELECT internship_id, status FROM applications WHERE student_id = '$student_id'";
$result = mysqli_query($conn, $sql);
$applications = mysqli_fetch_all($result, MYSQLI_ASSOC);
$appliedInternshipIds = array_column($applications, 'internship_id');
$applicationStatus = array_column($applications, 'status');

?>

<!DOCTYPE html>
<html>
<head>
    <title>Internship List</title>
</head>
<body>
    <h2>Internship List</h2>
    <?php if (count($internships) > 0) { ?>
        <ul>
            <?php foreach ($internships as $key => $internship) { ?>
                <li>
                    <h3><?php echo $internship['title']; ?></h3>
                    <p><?php echo $internship['company_name']; ?></p>
                    <p><?php echo $internship['description']; ?></p>
                    <p>Start Date: <?php echo $internship['start_date']; ?></p>
                    <p>End Date: <?php echo $internship['end_date']; ?></p>
                    <p>Duration: <?php echo $internship['duration']; ?></p>
                    <p>Salary: <?php echo $internship['salary']; ?></p>
                    <p>Location: <?php echo $internship['location']; ?></p>
                    <?php if (in_array($internship['internship_id'], $appliedInternshipIds)) { ?>
                        <p>You have already applied for this internship. Status: <?php echo $applicationStatus[$key]; ?></p>
                    <?php } else { ?>
                        <form method="POST" action="confirmation.php">
                            <input type="hidden" name="internship_id" value="<?php echo $internship['internship_id']; ?>">
                            <button type="submit">Apply</button>
                        </form>
                    <?php } ?>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p>No internships available at the moment.</p>
    <?php } ?>
    <br>
    <a href="student_dashboard.php">Back to Dashboard</a>
    <br>
    <a href="logout.php">Logout</a>
</body>
</html>
