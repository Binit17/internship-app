<?php
session_start();

// Include the database configuration file
require_once 'config.php';

// Check if the user is logged in as an admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}



// Fetch internship applications from the database
$sql = "SELECT applications.*, students.name, internships.title, company.name AS company_name
        FROM applications
        INNER JOIN students ON applications.student_id = students.student_id
        INNER JOIN internships ON applications.internship_id = internships.internship_id
        INNER JOIN company ON applications.company_id = company.company_id
        ORDER BY application_id DESC";
$result = mysqli_query($conn, $sql);
$applications = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Process form submission to update application status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['application_id']) && isset($_POST['status'])) {
        $application_id = $_POST['application_id'];
        $status = $_POST['status'];

        // Update the application status in the database
        $updateSql = "UPDATE applications SET status = '$status' WHERE application_id = $application_id";
        if (mysqli_query($conn, $updateSql)) {
            $message = "Application status updated successfully.";
        } else {
            $error = "Error updating application status: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Internship Applications</title>
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

        .status-update-form {
            display: inline-block;
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
    <?php if (isset($message)) { ?>
        <p><?php echo $message; ?></p>
    <?php } ?>
    <?php if (isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } ?>
    <table>
        <tr>
            <th>Application ID</th>
            <th>Student Name</th>
            <th>Company Name</th>
            <th>Internship Title</th>
            <th>Application Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php foreach ($applications as $application) { ?>
            <tr>
                <td><?php echo $application['application_id']; ?></td>
                <td><?php echo $application['name']; ?></td>
                <td><?php echo $application['company_name']; ?></td>
                <td><?php echo $application['title']; ?></td>
                <td><?php echo $application['application_date']; ?></td>
                <td>
                    <form class="status-update-form" method="POST" action="">
                        <input type="hidden" name="application_id" value="<?php echo $application['application_id']; ?>">
                        <select name="status">
                            <option value="pending" <?php if ($application['status'] === 'pending') echo 'selected'; ?>>Pending</option>
                            <option value="approved" <?php if ($application['status'] === 'approved') echo 'selected'; ?>>Approved</option>
                            <option value="disapproved" <?php if ($application['status'] === 'disapproved') echo 'selected'; ?>>Disapproved</option>
                        </select>
                        <button type="submit">Update</button>
                    </form>
                </td>
                <td class="view-profile-link">
                    <a href="profile.php?student_id=<?php echo $application['student_id']; ?>">View Profile</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <div class="logout-link">
        <a href="logout.php">Logout</a>
    </div>
    <!-- now admin cannot add internships -->
    <!-- <div class="add-internship-link">
        <a href="add_internship.php">Add New Internship</a>
    </div> -->
</body>
</html>

