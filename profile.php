<?php
session_start();

// Include the database configuration file
require_once 'config.php';

// Check if the user is logged in as an admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Check if the student_id is provided in the URL
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    // Fetch the student's information from the database
    $sql = "SELECT * FROM students WHERE student_id = '$student_id'";
    $result = mysqli_query($conn, $sql);
    $student = mysqli_fetch_assoc($result);
} else {
    // Redirect back to admin.php if student_id is not provided
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Student Profile</title>
</head>
<body>
    <h2>Student Profile</h2>
    <table>
        <tr>
            <th>Attribute</th>
            <th>Value</th>
        </tr>
        <tr>
            <td>Name</td>
            <td><?php echo $student['name']; ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php echo $student['email']; ?></td>
        </tr>
        <tr>
            <td>Phone</td>
            <td><?php echo $student['phone']; ?></td>
        </tr>
        <tr>
            <td>Gender</td>
            <td><?php echo $student['gender']; ?></td>
        </tr>
        <tr>
            <td>Skills</td>
            <td><?php echo $student['skills']; ?></td>
        </tr>
        <tr>
            <td>Department</td>
            <td><?php echo $student['department']; ?></td>
        </tr>
        <tr>
            <td>Date of Birth</td>
            <td><?php echo $student['dob']; ?></td>
        </tr>
        <tr>
            <td>Status</td>
            <td><?php echo $student['status']; ?></td>
        </tr>
        <tr>
            <td>Year of Study</td>
            <td><?php echo $student['year_of_study']; ?></td>
        </tr>
        <tr>
            <td>Profile Picture</td>
            <td>
                <?php if (!empty($student['profile_picture'])): ?>
                    <img src="<?php echo $student['profile_picture']; ?>" alt="Profile Picture" width="150">
                <?php else: ?>
                    No profile picture available
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>CV</td>
            <td>
                <?php if (!empty($student['cv'])): ?>
                    <img src="<?php echo $student['cv']; ?>" alt="CV" width="100%">
                <?php else: ?>
                    No CV available
                <?php endif; ?>
            </td>
        </tr>
    </table>
    <br>
    <a href="admin.php">Back to Internship Applications</a>
    <br>
    <a href="logout.php">Logout</a>
</body>
</html>
