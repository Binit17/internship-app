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
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        strong {
            font-weight: bold;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 8px 15px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .confirm-text {
            text-align: center;
            font-weight: bold;
            color: #4caf50;
            margin-bottom: 20px;
        }

        .cancel-link {
            text-align: center;
            display: block;
            font-size: 16px;
            color: #007bff;
            text-decoration: none;
        }

        .cancel-link:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Confirmation Page</h2>
        <p class="confirm-text">Details of the Applied Internship:</p>
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
            <div style="text-align: center;">
                <button type="submit">Confirm</button>
            </div>
        </form>
        <div style="text-align: center;">
            <a class="cancel-link" href="index.php">Cancel</a>
        </div>
    </div>
</body>
</html>

