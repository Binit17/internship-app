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

//fetch internships from the database
$sql = "SELECT * FROM internships WHERE status ='open'";
$result = mysqli_query($conn,$sql);
$internships = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Internship List</title>
</head>
<body>
    <h2>Internship List</h2>
    <p><?php echo $_SESSION['user_id']; ?></p> 
    <?php if (count($internships) > 0) { ?>
        <ul>
            <?php foreach ($internships as $internship) { ?>
                <li>
                    <h3><?php echo $internship['title']; ?></h3>
                    <p><?php echo $internship['company_name']; ?></p>
                    <p><?php echo $internship['description']; ?></p>
                    <p>Start Date: <?php echo $internship['start_date']; ?></p>
                    <p>End Date: <?php echo $internship['end_date']; ?></p>
                    <!-- <form method="POST" action="apply.php">
                        <input type="hidden" name="internship_id" value="<?php //echo $internship['internship_id']; ?>">
                        <button type="submit">Apply</button>
                    </form> -->
                    <!-- Link to apply.php -->
                    <p>internship_id: <?php echo $internship['internship_id']; ?></p>
                    <a href="apply.php?internship_id=<?php echo $internship['internship_id']; ?>">Apply</a>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p>No internships available at the moment.</p>
    <?php } ?>
    <br>
    <a href="logout.php">Logout</a>
</body>
</html>