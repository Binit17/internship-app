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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('grad0.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333333;
            margin-top: 0;
            text-align: center;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 4px;
        }

        h3 {
            margin: 0;
            color: #333333;
            font-size: 18px;
            margin-bottom: 10px;
        }

        p {
            margin: 0;
            color: #666666;
            font-size: 14px;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #0056b3;
        }

        .logout-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Internship List</h2>
        <!-- <p><?php echo $_SESSION['user_id']; ?></p>  -->
        <?php if (count($internships) > 0) { ?>
            <ul>
                <?php foreach ($internships as $internship) { ?>
                    <li>
                        <h3><?php echo $internship['title']; ?></h3>
                        <p><strong>Company:</strong> <?php echo $internship['company_name']; ?></p>
                        <p><strong>Description:</strong> <?php echo $internship['description']; ?></p>
                        <p><strong>Start Date:</strong> <?php echo $internship['start_date']; ?></p>
                        <p><strong>End Date:</strong> <?php echo $internship['end_date']; ?></p>
                        <p><strong>Internship ID:</strong> <?php echo $internship['internship_id']; ?></p>
                        <a href="apply.php?internship_id=<?php echo $internship['internship_id']; ?>">Apply</a>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p>No internships available at the moment.</p>
        <?php } ?>
        <div class="logout-link">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
