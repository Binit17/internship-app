<?php
session_start();

//include the database configuration file
require_once 'config.php';

//check if the user is logged in as a student
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role']!=='student')
{
    header("Location: login.php");
    exit();
}

//check if the internship_id is provided
if(!isset($_POST['internship-id'])) 
{
    header('location: index.php');
    exit();
}

$student_id = $_SESSION['user_id'];
$internship_id = $_POST['internship-id'];
$application_date = date("y-m-d");
$status = "pending";

//insert the application into the database
$sql = "INSERT INTO applications (student_id,internship_id,application_date,status)
        VALUES ('$student_id','$internship_id', '$application_date', '$status')";

if (mysqli_query($conn, $sql))
{
    $message = "application submitted successfully.";
}
else
{
    $error = "Error submitting the application." . mysqli_error($conn);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Apply for Internship</title>
</head>
<body>
    <h2>Apply for Internship</h2>
    <?php if (isset($message)) { ?>
        <p><?php echo $message; ?></p>
    <?php } ?>
    <?php if (isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } ?>
    <br>
    <a href="index.php">Back to Internship List</a>
</body>
</html>