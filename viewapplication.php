<?php
session_start();

// Include the database configuration file
require_once 'config.php';

// Check if the user is logged in as a company
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'company') {
    header("Location: login.php");
    exit();
}

// Get the company's internships

$company_id = $_SESSION['user_id'];

///
///
///
///
///
/// SINCE USER_ID AND COMPANY_ID ARE DIFFERENT, I HAD TO BRING UP THE COMPANY_ID MYSELF.
$sql = "SELECT company_id FROM company WHERE user_id= '$company_id'";
$result = mysqli_query($conn, $sql);
$row2=mysqli_fetch_assoc($result);
$_SESSION['company_id'] = $row2['company_id'];
$company_id = $_SESSION['company_id'];
///
///
///
///
///
///
///

$getInternshipsQuery = "SELECT * FROM internships WHERE company_id = ?";
$getInternshipsStmt = $conn->prepare($getInternshipsQuery);
$getInternshipsStmt->bind_param('i', $company_id);
$getInternshipsStmt->execute();
$internshipsResult = $getInternshipsStmt->get_result();

// Fetch applications for the company's internships
$applications = array();
while ($internship = $internshipsResult->fetch_assoc()) {
    $internship_id = $internship['internship_id'];
    $getApplicationsQuery = "SELECT applications.*, students.name, internships.title
                            FROM applications
                            INNER JOIN students ON applications.student_id = students.student_id
                            INNER JOIN internships ON applications.internship_id = internships.internship_id
                            WHERE applications.internship_id = ?";
    $getApplicationsStmt = $conn->prepare($getApplicationsQuery);
    $getApplicationsStmt->bind_param('i', $internship_id);
    $getApplicationsStmt->execute();
    $applicationsResult = $getApplicationsStmt->get_result();

    while ($application = $applicationsResult->fetch_assoc()) {
        $applications[] = $application;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Internship Applications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        h2 {
            margin: 20px 0;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .view-profile-link {
            display: inline-block;
            margin-left: 10px;
        }

        .view-profile-link a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }

        .view-profile-link a:hover {
            text-decoration: underline;
        }

        .logout-link {
            display: block;
            margin-top: 20px;
            text-align: center;
        }

        .add-internship-link {
            display: block;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Internship Applications</h2>
    <table>
        <tr>
            <th>Application ID</th>
            <th>Student Name</th>
            <th>Internship Title</th>
            <th>Application Date</th>
            <th>Status</th>
            <th>action</th>

        </tr>
        <?php foreach ($applications as $application) { ?>
            <tr>
                <td><?php echo $application['application_id']; ?></td>
                <td><?php echo $application['name']; ?></td>
                <td><?php echo $application['title']; ?></td>
                <td><?php echo $application['application_date']; ?></td>
                <td><?php echo $application['status']; ?></td>
                <td class="view-profile-link">
                    <a href="profile.php?student_id=<?php echo $application['student_id']; ?>">View Profile</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <div class="logout-link">
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
