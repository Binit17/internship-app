<?php
session_start();

// Include the database configuration file
require_once 'config.php';

// Check if the user is logged in as an admin or company.
if (!isset($_SESSION['user_id']) || (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'company'))) {
    header("Location: login.php");
    exit();
}

// Check if the student_id is provided in the URL
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    // Fetch the student's information from the database
    $sql = "SELECT * FROM students WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
} else {
    // Redirect back to the appropriate dashboard based on user role if student_id is not provided
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin_dashboard.php");
    } elseif ($_SESSION['role'] === 'company') {
        header("Location: company_dashboard.php");
    }
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        h2 {
            margin: 20px 0;
            text-align: center;
        }

        .profile-info {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .profile-picture {
            margin-right: 20px;
        }

        .profile-details {
            flex: 1;
            max-width: 500px;
        }

        .profile-details h3 {
            margin-top: 0;
            margin-bottom: 10px;
        }

        .profile-details p {
            margin: 0;
        }

        .profile-details strong {
            font-weight: bold;
        }

        .cv-image {
            display: block;
            width: 50%;
            margin-top: 20px;
            margin: 0 auto;
        }

        .go-back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>Student Profile</h2>
    <div class="profile-info">
        <div class="profile-picture">
            <img src="<?php echo $student['profile_picture']; ?>" alt="Profile Picture" width="200">
        </div>
        <div class="profile-details">
            <h3>Name: <strong><?php echo $student['name']; ?></strong></h3>
            <p>Email: <?php echo $student['email']; ?></p>
            <p>Phone: <?php echo $student['phone']; ?></p>
            <?php if ($_SESSION['role'] === 'admin') { ?>
                <!-- Display additional information for admin -->
                <p>Gender: <?php echo ucfirst($student['gender']); ?></p>
                <p>Department: <?php echo $student['department']; ?></p>
                <p>Date of Birth: <?php echo $student['dob']; ?></p>
                <p>Status: <?php echo ucfirst($student['status']); ?></p>
                <p>Year of Study: <?php echo $student['year_of_study']; ?></p>
            <?php } ?>
        </div>
    </div>

    <?php if (!empty($student['cv'])) { ?>
                <!-- Display CV for both admin and company -->
                <h3>CV</h3>
                <img src="<?php echo $student['cv']; ?>" alt="CV" width="100">
            <?php } ?>

    <div class="go-back-link">
        <?php if ($_SESSION['role'] === 'admin') { ?>
            <!-- Redirect back to admin dashboard -->
            <a href="admin_dashboard.php">Go Back to Applications</a>
        <?php } elseif ($_SESSION['role'] === 'company') { ?>
            <!-- Redirect back to company dashboard -->
            <a href="company_dashboard.php">Go Back to Dashboard</a>
        <?php } ?>
    </div>
</body>
</html>

