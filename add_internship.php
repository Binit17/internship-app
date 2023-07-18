<?php
session_start();

// Include the database configuration file
require_once 'config.php';

// Check if the user is logged in as an admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Process the form submission to add a new internship
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['title']) && isset($_POST['company_name']) && isset($_POST['description']) && isset($_POST['start_date']) && isset($_POST['end_date'])) {
        $title = $_POST['title'];
        $company_name = $_POST['company_name'];
        $description = $_POST['description'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $status = 'open';

        // Insert the new internship into the database
        $insertSql = "INSERT INTO internships (admin_id, title, company_name, description, start_date, end_date, status)
                      VALUES ('{$_SESSION['user_id']}', '$title', '$company_name', '$description', '$start_date', '$end_date', '$status')";

        if (mysqli_query($conn, $insertSql)) {
            $message = "New internship added successfully.";
        } else {
            $error = "Error adding the internship: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Internship</title>
</head>
<body>
    <h2>Add New Internship</h2>
    <?php if (isset($message)) { ?>
        <p><?php echo $message; ?></p>
    <?php } ?>
    <?php if (isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } ?>
    <form method="POST" action="">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <br>
        <label for="company_name">Company Name:</label>
        <input type="text" id="company_name" name="company_name" required>
        <br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        <br>
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required>
        <br>
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" required>
        <br>
        <button type="submit">Add Internship</button>
    </form>
    <br>
    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
