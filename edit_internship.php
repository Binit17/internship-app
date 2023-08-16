
<?php
session_start();
//error finding
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database configuration file
require_once 'config.php';

// Check if the user is logged in as a company
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'company') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['internship_id'])) {
    $internship_id = $_GET['internship_id'];

    // Retrieve internship details from the database
    $internshipQuery = "SELECT * FROM internships WHERE internship_id = ?";
    $internshipStmt = $conn->prepare($internshipQuery);
    $internshipStmt->bind_param('i', $internship_id);
    $internshipStmt->execute();
    $internshipResult = $internshipStmt->get_result();

    $internshipQuery = "SELECT * FROM internships WHERE internship_id = '$internship_id'";
    $result = mysqli_query($conn, $internshipQuery);

    if ($result->num_rows >= 0) {
        $internshipInfo = $internshipResult->fetch_assoc();
    } else {
        header("Location: internshipsfromcompany.php");
        exit();
    }
} else {
    header("Location: internshipsfromcompany.php");
    exit();
}

// Handle form submission to update the internship
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $duration = $_POST['duration'];
        $salary = $_POST['salary'];
        $location = $_POST['location'];

        // Update internship details in the database
        $sql = "UPDATE internships SET ,  title = '$title',  description = '$description', start_date = '$start_date', end_date = '$end_date', duration = '$duration', salary = '$salary', location = '$location' WHERE internship_id = '$internship_id'";
        if (mysqli_query($conn, $sql)) {
            $message = "Profile details updated successfully.";
        } else {
            $error = "Error updating profile details: " . mysqli_error($conn);
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Internship</title>
</head>
<body>
    <h2>Edit Internship</h2>
    <h1> <?php echo $internship_id; ?></h1>
    <?php if (isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } ?>
    <form method="POST" action="">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo $internshipInfo['title']; ?>" required><br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo $internshipInfo['description']; ?></textarea><br>
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" value="<?php echo $internshipInfo['start_date']; ?>" required><br>
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" value="<?php echo $internshipInfo['end_date']; ?>" required><br>
        <label for="duration">Duration:</label>
        <input type="text" id="duration" name="duration" value="<?php echo $internshipInfo['duration']; ?>" required><br>
        <label for="salary">Salary:</label>
        <input type="text" id="salary" name="salary" value="<?php echo $internshipInfo['salary']; ?>" required><br>
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" value="<?php echo $internshipInfo['location']; ?>" required><br>
        <button type="submit">Update Internship</button>
    </form>
    <!-- Display success message or error message, if any -->
    <?php if (isset($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
    <br>
    <a href="internshipsfromcompany.php">Back to Internships</a>
</body>
</html>
