<?php
session_start();

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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Company Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo $companyInfo['name']; ?>!</h2>
    <p>Company Name: <?php echo $companyInfo['company_name']; ?></p>
    <p>Email: <?php echo $companyInfo['email']; ?></p>
    <p>Phone: <?php echo $companyInfo['phone']; ?></p>
    <p>Address: <?php echo $companyInfo['address']; ?></p>
    <p>Contact Person: <?php echo $companyInfo['contact_person']; ?></p>
    <p>Website: <a href="<?php echo $companyInfo['website']; ?>" target="_blank"><?php echo $companyInfo['website']; ?></a></p>

    <h3>Manage Internships</h3>
    <ul>
        <li><a href="internshipsfromcompany.php">View Internships</a></li>
        <li><a href="addinternshipfromcompany.php">Add New Internship</a></li>
    </ul>

    <br>
    <a href="logout.php">Logout</a>
</body>
</html>
