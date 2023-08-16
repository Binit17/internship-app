<?php
session_start();
//error finding
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Check if the user is logged in as a company
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'company') {
    header("Location: login.php");
    exit();
}

// Include the database configuration file
require_once 'config.php';



// Retrieve company information from the database
$user_id = $_SESSION['user_id'];
$companyQuery = "SELECT * FROM company WHERE user_id = ?";
$companyStmt = $conn->prepare($companyQuery);
$companyStmt->bind_param('i', $user_id);
$companyStmt->execute();
$companyResult = $companyStmt->get_result();

if ($companyResult->num_rows > 0) {
    $companyInfo = $companyResult->fetch_assoc();
} else {
    // Redirect to logout if company information is not found (for data consistency)
    header("Location: logout.php");
    exit();
}

// Retrieve internships associated with the company from the database
$internshipsQuery = "SELECT * FROM internships WHERE company_id = ?";
$internshipsStmt = $conn->prepare($internshipsQuery);
$company_id = $companyInfo['company_id'];
$internshipsStmt->bind_param('i', $company_id);
$internshipsStmt->execute();
$internshipsResult = $internshipsStmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Internships from Company</title>
</head>
<body>
    <h2>Internships from <?php echo $companyInfo['name']; ?></h2>
    <ul>
        <?php while ($internship = $internshipsResult->fetch_assoc()) { ?>
            <li>
                <strong><?php echo $internship['title']; ?></strong><br>
                Description: <?php echo $internship['description']; ?><br>
                Start Date: <?php echo $internship['start_date']; ?><br>
                End Date: <?php echo $internship['end_date']; ?><br>
                Duration: <?php echo $internship['duration']; ?><br>
                Salary: <?php echo $internship['salary']; ?><br>
                Location: <?php echo $internship['location']; ?><br>
                Status: <?php echo ucfirst($internship['status']); ?><br>
                <a href="edit_internship.php?internship_id=<?php echo $internship['internship_id']; ?>">Edit</a>
                <a href="delete_internship.php?internship_id=<?php echo $internship['internship_id']; ?>">Delete</a>
            </li>
            <br>
        <?php } ?>
    </ul>
    <br>
    <a href="company_dashboard.php">Back to Dashboard</a>
</body>
</html>
