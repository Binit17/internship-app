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
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h3 {
            margin: 0;
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

        .applied {
            font-weight: bold;
            color: #4caf50;
        }

        .not-applied {
            font-weight: bold;
            color: #ff5722;
        }

        .no-internships {
            text-align: center;
            font-weight: bold;
            color: #ff5722;
        }
    </style>
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
                        <?php if ($applicationStatus[$key] === 'pending') { ?>
                            <p class="applied">You have already applied for this internship. Status: <?php echo $applicationStatus[$key]; ?></p>
                        <?php } else { ?>
                            <p class="applied">Congratulations! Your application for this internship is <?php echo $applicationStatus[$key]; ?>.</p>
                        <?php } ?>
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
        <p class="no-internships">No internships available at the moment.</p>
    <?php } ?>
    <br>
    <div style="text-align: center;">
        <a href="student_dashboard.php">Back to Dashboard</a>
        <br>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
