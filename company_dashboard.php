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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        #dashboard {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
            color: #333;
        }

        p {
            margin: 5px 0;
            color: #666;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        ul li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div id="dashboard">
        <h2>Welcome, <?php echo $companyInfo['name']; ?>!</h2>
        <p><strong>Company Name:</strong> <?php echo $companyInfo['name']; ?></p>
        <p><strong>Email:</strong> <?php echo $companyInfo['email']; ?></p>
        <p><strong>Phone:</strong> <?php echo $companyInfo['phone']; ?></p>
        <p><strong>Address:</strong> <?php echo $companyInfo['address']; ?></p>
        <p><strong>Contact Person:</strong> <?php echo $companyInfo['contact_person']; ?></p>
        <p><strong>Website:</strong> <a href="<?php echo $companyInfo['website']; ?>" target="_blank"><?php echo $companyInfo['website']; ?></a></p>

        <h3>Manage Internships</h3>
        <ul>
            <!-- not giving the company to edit or delete internships for now -->
            <!-- <li><a href="internshipsfromcompany.php">View Internships</a></li> -->
            <li><a href="addinternshipfromcompany.php">Add New Internship</a></li>
            <li><a href="viewapplication.php">View Internship Applications</a></li>
        </ul>

        <br>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
