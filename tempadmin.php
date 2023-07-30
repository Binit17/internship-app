<?php
session_start();
//error handling.
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database configuration file
require_once 'config.php';

//check if the user is logged in as an admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch internship applications from the database
$sql = "SELECT applications.*, students.name, internships.title
        FROM applications
        INNER JOIN students ON applications.student_id = students.student_id
        INNER JOIN internships ON applications.internship_id = internships.internship_id
        ORDER BY application_id DESC";
$result = mysqli_query($conn, $sql);
$applications = mysqli_fetch_all($result, MYSQLI_ASSOC);


// yo chai student le apply garisake paxi, approve,disapprove garna ko lagi.
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
            <th>Internship Title</th>
            <th>Application Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php foreach ($applications as $application) { ?>
            <tr>
                <td><?php echo $application['application_id']; ?></td>
                <td><?php echo $application['name']; ?></td>
                <td><?php echo $application['title']; ?></td>
                <td><?php echo $application['application_date']; ?></td>
                <td>
                    <form method="POST" action="">
                        <input type="hidden" name="application_id" value="<?php echo $application['application_id']; ?>">
                        <select name="status">
                            <option value="pending" <?php if ($application['status'] === 'pending') echo 'selected'; ?>>Pending</option>
                            <option value="approved" <?php if ($application['status'] === 'approved') echo 'selected'; ?>>Approved</option>
                            <option value="disapproved" <?php if ($application['status'] === 'disapproved') echo 'selected'; ?>>Disapproved</option>
                        </select>
                        <button type="submit">Update</button>
                    </form>
                </td>
                <td><a href="profile.php?student_id=<?php echo $application['student_id']; ?>">View Profile</a></td>
            </tr>
        <?php } ?>
    </table>
    <br>
    <a href="logout.php">Logout</a>
</body>
</html>
// Check if the username already exists in the database
    $checkQuery = "SELECT * FROM users WHERE username = $username ";
    // $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param('s', $username);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        $error = "Username already exists. Please choose a different username.";
    } 