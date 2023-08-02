<?php
session_start();

// Include the database configuration file
require_once 'config.php';

// Check if the user is logged in as a student
if (!isset($_SESSION['student_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

// Fetch the student's information from the database
$student_id = $_SESSION['student_id'];
$sql = "SELECT * FROM students WHERE student_id = '$student_id'";
$result = mysqli_query($conn, $sql);
$student = mysqli_fetch_assoc($result);

// Handle form submission to update the profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the updated values from the form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $skills = $_POST['skills'];
    $department = $_POST['department'];
    $dob = $_POST['dob'];
    $year_of_study = $_POST['year_of_study'];

    // Update the student's profile in the database
    $update_sql = "UPDATE students SET name = '$name', email = '$email', phone = '$phone', 
        skills = '$skills', department = '$department', dob = '$dob', year_of_study = '$year_of_study'
        WHERE student_id = '$student_id'";

    if (mysqli_query($conn, $update_sql)) {
        $message = "Profile updated successfully.";
    } else {
        $error = "Error updating profile: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Add your head content here (styles, meta tags, etc.) -->
</head>

<body>
    <!-- Add your header content here -->
    <header>
        <h1>Edit Profile</h1>
        <a href="student_dashboard.php">Back to Dashboard</a>
    </header>

    <!-- Add your main content here -->
    <main>
        <?php if (isset($message)) { ?>
            <p><?php echo $message; ?></p>
        <?php } ?>
        <?php if (isset($error)) { ?>
            <p><?php echo $error; ?></p>
        <?php } ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo $student['name']; ?>" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $student['email']; ?>" required>
            <br>
            <label for="phone">Phone:</label>
            <input type="tel" name="phone" value="<?php echo $student['phone']; ?>" required>
            <br>
            <label for="skills">Skills:</label>
            <input type="text" name="skills" value="<?php echo $student['skills']; ?>" required>
            <br>
            <label for="department">Department:</label>
            <input type="text" name="department" value="<?php echo $student['department']; ?>" required>
            <br>
            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob" value="<?php echo $student['dob']; ?>" required>
            <br>
            <label for="year_of_study">Year of Study:</label>
            <input type="text" name="year_of_study" value="<?php echo $student['year_of_study']; ?>" required>
            <br>
            <button type="submit">Update Profile</button>
        </form>
    </main>

    <!-- Add your footer content here -->
    <footer>
        <!-- Add your footer content here -->
    </footer>
</body>

</html>
