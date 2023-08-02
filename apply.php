
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
//include the database configuration file
require_once 'config.php';


//check if the user is logged in as a student
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role']!=='student')
{
    header("Location: login.php");
    exit();
}

//check if the internship_id is provided
if(!isset($_POST['internship_id'])) 
{
    header('location: index.php');
    exit();
}

$student_id = $_SESSION['student_id'];
$internship_id = $_POST['internship_id'];
// $application_date = date("y-m-d");
$status = "pending";

//insert the application into the database
$sql = "INSERT INTO applications (student_id,internship_id,status)
        VALUES ('$student_id','$internship_id','$status')";

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

        p {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
        }

        a {
            display: block;
            text-align: center;
            font-size: 16px;
            color: #007bff;
            text-decoration: none;
            margin-top: 20px;
        }

        a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Apply for Internship</h2>
        <?php if (isset($message)) { ?>
            <p><?php echo $message; ?></p>
        <?php } ?>
        <?php if (isset($error)) { ?>
            <p><?php echo $error; ?></p>
        <?php } ?>
        <a href="index.php">Back to Dashboard</a>
    </div>
</body>
</html>
