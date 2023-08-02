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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form submission
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $skills = $_POST['skills'];
    $department = $_POST['department'];
    $dob = $_POST['dob'];

    // Validate and update the student details in the database
    $sql = "UPDATE students SET 
            name = '$name', 
            email = '$email', 
            phone = '$phone', 
            gender = '$gender', 
            skills = '$skills', 
            department = '$department', 
            dob = '$dob' 
            WHERE student_id = '$student_id'";
    
    if (mysqli_query($conn, $sql)) {
        $message = "Profile details updated successfully.";
    } else {
        $error = "Error updating profile details: " . mysqli_error($conn);
    }

    // Upload Profile Picture and CV
    if ($_FILES['profile_picture']['name']) {
        // Process profile picture upload
        $profilePicture = $_FILES['profile_picture'];
        $profilePictureName = $profilePicture['name'];
        $profilePictureTmpName = $profilePicture['tmp_name'];
        $profilePictureError = $profilePicture['error'];

        // Validate and move the uploaded profile picture to a designated folder
        if ($profilePictureError === 0) {
            $profilePicturePath = 'uploads/profile_pictures/' . $profilePictureName;
            move_uploaded_file($profilePictureTmpName, $profilePicturePath);

            // Update the profile picture path in the database
            $sql = "UPDATE students SET profile_picture = '$profilePicturePath' WHERE student_id = '$student_id'";
            mysqli_query($conn, $sql);
        }
    }

    if ($_FILES['cv']['name']) {
        // Process CV upload
        $cv = $_FILES['cv'];
        $cvName = $cv['name'];
        $cvTmpName = $cv['tmp_name'];
        $cvError = $cv['error'];

        // Validate and move the uploaded CV to a designated folder
        if ($cvError === 0) {
            $cvPath = 'uploads/cv/' . $cvName;
            move_uploaded_file($cvTmpName, $cvPath);

            // Update the CV path in the database
            $sql = "UPDATE students SET cv = '$cvPath' WHERE student_id = '$student_id'";
            mysqli_query($conn, $sql);
        }
    }

    // Fetch the updated student's information from the database
    $sql = "SELECT * FROM students WHERE student_id = '$student_id'";
    $result = mysqli_query($conn, $sql);
    $student = mysqli_fetch_assoc($result);
} else {
    // Fetch the student's information from the database
    $sql = "SELECT * FROM students WHERE student_id = '$student_id'";
    $result = mysqli_query($conn, $sql);
    $student = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #008374; /* Change this to your desired green color */
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        h1 {
            margin: 0;
        }

        a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
        }

        a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="file"] {
            margin-top: 5px;
        }

        input[type="submit"] {
            margin-top: 20px;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p {
            color: green;
            font-size: 18px;
            margin-top: 10px;
        }

        .error {
            color: red;
            font-size: 18px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Edit Profile</h1>
        <a href="student_dashboard.php">Back to Dashboard</a>
    </header>
    <div class="container">
        <form action="editprofile.php" method="post" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo $student['name']; ?>">

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo $student['email']; ?>">

            <label for="phone">Phone:</label>
            <input type="text" name="phone" id="phone" value="<?php echo $student['phone']; ?>">

            <label for="gender">Gender:</label>
            <select name="gender" id="gender">
                <option value="male" <?php if ($student['gender'] === 'male') echo 'selected'; ?>>Male</option>
                <option value="female" <?php if ($student['gender'] === 'female') echo 'selected'; ?>>Female</option>
                <option value="other" <?php if ($student['gender'] === 'other') echo 'selected'; ?>>Other</option>
            </select>

            <label for="skills">Skills:</label>
            <textarea name="skills" id="skills"><?php echo $student['skills']; ?></textarea>

            <label for="department">Department:</label>
            <input type="text" name="department" id="department" value="<?php echo $student['department']; ?>">

            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob" id="dob" value="<?php echo $student['dob']; ?>">

            <label for="year_of_study">Year of Study:</label>
            <input type="text" name="year_of_study" id="year_of_study" value="<?php echo $student['year_of_study']; ?>">

            <!-- Add form fields for profile picture and CV uploads -->
            <label for="profile_picture">Profile Picture:</label>
            <input type="file" name="profile_picture" id="profile_picture">

            <label for="cv">CV:</label>
            <input type="file" name="cv" id="cv">
            <!-- End of form fields for profile picture and CV uploads -->

            <input type="submit" value="Save Changes">
        </form>

        <!-- Display success message or error message, if any -->
        <?php if (isset($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
